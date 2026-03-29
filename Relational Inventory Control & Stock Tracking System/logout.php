<?php

session_start();

$_SESSION = [];

session_destroy();

?>

<!DOCTYPE html>

<html>

<head>

<title>Logging out...</title>

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<meta http-equiv="refresh" content="1.5;url=login.php">

</head>


<body class="auth-bg">


<div class="glass-card auth-box floating-card">

<h2>

<i class="fa-solid fa-right-from-bracket"></i>

Logging out...

</h2>


<p>Redirecting to login page</p>


</div>


</body>


</html>