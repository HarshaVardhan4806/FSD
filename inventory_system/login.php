<?php include "includes/db.php"; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Inventory System Login</title>
<link rel="stylesheet" href="css/style.css">

<style>
/* FULL PAGE CENTER */
body{
    background: linear-gradient(120deg,#232f3e,#131921);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* LOGIN CARD */
.login-card{
    background:white;
    padding:40px;
    width:350px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
    text-align:center;
}

/* LOGO */
.logo{
    font-size:28px;
    font-weight:bold;
    color:#ff9900;
    margin-bottom:20px;
}

/* INPUTS */
.login-card input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:16px;
}

/* BUTTON */
.login-card button{
    width:100%;
    padding:12px;
    background:#ff9900;
    border:none;
    color:white;
    font-size:16px;
    border-radius:6px;
    cursor:pointer;
    margin-top:10px;
}

.login-card button:hover{
    background:#e68a00;
}

/* FOOTER TEXT */
.small{
    margin-top:15px;
    font-size:14px;
    color:#777;
}
</style>
</head>

<body>

<div class="login-card">


<div class="logo">InventoryPro</div>

<form method="POST">
<input type="text" name="username" placeholder="Enter Username" required>
<input type="password" name="password" placeholder="Enter Password" required>
<button name="login">Login</button>
<p style="margin-top:20px;">
Don't have an account?
<a href="signup.php" style="color:#ff9900;font-weight:600;">
Create Account
</a>
</p>
</form>

<div class="small">Relational Inventory Control System</div>

</div>

</body>
</html>

<?php
if(isset($_POST['login'])){
    $res=$conn->query("SELECT * FROM users WHERE username='$_POST[username]' AND password='$_POST[password]'");
    if($res->num_rows>0){
        $_SESSION['user']=$_POST['username'];
        header("Location: dashboard.php");
    }else{
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>