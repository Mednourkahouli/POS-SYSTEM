<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['customer_id'])) {
    $customer_id = $_POST['customer_id'];

    // Prepare your DELETE statement
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$customer_id])) {
        // If successful, redirect back to the customer list
        header("Location: customer.php");
        exit;
    } else {
        // Handle failure
        echo "An error occurred.";
    }
} else {
    // Redirect if accessed without posting data
    header("Location: Customer.php");
    exit;
}
?>