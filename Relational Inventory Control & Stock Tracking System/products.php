<?php 
include "includes/header.php";

/* HIGHLIGHT PRODUCT FROM SUPPLIER PAGE */
$highlight = $_GET['highlight'] ?? null;



/* DELETE PRODUCT */
if(isset($_POST['delete_id'])){

$id = $_POST['delete_id'];

/* get image */
$get = $conn->query("SELECT image FROM products WHERE id=$id");

$img = $get->fetch_assoc()['image'];


/* remove relations first */

$conn->query("DELETE FROM supplier_products WHERE product_id=$id");

/* delete stock */

$conn->query("DELETE FROM stock WHERE product_id=$id");


/* delete image file */

if(file_exists("images/".$img)){

unlink("images/".$img);

}


/* delete product */

$conn->query("DELETE FROM products WHERE id=$id");


header("Location: products.php");

exit();

}



/* ADD PRODUCT */

if(isset($_POST['add'])){

$name = $_POST['name'];

$category = $_POST['category'];

$price = $_POST['price'];

$image = $_FILES['img']['name'];


/* upload image */

move_uploaded_file(

$_FILES['img']['tmp_name'],

"images/".$image

);


/* insert */

$stmt = $conn->prepare("

INSERT INTO products(name,category,price,image)

VALUES(?,?,?,?)

");

$stmt->bind_param(

"ssds",

$name,

$category,

$price,

$image

);

$stmt->execute();


header("Location: products.php?added=1");

exit();

}

?>



<div class="main-container">

<h1 class="page-title">

<i class="fa-solid fa-box"></i>

Product Management

</h1>



<!-- ADD PRODUCT -->

<div class="glass-card floating-card">

<h3>

<i class="fa-solid fa-plus"></i>

Add New Product

</h3>



<form method="POST" enctype="multipart/form-data" class="modern-form">

<input
type="text"
name="name"
placeholder="Product Name"
required>



<input
type="text"
name="category"
placeholder="Category"
required>



<input
type="number"
name="price"
placeholder="Price"
required>



<input
type="file"
name="img"
required>



<button
name="add"
class="primary-btn">

<i class="fa-solid fa-cart-plus"></i>

Add Product

</button>

</form>

</div>



<!-- PRODUCT GRID -->

<div class="glass-card">

<h3>

<i class="fa-solid fa-store"></i>

Product List

</h3>



<div class="product-grid">

<?php

$res=$conn->query("SELECT * FROM products ORDER BY id DESC");

while($row=$res->fetch_assoc()){

?>


<div class="product-card glass-card product-float 

<?php

if($highlight == $row['name']){

echo "highlight-product";

}

?>

">



<img src="images/<?= $row['image'] ?>">



<h4>

<?= $row['name'] ?>

</h4>



<p class="category">

<?= $row['category'] ?>

</p>



<p class="price">

₹ <?= $row['price'] ?>

</p>



<!-- DELETE -->

<form method="POST"

onsubmit="return confirm('Delete this product?')">

<input

type="hidden"

name="delete_id"

value="<?= $row['id'] ?>">


<button class="delete-btn">

<i class="fa-solid fa-trash"></i>

Delete

</button>


</form>



</div>



<?php } ?>

</div>

</div>

</div>



<?php include "includes/footer.php"; ?>