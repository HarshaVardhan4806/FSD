<?php

/* START SESSION */
session_start();

/* LOAD DATABASE */
include __DIR__ . "/db.php";

/* CHECK LOGIN */
if(!isset($_SESSION['user'])){
header("Location: login.php");
exit();
}

/* GET USER PHOTO */
$username = $_SESSION['user'];

$stmt = $conn->prepare("
SELECT photo FROM users WHERE username=?
");

$stmt->bind_param("s",$username);
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

$img = $user['photo'] ?: "default.png";

/* ACTIVE PAGE */
$current_page = basename($_SERVER['PHP_SELF']);

?>


<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<!-- TOP NAVBAR -->

<header class="topbar">

<div class="topbar-left">

<div class="logo-text animated-logo">

<i class="fa-solid fa-boxes-stacked logo-icon"></i>

<span class="logo-name">    

InventoryPro

</span>

</div>

</div>



<div class="topbar-right">

<div class="user-area">

<div class="user-info">

<span class="username">

<?= $_SESSION['user'] ?>

</span>

<span class="role-badge">

<?= ucfirst($user['role'] ?? 'staff') ?>

</span>

</div>


<div class="avatar-dropdown">

<img
src="images/users/<?= $img ?>"
class="avatar-img"
onclick="toggleDropdown()">


<div class="dropdown-menu" id="profileMenu">

<a href="profile.php">

<i class="fa-solid fa-user"></i>
My Profile

</a>

<a href="profile.php#password">

<i class="fa-solid fa-key"></i>
Change Password

</a>

<a href="logout.php">

<i class="fa-solid fa-right-from-bracket"></i>
Logout

</a>

</div>

</div>

</div>

</div>

</header>




<!-- SIDEBAR -->

<aside class="sidebar"
id="sidebar">

<nav>



<a href="dashboard.php"
class="menu-item <?= $current_page=='dashboard.php'?'active':'' ?>">

<i class="fa-solid fa-chart-line"></i>

<span>Dashboard</span>

</a>



<a href="products.php"
class="menu-item <?= $current_page=='products.php'?'active':'' ?>">

<i class="fa-solid fa-box"></i>

<span>Products</span>

</a>



<a href="stock.php"
class="menu-item <?= $current_page=='stock.php'?'active':'' ?>">

<i class="fa-solid fa-layer-group"></i>

<span>Stock</span>

</a>



<a href="suppliers.php"
class="menu-item <?= $current_page=='suppliers.php'?'active':'' ?>">

<i class="fa-solid fa-truck"></i>

<span>Suppliers</span>

</a>



<a href="reports.php"
class="menu-item <?= $current_page=='reports.php'?'active':'' ?>">

<i class="fa-solid fa-chart-column"></i>

<span>Reports</span>

</a>



</nav>

</aside>



<script>


</script>

<script>

function toggleDropdown(){

document
.getElementById("profileMenu")
.classList
.toggle("show");

}

window.onclick = function(e){

if(!e.target.matches('.avatar-img')){

document
.getElementById("profileMenu")
.classList
.remove("show");

}

}

</script>