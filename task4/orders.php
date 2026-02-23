<?php
$conn = new mysqli("localhost", "root", "", "college");

$sql = "
SELECT c.name, p.product_name, o.quantity, p.price,
       (o.quantity * p.price) AS total, o.order_date
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN products p ON o.product_id = p.product_id
ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<style>
    body { font-family: Arial; }
    table {
        border-collapse: collapse;
        width: 80%;
        margin: auto;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }
    th { background: #333; color: white; }
</style>
</head>
<body>

<h2 style="text-align:center">🛒 Customer Order History</h2>

<table>
<tr>
    <th>Customer</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Total</th>
    <th>Date</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['product_name'] ?></td>
    <td><?= $row['quantity'] ?></td>
    <td><?= $row['price'] ?></td>
    <td><?= $row['total'] ?></td>
    <td><?= $row['order_date'] ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>
