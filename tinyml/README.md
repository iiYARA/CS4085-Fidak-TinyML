# Fidak TinyML Module

This folder adds a **resource-efficient donor-history prediction experiment** to Fidak.

## What the model predicts

The model uses four historical donation features:

1. **Recency** — months since the donor's last donation
2. **Frequency** — total number of previous donations
3. **Monetary** — total donated amount in the UCI dataset representation
4. **Time** — months since the donor's first donation

Output: probability of future donation behavior.

> This is an educational prediction model. It is **not** a medical eligibility model and must not replace blood-bank screening or clinical decisions.

## Dataset

UCI Machine Learning Repository:
**Blood Transfusion Service Center, dataset ID 176**

Citation:
I-Cheng Yeh (2008), Blood Transfusion Service Center, UCI Machine Learning Repository.
DOI: 10.24432/C5GS39

The dataset has 748 records, 4 input features, no missing values, and a binary target.

## Experiment

The script trains and compares:

- **Full MLP**: 4 → 64 → 32 → 16 → 1
- **Tiny MLP**: 4 → 16 → 8 → 1
- **Tiny INT8**: full-integer quantized TFLite version of the Tiny MLP

Reported metrics:

- Accuracy
- Precision
- Recall
- F1
- ROC-AUC
- Parameter count
- Model size
- Median single-sample inference latency

The Tiny model is also exported to TensorFlow.js using 1-byte weight quantization so it can run directly in the Fidak browser page.

## Run

From this folder:

```bash
pip install -r requirements.txt
python train_and_export.py
```

Generated files:

```text
tinyml/
├── artifacts/
│   ├── full_model.keras
│   ├── tiny_model.keras
│   ├── tiny_model.h5
│   └── tiny_model_int8.tflite
└── web_model/
    ├── model.json
    ├── group*.bin
    ├── scaler.json
    └── metrics.json
```

After generation, open:

- `need_blood.php` for Smart Match ranking
- `model_performance.php` for the Full vs Tiny vs INT8 comparison

## Database

Run:

```text
sql/tinyml_migration.sql
```

Optionally run:

```text
sql/tinyml_demo_seed.sql
```

The optional seed provides several fictional donors with the same blood group so the ranking is easy to demonstrate.
