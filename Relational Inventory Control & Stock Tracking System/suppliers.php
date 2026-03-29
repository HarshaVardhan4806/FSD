<?php 
include "includes/header.php";


/* DELETE SUPPLIER */

if(isset($_GET['delete'])){

$id = intval($_GET['delete']);

$conn->query("
DELETE FROM supplier_products
WHERE supplier_id=$id
");

$conn->query("
DELETE FROM suppliers
WHERE id=$id
");

header("Location: suppliers.php");
exit();

}



/* REMOVE SINGLE PRODUCT */

if(isset($_POST['remove_product'])){

$supplierID = $_POST['supplier_id'];
$productID = $_POST['product_id'];

$conn->query("
DELETE FROM supplier_products

WHERE supplier_id=$supplierID
AND product_id=$productID
");

header("Location: suppliers.php");
exit();

}



/* ASSIGN PRODUCTS */

if(isset($_POST['assign_products_btn'])){

$supplierID = $_POST['supplier_id'];

$conn->query("
DELETE FROM supplier_products
WHERE supplier_id=$supplierID
");

if(!empty($_POST['assign_products'])){

foreach($_POST['assign_products'] as $pid){

$conn->query("
INSERT INTO supplier_products
(supplier_id,product_id)

VALUES($supplierID,$pid)
");

}

}

header("Location: suppliers.php");
exit();

}



/* ADD SUPPLIER */

if(isset($_POST['add'])){

$name = $_POST['name'];
$contact = $_POST['contact'];
$address = $_POST['address'];


/* CREATE PRODUCT IF ENTERED */

if(!empty($_POST['new_product_name'])){

$newName = $_POST['new_product_name'];
$newCategory = $_POST['new_product_category'];
$newPrice = $_POST['new_product_price'];

$newImage = $_FILES['new_product_image']['name'];

if($newImage){

move_uploaded_file(
$_FILES['new_product_image']['tmp_name'],
"images/".$newImage
);

}else{

$newImage="default.png";

}

$stmt=$conn->prepare("
INSERT INTO products(name,category,price,image)

VALUES(?,?,?,?)
");

$stmt->bind_param(
"ssds",
$newName,
$newCategory,
$newPrice,
$newImage
);

$stmt->execute();

$_POST['products'][]=$conn->insert_id;

}



/* INSERT SUPPLIER */

$stmt=$conn->prepare("
INSERT INTO suppliers(name,contact,address)

VALUES(?,?,?)
");

$stmt->bind_param(
"sss",
$name,
$contact,
$address
);

$stmt->execute();

$supplierID=$conn->insert_id;



/* LINK PRODUCTS */

if(!empty($_POST['products'])){

foreach($_POST['products'] as $pid){

$conn->query("
INSERT INTO supplier_products
(supplier_id,product_id)

VALUES($supplierID,$pid)
");

}

}

header("Location: suppliers.php");
exit();

}

?>



<div class="main-container">

<h1 class="page-title">

<i class="fa-solid fa-truck"></i>

Supplier Management

</h1>



<!-- ADD SUPPLIER -->

<div class="glass-card floating-card">

<h3>

<i class="fa-solid fa-user-plus"></i>

Add New Supplier

</h3>



<form method="POST" enctype="multipart/form-data" class="modern-form">

<input
type="text"
name="name"
placeholder="Supplier Name"
required>



<input
type="text"
name="contact"
placeholder="Contact Number"
required>



<label class="form-label">

Products Supplied

</label>



<div class="product-checkbox-grid">

<?php

$plist=$conn->query("
SELECT * FROM products
ORDER BY name
");

while($p=$plist->fetch_assoc()){

?>

<label class="product-check">

<input
type="checkbox"
name="products[]"
value="<?= $p['id'] ?>">

<span>

<i class="fa-solid fa-box"></i>

<?= $p['name'] ?>

</span>

</label>

<?php } ?>

</div>



<div class="new-product-section">

<div class="new-product-title">

Add New Product (optional)

</div>



<div class="new-product-grid">

<input
type="text"
name="new_product_name"
placeholder="Product Name">


<input
type="text"
name="new_product_category"
placeholder="Category">


<input
type="number"
name="new_product_price"
placeholder="Price">


<input
type="file"
name="new_product_image">

</div>

</div>



<label class="form-label">

Supplier Address

</label>



<textarea
name="address"
placeholder="Enter location"
class="modern-textarea"
required>

</textarea>



<button name="add" class="primary-btn">

Add Supplier

</button>



</form>

</div>



<!-- SUPPLIER TABLE -->

<div class="glass-card table-glass">

<h3>

Supplier List

</h3>



<table class="modern-table">

<tr>

<th>ID</th>
<th>Supplier</th>
<th>Products</th>
<th>Contact</th>
<th>Address</th>
<th>Actions</th>

</tr>



<?php

$res=$conn->query("

SELECT
s.id,
s.name,
s.contact,
s.address,

GROUP_CONCAT(
p.id,'|',p.name
SEPARATOR ','
) products

FROM suppliers s

LEFT JOIN supplier_products sp
ON s.id=sp.supplier_id

LEFT JOIN products p
ON sp.product_id=p.id

GROUP BY s.id

ORDER BY s.id ASC

");



while($row=$res->fetch_assoc()){

?>

<tr>

<td><?= $row['id'] ?></td>



<td>

<i class="fa-solid fa-building"></i>

<?= $row['name'] ?>

</td>



<td>

<div class="supplier-products">

<?php

if($row['products']){

$items=explode(",",$row['products']);

foreach($items as $item){

list($pid,$pname)=explode("|",$item);

?>



<span class="product-tag">

<a
href="products.php?highlight=<?= urlencode($pname) ?>">

<?= $pname ?>

</a>



<form method="POST" class="inline-form">

<input
type="hidden"
name="supplier_id"
value="<?= $row['id'] ?>">


<input
type="hidden"
name="product_id"
value="<?= $pid ?>">


<button
name="remove_product"
class="tag-remove">

×

</button>

</form>

</span>



<?php }

}else{

echo "<span class='empty-tag'>None</span>";

}

?>

</div>

</td>



<td><?= $row['contact'] ?></td>



<td>

<a
href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($row['address']) ?>"
target="_blank"
class="map-link location-link">

<i class="fa-solid fa-location-dot"></i>
<?= $row['address'] ?>

</a>

</td>



<td>

<button
type="button"
class="assign-btn"
onclick="toggleAssign(<?= $row['id'] ?>)">

Assign

</button>



<a
href="suppliers.php?delete=<?= $row['id'] ?>"
class="delete-btn">

Delete

</a>

</td>

</tr>



<!-- DROPDOWN ROW -->

<tr
id="assignRow<?= $row['id'] ?>"
class="assign-row">

<td colspan="6">

<form method="POST">

<input
type="hidden"
name="supplier_id"
value="<?= $row['id'] ?>">



<div class="product-checkbox-grid">

<?php

$plist=$conn->query("
SELECT * FROM products
ORDER BY name
");

while($p=$plist->fetch_assoc()){


$checked=$conn->query("
SELECT * FROM supplier_products

WHERE supplier_id=".$row['id']."
AND product_id=".$p['id']."
")->num_rows>0;

?>



<label class="product-check">

<input
type="checkbox"
name="assign_products[]"
value="<?= $p['id'] ?>"

<?= $checked ? "checked":"" ?>

>

<span>

<?= $p['name'] ?>

</span>

</label>



<?php } ?>

</div>



<button
name="assign_products_btn"
class="primary-btn small-btn">

Save

</button>



</form>

</td>

</tr>



<?php } ?>

</table>

</div>

</div>



<script>

function toggleAssign(id){

document
.querySelectorAll(".assign-row")

.forEach(r=>{

if(r.id!="assignRow"+id){

r.style.display="none";

}

});



let row=document.getElementById("assignRow"+id);

row.style.display=

row.style.display=="table-row"

? "none"

: "table-row";

}

</script>



<?php include "includes/footer.php"; ?>