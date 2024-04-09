<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invoice_id'])) {
    $invoice_id = $_POST['invoice_id'];
    $customer_id = $_POST['customer_id']; // For redirecting back

    // Prepare the DELETE statement
    $stmt = $pdo->prepare("DELETE FROM invoices WHERE id = ?");
    $stmt->execute([$invoice_id]);

    // Redirect back to the invoices list for the customer
    header("Location: invoices.php?customer_id=" . urlencode($customer_id));
    exit;
} else {
    // Redirect to a default page if accessed incorrectly
    header("Location: customer.php");
    exit;
}
?>