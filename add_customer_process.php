<?php
// Include your database connection script
include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $number = $_POST['number'] ?? '';
    $address = $_POST['address'] ?? '';
    $notes = $_POST['notes'] ?? '';

    // Prepare SQL to prevent SQL injection
    $sql = "INSERT INTO customers (name, number, address, notes) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute statement
    if ($stmt->execute([$name, $number, $address, $notes])) {
        echo "Customer added successfully.";
        // Redirect back to the customer list or to a success page
        header("Location: Customer.php");
    } else {
        echo "Error adding customer.";
    }
} else {
    // Not a POST request
    echo "Invalid request.";
}
?>