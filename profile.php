<?php
include 'db_connect.php'; 

if(!isset($_SESSION['tutor'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="admin/Imgs/Icon.png" />
    <title>Tutor Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .bg{
        background: #e8f5e9;
    }
</style>

<body class="bg">
    <?php
        $Tutor = $_SESSION['tutor'];
    ?>
    <!-- navbar -->
    <?php require('components/navbar.php'); ?> 

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-body text-center">
                        <!-- Profile Image -->
                        <img src="<?php echo empty($Tutor['profile']) ? 'admin/uploads/users_img/tutors/default.png' : 'admin/uploads/users_img/tutors/'.$Tutor['profile'] ; ?>" class="rounded-circle mb-3" width="120" height="120">
                        
                        <!-- Tutor Name -->
                        <h2 class="fw-bold"><?php echo $Tutor['name'] ?></h2>
                        <p class="text-muted"><?php echo $Tutor['email'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['phone'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['gender'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['institute'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['subject'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['class'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['medium'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['salary'] ?></p>
                        <p class="text-muted"><?php echo $Tutor['city'] ?></p>


                        


<!-- 
                        <form action="update_profile.php" method="POST">
                            <label>Name:</label>
                            <input type="text" class="" name="name" value="<?php echo $Tutor['name']; ?>" required><br>

                            <label>Gender:</label>
                            <input type="text" name="gender" value="<?php echo $Tutor['gender']; ?>" required><br>

                            <label>Phone:</label>
                            <input type="text" name="phone" value="<?php echo $Tutor['phone']; ?>" required><br>

                            <label>Institute:</label>
                            <input type="text" name="institute" value="<?php echo $Tutor['institute']; ?>" required><br>

                            <label>Subjects:</label>
                            <input type="text" name="subject" value="<?php echo $Tutor['subject']; ?>" required><br>

                            <label>Classes:</label>
                            <input type="text" name="class" value="<?php echo $Tutor['class']; ?>" required><br>

                            <label>Medium:</label>
                            <input type="text" name="medium" value="<?php echo $Tutor['medium']; ?>" required><br>

                            <label>Salary:</label>
                            <input type="text" name="salary" value="<?php echo $Tutor['salary']; ?>" required><br>

                            <label>City:</label>
                            <input type="text" name="city" value="<?php echo $Tutor['city']; ?>" required><br>

                            <button type="submit" name="update_profile">Update Profile</button>
                        </form>

                        <a href="index.php">Back to Dashboard</a>

 -->




















                        <!-- ========================= -->









                        <!-- Subject Specialization -->
                        <p class="text-muted">Mathematics Tutor | 5+ Years Experience</p>

                        <!-- Rating -->
                        <div class="mb-3">
                            ⭐⭐⭐⭐⭐ <span class="text-muted">(4.9/5 based on 150 reviews)</span>
                        </div>

                        <!-- Bio -->
                        <p class="text-dark">
                            Passionate about teaching mathematics, helping students improve their problem-solving skills. 
                            Available for online and in-person tutoring sessions.
                        </p>

                        <!-- Contact & Booking Buttons -->
                        <div class="d-flex justify-content-center my-3">
                            <a href="#" class="btn btn-primary mx-2">Book a Session</a>
                            <a href="#" class="btn btn-outline-dark mx-2">Contact</a>
                        </div>
                        
                        <!-- Availability Schedule -->
                        <h5 class="mt-4">Availability</h5>
                        <p class="text-muted">Monday - Friday: 10:00 AM - 6:00 PM</p>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
