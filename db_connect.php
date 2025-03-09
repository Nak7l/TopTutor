<?php
session_start(); 

$host = "localhost"; 
$user = "root"; 
$password = ""; 
$database = "TopTutor"; 

$db = new mysqli($host, $user, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}



?>


