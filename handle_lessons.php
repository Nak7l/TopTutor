<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];

    if (isset($_POST['accept'])) {
        $student_id = $_POST['student_id'];
        $tutor_id = $_POST['tutor_id'];
        $subject = $_POST['subject'];
        $class = $_POST['class'];
        $medium = $_POST['medium'];
        $lesson_date = $_POST['lesson_date'];
        $lesson_time = $_POST['lesson_time'];

        // Insert accepted lesson into my_lessons_tutors table
        $stmt = $db->prepare("INSERT INTO my_lessons_tutors (student_id, tutor_id, class, medium, lesson_date, lesson_time, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'Accepted', NOW())");
        $stmt->bind_param("iisssss", $student_id, $tutor_id, $subject, $class, $medium, $lesson_date, $lesson_time);
        
        if ($stmt->execute()) {
            // Update lesson_requests table status to "Accepted"
            $update_stmt = $db->prepare("UPDATE lesson_requests SET status = 'Accepted' WHERE id = ?");
            $update_stmt->bind_param("i", $request_id);
            $update_stmt->execute();
            echo "<p>Lesson request accepted successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }
    }

    if (isset($_POST['decline'])) {
        // Update lesson_requests table status to "Declined"
        $stmt = $db->prepare("UPDATE lesson_requests SET status = 'Declined' WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            echo "<p>Lesson request declined.</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }
    }
}
?>
