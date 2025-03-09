<?php
// session_start(); // Start the session to use session variables
include 'db_connect.php';

require 'PHPMailer-master/src/PHPMailer.php'; 
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Load PHPMailer

if (!isset($_SESSION['tutor'])) {
    header("location: login.php");
    exit();
}

$Tutor = $_SESSION['tutor'];

// Function to send email notification
function sendLessonRequestEmail($student_email, $student_name, $tutor_name, $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'toptutor14700@gmail.com';
        $mail->Password = 'npna tmra exko marc'; // Make sure this is an app password
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

    // Fetch student details securely using prepared statements
    $stmt = $db->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        $student_email = $student['email'];
        $student_name = $student['name'];

        // Insert notification into database securely using prepared statements
        $stmt = $db->prepare("INSERT INTO notifications (student_id, tutor_id, message, status) 
                              VALUES (?, ?, ?, ?)");
        $message = "New lesson request from {$Tutor['name']}";
        $status = 'unread';
        $stmt->bind_param("ssss", $student_id, $tutor_id, $message, $status);
        $stmt->execute();

        // Send email notification
        if (sendLessonRequestEmail($student_email, $student_name, $Tutor['name'], $message)) {
            echo "<script>alert('Lesson request sent successfully! Email notification sent.');</script>";
        } else {
            echo "<script>alert('Lesson request sent, but email could not be delivered.');</script>";
        }
    }
}
?>
