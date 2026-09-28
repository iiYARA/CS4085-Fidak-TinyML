"""
Fidak TinyML experiment
CS4085 - Tiny Deep Learning Models

What this script does:
1) Downloads the UCI Blood Transfusion Service Center dataset (ID 176).
2) Trains a larger baseline MLP.
3) Trains a smaller Tiny MLP.
4) Converts the Tiny MLP to full-integer INT8 TFLite.
5) Measures Accuracy, Precision, Recall, F1, ROC-AUC, parameter count,
   model size and inference latency.
6) Exports the Tiny model to TensorFlow.js with 1-byte weight quantization
   so Fidak can run predictions directly in the browser.

Important:
The model predicts future donation behavior from historical donation data.
It must NOT be used as a medical eligibility decision system.
"""

from __future__ import annotations

import json
import statistics
import subprocess
import sys
import time
from pathlib import Path

import numpy as np
import pandas as pd
import tensorflow as tf
from sklearn.metrics import (
    accuracy_score,
    f1_score,
    precision_score,
    recall_score,
    roc_auc_score,
)
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from ucimlrepo import fetch_ucirepo

RANDOM_STATE = 42
np.random.seed(RANDOM_STATE)
tf.random.set_seed(RANDOM_STATE)

BASE_DIR = Path(__file__).resolve().parent
ARTIFACT_DIR = BASE_DIR / "artifacts"
WEB_MODEL_DIR = BASE_DIR / "web_model"
ARTIFACT_DIR.mkdir(exist_ok=True)
WEB_MODEL_DIR.mkdir(exist_ok=True)


def load_data():
    dataset = fetch_ucirepo(id=176)
    X = dataset.data.features.copy()
    y = dataset.data.targets.copy()

    X.columns = ["Recency", "Frequency", "Monetary", "Time"]

    if isinstance(y, pd.DataFrame):
        y = y.iloc[:, 0]
    y = y.astype(int).to_numpy()

    return X.astype("float32"), y


def build_full_model():
    return tf.keras.Sequential(
        [
            tf.keras.layers.Input(shape=(4,), name="donor_history"),
            tf.keras.layers.Dense(64, activation="relu"),
            tf.keras.layers.Dense(32, activation="relu"),
            tf.keras.layers.Dense(16, activation="relu"),
            tf.keras.layers.Dense(1, activation="sigmoid", name="donation_probability"),
        ],
        name="full_mlp",
    )


def build_tiny_model():
    return tf.keras.Sequential(
        [
            tf.keras.layers.Input(shape=(4,), name="donor_history"),
            tf.keras.layers.Dense(16, activation="relu"),
            tf.keras.layers.Dense(8, activation="relu"),
            tf.keras.layers.Dense(1, activation="sigmoid", name="donation_probability"),
        ],
        name="tiny_mlp",
    )


def compile_and_train(model, X_train, y_train, X_val, y_val):
    model.compile(
        optimizer=tf.keras.optimizers.Adam(learning_rate=0.001),
        loss="binary_crossentropy",
        metrics=["accuracy"],
    )
    callbacks = [
        tf.keras.callbacks.EarlyStopping(
            monitor="val_loss",
            patience=20,
            restore_best_weights=True,
            min_delta=1e-4,
        )
    ]
    model.fit(
        X_train,
        y_train,
        validation_data=(X_val, y_val),
        epochs=250,
        batch_size=32,
        verbose=0,
        callbacks=callbacks,
    )
    return model


def classification_metrics(y_true, probabilities):
    predictions = (np.asarray(probabilities).reshape(-1) >= 0.5).astype(int)
    probabilities = np.asarray(probabilities).reshape(-1)

    return {
        "accuracy": float(accuracy_score(y_true, predictions)),
        "precision": float(precision_score(y_true, predictions, zero_division=0)),
        "recall": float(recall_score(y_true, predictions, zero_division=0)),
        "f1": float(f1_score(y_true, predictions, zero_division=0)),
        "roc_auc": float(roc_auc_score(y_true, probabilities)),
    }


def keras_latency_ms(model, X_sample, repeats=150):
    _ = model(X_sample[:1], training=False).numpy()

    samples = []
    for i in range(repeats):
        x = X_sample[i % len(X_sample): (i % len(X_sample)) + 1]
        start = time.perf_counter()
        _ = model(x, training=False).numpy()
        samples.append((time.perf_counter() - start) * 1000)

    return float(statistics.median(samples))


def convert_to_int8_tflite(model, X_train):
    converter = tf.lite.TFLiteConverter.from_keras_model(model)
    converter.optimizations = [tf.lite.Optimize.DEFAULT]

    def representative_dataset():
        for i in range(min(200, len(X_train))):
            yield [X_train[i:i+1].astype(np.float32)]

    converter.representative_dataset = representative_dataset
    converter.target_spec.supported_ops = [tf.lite.OpsSet.TFLITE_BUILTINS_INT8]
    converter.inference_input_type = tf.int8
    converter.inference_output_type = tf.int8

    model_bytes = converter.convert()
    out_path = ARTIFACT_DIR / "tiny_model_int8.tflite"
    out_path.write_bytes(model_bytes)
    return out_path


