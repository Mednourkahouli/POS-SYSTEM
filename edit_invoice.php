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
    <title>Edit Invoice</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}
h2 {
    color: #333;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #666;
}

input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #2f3542;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error {
    color: #ff0000;
    font-style: italic;
}

    </style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
    </div>

<?php
include 'db.php';
$invoice_id = $_GET['invoice_id'] ?? null;
$customer_id = $_GET['customer_id'] ?? null;

if (!$invoice_id || !$customer_id) {
    echo "Invoice ID and Customer ID are required.";
    exit;
}

// Fetch invoice data
$stmt = $pdo->prepare("SELECT * FROM invoices WHERE id = ?");
$stmt->execute([$invoice_id]);
$invoice = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$invoice) {
    echo "Invoice not found.";
    exit;
}
$stmt = $pdo->prepare("SELECT name FROM customers WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo "Customer not found.";
    exit;
}
?>

<h2>Edit Invoice for <?php echo $customer['name']; ?></h2>

<form action="process_edit_invoice.php" method="POST" onsubmit="return validateForm()">
    <input type="hidden" name="invoice_id" value="<?php echo htmlspecialchars($invoice_id); ?>">
    <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">

    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date" value="<?php echo $invoice['date']; ?>" required><br>

    <label for="total">Total:</label><br>
    <input type="number" id="total" name="total" value="<?php echo $invoice['total']; ?>" step="0.01" required><br>

    <input type="submit" value="Update Invoice">
</form>
<script>
    function validateForm() {
        var totalInput = document.getElementById("total").value;
        if (totalInput <= 0) {
            alert("Total must be a positive value.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>