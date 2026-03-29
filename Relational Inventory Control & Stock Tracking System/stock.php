<?php 
include "includes/header.php";


// UPDATE STOCK (PREVENT MULTIPLE INSERT)
if(isset($_POST['add'])){

$pid = $_POST['pid'];
$qty = $_POST['qty'];

$stmt = $conn->prepare("INSERT INTO stock(product_id,quantity) VALUES(?,?)");
$stmt->bind_param("ii",$pid,$qty);
$stmt->execute();

header("Location: stock.php?updated=1");
exit();
}
?>


<div class="main-container">

<h1 class="page-title">
<i class="fa-solid fa-layer-group"></i> Stock Management
</h1>



<!-- UPDATE STOCK -->
<div class="glass-card floating-card">

<h3>
<i class="fa-solid fa-warehouse"></i> Update Stock
</h3>

<form method="POST" class="modern-form">

<select name="pid" required>

<option value="">Select Product</option>

<?php
$res=$conn->query("SELECT * FROM products ORDER BY name ASC");

while($r=$res->fetch_assoc()){
?>

<option value="<?= $r['id'] ?>">
<?= $r['name'] ?>
</option>

<?php } ?>

</select>


<input type="number" name="qty" placeholder="Enter Quantity" required>


<button name="add" class="primary-btn">

<i class="fa-solid fa-plus"></i>
Update Stock

</button>

</form>

</div>




<!-- STOCK TABLE -->
<div class="glass-card table-glass">

<h3>
<i class="fa-solid fa-chart-column"></i> Current Stock
</h3>


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
ORDER BY qty DESC
");


while($row=$res->fetch_assoc()){
?>

<tr>

<td>

<i class="fa-solid fa-box"></i>
<?= $row['name'] ?>

</td>

<td>

<span class="stock-badge">

<?= $row['qty'] ?>

</span>

</td>

</tr>

<?php } ?>


</table>

</div>


</div>

<?php include "includes/footer.php"; ?>