<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $date = $_POST['date'];
    $total = $_POST['total'];

    $stmt = $pdo->prepare("INSERT INTO invoices (customer_id, date, total) VALUES (?, ?, ?)");
    if ($stmt->execute([$customer_id, $date, $total])) {
        echo "Invoice created successfully.";
        header("Location: Customer.php");
        exit;
    } else {
        echo "Error creating invoice.";
    }
} else {
    echo "Invalid request.";
    exit;
}
?>