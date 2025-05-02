<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:user_login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$services = [];

// Fetch all services
$result = $conn->query("SELECT id, name FROM services ORDER BY name");
while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, service_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $service_id, $date, $time);
    $stmt->execute();

    $message = "Appointment booked successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
</head>
<body>
    <h2>Book a Beauty Service</h2>

    <?php if (isset($message)): ?>
        <p style="color:green;"><?= $message ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="service">Choose Service:</label>
        <select name="service_id" id="service" required>
            <option value="">--Select--</option>
            <?php foreach ($services as $service): ?>
                <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required min="<?= date('Y-m-d') ?>">
        <br><br>

        <label for="time">Time:</label>
        <input type="time" name="time" id="time" required>
        <br><br>

        <input type="submit" value="Book Appointment">
    </form>
</body>
</html>
