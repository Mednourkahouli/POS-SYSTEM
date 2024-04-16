<?php
include 'db.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $products = $_POST['product_id']; // Array of product IDs
    $quantities = $_POST['quantity']; // Array of quantities
    $payment_method = $_POST['payment_method'];
    $date = date('Y-m-d H:i:s'); // Current date and time
    $total = 0;

    // Start a transaction
    $pdo->beginTransaction();
    try {
        // Calculate total and update product stock
        foreach ($products as $i => $product_id) {
            $quantity = $quantities[$i];

            // Fetch the product price and stock
            $stmt = $pdo->prepare("SELECT price, stock FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product['stock'] < $quantity) {
                throw new Exception("Insufficient stock for product ID: $product_id");
            }

            // Calculate total price for this item
            $item_total = $product['price'] * $quantity;
            $total += $item_total;

            // Update stock
            $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$quantity, $product_id]);
        }

        // Insert the invoice
        $stmt = $pdo->prepare("INSERT INTO invoices (customer_id, date, total, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->execute([$customer_id, $date, $total, $payment_method]);
        $invoice_id = $pdo->lastInsertId(); // Get the last inserted invoice ID

        // Insert invoice items
        foreach ($products as $i => $product_id) {
            $quantity = $quantities[$i];

            // Fetch the product price again (could be optimized)
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            $item_total = $product['price'] * $quantity;

            $stmt = $pdo->prepare("INSERT INTO invoice_items (invoice_id, product_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$invoice_id, $product_id, $quantity, $product['price'], $item_total]);
        }

        // Commit transaction
        $pdo->commit();
        header("Location: customer.php");
        exit;
    } catch (Exception $e) {
        // An error occurred; rollback transaction
        $pdo->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
    exit;
}
?>