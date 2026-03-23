<?php include "includes/header.php"; include "includes/db.php"; ?>

<div class="main-container">

<h1 class="page-title">Product Management</h1>

<!-- ADD PRODUCT CARD -->
<div class="form-card">

<h3>Add New Product</h3>

<form method="POST" enctype="multipart/form-data" class="product-form">

<input type="text" name="name" placeholder="Product Name" required>
<input type="text" name="category" placeholder="Category" required>
<input type="number" name="price" placeholder="Price" required>
<input type="file" name="img" required>

<button name="add">Add Product</button>

</form>
</div>

<?php
if(isset($_POST['add'])){
    $img=$_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'],"images/".$img);

    $conn->query("INSERT INTO products(name,category,price,image)
    VALUES('$_POST[name]','$_POST[category]','$_POST[price]','$img')");
    echo "<script>location.reload();</script>";
}
?>

<!-- PRODUCT LIST -->
<div class="table-card">

<h3>Product List</h3>

<div class="product-grid">

<?php
$res=$conn->query("SELECT * FROM products");
while($row=$res->fetch_assoc()){
?>

<div class="product-card">

<img src="images/<?php echo $row['image']; ?>">

<h4><?php echo $row['name']; ?></h4>
<p>Category: <?php echo $row['category']; ?></p>
<p class="price">₹ <?php echo $row['price']; ?></p>

</div>

<?php } ?>

</div>

</div>

</div>