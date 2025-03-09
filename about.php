<?php
include 'db_connect.php'; 

if(!isset($_SESSION['student'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Online Tutor Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Icon -->
    <link rel="icon" href="admin/Imgs/Icon2.png" /> 

    <!-- AOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e8f5e9;
        }
        .bg {
            background-color: #e8f5e9; 
        }
        .hero-section {
            position: relative;
            height: 80vh;
            background: url('admin/Imgs/about4.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeIn 1.5s ease-in-out;
        }
        .section {
            padding: 60px 20px;
            border-radius: 10px;
            margin: 30px auto;
        }
        .team-section {
            position: relative;
            padding: 80px 20px;
            color: white;
            background: url('admin/Imgs/header2.webp') no-repeat center center/cover;
            background-attachment: fixed; /* Parallax effect */
            text-align: center;
        }
        .team-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Dark overlay */
        }
        .team-section .container {
            position: relative;
            z-index: 2;
        }
        .team-member {
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .team-member:hover {
            transform: translateY(-10px);
        }
        .team-member img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #fff;
        }
        .cta-section {
            background: #0C0B60;
            color: white;
            text-align: center;
            padding: 50px 20px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg">
    
    <!-- Navbar -->
    <?php require('components/navbar.php'); ?>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 data-aos="fade-up">About Us</h1>
            <p data-aos="fade-up" data-aos-delay="200">Connecting students with the best tutors for personalized learning.</p>
        </div>
    </section>
    
    <!-- About Us Section -->
    <section class="section container">
        <div class="row">
            <div class="col-md-6">
                <h2 data-aos="zoom-in-up">Who We Are</h2>
                <p data-aos="zoom-in-up">We are a passionate team dedicated to bridging the gap between students and qualified tutors. Our platform provides a seamless experience for students to find tutors who match their learning needs.</p>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <img src="admin/Imgs/header1.avif" alt="About Us" class="img-fluid rounded">
            </div>
        </div>
    </section>
    
    <!-- Team Section with Background Image -->
    <section class="team-section" data-aos="fade-up">
        <div class="container">
            <h2  data-aos="fade-right">Meet Our Team</h2>
            <p  data-aos="fade-left">Passionate individuals dedicated to making education more accessible.</p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="admin/Imgs/header1.avif" alt="John Doe" data-aos="zoom-in-up">
                        <h5 data-aos="zoom-in-up">John Doe</h5>
                        <p data-aos="zoom-in-up">Founder & CEO</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="admin/Imgs/header1.avif" alt="Jane Smith" data-aos="zoom-in-up">
                        <h5 data-aos="zoom-in-up">Jane Smith</h5>
                        <p data-aos="zoom-in-up">Lead Developer</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="admin/Imgs/header1.avif" alt="Emily Johnson" data-aos="zoom-in-up">
                        <h5 data-aos="zoom-in-up">Emily Johnson</h5>
                        <p data-aos="zoom-in-up">UI/UX Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="cta-section mb-md-4 mt-md-4" data-aos="zoom-in-up">
        <h2 data-aos="fade-right">Start Your Learning Journey Today</h2>
        <p data-aos="fade-left">Find the perfect tutor and begin your education journey now!</p>
        <a href="search_tutors.php" class="btn btn-light btn-lg" data-aos="zoom-out-up">Find Your Tutor</a>
    </section>
    
    <!-- Footer -->
    <?php require('components/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 2000,
            // easing: "ease-in-out",
            once: true
        });
    </script>
</body>
</html>
