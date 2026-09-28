<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Become a Blood Donor - Fidak</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #e53935;
            --primary-dark: #c62828;
            --dark: #212121;
        }

        body {
            font-family: 'Poppins', 'Noto Kufi Arabic', sans-serif;
            background: #fafafa;
            color: var(--dark);
            line-height: 1.8;
        }

        .donor-section {
            padding: 70px 0;
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 30px;
            padding-bottom: 15px;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .donor-form {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }

        .required-field:after {
            content: '*';
            color: var(--primary);
            margin-left: 4px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 14px;
            border: 1px solid #e0e0e0;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .history-box {
            margin-top: 20px;
            padding: 24px;
            background: #fff7f7;
            border: 1px solid #ffd8d8;
            border-radius: 10px;
        }

        .history-box h4 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .helper {
            color: #757575;
            font-size: 13px;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>

<?php
$active = 'donate';
include('head.php');
?>

<div class="donor-section">
    <div class="container">

        <h1 class="section-title">Become a Blood Donor</h1>

        <div class="donor-form">

            <form action="savedata.php" method="post">

                <div class="row">

                    <div class="col-md-4">
                        <label class="form-label required-field">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="fullname"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required-field">
                            Mobile Number
                        </label>

                        <input
                            type="text"
                            name="mobileno"
                            class="form-control"
                            maxlength="15"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="emailid"
                            class="form-control"
                        >
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label required-field">
                            Age
                        </label>

                        <input
                            type="number"
                            name="age"
                            class="form-control"
                            min="18"
                            max="70"
                            required
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label required-field">
                            Gender
                        </label>

                        <select
                            name="gender"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Select Gender
                            </option>

                            <option value="Male">
                                Male
                            </option>

                            <option value="Female">
                                Female
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label required-field">
                            Blood Group
                        </label>

                        <select
                            name="blood"
                            class="form-control"
                            required
                        >

                            <option value="" selected disabled>
                                Select Blood Group
                            </option>

                            <?php

                            include 'conn.php';

                            $sql = "SELECT * FROM blood ORDER BY blood_group";

                            $result = mysqli_query($conn, $sql)
                                or die("query unsuccessful.");

                            while ($row = mysqli_fetch_assoc($result)) {

                            ?>

                                <option value="<?php echo htmlspecialchars($row['blood_group']); ?>">

                                    <?php echo htmlspecialchars($row['blood_group']); ?>

                                </option>

                            <?php
                            }
                            ?>

                        </select>

                    </div>

                </div>


                <label class="form-label required-field">
                    Address
                </label>

                <textarea
                    class="form-control"
                    name="address"
                    required
                ></textarea>


                <div class="history-box">

                    <h4>
                        <i class="fas fa-chart-line mr-2"></i>
                        Donation History for TinyML
                    </h4>

                    <p class="helper">
                        These fields are used to estimate future donation likelihood.
                        They do not determine medical eligibility.
                    </p>


                    <div class="row">

                        <div class="col-md-4">

                            <label class="form-label required-field">
                                Have you donated before?
                            </label>

                            <select
                                name="donated_before"
                                id="donated_before"
                                class="form-control"
                                required
                            >

                                <option value="0">
                                    No
                                </option>

                                <option value="1">
                                    Yes
                                </option>

                            </select>

                        </div>


                        <div
                            class="col-md-4 history-field"
                            style="display:none;"
                        >

                            <label class="form-label">
                                Total Previous Donations
                            </label>

                            <input
                                type="number"
                                name="total_donations"
                                id="total_donations"
                                min="1"
                                value="1"
                                class="form-control"
                            >

                        </div>


                        <div
                            class="col-md-4 history-field"
                            style="display:none;"
                        >

                            <label class="form-label">
                                Last Donation Date
                            </label>

                            <input
                                type="date"
                                name="last_donation_date"
                                id="last_donation_date"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div
                        class="row history-field"
                        style="display:none;"
                    >

                        <div class="col-md-4">

                            <label class="form-label">
                                First Donation Date
                            </label>

                            <input
                                type="date"
                                name="first_donation_date"
                                id="first_donation_date"
                                class="form-control"
                            >

                        </div>

                    </div>

                </div>


                <div
                    style="
                        width:100%;
                        text-align:center;
                        margin-top:30px;
                        display:block;
                    "
                >

                    <button
                        type="submit"
                        name="submit"
                        style="
                            background:#e53935;
                            color:white;
                            border:none;
                            padding:14px 40px;
                            border-radius:8px;
                            font-size:16px;
                            font-weight:600;
                            cursor:pointer;
                            display:inline-block;
                        "
                    >

                        <i class="fas fa-heartbeat mr-2"></i>

                        Register as Donor

                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


<?php
include('footer.php');
?>


<script>

const donatedBefore =
    document.getElementById('donated_before');

const historyFields =
    document.querySelectorAll('.history-field');


function toggleHistoryFields() {

    const show =
        donatedBefore.value === '1';


    historyFields.forEach(function(field) {

        field.style.display =
            show ? '' : 'none';

    });


    document.getElementById(
        'total_donations'
    ).required = show;


    document.getElementById(
        'last_donation_date'
    ).required = show;


    document.getElementById(
        'first_donation_date'
    ).required = show;

}


donatedBefore.addEventListener(
    'change',
    toggleHistoryFields
);


toggleHistoryFields();

</script>


</body>
</html>