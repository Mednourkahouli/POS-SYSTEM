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
    <title>Create Invoice</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
}

form {
    max-width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

select,
input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #2f3542;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}


        </style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
    </div>

<h2>Create Invoice</h2>

<form action="process_create_invoice.php" method="POST" onsubmit="return validateForm()">
    <label for="customer_id">Customer:</label>
    <br>
    <br>
    <select id="customer_id" name="customer_id" required>
        <option value="">Select a Customer</option>
        <?php
        include 'db.php'; // Ensure this points to your database connection script
        $stmt = $pdo->query("SELECT id, name FROM customers");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>
    <br>
    <br>

    <label for="date">Date:</label>
    <br>
    <br>
    <input type="date" id="date" name="date" required>
    <br>
    <br>

    <label for="total">Total:</label><br>
    <input type="number" id="total" name="total" step="0.01" required>
    <br>
    <br>

    <input class="submit" type="submit" value="Create Invoice">
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