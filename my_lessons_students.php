<?php
include 'db_connect.php';

if (!isset($_SESSION['student'])) {
    header("location: login.php");
    exit();
}

$student_id = $_SESSION['student']['student_id'];

// // Fetch all lessons for the student
// $query = "SELECT lessons.*, tutors.name AS tutor_name 
//           FROM my_lessons_students AS lessons
//           JOIN tutors ON lessons.tutor_id = tutors.tutor_id
//           WHERE lessons.student_id = ?
//           ORDER BY lessons.lesson_date DESC";

// $query = "SELECT * FROM my_lessons_students"

// $stmt = $db->prepare($query);
// $stmt->bind_param("s", $student_id);
// $stmt->execute();
// $result = $stmt->get_result();


$query = "SELECT * FROM my_lessons_students";
$result = mysqli_query($db,$query);
?>

<?php

$student = $_SESSION['student'];

$query = "SELECT my_lessons_tutors.id, tutors.tutor_id AS tutor_id, tutors.name, my_lessons_tutors.subject, my_lessons_tutors.class, my_lessons_tutors.medium, my_lessons_tutors.lesson_date, my_lessons_tutors.lesson_time 
          FROM my_lessons_tutors 
          JOIN tutors ON my_lessons_tutors.tutor_id = tutors.tutor_id 
          WHERE my_lessons_tutors.student_id = ? AND my_lessons_tutors.status = 'Pending'";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $student);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Icon -->
    <link rel="icon" href="admin/Imgs/Icon2.png" /> 

    <title>My Lessons</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
    .bg {
        background-color: #e8f5e9;
    }
    .text-color{
        color: #0C0B60;
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
        background: #28a745;
    }
    .table-bg{
        background: #28a745;
        color: white !important;
    }
    .table-height{
        max-height: 200px;
    }
    .table-bg th {
        color: white !important;
    }
</style>
<body class="bg">

<!-- navbar -->
<?php require('components/navbar.php'); ?> 

<div class="container mt-5 text-color">
    <h2 class="text-center text-color">My Lessons</h2>
    
    <!-- NEW code -->
    <ul>
        <?php 
        // foreach ($lessons as $lesson): ?>
            <li><?php 
            // echo $lesson['title'] . " - " . $lesson['status']; ?></li>
        <?php 
    // endforeach; ?>
    </ul>
    <!-- NEW code -->


    <?php
    
    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead>
                <tr>
                    <th>Tutor Name</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Medium</th>
                    <th>Lesson Date</th>
                    <th>Lesson Time</th>
                    <th>Action</th>
                </tr>
              </thead>";
        echo "<tbody>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['subject'] . "</td>
                    <td>" . $row['class'] . "</td>
                    <td>" . $row['medium'] . "</td>
                    <td>" . $row['lesson_date'] . "</td>
                    <td>" . $row['lesson_time'] . "</td>
                    <td>
                        <form method='post' action='handle_lesson_requests.php'>
                            <input type='hidden' name='request_id' value='" . $row['id'] . "'>
                            <input type='hidden' name='student_id' value='" . $student_id . "'>
                            <input type='hidden' name='tutor_id' value='" . $row['tutor_id'] . "'>
                            <input type='hidden' name='subject' value='" . $row['subject'] . "'>
                            <input type='hidden' name='class' value='" . $row['class'] . "'>
                            <input type='hidden' name='medium' value='" . $row['medium'] . "'>
                            <input type='hidden' name='lesson_date' value='" . $row['lesson_date'] . "'>
                            <input type='hidden' name='lesson_time' value='" . $row['lesson_time'] . "'>
                            <button type='submit' name='accept' class='btn btn-success btn-sm'>Accept</button>
                            <button type='submit' name='decline' class='btn btn-danger btn-sm'>Decline</button>
                        </form>
                    </td>
                  </tr>";
        }
    
        echo "</tbody></table>";
    } else {
        echo "<p>No lesson requests available.</p>";
    }
    
    ?>



    <!-- OLD code -->
    <?php if ($result->num_rows > 0) { ?>
        <div class="table-responsive table-container">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Lesson Title</th>
                        <th>Tutor</th>
                        <th>Lesson Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    while ($query = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$count}</td>
                                <td>{$query['lesson_title']}</td>
                                <td>{$query['tutor_name']}</td>
                                <td>{$query['lesson_date']}</td>
                                <td><span class='badge bg-" . ($query['status'] == 'completed' ? 'success' : ($query['status'] == 'upcoming' ? 'warning' : 'danger')) . "'>{$query['status']}</span></td>
                              </tr>";
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <!-- No lessons found, show empty state -->
        <div class="text-center mt-5">
            <h3><strong>No lessons yet</strong></h3>
            <p>As soon as you find a suitable tutor and book your first lesson, you'll see it here.</p>
            <a href="search_tutors.php" class="btn btn-profile">Find a private tutor</a>
        </div>
    <?php } ?>
    <!-- OLD code -->

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
