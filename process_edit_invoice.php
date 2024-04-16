<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice_id = $_POST['invoice_id'];
    $customer_id = $_POST['customer_id'];
    $product_ids = $_POST['product_id'];
    $new_quantities = $_POST['quantity'];

    $pdo->beginTransaction();
    try {
        // Fetch the current quantities to compare
        $stmt = $pdo->prepare("SELECT product_id, quantity FROM invoice_items WHERE invoice_id = ?");
        $stmt->execute([$invoice_id]);
        $current_items = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $existing_product_ids = array_keys($current_items);

        // Update existing items or delete if not present in new submission
        foreach ($existing_product_ids as $product_id) {
            if (!in_array($product_id, $product_ids)) {
                // If item is not in the new list, delete it
                $stmt = $pdo->prepare("DELETE FROM invoice_items WHERE invoice_id = ? AND product_id = ?");
                $stmt->execute([$invoice_id, $product_id]);
            } else {
                // Update existing item
                $key = array_search($product_id, $product_ids);
                $new_quantity = $new_quantities[$key];
                $stmt = $pdo->prepare("UPDATE invoice_items SET quantity = ? WHERE invoice_id = ? AND product_id = ?");
                $stmt->execute([$new_quantity, $invoice_id, $product_id]);

                // Adjust stock based on the difference
                $quantity_difference = $current_items[$product_id] - $new_quantity;
                $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                $stmt->execute([$quantity_difference, $product_id]);
            }
        }

        // Insert new items that are not in existing products
        foreach ($product_ids as $index => $product_id) {
            if (!in_array($product_id, $existing_product_ids)) {
                $stmt = $pdo->prepare("INSERT INTO invoice_items (invoice_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$invoice_id, $product_id, $new_quantities[$index]]);
            }
        }

        $pdo->commit();
        header("Location: invoices.php");
    } catch (Exception $e) {
        $pdo->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>