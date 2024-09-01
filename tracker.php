<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM plans WHERE username='$username'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Your Fitness Tracker</h1>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
        <li><?php echo $row['plan_type'] . " Plan for " . $row['goal'] . ": " . $row['plan']; ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
