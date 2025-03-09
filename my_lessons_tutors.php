<?php
include 'db_connect.php';

if (!isset($_SESSION['tutor'])) {
    header("location: login.php");
    exit();
}

$tutor_id = $_SESSION['tutor']['tutor_id'];

// Fetch students who accepted the lesson request
$query = "SELECT students.student_id, students.name 
          FROM lesson_requests 
          JOIN students ON lesson_requests.student_id = students.student_id 
          WHERE lesson_requests.tutor_id = ? AND lesson_requests.status = 'Accepted'";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all lessons for the tutor
$lesson_query = "SELECT lessons.*, students.name AS student_name 
                 FROM lessons 
                 JOIN students ON lessons.student_id = students.student_id
                 WHERE lessons.tutor_id = ?
                 ORDER BY lessons.lesson_date DESC";
$stmt = $db->prepare($lesson_query);
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$lesson_result = $stmt->get_result();
$lessons = $lesson_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="admin/Imgs/Icon2.png" /> 
    <title>My Lessons</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
    .bg {
        background-color: #e8f5e9;
    }
    .text-color {
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
    .table-container::-webkit-scrollbar-thumb {
        background: #28a745;
        border-radius: 10px;
    }
    .table-bg {
        background: #28a745;
        color: white !important;
    }
</style>
<body class="bg">

<!-- Navbar -->
<?php require('components/navbar2.php'); ?> 

<div class="container mt-5 text-color">
    <h2 class="text-center">Accepted Students</h2>

    <?php if (!empty($students)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Add Lesson</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td>
                                <form action="handle_lessons.php" method="POST">
                                    <input type="hidden" name="action" value="add_lesson">
                                    <input type="hidden" name="tutor_id" value="<?php echo $tutor_id; ?>">
                                    <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                    <input type="text" name="title" placeholder="Lesson Title" required class="form-control mb-2">
                                    <textarea name="description" placeholder="Lesson Description" class="form-control mb-2"></textarea>
                                    <input type="date" name="lesson_date" required class="form-control mb-2">
                                    <button type="submit" class="btn btn-success btn-sm">Add Lesson</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="text-center">No students have accepted your requests yet.</p>
    <?php } ?>

    <h2 class="text-center mt-5">My Lessons</h2>

    <?php if (!empty($lessons)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Lesson Title</th>
                        <th>Student</th>
                        <th>Lesson Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $lesson['title']; ?></td>
                            <td><?php echo $lesson['student_name']; ?></td>
                            <td><?php echo $lesson['lesson_date']; ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo ($lesson['status'] == 'Completed') ? 'success' : 
                                         (($lesson['status'] == 'Upcoming') ? 'warning' : 'danger');
                                ?>">
                                    <?php echo $lesson['status']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="text-center mt-5">
            <h3><strong>No lessons yet</strong></h3>
            <p>As soon as you add a lesson, you'll see it here.</p>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
