<?php
include "includes/db.php";

if(isset($_POST['signup'])){

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


/* CHECK IF EMAIL EXISTS */
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s",$email);
$check->execute();
$check->store_result();

if($check->num_rows > 0){

$error = "Email already registered";

}else{

$stmt = $conn->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");
$stmt->bind_param("sss",$username,$email,$password);
$stmt->execute();

$success = "Account created successfully. Please login.";

}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Create Account</title>

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="auth-bg">

<div class="auth-container">

<div class="glass-card auth-box floating-card">

<h2>

<i class="fa-solid fa-user-plus"></i>
Create Account

</h2>


<form method="POST" class="modern-form">

<input type="text" name="username"
placeholder="Username"
required>

<input type="email" name="email"
placeholder="Email Address"
required>

<input type="password" name="password"
placeholder="Password"
required>

<button name="signup" class="primary-btn">

Register

</button>

</form>


<?php if(isset($error)){ ?>

<p style="color:#ff6b6b;">
<?= $error ?>
</p>

<?php } ?>


<?php if(isset($success)){ ?>

<p style="color:#38ef7d;">
<?= $success ?>
</p>

<?php } ?>


<p class="auth-link">

Already have an account?

<a href="login.php">

Login

</a>

</p>


</div>

</div>

</body>

</html>