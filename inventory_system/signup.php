<?php
include "includes/db.php";

if(isset($_POST['signup'])){
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$conn->query("INSERT INTO users(username,email,password)
VALUES('$username','$email','$password')");

header("Location: login.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Account</title>
<link rel="stylesheet" href="css/style.css">
<style>
.signup-box{
width:400px;
margin:100px auto;
background:white;
padding:40px;
border-radius:12px;
box-shadow:0 20px 40px rgba(0,0,0,0.2);
text-align:center;
}
.signup-box input{
width:100%;
padding:12px;
margin:12px 0;
border:1px solid #ddd;
border-radius:6px;
}
</style>
</head>

<body style="background:#eaeded;">

<div class="signup-box">

<h2>Create Account</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button name="signup">Register</button>

</form>

<p style="margin-top:15px;">
Already have an account?
<a href="login.php" style="color:#ff9900;font-weight:bold;">Login</a>
</p>

</div>

</body>
</html>