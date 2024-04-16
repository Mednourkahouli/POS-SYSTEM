<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$invoice_id = $_GET['invoice_id'] ?? null;
$customer_id = $_GET['customer_id'] ?? null;

if (!$invoice_id || !$customer_id) {
    echo "Invoice ID and Customer ID are required.";
    exit;
}

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

$stmt = $pdo->prepare("SELECT ii.*, p.name, p.price, p.stock FROM invoice_items ii JOIN products p ON ii.product_id = p.id WHERE ii.invoice_id = ?");
$stmt->execute([$invoice_id]);
$invoice_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>'; print_r($invoice_items); echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        h2 { text-align: center; }
        form { max-width: 500px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        select, input[type="date"], input[type="number"], input[type="text"] { width: 100%; padding: 10px; margin: 5px 0 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        input[type="submit"] { background-color: #2f3542; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .product-item { padding-bottom: 10px; border-bottom: 1px solid #eee; margin-bottom: 20px; position: relative; }
        .remove-product { color: red; cursor: pointer; position: absolute; right: 0; top: 0; }
    </style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
</div>

<h2>Edit Invoice for <?php echo htmlspecialchars($customer['name']); ?></h2>

<form action="process_edit_invoice.php" method="POST" onsubmit="return validateForm()">
    <input type="hidden" name="invoice_id" value="<?php echo htmlspecialchars($invoice_id); ?>">
    <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">

    <div id="product-entries">
        <?php foreach ($invoice_items as $item): ?>
            <div class="product-item" data-product-id="<?php echo $item['product_id']; ?>">
                <label>Product: <?php echo htmlspecialchars($item['name']); ?></label>
                <label>Price: $<?php echo htmlspecialchars($item['price']); ?></label>
                <label>Available Stock: <?php echo htmlspecialchars($item['stock']); ?></label>
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity[]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" required>
                <button type="button" class="remove-product" onclick="removeProduct(this)">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="button" onclick="addProduct()">Add Another Product</button>
    <input type="submit" value="Update Invoice">
</form>

<script>
function addProduct() {
    var container = document.getElementById("product-entries");
    var newProduct = document.querySelector(".product-item").cloneNode(true);
    newProduct.querySelector("input[type='number']").value = 1; // Reset quantity for new products
    newProduct.querySelector(".remove-product").onclick = function() { removeProduct(this); };
    container.appendChild(newProduct);
}

function removeProduct(element) {
    var productItem = element.parentNode;
    productItem.parentNode.removeChild(productItem);
    updateTotal();
}

function updateTotal() {
    var total = 0;
    var entries = document.querySelectorAll(".product-item");
    entries.forEach(entry => {
        var price = parseFloat(entry.dataset.price);
        var quantity = parseInt(entry.querySelector("input[type='number']").value);
        total += price * quantity;
    });
    document.getElementById('total').value = total.toFixed(2) + "$";
}

function validateForm() {
    var total = parseFloat(document.getElementById("total").value);
    if (total <= 0) {
        alert("Total must be a positive value.");
        return false;
    }
    return true;
}
document.addEventListener('DOMContentLoaded', updateTotal);
</script>
</body>
</html>