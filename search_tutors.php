<?php
include 'db_connect.php';

if (!isset($_SESSION['student'])) {
    header("location: login.php");
    exit();
}

$student = $_SESSION['student']; // Corrected variable name

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query dynamically
$query = "SELECT * FROM tutors ORDER BY created_at DESC";
if ($search) {
    $query = "SELECT * FROM tutors WHERE name LIKE '%$search%' OR class LIKE '%$search%' ORDER BY created_at DESC";
}
$result = mysqli_query($db, $query);

// PHP Mailer
require 'PHPMailer-master/src/PHPMailer.php'; 
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email notification
function sendLessonRequestEmail($tutor_email, $tutor_name, $student_name, $message) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'toptutor14700@gmail.com';
        $mail->Password = 'npna tmra exko marc'; // Use a secure app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Details
        $mail->setFrom('toptutor14700@gmail.com', 'Tutor Finder System');
        $mail->addAddress($tutor_email, $tutor_name);
        $mail->Subject = 'New Lesson Request';
        $mail->isHTML(true);
        $mail->Body = "<h3>Hello $tutor_name,</h3>
                    <p>You have received a new lesson request from <strong>{$student_name}</strong>.</p>
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
    $student_id = $student['student_id']; // Corrected to fetch from session
    $tutor_id = $_POST['tutor_id']; // Corrected to get from POST form

    // Fetch tutor details securely
    $stmt = $db->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
    $stmt->bind_param("s", $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tutor = $result->fetch_assoc();

    if ($tutor) {
        $tutor_email = $tutor['email'];
        $tutor_name = $tutor['name'];

        // Insert notification securely
        $stmt = $db->prepare("INSERT INTO notifications_student (student_id, tutor_id, message, status) VALUES (?, ?, ?, ?)");
        $message = "New lesson request from {$student['name']}";
        $status = 'unread';
        $stmt->bind_param("ssss", $student_id, $tutor_id, $message, $status);
        $stmt->execute();

        // Send email notification
        if (sendLessonRequestEmail($tutor_email, $tutor_name, $student['name'], $message)) {
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
                text: 'Tutor not found. Please try again.',
                icon: 'error',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.location.reload(); 
            });
        </script>";
    }
}
// PHP MAiler
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="admin/Imgs/Icon2.png" />
       <!-- AOS -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

       <title>Find Tutors</title>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
       </head>
<style>
    .bg { 
        background-color: #e8f5e9; 
    }
    .button { 
        background-color: #0C0B60 !important; 
        border-color: #0C0B60!important; 
    }
    .button:hover { 
        background-color: #222187!important; 
        border-color: #222187!important; 
    }
    .send-button{
        background-color: transparent !important; 
        border-color: #0C0B60!important; 
        color: #0C0B60 !important;
    }
    .send-button:hover{
        background-color: #222187 !important; 
        border-color: #fff!important; 
        color: #fff !important;
    }

    .container {
        gap: 20px;
        position: relative;
    }

    .left-section {
        transition: 0.3s;
    }

    .right-section {
        opacity: 0;
        visibility: hidden;
        transform: translateX(50px);
        transition: transform 0.5s ease-in-out, opacity 0.3s ease-in-out, visibility 0.3s;
    }

    .left-section:hover + .right-section {
        opacity: 1;
        visibility: visible;
        transform: translateX(0); 
    }



