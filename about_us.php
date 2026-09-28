<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>About Us - Fidak (BBMS)</title>
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
        
        .about-section {
            padding: 80px 0;
        }
        
        .about-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .about-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .about-img {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 400px;
            object-fit: cover;
            width: 100%;
        }
        
        .about-img:hover {
            transform: scale(1.02);
        }
        
        .about-content {
            padding-right: 30px;
        }
        
        .mission-section {
            background-color: var(--secondary);
            padding: 60px 0;
            margin: 60px 0;
        }
        
        .mission-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        
        .mission-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .about-content {
                padding-right: 0;
                margin-bottom: 30px;
            }
            
            .about-section {
                padding: 50px 0;
            }
        }
    </style>
</head>
<body>
    <?php 
    $active = 'about';
    include('head.php');
    ?>

    <div class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 about-content">
                    <h1 class="about-title">About Our Fidak (BBMS)</h1>
                    <div class="about-text">
                        <?php
                        include 'conn.php';
                        $sql = "SELECT * FROM pages WHERE page_type='aboutus'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo $row['page_data'];
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=590&h=300" class="about-img" alt="Fidak (BBMS) Team">                </div>
            </div>
        </div>
    </div>

    <div class="mission-section">
        <div class="container">
            <h2 class="text-center mb-5 about-title">Our Mission & Values</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="mission-card text-center">
                        <div class="mission-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>Save Lives</h3>
                        <p>We connect blood donors with recipients to save lives in emergency situations.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mission-card text-center">
                        <div class="mission-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Build Community</h3>
                        <p>Creating a network of regular donors committed to helping others.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mission-card text-center">
                        <div class="mission-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Ensure Safety</h3>
                        <p>Maintaining the highest standards of blood collection and storage.</p>
                    </div>
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