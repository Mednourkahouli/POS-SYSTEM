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
    <title>Invoices</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}



h2 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
}

table th {
    background-color: #f2f2f2;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #e9e9e9;
}

.actions a, .actions button {
    padding: 5px 10px;
    margin-right: 5px;
    text-decoration: none;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.actions a {
    background-color: #3498db;
}

.actions button {
    background-color: #e74c3c;
}

.actions button:hover {
    background-color: #c0392b;
}

.actions form {
    display: inline;
    margin: 0;
}

.goBack {
    margin-top: 20px;
}

.goBack a {
    background-color: #2f3542;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    display: inline-block;
}

    </style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
    </div>

<?php
include 'db.php'; // Ensure this points to your database connection script

$customer_id = $_GET['customer_id'] ?? null;

if (!$customer_id) {
    echo "Customer ID is required.";
    exit;
}

// Fetch customer name
$stmt = $pdo->prepare("SELECT name FROM customers WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>Invoices for {$customer['name']}</h2>";

// Fetch the invoices for the given customer ID
$stmt = $pdo->prepare("SELECT * FROM invoices WHERE customer_id = ?");
$stmt->execute([$customer_id]);
$invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($invoices)) {
    echo "No invoices found for this customer.";
} else {
    echo "<table border='1'>
            <tr>
                <th>Invoice ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>";
    foreach ($invoices as $invoice) {
        echo "<tr>
                <td>{$invoice['id']}</td>
                <td>{$invoice['date']}</td>
                <td>{$invoice['total']}</td>
                <td>
                <a href='edit_invoice.php?invoice_id={$invoice['id']} & customer_id={$customer_id}'>Edit</a>
            |
                    <form style='display:inline' action='delete_invoice.php' method='post' onsubmit='return confirm('Are you sure you want to delete this invoice?');'>
                        <input type='hidden' name='invoice_id' value='{$invoice['id']}'>
                        <input type='hidden' name='customer_id' value='{$customer_id}'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
}

// Go Back link
echo "<div style='margin-top: 20px;'>
        <a href='customer.php' style='background-color: #2f3542; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;'>Go Back</a>
      </div>";
?>
</body>
</html>