<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contact Us - Fidak (BBMS)</title>
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
        
        .contact-section {
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
        
        .contact-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }
        
        .contact-info {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            height: 100%;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(229, 57, 53, 0.25);
        }
        
        textarea.form-control {
            min-height: 200px;
            resize: none;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .contact-detail {
            margin-bottom: 25px;
        }
        
        .contact-detail i {
            color: var(--primary);
            font-size: 1.5rem;
            margin-right: 15px;
            vertical-align: middle;
        }
        
        .contact-detail h4 {
            display: inline-block;
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .alert-success {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .contact-section {
                padding: 50px 0;
            }
            
            .contact-info {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>
    <?php 
    $active = 'contact';
    include('head.php');
    
    if(isset($_POST["send"])) {
        $name = $_POST['fullname'];
        $number = $_POST['contactno'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $conn = mysqli_connect("localhost","root","","fidak_bbms") or die("Connection error");
        $sql = "INSERT INTO contact_query (query_name, query_mail, query_number, query_message) VALUES('{$name}','{$number}','{$email}','{$message}')";
        $result = mysqli_query($conn, $sql) or die("query unsuccessful.");
        echo '<div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Thank you!</strong> Your query has been sent. We will contact you shortly.
              </div>';
    }
    ?>

    <div class="contact-section">
        <div class="container">
            <h1 class="section-title">Contact Us</h1>
            
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="contact-form">
                        <h3>Send us a Message</h3>
                        <form name="sentMessage" method="post">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" id="name" name="fullname" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="contactno" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea rows="6" class="form-control" id="message" name="message" required maxlength="999"></textarea>
                            </div>
                            <button type="submit" name="send" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="contact-info">
                        <h3>Contact Details</h3>
                        <?php
                        include 'conn.php';
                        $sql = "SELECT * FROM contact_info";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) { ?>
                                <div class="contact-detail">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h4>Address:</h4>
                                    <p><?php echo $row['contact_address']; ?></p>
                                </div>
                                <div class="contact-detail">
                                    <i class="fas fa-phone-alt"></i>
                                    <h4>Phone:</h4>
                                    <p><?php echo $row['contact_phone']; ?></p>
                                </div>
                                <div class="contact-detail">
                                    <i class="fas fa-envelope"></i>
                                    <h4>Email:</h4>
                                    <p><a href="mailto:<?php echo $row['contact_mail']; ?>"><?php echo $row['contact_mail']; ?></a></p>
                                </div>
                            <?php }
                        } ?>
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