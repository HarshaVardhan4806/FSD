<?php include "includes/header.php"; include "includes/db.php"; ?>

<div class="main-container">

<h1 class="page-title">Reports & Analytics</h1>

<?php
$totalProducts = $conn->query("SELECT COUNT(*) c FROM products")->fetch_assoc()['c'];
$totalStock = $conn->query("SELECT SUM(quantity) q FROM stock")->fetch_assoc()['q'];
$totalSuppliers = $conn->query("SELECT COUNT(*) c FROM suppliers")->fetch_assoc()['c'];
?>

<!-- SUMMARY CARDS -->
<div class="cards">

<div class="dashboard-card">
<div class="icon">📦</div>
<h2><?php echo $totalProducts; ?></h2>
<p>Total Products</p>
</div>

<div class="dashboard-card">
<div class="icon">📊</div>
<h2><?php echo $totalStock ?: 0; ?></h2>
<p>Total Stock</p>
</div>

<div class="dashboard-card">
<div class="icon">🚚</div>
<h2><?php echo $totalSuppliers; ?></h2>
<p>Total Suppliers</p>
</div>

</div>

<!-- CHART SECTION -->
<div class="chart-container">
<h3>Stock Distribution by Product</h3>
<canvas id="stockChart"></canvas>
</div>

<!-- STOCK TABLE -->
<div class="table-card">

<h3>Detailed Stock Report</h3>

<table class="modern-table">
<tr>
<th>Product</th>
<th>Category</th>
<th>Price</th>
<th>Total Stock</th>
</tr>

<?php
$res = $conn->query("
SELECT p.name,p.category,p.price,SUM(s.quantity) qty
FROM products p
LEFT JOIN stock s ON p.id=s.product_id
GROUP BY p.id
");

while($row = $res->fetch_assoc()){
echo "<tr>
<td>$row[name]</td>
<td>$row[category]</td>
<td>₹ $row[price]</td>
<td>".($row['qty'] ?: 0)."</td>
</tr>";
}
?>

</table>

</div>

</div>

<script>
const labels = [];
const values = [];

<?php
$chart = $conn->query("
SELECT p.name,SUM(s.quantity) qty
FROM products p
LEFT JOIN stock s ON p.id=s.product_id
GROUP BY p.id
");

while($row=$chart->fetch_assoc()){
echo "labels.push('$row[name]');";
echo "values.push(".($row['qty'] ?: 0).");";
}
?>

new Chart(document.getElementById("stockChart"),{
type:'bar',
data:{
labels:labels,
datasets:[{
label:'Stock Quantity',
data:values,
backgroundColor:'#ff9900'
}]
}
});
</script>