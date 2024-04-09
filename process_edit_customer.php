<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("UPDATE customers SET name = ?, number = ?, address = ?, notes = ? WHERE id = ?");
    $stmt->execute([$name, $number, $address, $notes, $customer_id]);

    // Redirect back to the customer list or a confirmation page
    header("Location: customer.php");
    exit;
}

echo "Invalid request.";