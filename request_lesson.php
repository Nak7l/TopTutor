<?php
// session_start(); // Start the session to use session variables
include 'db_connect.php';
include 'Email_TutorToStudent.php'; // Include the email function file

if (isset($_POST['request_lesson'])) {
    $student_id = $_POST['student_id'];
    $tutor_id = $_SESSION['tutor']['tutor_id'];
    $tutor_name = $_SESSION['tutor']['name'];

    // Fetch student details securely using prepared statements
    $stmt = $db->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student = $student_result->fetch_assoc();

    if ($student) {
        $student_email = $student['email'];
        $student_name = $student['name'];

        // Insert notification into database securely using prepared statements
        $stmt = $db->prepare("INSERT INTO notifications (student_id, tutor_id, message, status) 
                              VALUES (?, ?, ?, ?)");
        $message = "New lesson request from $tutor_name";
        $status = 'unread';
        $stmt->bind_param("ssss", $student_id, $tutor_id, $message, $status);
        $stmt->execute();

        // Send email notification
        if (sendLessonRequestEmail($student_email, $student_name, $tutor_name, $message)) {
            echo "<script>alert('Lesson request sent successfully! Email notification also sent.');</script>";
        } else {
            echo "<script>alert('Lesson request sent but email notification failed.');</script>";
        }
    }
}
?>
