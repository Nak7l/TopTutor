<?php
include 'db_connect.php';

if (!isset($_SESSION['tutor'])) {
    header("location: login.php");
    exit();
}

$Tutor = $_SESSION['tutor'];

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query dynamically
$query = "SELECT * FROM students ORDER BY created_at DESC";
if ($search) {
    $query .= " AND (name LIKE '%$search%' OR class LIKE '%$search%')";
}
$result = mysqli_query($db, $query);


// PHP Mailer
require 'PHPMailer-master/src/PHPMailer.php'; 
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email notification
function sendLessonRequestEmail($student_email, $student_name, $tutor_name, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'toptutor14700@gmail.com';
        $mail->Password = 'npna tmra exko marc'; // Use an app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Details
        $mail->setFrom('toptutor14700@gmail.com', 'Tutor Finder System');
        $mail->addAddress($student_email, $student_name);
        $mail->Subject = 'New Lesson Request';
        $mail->isHTML(true);
        $mail->Body = "<h3>Hello $student_name,</h3>
                    <p>You have received a new lesson request from <strong>{$tutor_name}</strong>.</p>
                    <p>Please login to your account to accept or decline the request.</p>
                    <p><a href='http://localhost/TopTutor/login.php'>Click here to login</a></p>
                    <p>Best Regards,<br>Online Tutor Finder</p>";

        // Send Email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle lesson request
if (isset($_POST['request_lesson'])) {
    $student_id = $_POST['student_id'];
    $tutor_id = $Tutor['tutor_id'];

    // Fetch student details securely
    $stmt = $db->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        $student_email = $student['email'];
        $student_name = $student['name'];

        // Insert notification securely
        $stmt = $db->prepare("INSERT INTO notifications (student_id, tutor_id, message, status) 
                              VALUES (?, ?, ?, ?)");
        $message = "New lesson request from {$Tutor['name']}";
        $status = 'unread';
        $stmt->bind_param("ssss", $student_id, $tutor_id, $message, $status);
        $stmt->execute();

        // Send email notification
        if (sendLessonRequestEmail($student_email, $student_name, $Tutor['name'], $message)) {
            echo "<script>
                Swal.fire({
                    title: 'Lesson Request Sent!',
                    text: 'Your request has been sent successfully. Email notification delivered.',
                    icon: 'success',
                    confirmButtonColor: '#0C0B60'
                }).then(() => {
                    window.location.reload(); 
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Lesson Request Sent!',
                    text: 'Your request was sent, but email delivery failed.',
                    icon: 'warning',
                    confirmButtonColor: '#FFC107'
                }).then(() => {
                    window.location.reload();
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Student not found. Please try again.',
                icon: 'error',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.location.reload(); 
            });
        </script>";
    }
}

// PHP Mailer







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="admin/Imgs/Icon2.png" />
    <!-- AOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <title>Find Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
    .body {
        background: #e8f5e9;
    }
    .button {
        background-color: #0C0B60 !important;
        border-color: #0C0B60!important;
    }
    .button:hover {
        background-color: #222187!important;
        border-color: #222187!important;
    }
</style>
<body class="body">
    <?php require('components/navbar2.php'); ?>

    <!-- Back to Dashboard Button -->
    <div class="container mt-4 d-flex justify-content-start">
        <a href="index2.php" class="btn btn-success button">Back to Home</a>
    </div>

    <div class="container my-4">
        <!-- Search Form -->
        <form method="GET" action="" class="mb-4 card shadow-lg" data-aos="fade-down">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Name or Class" value="<?php echo $search; ?>">
                <button class="btn btn-success button" type="submit">Search</button>
            </div>
        </form>

        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($student = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="card shadow-lg mb-4">
                            <div class="card-body text-center">
                                <!-- Profile Image -->
                                <img src="<?php echo empty($student['profile']) ? 'admin/uploads/users_img/tutors/default.png' : 'admin/uploads/users_img/tutors/'.$student['profile']; ?>" class="rounded-circle mb-3" width="120" height="120">

                                <!-- Student Name -->
                                <h4><?php echo $student['name']; ?></h4>

                                <!-- Additional Student Details -->
                                <p class="text-muted mb-1"><strong>Class:</strong> <?php echo $student['class']; ?></p>
                                <p class="text-muted mb-1"><strong>Email:</strong> <?php echo $student['email']; ?></p>
                                <p class="text-muted mb-1"><strong>Phone:</strong> <?php echo $student['phone']; ?></p>
                                <p class="text-muted mb-1"><strong>Gender:</strong> <?php echo ucfirst($student['gender']); ?></p>
                                <p class="text-muted mb-3"><strong>City:</strong> <?php echo $student['city']; ?></p>

                                <!-- Request Lesson Button -->
                                <form method="POST">
                                    <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                    <button type="submit" name="request_lesson" class="btn btn-primary button request-lesson" data-student-id="<?php echo $student['student_id']; ?>">Request Lesson</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
            <?php 
                }
            } else {
                echo "<div class='text-center text-danger fw-bold'>No students found.</div>";
            }
            ?>
        </div>
        
    </div>

    <!-- Footer -->
    <?php require('components/footer2.php'); ?>

    <!-- Sweet Alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".request-lesson").click(function () {
        let studentId = $(this).data("student-id"); // Get student ID from button

        // Send AJAX request
        $.ajax({
            url: "request_lesson.php",  // PHP file that handles request
            type: "POST",
            data: { student_id: studentId },
            success: function (response) {
                // Show SweetAlert popup on success
                Swal.fire({
                    title: "Lesson Request Sent!",
                    text: "Your request has been sent successfully. Please wait for the student's response.",
                    icon: "success",
                    confirmButtonColor: "#0C0B60"
                }).then(() => {
                    location.reload(); // Reload the page after clicking "OK"
                });
            },
            error: function () {
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    confirmButtonColor: "#d33"
                }).then(() => {
                    location.reload(); // Reload the page even if there's an error
                });
            }
        });
    });
});

</script>



    <!-- AOS -->
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
