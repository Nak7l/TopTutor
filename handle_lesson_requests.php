<?php
include 'db_connect.php';

if (isset($_POST['accept']) || isset($_POST['decline'])) {
    $request_id = $_POST['request_id'];
    $status = isset($_POST['accept']) ? 'Accepted' : 'Declined';

    // Update request status
    $stmt = $db->prepare("UPDATE lesson_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        if ($status == 'Accepted') {
            echo "Request accepted! The tutor will be notified.";
        } else {
            echo "Request declined.";
        }
    } else {
        echo "Failed to update request status.";
    }
}
?>
