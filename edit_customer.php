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
    <title>Edit Customer</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
h2 {
    text-align: center;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #2f3542;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.error {
    color: red;
}

    </style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
    </div>

<?php
include 'db.php'; // Your database connection file
$customer_id = $_GET['customer_id'] ?? null;

if (!$customer_id) {
    echo "Customer ID is required.";
    exit;
}

// Fetch the customer's data
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo "Customer not found.";
    exit;
}
?>

<h2>Edit Customer</h2>
<form action="process_edit_customer.php" method="POST">
    <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer['id']); ?>">

    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required><br>

    <label for="number">Number:</label><br>
    <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($customer['number']); ?>" required><br>

    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>"><br>

    <label for="notes">Notes:</label><br>
    <textarea id="notes" name="notes"><?php echo htmlspecialchars($customer['notes']); ?></textarea><br><br>

    <input type="submit" value="Update Customer">
</form>

</body>
</html>