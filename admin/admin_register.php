<?php
// session_start();
include '../db_connect.php'; // Database connection file

if(isset($_POST['adminRegister'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $check_email = $db->prepare("SELECT * FROM admin WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $result = $check_email->get_result();

        if($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $stmt = $db->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashed_password);
            if($stmt->execute()) {
                $success = "Registration Successful! <a href='admin_login.php'>Login here</a>";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Imgs/Icon2.png" />
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background: #e8f5e9;  
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-lg" style="width: 350px;">
    <h3 class="text-center">Admin Registration</h3>
    
    <?php 
        if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } 
        if(isset($success)) { echo "<div class='alert alert-success'>$success</div>"; }
    ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" name="adminRegister" class="btn btn-primary w-100">Register</button>
    </form>
    
    <p class="text-center mt-2">Already have an account? <a href="admin_login.php">Login</a></p>
</div>

</body>
</html>
