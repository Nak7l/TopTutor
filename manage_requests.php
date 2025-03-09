<?php
include 'db_connect.php';

$student = $_SESSION['student'];

// Fetch lesson requests for the logged-in student
$query = "SELECT lesson_requests.id, tutors.name 
          FROM lesson_requests 
          INNER JOIN tutors ON lesson_requests.tutor_id = tutors.tutor_id 
          WHERE lesson_requests.student_id = ? AND lesson_requests.status = 'Pending'";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $student);
$stmt->execute();
$result = $stmt->get_result();
$requests = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Lesson Requests</title>
</head>
<body>
    <h2>Pending Lesson Requests</h2>
    <?php foreach ($requests as $request): ?>
        <p>Request from Tutor: <?php echo htmlspecialchars($request['name']); ?></p>
        <form action="handle_request.php" method="POST">
            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
            <button type="submit" name="action" value="accept">Accept</button>
            <button type="submit" name="action" value="decline">Decline</button>
        </form>
    <?php endforeach; ?>
</body>
</html>
