<?php 
include "includes/header.php";

/* SUMMARY DATA */

$totalProducts =
$conn->query("SELECT COUNT(*) c FROM products")
->fetch_assoc()['c'];

$totalStock =
$conn->query("SELECT IFNULL(SUM(quantity),0) q FROM stock")
->fetch_assoc()['q'];

$totalSuppliers =
$conn->query("SELECT COUNT(*) c FROM suppliers")
->fetch_assoc()['c'];


/* STOCK DISTRIBUTION */

$chartQuery = $conn->query("
SELECT p.name,
IFNULL(SUM(s.quantity),0) qty

FROM products p

LEFT JOIN stock s
ON p.id=s.product_id

GROUP BY p.id
ORDER BY qty DESC
");

$labels=[];
$values=[];

while($row=$chartQuery->fetch_assoc()){

$labels[]=$row['name'];
$values[]=$row['qty'];

}


/* LOW STOCK */

$lowStock = $conn->query("
SELECT p.name,
IFNULL(SUM(s.quantity),0) qty

FROM products p

LEFT JOIN stock s
ON p.id=s.product_id

GROUP BY p.id

HAVING qty<=40

ORDER BY qty ASC
");


/* RECENT ACTIVITY */

$recentProducts = $conn->query("
SELECT name FROM products
ORDER BY id DESC
LIMIT 5
");

$recentSuppliers = $conn->query("
SELECT name FROM suppliers
ORDER BY id DESC
LIMIT 5
");

?>



<div class="main-container">

<h1 class="page-title">

<i class="fa-solid fa-chart-line"></i>

Dashboard Overview

</h1>



<!-- QUICK ACTIONS -->

<div class="quick-actions">

<a href="products.php" class="action-btn">
<i class="fa-solid fa-plus"></i>
Add Product
</a>

<a href="stock.php" class="action-btn">
<i class="fa-solid fa-layer-group"></i>
Update Stock
</a>

<a href="suppliers.php" class="action-btn">
<i class="fa-solid fa-truck"></i>
Add Supplier
</a>

</div>



<!-- STATS -->

<div class="dashboard-grid">



<div class="stat-card glow-card">

<i class="fa-solid fa-box stat-icon"></i>

<h2><?= $totalProducts ?></h2>

<p>Total Products</p>

<span class="mini-badge">Inventory Items</span>

</div>



<div class="stat-card glow-card">

<i class="fa-solid fa-layer-group stat-icon"></i>

<h2><?= $totalStock ?></h2>

<p>Total Stock</p>

<span class="mini-badge">Units Available</span>

</div>



<div class="stat-card glow-card">

<i class="fa-solid fa-truck stat-icon"></i>

<h2><?= $totalSuppliers ?></h2>

<p>Suppliers</p>

<span class="mini-badge">Partners</span>

</div>



</div>



<!-- MAIN GRID -->

<div class="dashboard-layout">



<!-- CHART -->

<div class="chart-section">

<div class="glass-card chart-card">

<h3>

<i class="fa-solid fa-chart-column"></i>

Stock Distribution

</h3>



<canvas id="stockChart"></canvas>

</div>

</div>



<!-- RIGHT SIDE -->

<div class="side-section">



<!-- LOW STOCK -->

<div class="glass-card info-box">

<h4>

<i class="fa-solid fa-triangle-exclamation"></i>

Low Stock Alert

</h4>



<table class="mini-table">

<?php while($row=$lowStock->fetch_assoc()){ ?>

<tr>

<td><?= $row['name'] ?></td>

<td>

<span class="badge low">

<?= $row['qty'] ?>

</span>

</td>

</tr>

<?php } ?>

</table>

</div>



<!-- RECENT ACTIVITY -->

<div class="glass-card info-box">

<h4>

<i class="fa-solid fa-clock"></i>

Recent Activity

</h4>



<p class="activity-title">

Products

</p>

<ul>

<?php while($p=$recentProducts->fetch_assoc()){ ?>

<li><?= $p['name'] ?></li>

<?php } ?>

</ul>



<p class="activity-title">

Suppliers

</p>

<ul>

<?php while($s=$recentSuppliers->fetch_assoc()){ ?>

<li><?= $s['name'] ?></li>

<?php } ?>

</ul>

</div>



<!-- QUICK LINKS -->

<div class="glass-card info-box">

<h4>

<i class="fa-solid fa-bolt"></i>

Quick Links

</h4>



<div class="quick-grid">

<a href="products.php" class="quick-btn">

Manage Products

</a>



<a href="suppliers.php" class="quick-btn">

Manage Suppliers

</a>



<a href="stock.php" class="quick-btn">

Update Inventory

</a>



<a href="reports.php" class="quick-btn">

View Reports

</a>

</div>



</div>



</div>



</div>



</div>



<script>

new Chart(

document.getElementById("stockChart"),

{

type:'bar',

data:{

labels:<?= json_encode($labels) ?>,

datasets:[{

label:'Stock Quantity',

data:<?= json_encode($values) ?>,

borderRadius:8

}]

},

options:{

plugins:{

legend:{

labels:{ color:'white'}

}

},

scales:{

x:{ ticks:{ color:'white'} },

y:{ ticks:{ color:'white'} }

}

}

});

</script>



<?php include "includes/footer.php"; ?>