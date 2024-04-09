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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <style> 
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #2f3542;
}
th {
  background-color: #2f3542;
  color: white;
}
.edit-button {
  background-color: #2f3542;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.remove-button {
    background-color: #2f3542;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.Invoicecontainer{
  display:flex;
  justify-content:center;
  
}
.Invoice{
  background-color: #2f3542;
  color: white;
  border: none;
  padding: 10px 20px;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

</style>
</head>
<body>
<div class="container header-nav">
    <?php include 'navbar.php'; ?>
    </div>

<?php

include 'db.php';


$stmt = $pdo->query("SELECT * FROM customers");
?>

<table>
  <tr>
    <th>Name</th>
    <th>Number</th>
    <th>Address</th>
    <th>Notes</th>
    <th>Invoice</th>
    <th>Edit</th>
    <th>Remove</th>
  </tr>
  <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <tr>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo htmlspecialchars($row['number']); ?></td>
      <td><?php echo htmlspecialchars($row['address']); ?></td>
      <td><?php echo htmlspecialchars($row['notes']); ?></td>
      <td><a href="invoices.php?customer_id=<?php echo $row['id']; ?>" class="edit-button">Invoices</a></td>
      <td><a href="edit_customer.php?customer_id=<?php echo $row['id']; ?>" class="edit-button">Edit</a></td>
      <td><form action="remove_customer.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this customer?');">
          <input type="hidden" name="customer_id" value="<?php echo $row['id']; ?>">
          <button type="submit" class="remove-button">Remove</button>
        </form></td>
    </tr>
  <?php endwhile; ?>
</table>
<br>
<br>
<div class="Invoicecontainer">
  <a href="Add_customer.php" class="Invoice">Create Customer</a> 
  <a href="create_invoice.php" class="Invoice">Create Invoice</a> 
</div>

</body>
</html>