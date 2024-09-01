<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- <link rel="stylesheet" href="login.css"> -->
     <link rel="stylesheet" href="login.css">
     <style>
        body {
           background-image: url(bg.jpg);
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
<div class="main-content">
        <h1>Register</h1>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="contact">Contact Number:</label>
        <input type="tel" id="contact" name="contact" required><br><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>
        <label for="height">Height (cm):</label>
        <input type="number" id="height" name="height" required><br><br>
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" required><br><br>
        <input id="btn" type="submit" value="Register">
    </form></div>

    <?php
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $gender = $_POST['gender'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (username, password, email, contact, gender, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $username, $password, $email, $contact, $gender, $height, $weight);

        if ($stmt->execute()) {
            // Redirect to home page after successful registration
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
