<?php
// Start the session to access session variables
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired location
header("Location: login.php"); // Replace 'login.php' with the path to your login page
exit();
?>