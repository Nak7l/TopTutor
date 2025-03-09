<?php
// include 'db_connect.php';
$tutor = $_SESSION['tutor']; // Tutor or Student ID

// Fetch unread notification count
$query = "SELECT COUNT(*) AS count FROM notifications WHERE tutor_id = ? AND status = 'unread'";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $tutor);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$notification_count = $row['count'];
?>

<style>
    .bg{
        background-color: #e8f5e9;
    }
    .bell{
        background-color: #0C0B60;
        color: #0C0B60;
    }
    .hr{
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>

<!-- Bootstrap Notification Icon -->
<div class="dropdown">
    <button class="btn text-color position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <img
            src="admin/Imgs/bell.svg"
            width="22"
            height="22"
            class="rounded-circle"
            style="border-radius: 50%;"
        />
        <?php if ($notification_count > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $notification_count; ?>
            </span>
        <?php endif; ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end bg" aria-labelledby="notificationDropdown">
        <li><h6 class="dropdown-header">Notifications</h6></li>
        <hr class="hr">

        <?php
        // Fetch latest notifications
        $query = "SELECT id, message FROM notifications WHERE tutor_id = ? ORDER BY created_at DESC LIMIT 5";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $tutor);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li><a class='dropdown-item' href='notifications.php?id=" . $row['id'] . "'>" . $row['message'] . "</a></li>";
            }
        } else {
            echo "<li><a class='dropdown-item text-muted'>No new notifications</a></li>";
        }
        ?>
    </ul>
</div>
