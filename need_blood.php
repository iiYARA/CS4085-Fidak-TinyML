<?php
$active = 'need';
include 'conn.php';

function monthsBetweenDates($dateString) {
    if (!$dateString) return null;
    try {
        $then = new DateTime($dateString);
        $now = new DateTime();
        $diff = $then->diff($now);
        return max(0, ($diff->y * 12) + $diff->m);
    } catch (Exception $e) {
        return null;
    }
}

$donors = [];
$selectedBlood = '';
$searched = false;

if (isset($_POST['search'])) {
    $searched = true;
    $selectedBlood = trim($_POST['blood'] ?? '');

    $stmt = mysqli_prepare(
        $conn,
        "SELECT donor_id, donor_name, donor_number, donor_mail, donor_age, donor_gender,
                donor_blood, donor_address, total_donations, last_donation_date, first_donation_date
         FROM donor_details
         WHERE donor_blood = ?"
    );
    mysqli_stmt_bind_param($stmt, "s", $selectedBlood);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $frequency = (int)($row['total_donations'] ?? 0);
        $recency = monthsBetweenDates($row['last_donation_date']);
        $time = monthsBetweenDates($row['first_donation_date']);

        $row['has_history'] = ($frequency > 0 && $recency !== null && $time !== null);
        $row['ml_recency'] = $row['has_history'] ? $recency : 0;
        $row['ml_frequency'] = $row['has_history'] ? $frequency : 0;
        $row['ml_monetary'] = $row['has_history'] ? ($frequency * 250) : 0;
        $row['ml_time'] = $row['has_history'] ? max($time, $recency) : 0;

        $donors[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Need Blood - Fidak</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary:#e53935; --primary-dark:#c62828; --dark:#212121; }
        body { font-family:'Poppins','Noto Kufi Arabic',sans-serif; background:#fafafa; color:var(--dark); line-height:1.7; }
        .need-blood-section { padding:70px 0; }
        .section-title { color:var(--primary); font-weight:700; margin-bottom:30px; }
        .search-form { background:white; padding:30px; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,.08); margin-bottom:30px; }
        .form-control { border-radius:8px; padding:12px 15px; margin-bottom:15px; }
        .btn-search { background:var(--primary); border-color:var(--primary); padding:12px 28px; font-weight:600; border-radius:8px; }
        .btn-search:hover { background:var(--primary-dark); border-color:var(--primary-dark); }
        .tinyml-banner { background:#fff7f7; border:1px solid #ffd5d5; padding:18px 20px; border-radius:10px; margin-bottom:25px; }
        .tinyml-banner strong { color:var(--primary); }
        .donor-card { background:white; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,.08); overflow:hidden; margin-bottom:24px; height:100%; }
        .donor-img { width:100%; height:150px; object-fit:contain; padding:25px; background:#fffafa; }
        .donor-details { padding:20px; }
        .donor-name { color:var(--primary); font-weight:700; margin-bottom:12px; }
        .donor-info { margin-bottom:7px; }
        .donor-info i { color:var(--primary); width:22px; }
        .score-box { margin-top:14px; padding:12px; background:#f8f9fa; border-radius:8px; }
        .score-value { font-size:22px; font-weight:700; color:var(--primary); }
        .score-label { font-size:12px; color:#777; }
        .progress { height:8px; margin-top:8px; }
        .progress-bar { background-color:var(--primary); }
        .ranking-badge { display:inline-block; padding:4px 9px; font-size:12px; border-radius:20px; background:#ffe4e4; color:#b71c1c; margin-bottom:8px; }
        .model-status { font-size:13px; color:#666; margin-top:8px; }
    </style>
</head>
<body>
<?php include('head.php'); ?>

<div class="need-blood-section">
    <div class="container">
        <h1 class="section-title">Need Blood</h1>

        <form name="needblood" method="post" class="search-form">
            <div class="row">
                <div class="col-md-4">
                    <label class="font-weight-bold">Blood Group</label>
                    <select name="blood" class="form-control" required>
                        <option value="" selected disabled>Select Blood Group</option>
                        <?php
                        $bloodResult = mysqli_query($conn, "SELECT blood_group FROM blood ORDER BY blood_group");
                        while ($b = mysqli_fetch_assoc($bloodResult)) {
                            $bg = $b['blood_group'];
                            $selected = ($selectedBlood === $bg) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($bg) . '" ' . $selected . '>' . htmlspecialchars($bg) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="font-weight-bold">Reason for needing blood</label>
                    <textarea class="form-control" name="reason" rows="2" required><?php echo htmlspecialchars($_POST['reason'] ?? ''); ?></textarea>
                </div>
            </div>
            <button type="submit" name="search" class="btn btn-search text-white">
                <i class="fas fa-wand-magic-sparkles mr-2"></i> Smart Match Donors
            </button>
        </form>

        <?php if ($searched): ?>
            <div class="tinyml-banner">
                <strong><i class="fas fa-microchip mr-2"></i>TinyML Smart Ranking</strong><br>
                Donors are first filtered by the selected blood group. Donors with donation history are then ranked by a tiny neural network predicting future donation likelihood.
                <div id="model-status" class="model-status">Loading TinyML model...</div>
            </div>
        <?php endif; ?>

        <div id="donor-grid" class="row">
            <?php if ($searched && count($donors) === 0): ?>
                <div class="col-12">
                    <div class="alert alert-danger">No donors found for the selected blood group.</div>
                </div>
            <?php endif; ?>

            <?php foreach ($donors as $row): ?>
                <div class="col-lg-4 col-md-6 donor-wrapper"
                     data-name="<?php echo htmlspecialchars($row['donor_name']); ?>"
                     data-history="<?php echo $row['has_history'] ? '1' : '0'; ?>"
                     data-recency="<?php echo (int)$row['ml_recency']; ?>"
                     data-frequency="<?php echo (int)$row['ml_frequency']; ?>"
                     data-monetary="<?php echo (int)$row['ml_monetary']; ?>"
                     data-time="<?php echo (int)$row['ml_time']; ?>"
                     data-score="-1">
                    <div class="donor-card">
                        <img src="https://www.svgrepo.com/show/1939/blood.svg" class="donor-img" alt="Blood Donation Logo">
                        <div class="donor-details">
                            <span class="ranking-badge">Waiting for TinyML ranking</span>
                            <h3 class="donor-name"><?php echo htmlspecialchars($row['donor_name']); ?></h3>
                            <p class="donor-info"><i class="fas fa-tint"></i> <?php echo htmlspecialchars($row['donor_blood']); ?></p>
                            <p class="donor-info"><i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($row['donor_number']); ?></p>
                            <p class="donor-info"><i class="fas fa-venus-mars"></i> <?php echo htmlspecialchars($row['donor_gender']); ?></p>
                            <p class="donor-info"><i class="fas fa-birthday-cake"></i> <?php echo (int)$row['donor_age']; ?> years</p>
                            <p class="donor-info"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['donor_address']); ?></p>

                            <div class="score-box">
                                <div class="score-value">--</div>
                                <div class="score-label">Predicted future donation likelihood</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width:0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.22.0/dist/tf.min.js"></script>
<script>
async function runTinyMLRanking() {
    const status = document.getElementById('model-status');
    const cards = Array.from(document.querySelectorAll('.donor-wrapper'));
    if (!status || cards.length === 0) return;

    try {
        const [model, scalerResponse] = await Promise.all([
            tf.loadLayersModel('tinyml/web_model/model.json'),
            fetch('tinyml/web_model/scaler.json')
        ]);

        if (!scalerResponse.ok) throw new Error('scaler.json not found');
        const scaler = await scalerResponse.json();

        for (const card of cards) {
            const hasHistory = card.dataset.history === '1';
            const scoreEl = card.querySelector('.score-value');
            const badgeEl = card.querySelector('.ranking-badge');
            const barEl = card.querySelector('.progress-bar');

            if (!hasHistory) {
                card.dataset.score = '-1';
                scoreEl.textContent = 'New donor';
                badgeEl.textContent = 'No history available';
                barEl.style.width = '0%';
                continue;
            }

            const raw = [
                Number(card.dataset.recency),
                Number(card.dataset.frequency),
                Number(card.dataset.monetary),
                Number(card.dataset.time)
            ];

            const normalized = raw.map((v, i) => (v - scaler.mean[i]) / scaler.scale[i]);
            const input = tf.tensor2d([normalized], [1, 4]);
            const output = model.predict(input);
            const probability = (await output.data())[0];
            const percent = Math.max(0, Math.min(100, probability * 100));

            input.dispose();
            output.dispose();

            card.dataset.score = probability.toString();
            scoreEl.textContent = percent.toFixed(1) + '%';
            barEl.style.width = percent.toFixed(1) + '%';
        }

        cards.sort((a, b) => Number(b.dataset.score) - Number(a.dataset.score));
        const grid = document.getElementById('donor-grid');

        cards.forEach((card, index) => {
            const badge = card.querySelector('.ranking-badge');
            if (Number(card.dataset.score) >= 0) {
                badge.textContent = '#' + (index + 1) + ' TinyML recommendation';
            }
            grid.appendChild(card);
        });

        status.innerHTML = '<i class="fas fa-check-circle text-success mr-1"></i> TinyML model loaded and ranking completed in your browser.';
    } catch (error) {
        console.error(error);
        status.innerHTML = '<i class="fas fa-exclamation-triangle text-warning mr-1"></i> TinyML model files are not generated yet. Run <code>tinyml/train_and_export.py</code> first.';
        cards.forEach(card => {
            const badge = card.querySelector('.ranking-badge');
            const score = card.querySelector('.score-value');
            badge.textContent = card.dataset.history === '1' ? 'TinyML model unavailable' : 'No history available';
            score.textContent = card.dataset.history === '1' ? '--' : 'New donor';
        });
    }
}

document.addEventListener('DOMContentLoaded', runTinyMLRanking);
</script>
</body>
</html>
