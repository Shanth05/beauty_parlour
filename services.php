<?php
include 'config.php';

$services = [];

$result = $conn->query("SELECT * FROM services ORDER BY category, name");

while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beauty Services</title>
</head>
<body>
    <h2>Available Services</h2>
    <?php foreach ($services as $service): ?>
        <div>
            <h3><?= htmlspecialchars($service['name']) ?> (<?= $service['category'] ?>)</h3>
            <p><?= htmlspecialchars($service['description']) ?></p>
            <p>Duration: <?= $service['duration_minutes'] ?> mins | Price: $<?= $service['price'] ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
