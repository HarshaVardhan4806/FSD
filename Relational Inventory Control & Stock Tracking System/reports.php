<?php 
include "includes/header.php";

/* STOCK DATA FOR CHART */

$chartQuery = $conn->query("
SELECT p.name, IFNULL(SUM(s.quantity),0) qty
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

HAVING qty<=5
");


/* CATEGORY SUMMARY */

$categories = $conn->query("
SELECT category,
COUNT(*) total

FROM products

GROUP BY category
");


/* SUPPLIER REPORT */

$suppliers = $conn->query("
SELECT s.name,
COUNT(sp.product_id) total_products

FROM suppliers s

LEFT JOIN supplier_products sp
ON s.id=sp.supplier_id

GROUP BY s.id

ORDER BY total_products DESC
");

?>

<div class="main-container">

<h1 class="page-title">

<i class="fa-solid fa-chart-column"></i>

Reports & Analytics

</h1>



<!-- EXPORT BUTTON -->

<div class="quick-actions">

<a
href="reports.php?export=csv"
class="action-btn">

<i class="fa-solid fa-file-export"></i>

Export CSV

</a>

</div>



<div class="dashboard-grid">



<!-- STOCK CHART -->

<div class="glass-card">

<h3>

<i class="fa-solid fa-chart-simple"></i>

Stock Distribution

</h3>



<canvas id="stockChart"></canvas>

</div>



<!-- LOW STOCK -->

<div class="glass-card">

<h3>

<i class="fa-solid fa-triangle-exclamation"></i>

Low Stock Alert

</h3>



<table class="modern-table">

<tr>

<th>Product</th>

<th>Stock</th>

<th>Status</th>

</tr>



<?php

while($row=$lowStock->fetch_assoc()){

$status = $row['qty']==0 ? "Out of stock" : "Low";

?>

<tr>

<td><?= $row['name'] ?></td>

<td><?= $row['qty'] ?></td>

<td>

<span class="badge low">

<?= $status ?>

</span>

</td>

</tr>

<?php } ?>

</table>

</div>



</div>



<div class="dashboard-grid">



<!-- CATEGORY SUMMARY -->

<div class="glass-card">

<h3>

<i class="fa-solid fa-layer-group"></i>

Category Summary

</h3>



<table class="modern-table">

<tr>

<th>Category</th>

<th>Total Products</th>

</tr>



<?php

while($row=$categories->fetch_assoc()){

?>

<tr>

<td><?= $row['category'] ?></td>

<td><?= $row['total'] ?></td>

</tr>

<?php } ?>

</table>

</div>



<!-- SUPPLIER REPORT -->

<div class="glass-card">

<h3>

<i class="fa-solid fa-truck"></i>

Supplier Contribution

</h3>



<table class="modern-table">

<tr>

<th>Supplier</th>

<th>Products</th>

</tr>



<?php

while($row=$suppliers->fetch_assoc()){

?>

<tr>

<td><?= $row['name'] ?></td>

<td><?= $row['total_products'] ?></td>

</tr>

<?php } ?>

</table>

</div>



</div>



</div>



<script>

/* CHART */

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