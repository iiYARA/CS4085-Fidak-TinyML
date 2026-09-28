<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Why Donate Blood? - Fidak (BBMS)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #e53935;
            --primary-dark: #c62828;
            --secondary: #f5f5f5;
            --dark: #212121;
            --light: #ffffff;
            --gray: #757575;
        }
        
        body {
            font-family: 'Poppins', 'Noto Kufi Arabic', sans-serif;
            background-color: #fafafa;
            color: var(--dark);
            line-height: 1.8;
        }
        
        .why-donate-section {
            padding: 80px 0;
        }
        
        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
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
        
        .content-image {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            max-height: 600px;
            width: 100%;
            object-fit: contain;
        }
        
        .benefits-list {
            margin-top: 30px;
        }
        
        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .benefit-icon {
            color: var(--primary);
            font-size: 1.5rem;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .benefit-text {
            flex-grow: 1;
        }
        
        .cta-button {
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .why-donate-section {
                padding: 50px 0;
            }
            
            .content-image {
                margin-top: 30px;
                max-height: 400px;
            }
        }
    </style>
</head>
<body>
    <?php 
    $active = 'why';
    include('head.php');
    ?>

    <div class="why-donate-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="section-title">Why Should I Donate Blood?</h1>
                    <div class="content-text">
                        <?php
                        include 'conn.php';
                        $sql = "SELECT * FROM pages WHERE page_type='donor'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo $row['page_data'];
                            }
                        }
                        ?>
                    </div>
                    
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Health Benefits</h4>
                                <p>Regular blood donation helps reduce harmful iron stores and stimulates new blood cell production.</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Community Impact</h4>
                                <p>Your single donation can save up to three lives in emergency situations.</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Personal Satisfaction</h4>
                                <p>Experience the joy of giving and making a tangible difference in someone's life.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cta-button">
                        <a href="donate_blood.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-hand-holding-heart mr-2"></i> Become a Donor Today
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <img src="image/08f2fccc45d2564f74ead4a6d5086871.png" class="content-image" alt="Blood donation importance">
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>