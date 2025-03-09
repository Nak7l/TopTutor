<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background: #e8f5e9;
    }
    .slider-container {
        width: 60%;
        margin: auto;
        padding: 50px 0;
    }
    .slide {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: left;
        background: #e8f5e9;
        padding: 60px;
        border-radius: 10px;
    }
    .slide img {
        width: 400px;
        border-radius: 10px;
        margin-right: 20px;
    }
    .slide-content {
        max-width: 500px;
        max-height: 1000px;
    }
    .tutorSlider{
        max-height: 1000px;
    }
</style>

<h1 class="text-center" data-aos="fade-left">Find the right tutor for you.</h1>
<p class="text-center text-muted" data-aos="fade-right">With over 30,000 tutors and 1M+ learners, we know language learning.</p>

<!-- AOS animation applied here -->
<div class="slider-container mb-5" data-aos="zoom-in-left">
    <div class="slider">
        <div class="slide d-flex bg-white">
            <img src="admin/Imgs/header1.avif" class="tutorSlider" alt="Tutor 1">
            <div class="slide-content">
                <h2>Brianna</h2>
                <p>"The energy she brings to each lesson is amazing."</p>
                <button class="btn">English Tutor</button>
            </div>
        </div>
        <div class="slide d-flex bg-white">
            <img src="admin/Imgs/header1.avif" class="tutorSlider" alt="Tutor 2">
            <div class="slide-content">
                <h2>John</h2>
                <p>"John's lessons helped me improve my grammar a lot!"</p>
                <button class="btn">French Tutor</button>
            </div>
        </div>
        <div class="slide d-flex bg-white">
            <img src="admin/Imgs/header1.avif" class="tutorSlider" alt="Tutor 3">
            <div class="slide-content">
                <h2>Sophia</h2>
                <p>"Sophia makes learning fun and engaging!"</p>
                <button class="btn">Spanish Tutor</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
        });
    });

    // Initialize AOS
    AOS.init({
        duration: 3000,
        once: true
    });
</script>
