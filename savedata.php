<?php
require_once 'conn.php';

$name = trim($_POST['fullname'] ?? '');
$number = trim($_POST['mobileno'] ?? '');
$email = trim($_POST['emailid'] ?? '');
$age = (int)($_POST['age'] ?? 0);
$gender = trim($_POST['gender'] ?? '');
$blood_group = trim($_POST['blood'] ?? '');
$address = trim($_POST['address'] ?? '');
$donated_before = (int)($_POST['donated_before'] ?? 0);

$total_donations = 0;
$last_donation_date = null;
$first_donation_date = null;

if ($donated_before === 1) {
    $total_donations = max(1, (int)($_POST['total_donations'] ?? 1));
    $last_donation_date = $_POST['last_donation_date'] ?: null;
    $first_donation_date = $_POST['first_donation_date'] ?: null;
}

if ($name === '' || $number === '' || $age <= 0 || $gender === '' || $blood_group === '' || $address === '') {
    die('Missing required donor information.');
}

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO donor_details
    (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address,
     total_donations, last_donation_date, first_donation_date)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die('Database error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssisssiss",
    $name,
    $number,
    $email,
    $age,
    $gender,
    $blood_group,
    $address,
    $total_donations,
    $last_donation_date,
    $first_donation_date
);

if (!mysqli_stmt_execute($stmt)) {
    die('Unable to save donor: ' . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: home.php");
exit;
?>