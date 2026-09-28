<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fidak (BBMS)</title>
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
            line-height: 1.6;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&h=900&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
            margin-bottom: 60px;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
            font-weight: 300;
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
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: none;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .info-card {
            height: 100%;
            border-left: 4px solid var(--primary);
        }
        
        .info-card .card-body {
            padding: 20px;
            height: 150px;
            overflow-y: auto;
        }
        
        .donor-card {
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .donor-card:hover {
            transform: scale(1.03);
        }
        
        .donor-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 15px;
            border: 3px solid var(--primary);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .blood-group {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 10px 0;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .feature-img {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .feature-img:hover {
            transform: scale(1.02);
        }
        
        .cta-section {
            background-color: var(--primary);
            color: white;
            padding: 40px 0;
            border-radius: 12px;
            margin: 60px 0;
            box-shadow: 0 10px 30px rgba(229, 57, 53, 0.3);
        }
        
        .cta-title {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .stat-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: var(--gray);
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include('head.php'); ?>    
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Save Lives, Donate Blood</h1>
            <p class="hero-subtitle">Join our community of life-savers today</p>
            <a href="donate_blood.php" class="btn btn-light btn-lg">Become a Donor</a>
        </div>
    </div>
    
    <div class="container" style="padding-bottom: 100px;">
        <!-- Stats Section -->
        <div class="row text-center mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">1,250+</div>
                    <div class="stat-label">Registered Donors</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Lives Saved</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Blood Types</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Emergency Service</div>
                </div>
            </div>
        </div>
        
        <!-- Info Cards -->
        <h2 class="section-title">Why Blood Donation Matters</h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card info-card">
                    <div class="card-header">The Need for Blood</div>
                    <div class="card-body">
                        <?php
                            include 'conn.php';
                            $sql= "select * from pages where page_type='needforblood'";
                            $result=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo $row['page_data'];
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card info-card">
                    <div class="card-header">Blood Donation Tips</div>
                    <div class="card-body">
                        <?php
                            include 'conn.php';
                            $sql= "select * from pages where page_type='bloodtips'";
                            $result=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo $row['page_data'];
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card info-card">
                    <div class="card-header">Who You Could Help</div>
                    <div class="card-body">
                        <?php
                            include 'conn.php';
                            $sql= "select * from pages where page_type='whoyouhelp'";
                            $result=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo $row['page_data'];
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Featured Donors -->
        <h2 class="section-title mt-5">Our Recent Donors</h2>
        <div class="row">
            <?php
                include 'conn.php';
                $sql= "select * from donor_details join blood where donor_details.donor_blood=blood.blood_group order by rand() limit 6";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0) {
                    while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card donor-card">
                    <div class="card-body">
                    <img src="https://cdn-icons-png.flaticon.com/512/2855/2855159.png" alt="Blood Donor Logo" class="donor-img" width="100">
                    <h3><?php echo $row['donor_name']; ?></h3>
                        <p class="blood-group"><?php echo $row['blood_group']; ?></p>
                        <p>
                            <i class="fas fa-phone-alt mr-2"></i><?php echo $row['donor_number']; ?><br>
                            <i class="fas fa-venus-mars mr-2"></i><?php echo $row['donor_gender']; ?><br>
                            <i class="fas fa-birthday-cake mr-2"></i><?php echo $row['donor_age']; ?> years<br>
                            <i class="fas fa-map-marker-alt mr-2"></i><?php echo $row['donor_address']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php }} ?>
        </div>
        
        <!-- Blood Groups Info -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h2 class="section-title">Blood Groups Information</h2>
                <div class="card">
                    <div class="card-body">
                        <?php
                            include 'conn.php';
                            $sql= "select * from pages where page_type='bloodgroups'";
                            $result=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo $row['page_data'];
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <img src="https://images.pexels.com/photos/3825586/pexels-photo-3825586.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" 
     alt="Blood Donation Process" 
     class="img-fluid feature-img">            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="cta-title">Ready to make a difference?</h3>
                        <p>Your blood donation can save up to 3 lives. Join our community of donors today.</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="donate_blood.php" class="btn btn-light btn-lg">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Universal Donors -->
        <div class="row mb-5">
            <div class="col-md-8">
                <h4 class="section-title">Universal Donors and Recipients</h4>
                <div class="card">
                    <div class="card-body">
                        <?php
                            include 'conn.php';
                            $sql= "select * from pages where page_type='universal'";
                            $result=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo $row['page_data'];
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <a href="need_blood.php" class="btn btn-primary btn-block py-3">
                    <i class="fas fa-tint mr-2"></i> Need Blood?
                </a>
            </div>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>