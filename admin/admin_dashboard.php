<?php
    require('../db_connect.php');

    // Count total tutors
    $result = mysqli_query($db, "SELECT COUNT(*) AS total_tutors FROM tutors");
    $row = mysqli_fetch_assoc($result);
    $total_tutors = $row['total_tutors'];

    // Count total students
    $result = mysqli_query($db, "SELECT COUNT(*) AS total_students FROM students");
    $row = mysqli_fetch_assoc($result);
    $total_students = $row['total_students'];

    // Count total tutors msg
    $result = mysqli_query($db, "SELECT COUNT(*) AS total_tutorMSG FROM tutorMSG");
    $row = mysqli_fetch_assoc($result);
    $total_tutorMSG = $row['total_tutorMSG'];

    // Count total students msg
    $result = mysqli_query($db, "SELECT COUNT(*) AS total_studentMSG FROM studentMSG");
    $row = mysqli_fetch_assoc($result);
    $total_studentMSG = $row['total_studentMSG'];

    // Recent tutor registration
    $result = mysqli_query($db, "SELECT COUNT(*) AS new_tutors FROM tutors WHERE created_at >= NOW() - INTERVAL 3 DAY");
    $row = mysqli_fetch_assoc($result);
    $new_tutors = $row['new_tutors'];

    // Recent students registration
    $result = mysqli_query($db, "SELECT COUNT(*) AS new_students FROM students WHERE created_at >= NOW() - INTERVAL 3 DAY");
    $row = mysqli_fetch_assoc($result);
    $new_students = $row['new_students'];

    // Fetch Recent registered tutors
    $tutors = mysqli_query($db, "SELECT * FROM tutors WHERE created_at >= NOW() - INTERVAL 3 DAY ORDER BY created_at DESC");

    // Fetch Recent registered students
    $students = mysqli_query($db, "SELECT * FROM students WHERE created_at >= NOW() - INTERVAL 3 DAY ORDER BY created_at DESC");
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Imgs/Icon2.png" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        a {
            text-decoration: none;
        }
        html,
        body {
            position: relative;
            height: 100%;
        }
        body {
            background: #e8f5e9;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        @media screen and (max-width: 575px) {
            .avalibility-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }
        #dashboard-menu {
            position: fixed;
            height: 100%;
            z-index: 11;

        }
        @media screen and (max-width: 992px) {
            #dashboard-menu {
                height: auto;
                width: 100%;
            }
            #main-content {
                margin-top: 60px;
            }
        }
        .bg-header{
            background-color: #0C0B60;
        }
        .body{
            background-color: #e8f5e9;
        }
        .table-container {
            width: 100%;
            overflow-x: auto; 
            white-space: nowrap;
        }
        .table-container::-webkit-scrollbar {
            height: 8px; 
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: #fff;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #0C0B60;
        }
        .table-bg{
            background: #0C0B60;
            color: white;
        }
        .table-height{
            max-height: 200px;
        }
    </style>

    <title>Admin Panel - Dashboard</title>
</head>

<body class="body">

<?php 
    require("header.php");
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <div class="d-flex align-item-center justify-content-between mb-4">
                    <h3>DASHBOARD</h3>
                </div>

                <!-- Dashboard -->
                 <!-- Tutor Dashboard -->
                <div class="row mb-4">
                    <h3>Tutor's</h3>
                    <div class="col-md-6 col-sm-6 col-lg-3 mb-4">
                        <a href="#tutorTable">
                            <div class="card text-center text-success p-3">
                                <h6>New Tutor Registrations</h6>
                                <h1 class="mt-2 mb-0"><?php echo $new_tutors ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3 mb-4">
                        <a href="tutorDetails.php">
                            <div class="card text-center text-warning p-3">
                                <h6>Total Tutor Registrations</h6>
                                <h1 class="mt-2 mb-0"><?php echo $total_tutors; ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3 mb-4">
                        <a href="tutorMessages.php">
                            <div class="card text-center text-primary p-3">
                                <h6>Messages From Tutors</h6>
                                <h1 class="mt-2 mb-0"><?php echo $total_tutorMSG ?></h1>
                            </div>
                        </a>
                    </div>
                </div>

                 <!-- Student Dashboard -->
                <div class="row mb-4">
                    <h3>Students's</h3>
                    <div class="col-md-6 col-sm-6 col-lg-3 mb-4">
                        <a href="#studentTable">
                            <div class="card text-center text-success p-3">
                                <h6>New Student Registrations</h6>
                                <h1 class="mt-2 mb-0"><?php echo $new_students; ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3 mb-4">
                        <a href="studentDetails.php">
                            <div class="card text-center text-warning p-3">
                                <h6>Total Student Registrations</h6>
                                <h1 class="mt-2 mb-0"><?php echo $total_students; ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-3 mb-4">
                        <a href="studentMessages.php">
                            <div class="card text-center text-primary p-3">
                                <h6>Messages From Students</h6>
                                <h1 class="mt-2 mb-0"><?php echo $total_studentMSG ?></h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Tutor recent register table -->
                    <div class="col-md-6" id="tutorTable">
                        <div class="container mt-4 mb-sm-5">
                            <h5 class="text-center">Last 3 Days' Tutors Registrations</h5>
                            <div class="table-container">
                                <table class="table table-bordered table-hover table-responsive table-height" style="max-height: 400px; overflow-y: auto;">
                                    <thead class="table-bg">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Class</th>
                                            <th>City</th>
                                            <th>Registered On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(mysqli_num_rows($tutors) > 0) {
                                            $tmp=0;
                                            while($row = mysqli_fetch_assoc($tutors)) {
                                            $tmp+=1; 
                                                echo "<tr>
                                                        <td>{$tmp}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['email']}</td>
                                                        <td>{$row['phone']}</td>
                                                        <td>{$row['class']}</td>
                                                        <td>{$row['city']}</td>
                                                        <td>{$row['created_at']}</td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center text-danger'>No students registered in the last 3 days.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- student recent register table -->
                    <div class="col-md-6" id="studentTable">
                        <div class="container mt-4 mb-sm-5">
                            <h5 class="text-center">Last 3 Days' Student Registrations</h5>
                            <div class="table-container">
                                <table class="table table-bordered table-hover table-responsive table-height" style="max-height: 400px; overflow-y: auto;">
                                    <thead class="table-bg">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Class</th>
                                            <th>City</th>
                                            <th>Registered On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(mysqli_num_rows($students) > 0) {
                                            $tmp=0;
                                            while($row = mysqli_fetch_assoc($students)) {
                                            $tmp+=1; 
                                                echo "<tr>
                                                        <td>{$tmp}</td>
                                                        <td>{$row['name']}</td>
                                                        <td>{$row['email']}</td>
                                                        <td>{$row['phone']}</td>
                                                        <td>{$row['class']}</td>
                                                        <td>{$row['city']}</td>
                                                        <td>{$row['created_at']}</td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center text-danger'>No students registered in the last 3 days.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>