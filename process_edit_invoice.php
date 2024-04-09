<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $invoice_id = $_POST['invoice_id'];
    $customer_id = $_POST['customer_id'];
    $date = $_POST['date'];
    $total = $_POST['total'];

    // Update the invoice
    $stmt = $pdo->prepare("UPDATE invoices SET date = ?, total = ? WHERE id = ?");
    if ($stmt->execute([$date, $total, $invoice_id])) {
        echo "Invoice updated successfully.";
        header("Location: invoices.php?customer_id=" . urlencode($customer_id)); // Redirect back to the invoice list
        exit;
    } else {
        echo "Error updating invoice.";
    }
} else {
    echo "Invalid request.";
    exit;
}
?>