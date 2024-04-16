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
            max-width: 500px;
            margin: 20px auto;
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

        select, input[type="date"], input[type="number"], input[type="text"] {
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

        .product-item {
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .remove-product {
            color: red;
            cursor: pointer;
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
    <select id="customer_id" name="customer_id" required>
        <option value="">Select a Customer</option>
        <?php
        include 'db.php';
        $stmt = $pdo->query("SELECT id, name FROM customers");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    <div id="product-entries">
        <div class="product-item">
            <label for="products">Product:</label>
            <select name="product_id[]" required onchange="updateTotal()">
                <option value="">Select a Product</option>
                <?php
                $stmt = $pdo->query("SELECT id, name, price,stock FROM products");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}' data-price='{$row['price']}' data-stock='{$row['stock']}'>{$row['name']} - {$row['price']} $ (Stock: {$row['stock']})</option>";
                }
                ?>
            </select>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity[]" min="1" step="1" required onchange="updateTotal()">
        </div>
    </div>

    <button type="button" onclick="addProduct()">Add Another Product</button>
    <br><br>
    <label for="payment_method">Payment Method:</label>
<select id="payment_method" name="payment_method" required>
    <option value="">Select a Payment Method</option>
    <option value="cash">Cash</option>
    <option value="credit_card">Credit Card</option>
    <br>
<br>
</select>
    <label>Total:</label>
    <input type="text" id="total" readonly>
    <br><br>

    <input type="submit" value="Create Invoice">
</form>

<script>
    function addProduct() {
        var container = document.getElementById("product-entries");
        var newProduct = document.querySelector(".product-item").cloneNode(true);
        newProduct.querySelector("select[name='product_id[]']").onchange = updateTotal;
        newProduct.querySelector("input[name='quantity[]']").onchange = updateTotal;
        container.appendChild(newProduct);
    }

    function updateTotal() {
    var total = 0;
    var allItemsValid = true;
    var entries = document.querySelectorAll(".product-item");

    entries.forEach(entry => {
        var select = entry.querySelector("select[name='product_id[]']");
        var quantityInput = entry.querySelector("input[name='quantity[]']");
        var price = select.options[select.selectedIndex].dataset.price || 0;
        var stock = parseInt(select.options[select.selectedIndex].dataset.stock || 0);
        var quantity = parseInt(quantityInput.value || 0);

        if (quantity > stock) {
            alert(`Only ${stock} units available for ${select.options[select.selectedIndex].text.trim().split(" -")[0]}, but ${quantity} units were requested.`);
            allItemsValid = false;
            quantityInput.value = stock; // Optional: reset the value to max available stock
        }

        total += price * quantity;
    });

    document.getElementById("total").value = total.toFixed(2) + "$";

    return allItemsValid; // This tells you if any of the items are invalid
}

function validateForm() {
    // Call updateTotal and check if all items are valid
    if (!updateTotal()) {
        alert("Please correct the quantities based on stock availability.");
        return false;
    }

    var totalInput = document.getElementById("total").value;
    if (parseFloat(totalInput) <= 0) {
        alert("Total must be a positive value.");
        return false;
    }
    return true;
}
</script>
</body>
</html>