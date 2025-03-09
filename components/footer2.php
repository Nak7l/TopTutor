<style>
    .footerSection {
        background-color: #1c1b29;
        color: #ffffff;
        font-family: 'Arial', sans-serif;
    }
    .newsletter {
        text-align: center;
        padding: 50px 20px;
        background-color: #282740;
        border-radius: 10px;
        margin-bottom: 50px;
    }
    .newsletter h2 {
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .logo img {
        width: 100px;
        margin-bottom: 15px;
    }
    .explore ul, .socials ul {
        list-style: none;
        padding: 0;
    }
    .explore ul li, .socials ul li {
        margin-bottom: 10px;
    }
    .explore ul li a, .socials ul li a {
        color: #b3b3b3;
        text-decoration: none;
    }
    .explore ul li a:hover, .socials ul li a:hover {
        color: white;
    }
    .contact p {
        margin-bottom: 5px;
    }
    .button {
        background-color: #0C0B60 !important;
        border-color: #fff!important;
        color: #fff !important;
    }
    .btn-success{
        background-color: #222187;
        justify-items: start;
    }
    .footer {
        border-top: 1px solid #444;
        padding-top: 20px;
        text-align: center;
        margin-top: 40px;
    }
    .footer a {
        color: #6c63ff;
        text-decoration: none;
    }
    .footer a:hover {
        text-decoration: underline;
    }
    
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 20px;
        display: none;
        background: #222187;
        color: white;
        border: 2px solid #e8f5e9; 
        border-radius: 50%;
        width: 40px;
        height: 40px;
        font-size: 20px;
        cursor: pointer;
        transition: 0.3s;
    }
    .back-to-top:hover {
        background: #e8f5e9;
        color: black;
        border: 3px solid #222187; 
        border-radius: 10px;
    }
</style>


<div class="container-fluid footerSection">
    <div class="row">
        <div class="col-md-12">
            <div class="newsletter">
                <h2  data-aos="fade-right">Subscribe to our newsletter</h2>
                <p  data-aos="fade-left">Join the 15,000+ students lorem ipsum dolor sit amet.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row text-left justify-content-center">
            <div class="col-md-3">
                <div class="logo">
                    <img src="admin/Imgs/TopTutor.png" class="rounded-circle mb-3" width="120" height="" alt="TopTutor Logo" data-aos="fade-left">
                    <p data-aos="fade-left">TopTutor is an <b>Online Tutor Finder System</b> that connects students with qualified tutors based on location and subjects. It provides a seamless and secure platform for efficient learning and teaching.</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="explore">
                    <h3 data-aos="fade-left">Explore</h3>
                    <ul>
                        <li><a href="index2.php" data-aos="fade-left">Home</a></li>
                        <li><a href="about2.php" data-aos="fade-left">About</a></li>
                        <li><a href="#contact" data-aos="fade-left">Contact</a></li>
                        <li><a href="#" data-aos="fade-left">Services</a></li>
                        <li><a href="#" data-aos="fade-left">Blog</a></li>
                        <li><a href="#" data-aos="fade-left">FAQs</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="socials">
                    <h3 data-aos="fade-left">Socials</h3>
                    <ul>
                        <li><a href="#" data-aos="fade-left">Instagram</a></li>
                        <li><a href="#" data-aos="fade-left">Facebook</a></li>
                        <li><a href="#" data-aos="fade-left">Twitter</a></li>
                        <li><a href="#" data-aos="fade-left">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact" id="contact">
                    <h3 data-aos="fade-left">Contact Us</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <input type="text" placeholder="Name" name="name" class="form-control" data-aos="fade-left" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" placeholder="Email" name="email" class="form-control" data-aos="fade-left" required>
                        </div>
                        <div class="mb-3">
                            <textarea placeholder="Message" name="message" rows="2" class="form-control" data-aos="fade-left" required></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-success button text-white w-20" data-aos="fade-left">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer mt-5 p-5">
        <p>&copy; 2025 TopTutor. <a>Privacy Policy</a> | <a>Terms & Services</a></p>
    </div>
</div>

<!-- Sending Msg -->
<?php
    if(isset($_POST['send']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $db = mysqli_connect('localhost', 'root', '', 'TopTutor');

        if(!$db) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Database Error',
                    text: 'Could not connect to the database!',
                    confirmButtonColor: '#d33'
                });
            </script>";
            exit;
        }

        $sql = "INSERT INTO `StudentMSG`(`name`, `email`, `message`) VALUES ('$name', '$email', '$message')";
        $res = mysqli_query($db, $sql);

        if($res)
        {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: 'Thank you for reaching out. We will get back to you soon!',
                    confirmButtonColor: '#222187'
                });
            </script>";
        }
        else
        {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong. Please try again later!',
                    confirmButtonColor: '#d33'
                });
            </script>";
        }

        mysqli_close($db);
    }
?>


<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top">&#8679;</button>

<script>
    window.onscroll = function () {
        let button = document.getElementById("backToTop");
        if (document.documentElement.scrollTop > 200) {
            button.style.display = "block";
        } else {
            button.style.display = "none";
        }
    };

    document.getElementById("backToTop").addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

</script>
<script>
    AOS.init({
        duration: 3000,
        once: true
    });
</script>
