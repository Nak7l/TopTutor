<?php
include '../db_connect.php'; 

if(isset($_POST['adminLogin'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM `admin` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $admin = $result->fetch_assoc();

        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['id'];  
            header("location: admin_dashboard.php"); 
            exit;
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Imgs/Icon2.png" />
    <title>Admin Login</title>
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
    <h3 class="text-center">Admin Login</h3>
    <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="adminLogin" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center text-decoration-none">Don't have an account? <a href="admin_register.php">Register Here</a></p>
</div>

</body>
</html>
