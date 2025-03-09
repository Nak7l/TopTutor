<?php
include 'db_connect.php'; 

// Tutor Login
if (isset($_POST['Tutorlogin'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM `tutors` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $result_fetch = $result->fetch_assoc();

        if (password_verify($password, $result_fetch['password'])) {
            $_SESSION['tutor'] = $result_fetch;  // Store tutor session separately
            header("location: index2.php");
            exit;
        } else {
            echo "<script>alert('Incorrect Password!'); window.location.href='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Tutor Email Not Registered!'); window.location.href='login.php';</script>";
        exit;
    }
}

// Student Login
if (isset($_POST['Studentlogin'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM `students` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $result_fetch = $result->fetch_assoc();

        if (password_verify($password, $result_fetch['password'])) {
            $_SESSION['student'] = $result_fetch;  // Store student session separately
            header("location: index.php");
            exit;
        } else {
            echo "<script>alert('Incorrect Password!'); window.location.href='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Student Email Not Registered!'); window.location.href='login.php';</script>";
        exit;
    }
}

if(isset($error1))
{
    foreach($error1 as $error1)
    {
        echo '<div class = "message" id="message">'.$error1.'</div><br>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="admin/Imgs/Icon2.png" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #e8f5e9;
        }
        .container {
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 500px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background: white;
            position: relative;
        }
        .left-section {
            width: 100%;
            background: #0C0B60;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        .right-section {
            width: 100%;
            padding: 30px;
        }
        .btn-primary {
            background-color: #0C0B60;
            border-color: #0C0B60;
        }
        .btn-primary:hover {
            background-color: #222187;
            border-color: #222187;
        }
        .back-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #0C0B60;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .back-btn:hover {
            background: #222187;
        }
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
                max-width: 700px;
            }
            .left-section {
                width: 40%;
            }
            .right-section {
                width: 60%;
            }
        }
    </style>
    <script>
    function toggleForm() {
        var role = document.getElementById('role').value;
        document.getElementById('tutorFields').style.display = role === 'tutor' ? 'block' : 'none';
        document.getElementById('studentFields').style.display = role === 'student' ? 'block' : 'none';
    }
    </script>
</head>
<body>
    <!-- Back Button -->
    <a href="index.php"><button class="back-btn">← Back</button></a>/

    <!-- Login Form -->
    <div class="container">
        <div class="left-section">
            <h2>Tutor or Student Login</h2>
            <p>Don't have an account? <a href="register.php" style="color: yellow;">Register Here</a></p>
        </div>
        <div class="right-section">
            <h3>Login</h3>
            <div class="mb-3">
                <label for="role" class="form-label">Login as</label>
                <select class="form-control" name="role" id="role" onchange="toggleForm()" required>
                    <option value="">Select Tutor or Student</option>
                    <option value="tutor">Tutor</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <!-- Tutor Login -->
            <form action="" id="tutorFields" style="display: none;" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" name="Tutorlogin" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- Student Login -->
            <form action="" id="studentFields" style="display: none;" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" name="Studentlogin" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
