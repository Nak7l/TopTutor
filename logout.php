<?php
session_start();

if (isset($_GET['role'])) {
    $role = $_GET['role'];

    if ($role === 'tutor' && isset($_SESSION['tutor'])) {
        unset($_SESSION['tutor']);  // Remove only tutor session
    } elseif ($role === 'student' && isset($_SESSION['student'])) {
        unset($_SESSION['student']);  // Remove only student session
    }
}

// Redirect to login page after logout
header("location: login.php");
exit();
?>
