<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $medium = $_POST['medium'];
    $salary = $_POST['salary'];
    $city = $_POST['city'];

    $sql = "INSERT INTO tutors (name, email, phone, subject, class, medium, salary) VALUES 
            ('$name', '$email', '$phone', '$subject', '$class', '$medium', '$salary')";

    if ($conn->query($sql) === TRUE) {
        echo "Tutor added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

