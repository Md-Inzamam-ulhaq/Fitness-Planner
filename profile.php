<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

// Fetch current user data
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $username);
if ($stmt->execute() === false) {
    die("Error executing statement: " . $conn->error);
}
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    // Handle profile picture upload
    $profile_pic = 'default.png'; // Default profile picture
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if (in_array($file_type, ["jpg", "png", "jpeg"])) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $target_file;
            } else {
                echo "Error uploading file.";
            }
        }
    }

    // Update user information
    $stmt = $conn->prepare("UPDATE user SET username = ?, height = ?, weight = ?, profile_pic = ? WHERE id = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $new_username, $height, $weight, $profile_pic, $user['id']);
    if ($stmt->execute() === false) {
        die("Error executing statement: " . $conn->error);
    }

    $_SESSION['username'] = $new_username; // Update session username
    $_SESSION['success_msg'] = "Profile updated successfully."; // Store success message
    header("Location: home.php"); // Redirect to home page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile__container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
        <div class="profile__pic">
            <img src="<?php echo htmlspecialchars($user['profile_pic'] ? $user['profile_pic'] : 'default.png'); ?>" alt="Profile Picture" class="profile__image">
        </div>

        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="height">Height (cm):</label>
            <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>

            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" required>

            <label for="profile_pic">Change Profile Picture:</label>
            <input type="file" id="profile_pic" name="profile_pic">

            <input type="submit" value="Update Profile">
        </form>

        <nav>
            <a href="home.php">Home</a>
            <a href="planner.php">Gym & Diet Planner</a>
            <a href="tracker.php">Tracker</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</body>
</html>
