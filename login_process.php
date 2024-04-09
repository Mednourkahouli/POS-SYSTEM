<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

    $sql = "SELECT id, username, password FROM employer WHERE username = :username";
    $stmt = $pdo->prepare($sql);

    // Binding the value to prevent SQL injection
    $stmt->bindValue(':username', $username);

    // Execute the statement
    $stmt->execute();

    // Fetch the user row
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user === false) {
        echo "<script>alert('Incorrect username!'); window.location.href='login.php';</script>";
    } else {
        // Verify the provided password with the hashed password from the database
        if (password_verify($passwordAttempt, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

            header('Location: Customer.php');
            exit;
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.php';</script>";
        }
    }
} else {
    echo "<script>alert('Form was not submitted.'); window.location.href='login.php';</script>";
}
?>
