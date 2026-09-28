# CS4085 – Fidak TinyML

A Deep Learning course project that extends the Fidak Blood Donation Management System with a lightweight neural network for smart donor prioritization.

## Project Overview

The system first filters donors by blood group, then uses donation-history features to estimate the likelihood of future donation and rank matching donors.

### TinyML features
- Recency: months since last donation
- Frequency: total previous donations
- Monetary: estimated total blood donated
- Time: months since first donation

The project compares a full neural network, a smaller neural network, and an INT8-quantized Tiny model using accuracy, precision, recall, F1-score, ROC-AUC, parameter count, model size, and inference latency.

## Structure

- `tinyml/` – training, export, and browser-model files
- `sql/` – database migration and demo data
- PHP application files – Fidak website with TinyML integration

> The prediction is used for donor prioritization based on donation history. It is not a medical eligibility decision.