def tflite_predict_and_latency(model_path, X):
    interpreter = tf.lite.Interpreter(model_path=str(model_path))
    interpreter.allocate_tensors()

    input_details = interpreter.get_input_details()[0]
    output_details = interpreter.get_output_details()[0]

    in_scale, in_zero = input_details["quantization"]
    out_scale, out_zero = output_details["quantization"]

    probabilities = []
    latencies = []

    warm = X[:1]
    if in_scale and in_scale > 0:
        warm = np.round(warm / in_scale + in_zero).clip(-128, 127).astype(np.int8)
    interpreter.set_tensor(input_details["index"], warm)
    interpreter.invoke()

    for row in X:
        x = row.reshape(1, -1).astype(np.float32)
        if in_scale and in_scale > 0:
            x = np.round(x / in_scale + in_zero).clip(-128, 127).astype(np.int8)

        start = time.perf_counter()
        interpreter.set_tensor(input_details["index"], x)
        interpreter.invoke()
        output = interpreter.get_tensor(output_details["index"])
        latencies.append((time.perf_counter() - start) * 1000)

        if out_scale and out_scale > 0:
            prob = (output.astype(np.float32) - out_zero) * out_scale
        else:
            prob = output.astype(np.float32)
        probabilities.append(float(prob.reshape(-1)[0]))

    return np.array(probabilities), float(statistics.median(latencies))


def export_tfjs_quantized(tiny_h5_path):
    cmd = [
        sys.executable,
        "-m",
        "tensorflowjs.converters.converter",
        "--input_format=keras",
        "--quantization_bytes=1",
        str(tiny_h5_path),
        str(WEB_MODEL_DIR),
    ]

    try:
        subprocess.run(cmd, check=True)
    except subprocess.CalledProcessError:
        subprocess.run(
            [
                "tensorflowjs_converter",
                "--input_format=keras",
                "--quantization_bytes=1",
                str(tiny_h5_path),
                str(WEB_MODEL_DIR),
            ],
            check=True,
        )


def directory_size_kb(path):
    path = Path(path)
    if path.is_file():
        return path.stat().st_size / 1024
    return sum(p.stat().st_size for p in path.rglob("*") if p.is_file()) / 1024


def main():
    print("Loading UCI Blood Transfusion Service Center dataset...")
    X, y = load_data()

    X_train, X_test, y_train, y_test = train_test_split(
        X.to_numpy(),
        y,
        test_size=0.20,
        random_state=RANDOM_STATE,
        stratify=y,
    )
    X_train, X_val, y_train, y_val = train_test_split(
        X_train,
        y_train,
        test_size=0.20,
        random_state=RANDOM_STATE,
        stratify=y_train,
    )

    scaler = StandardScaler()
    X_train_scaled = scaler.fit_transform(X_train).astype(np.float32)
    X_val_scaled = scaler.transform(X_val).astype(np.float32)
    X_test_scaled = scaler.transform(X_test).astype(np.float32)

    scaler_payload = {
        "features": ["Recency", "Frequency", "Monetary", "Time"],
        "mean": scaler.mean_.astype(float).tolist(),
        "scale": scaler.scale_.astype(float).tolist(),
        "dataset": "UCI Blood Transfusion Service Center (ID 176)",
        "note": "For educational research only; not a medical eligibility model.",
    }
    (WEB_MODEL_DIR / "scaler.json").write_text(
        json.dumps(scaler_payload, indent=2), encoding="utf-8"
    )

    full_model = compile_and_train(
        build_full_model(), X_train_scaled, y_train, X_val_scaled, y_val
    )
    tiny_model = compile_and_train(
        build_tiny_model(), X_train_scaled, y_train, X_val_scaled, y_val
    )

    full_keras = ARTIFACT_DIR / "full_model.keras"
    tiny_keras = ARTIFACT_DIR / "tiny_model.keras"
    tiny_h5 = ARTIFACT_DIR / "tiny_model.h5"

    full_model.save(full_keras)
    tiny_model.save(tiny_keras)
    tiny_model.save(tiny_h5)

    full_probs = full_model.predict(X_test_scaled, verbose=0).reshape(-1)
    tiny_probs = tiny_model.predict(X_test_scaled, verbose=0).reshape(-1)

    full_result = classification_metrics(y_test, full_probs)
    tiny_result = classification_metrics(y_test, tiny_probs)

    full_result.update(
        {
            "parameters": int(full_model.count_params()),
            "size_kb": float(directory_size_kb(full_keras)),
            "latency_ms": keras_latency_ms(full_model, X_test_scaled),
        }
    )
    tiny_result.update(
        {
            "parameters": int(tiny_model.count_params()),
            "size_kb": float(directory_size_kb(tiny_keras)),
            "latency_ms": keras_latency_ms(tiny_model, X_test_scaled),
        }
    )

    int8_path = convert_to_int8_tflite(tiny_model, X_train_scaled)
    int8_probs, int8_latency = tflite_predict_and_latency(int8_path, X_test_scaled)

    int8_result = classification_metrics(y_test, int8_probs)
    int8_result.update(
        {
            "parameters": int(tiny_model.count_params()),
            "size_kb": float(directory_size_kb(int8_path)),
            "latency_ms": float(int8_latency),
        }
    )

    print("Exporting quantized Tiny model for browser inference...")
    export_tfjs_quantized(tiny_h5)

    results = {
        "dataset": {
            "name": "UCI Blood Transfusion Service Center",
            "uci_id": 176,
            "instances": int(len(X)),
            "features": 4,
            "test_instances": int(len(X_test)),
            "random_state": RANDOM_STATE,
        },
        "full": full_result,
        "tiny": tiny_result,
        "tiny_int8": int8_result,
        "browser_model_size_kb": float(directory_size_kb(WEB_MODEL_DIR)),
    }

    (WEB_MODEL_DIR / "metrics.json").write_text(
        json.dumps(results, indent=2), encoding="utf-8"
    )

    print("\nExperiment complete.")
    print(json.dumps(results, indent=2))
    print(f"\nBrowser model exported to: {WEB_MODEL_DIR}")
    print("Open Fidak -> Need Blood to see TinyML ranking.")


if __name__ == "__main__":
    main()
