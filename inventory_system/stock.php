<?php include "includes/header.php"; include "includes/db.php"; ?>

<div class="main-container">

<h1 class="page-title">Stock Management</h1>

<!-- UPDATE STOCK CARD -->
<div class="form-card">

<h3>Update Stock</h3>

<form method="POST" class="stock-form">

<select name="pid" required>
<option value="">Select Product</option>
<?php
$res=$conn->query("SELECT * FROM products");
while($r=$res->fetch_assoc()){
echo "<option value='$r[id]'>$r[name]</option>";
}
?>
</select>

<input type="number" name="qty" placeholder="Enter Quantity" required>

<button name="add">Update Stock</button>

</form>

</div>

<?php
if(isset($_POST['add'])){
$conn->query("INSERT INTO stock(product_id,quantity)
VALUES('$_POST[pid]','$_POST[qty]')");
echo "<script>location.reload();</script>";
}
?>

<!-- STOCK TABLE -->
<div class="table-card">

<h3>Current Stock</h3>

<table class="modern-table">
<tr>
<th>Product</th>
<th>Quantity</th>
</tr>

<?php
$res=$conn->query("
SELECT p.name, SUM(s.quantity) as qty
FROM stock s
JOIN products p ON s.product_id=p.id
GROUP BY p.id
");

while($row=$res->fetch_assoc()){
echo "<tr>
<td>$row[name]</td>
<td>$row[qty]</td>
</tr>";
}
?>

</table>

</div>

</div>