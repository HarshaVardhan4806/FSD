<?php include "includes/header.php"; include "includes/db.php"; ?>

<div class="main-container">

<h1 class="page-title">Dashboard Overview</h1>

<?php
$p=$conn->query("SELECT COUNT(*) c FROM products")->fetch_assoc();
$s=$conn->query("SELECT SUM(quantity) q FROM stock")->fetch_assoc();
?>

<div class="cards">

<div class="dashboard-card">
<div class="icon">📦</div>
<h2><?php echo $p['c']; ?></h2>
<p>Total Products</p>
</div>

<div class="dashboard-card">
<div class="icon">📊</div>
<h2><?php echo $s['q'] ?: 0; ?></h2>
<p>Total Stock</p>
</div>

<div class="dashboard-card">
<div class="icon">🚚</div>
<h2><?php echo $conn->query("SELECT COUNT(*) c FROM suppliers")->fetch_assoc()['c']; ?></h2>
<p>Suppliers</p>
</div>

</div>

<div class="chart-container">
<h3>Stock Distribution</h3>
<canvas id="chart"></canvas>
</div>

</div>

<script>
fetch('reports.php?chart=1')
.then(res=>res.json())
.then(data=>{
new Chart(document.getElementById("chart"),{
type:'bar',
data:{
labels:data.labels,
datasets:[{
label:'Stock Quantity',
data:data.values,
backgroundColor:'#ff9900'
}]
}
});
});
</script>