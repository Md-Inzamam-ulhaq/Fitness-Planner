<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user's details
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start the session
            $_SESSION['username'] = $user['username'];
            header("Location: home.php"); // Redirect to the home page
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No user found with that username.";
    }

    $conn->close();
}
?>
