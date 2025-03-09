<?php
include 'db_connect.php'; // Ensure this file connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id']; // Get student ID from form
    $tutor_id = $_SESSION['tutor_id']; // Tutor must be logged in
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $medium = $_POST['medium'];
    $lesson_date = $_POST['lesson_date'];
    $lesson_time = $_POST['lesson_time'];

    // Prepare SQL query
    $stmt = $db->prepare("INSERT INTO `my_lessons_tutors`(`student_id`, `tutor_id`, `subject`, `class`, `medium`, `lesson_date`, `lesson_time`, `status`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
    $stmt->bind_param("iisssss", $student_id, $tutor_id, $subject, $class, $medium, $lesson_date, $lesson_time);

    if ($stmt->execute()) {
        echo "Lesson request sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>
