<?php
include 'db.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $stmt = $pdo->prepare("INSERT INTO employer (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);

    // Redirect to login page after successful sign up
    header("Location: login.php");
    exit;
}
?>
