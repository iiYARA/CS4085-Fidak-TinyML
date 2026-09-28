<?php
$active = 'tinyml';
$metricsPath = __DIR__ . '/tinyml/web_model/metrics.json';
$metrics = null;

if (file_exists($metricsPath)) {
    $decoded = json_decode(file_get_contents($metricsPath), true);
    if (is_array($decoded)) $metrics = $decoded;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TinyML Performance - Fidak</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background:#fafafa; }
        .page { padding:60px 0; }
        .title { color:#e53935; font-weight:700; }
        .card { border:0; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,.07); }
        .metric { font-weight:700; color:#e53935; }
        .note { background:#fff7f7; border:1px solid #ffd5d5; padding:18px; border-radius:10px; }
        th { background:#f8f9fa; }
    </style>
</head>
<body>
<?php include 'head.php'; ?>

<div class="page">
    <div class="container">
        <h1 class="title mb-3">TinyML Model Performance</h1>
        <p class="lead">Full neural network vs. Tiny neural network vs. INT8 Tiny model.</p>

        <div class="note mb-4">
            <strong>Course focus:</strong> compare predictive performance and computational cost.
            The model predicts future donation behavior; it does not determine medical eligibility.
        </div>

        <?php if (!$metrics): ?>
            <div class="alert alert-warning">
                No experiment results found yet. Run <code>python tinyml/train_and_export.py</code>.
                The script will generate <code>tinyml/web_model/metrics.json</code>.
            </div>
        <?php else: ?>
            <div class="card p-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Full Model</th>
                                <th>Tiny Model</th>
                                <th>Tiny INT8</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows = [
                            ['Accuracy', 'accuracy', true],
                            ['Precision', 'precision', true],
                            ['Recall', 'recall', true],
                            ['F1 Score', 'f1', true],
                            ['ROC-AUC', 'roc_auc', true],
                            ['Parameters', 'parameters', false],
                            ['Model Size (KB)', 'size_kb', false],
                            ['Inference Latency (ms)', 'latency_ms', false],
                        ];

                        foreach ($rows as [$label, $key, $decimal]) {
                            echo '<tr><td><strong>' . htmlspecialchars($label) . '</strong></td>';
                            foreach (['full', 'tiny', 'tiny_int8'] as $name) {
                                $value = $metrics[$name][$key] ?? null;
                                if ($value === null) {
                                    echo '<td>—</td>';
                                } else {
                                    $formatted = $decimal ? number_format((float)$value, 4) : number_format((float)$value, 2);
                                    echo '<td>' . $formatted . '</td>';
                                }
                            }
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