</style>
<body class="bg">
    <?php require('components/navbar.php'); ?>

    <div class="container mt-4 d-flex justify-content-start">
        <a href="index.php" class="btn btn-success button">Back to Home</a>
    </div>

    <div class="container my-4">
        <form method="GET" action="" class="mb-4 card shadow-lg" data-aos="fade-down">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Name or Class" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-success button" type="submit">Search</button>
            </div>
        </form>



        <!--  -->
        
        <div class="row justify-content-center m-auto left-section">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($tutor = mysqli_fetch_assoc($result)) { ?>
                    
                    <div class="col-md-7 left-section" data-aos="fade-up">
                        <div class="card shadow-lg mb-4">
                            <div class="card-body text-center">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 m-auto">
                                        <img src="<?php echo empty($tutor['profile']) ? 'admin/uploads/users_img/tutors/default.png' : 'admin/uploads/users_img/tutors/'.$tutor['profile']; ?>" class="rounded" width="200" height="200">
                                    </div>
                                    <div class="col-md-4 text-start m-auto">
                                        <h4><?php echo htmlspecialchars($tutor['name']); ?></h4>
                                        <p class="text-muted mb-1"><strong>Class:</strong> <?php echo htmlspecialchars($tutor['class']); ?></p>
                                        <p class="text-muted mb-1"><strong>Phone:</strong> <?php echo htmlspecialchars($tutor['phone']); ?></p>
                                        <p class="text-muted mb-1"><strong>Gender:</strong> <?php echo ucfirst(htmlspecialchars($tutor['gender'])); ?></p>
                                        <p class="text-muted mb-1"><strong>City:</strong> <?php echo htmlspecialchars($tutor['city']); ?></p>
                                        <p class="text-muted mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($tutor['email']); ?></p>
                                    </div>
                                    <div class="col-md-4 m-auto">
                                        <form method="POST my-2">
                                            <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                            <button type="submit" name="request_lesson" class="btn btn-primary button request-lesson" data-student-id="<?php echo $student['student_id']; ?>">Request Lesson</button>
                                        </form>
                                        <button type="button" class="btn btn-primary send-button my-2" data-bs-toggle="modal" data-bs-target="#sendMessageModal" 
                                            data-tutor-id="<?php echo $tutor['tutor_id']; ?>" 
                                            data-tutor-name="<?php echo htmlspecialchars($tutor['name']); ?>"
                                            data-tutor-image="<?php echo htmlspecialchars($tutor['profile']); ?>">
                                            Send message  
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 right-section" id="col_3">
                        <div class="card shadow-lg mb-4">
                            <div class="card-body text-center">
                                <img src="<?php echo empty($tutor['profile']) ? 'admin/uploads/users_img/tutors/default.png' : 'admin/uploads/users_img/tutors/'.$tutor['profile']; ?>" class="rounded-circle mb-3" width="120" height="120">
                                <h4><?php echo htmlspecialchars($tutor['name']); ?></h4>
                                <p class="text-muted mb-1"><strong>Class:</strong> <?php echo htmlspecialchars($tutor['class']); ?></p>
                                
                                
                            </div>
                        </div>
                    </div>

            <?php 
                }
            } else {
                echo "<div class='text-center text-danger fw-bold'>No tutors found.</div>";
            }
            ?>
        </div>
    </div>

    <script>


    </script>


    <!-- Sen Message Modal -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMessageModalLabel">Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tutor Info -->
                    <div class="text-center">
                        <!-- <img id="tutorProfile" src="" alt="Tutor Profile" class="rounded-circle mb-2" width="80" height="80"> -->
                        <span><h5>Send message to </h5></span><h5 id="tutorName" class="mb-3"></h5>
                    </div>
                    
                    <!-- Message Form -->
                    <form id="sendMessageForm" method="POST">
                        <input type="hidden" name="tutor_id" id="tutorIdInput">
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php require('components/footer.php'); ?>

    <!-- JavaScript to Populate Modal Dynamically -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var sendButtons = document.querySelectorAll(".send-button");
            sendButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var tutorId = this.getAttribute("data-tutor-id");
                    var tutorName = this.getAttribute("data-tutor-name");
                    var tutorImage = this.getAttribute("data-tutor-image");
        
                    document.getElementById("tutorName").textContent = tutorName;
                    document.getElementById("tutorIdInput").value = tutorId;
                    document.getElementById("tutorProfileImage").src = tutorImage || 'default-profile.png'; // Use default if no image
                });
            });
        });
    </script>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
