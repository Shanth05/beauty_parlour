<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$appointments = [];

$stmt = $conn->prepare("SELECT a.id, s.name AS service, s.duration_minutes, s.price, a.appointment_date, a.appointment_time, a.status
                        FROM appointments a
                        JOIN services s ON a.service_id = s.id
                        WHERE a.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Appointments</title>
</head>
<body>
    <h2>Your Appointments</h2>
    <table border="1">
        <tr>
            <th>Service</th>
            <th>Duration</th>
            <th>Price</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php foreach ($appointments as $appt): ?>
            <tr>
                <td><?= htmlspecialchars($appt['service']) ?></td>
                <td><?= $appt['duration_minutes'] ?> mins</td>
                <td>$<?= $appt['price'] ?></td>
                <td><?= $appt['appointment_date'] ?></td>
                <td><?= $appt['appointment_time'] ?></td>
                <td><?= $appt['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>