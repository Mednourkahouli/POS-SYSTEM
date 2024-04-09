<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

form {
    max-width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
}

.input,
textarea {
    width: 100%;
    padding: 10px;
    margin: 5px 0 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.input:focus,
textarea:focus {
    outline: none;
    border-color: #007bff;
}

.submit {
    background-color: #2f3542;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.submit:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
    </div>

<form action="add_customer_process.php" method="POST">
    <label class="name"for="name">Name:</label><br>
    <input class="input"type="text" id="name" name="name" required><br>

    <label for="number">Number:</label><br>
    <input class="input" type="text" id="number" name="number" required><br>

    <label for="address">Address:</label><br>
    <input class="input" type="text" id="address" name="address"><br>

    <label class="note" for="notes">Notes:</label><br>
    <textarea id="notes" name="notes"></textarea><br><br>

    <input class="submit"type="submit" value="Add Customer">
</form>

</body>
</html>