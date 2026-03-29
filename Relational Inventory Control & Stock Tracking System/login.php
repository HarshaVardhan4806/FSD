<?php

include "includes/db.php";

session_start();

if(isset($_POST['login'])){

$username = trim($_POST['username']);
$password = $_POST['password'];


/* FIND USER */
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s",$username);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 1){

$user = $result->fetch_assoc();


/* CHECK PASSWORD */
if(password_verify($password, $user['password'])){

$_SESSION['user'] = $user['username'];

header("Location: dashboard.php");
exit();

}else{

$error = "Wrong password";

}

}else{

$error = "User not found";

}

}
?>


<!DOCTYPE html>

<html>

<head>

<title>Login</title>

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="auth-bg login-page">

<div class="auth-container">

<div class="glass-card auth-box floating-card">

<h2 class="login-title">

Inventory Control & Stock Tracking

</h2>


<form method="POST" class="modern-form">

<input type="text"
name="username"
placeholder="Username"
required>

<input type="password"
name="password"
placeholder="Password"
required>


<button name="login" class="primary-btn">

Login

</button>

</form>


<?php if(isset($error)){ ?>

<p style="color:#ff6b6b;">
<?= $error ?>
</p>

<?php } ?>


<p class="auth-link">

Don't have an account?

<a href="signup.php">

Create Account

</a>

</p>


</div>

</div>

</body>

</html>

<?php include "includes/footer.php"; ?>