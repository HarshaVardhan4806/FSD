<?php include "includes/header.php"; include "includes/db.php"; ?>

<div class="main-container">

<h1 class="page-title">Supplier Management</h1>

<!-- ADD SUPPLIER CARD -->
<div class="form-card">

<h3>Add New Supplier</h3>

<form method="POST" class="supplier-form">

<input type="text" name="name" placeholder="Supplier Name" required>
<input type="text" name="contact" placeholder="Contact Number" required>
<textarea name="address" placeholder="Address" required></textarea>

<button name="add">Add Supplier</button>

</form>
</div>

<?php
if(isset($_POST['add'])){
$conn->query("INSERT INTO suppliers(name,contact,address)
VALUES('$_POST[name]','$_POST[contact]','$_POST[address]')");
echo "<script>location.reload();</script>";
}
?>

<!-- SUPPLIER LIST TABLE -->
<div class="table-card">

<h3>Supplier List</h3>

<table class="modern-table">
<tr>
<th>ID</th>
<th>Name</th>
<th>Contact</th>
<th>Address</th>
</tr>

<?php
$res=$conn->query("SELECT * FROM suppliers");
while($row=$res->fetch_assoc()){
echo "<tr>
<td>$row[id]</td>
<td>$row[name]</td>
<td>$row[contact]</td>
<td>$row[address]</td>
</tr>";
}
?>

</table>

</div>

</div>