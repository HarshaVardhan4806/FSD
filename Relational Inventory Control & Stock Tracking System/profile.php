<?php

include "includes/header.php";

$username = $_SESSION['user'];


/* GET USER INFO */

$stmt = $conn->prepare("
SELECT * FROM users WHERE username=?
");

$stmt->bind_param("s",$username);

$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();



/* UPDATE PROFILE */

if(isset($_POST['save'])){

$fullname = $_POST['full_name'];

$email = $_POST['email'];

$phone = $_POST['phone'];

$photo = $user['photo'];


/* UPLOAD NEW PHOTO */

if(!empty($_FILES['photo']['name'])){

$photo =
time()."_".$_FILES['photo']['name'];

move_uploaded_file(

$_FILES['photo']['tmp_name'],

"images/users/".$photo

);

}


/* UPDATE DB */

$stmt = $conn->prepare("

UPDATE users

SET full_name=?, email=?, phone=?, photo=?

WHERE username=?

");

$stmt->bind_param(

"sssss",

$fullname,

$email,

$phone,

$photo,

$username

);

$stmt->execute();


header("Location: profile.php?updated=1");

exit();

}



/* CHANGE PASSWORD */

if(isset($_POST['change_password'])){


$new_password =

password_hash(

$_POST['new_password'],

PASSWORD_DEFAULT

);


$stmt = $conn->prepare("

UPDATE users

SET password=?

WHERE username=?

");

$stmt->bind_param(

"ss",

$new_password,

$username

);

$stmt->execute();


header("Location: profile.php?pass=1");

exit();

}



/* PROFILE COMPLETION */

$fields = 0;

if(!empty($user['full_name'])) $fields++;

if(!empty($user['email'])) $fields++;

if(!empty($user['phone'])) $fields++;

if(!empty($user['photo'])) $fields++;


$completion = ($fields / 4) * 100;

?>


<div class="main-container">

<h1 class="page-title">

<i class="fa-solid fa-user"></i>

My Profile

</h1>



<!-- PROFILE COMPLETION -->

<div class="glass-card">

<div class="profile-progress">

<div class="progress-label">

Profile Completion: <?= $completion ?>%

</div>


<div class="progress-bar">

<div
class="progress-fill"

style="width:<?= $completion ?>%">

</div>

</div>

</div>

</div>




<div class="glass-card profile-card">

<form method="POST" enctype="multipart/form-data">



<!-- PHOTO -->

<div class="profile-photo">

<?php

$img = $user['photo'] ?: "default.png";

?>

<img

src="images/users/<?= $img ?>">

<input type="file" name="photo">

</div>



<!-- DETAILS -->

<input

type="text"

name="full_name"

placeholder="Full Name"

value="<?= $user['full_name'] ?>"



>



<input

type="email"

name="email"

placeholder="Email"

value="<?= $user['email'] ?>"

required

>



<input

type="text"

name="phone"

placeholder="Phone Number"

value="<?= $user['phone'] ?>"

>



<button

name="save"

class="primary-btn">

Save Changes

</button>



<hr>



<!-- PASSWORD -->

<h3 id="password">

Change Password

</h3>



<input

type="password"

name="new_password"

placeholder="New Password"

required

>



<button

name="change_password"

class="primary-btn">

Update Password

</button>



</form>



<?php if(isset($_GET['updated'])){ ?>

<p style="color:#38ef7d; margin-top:10px;">

Profile updated successfully

</p>

<?php } ?>



<?php if(isset($_GET['pass'])){ ?>

<p style="color:#38ef7d; margin-top:10px;">

Password changed successfully

</p>

<?php } ?>



</div>



</div>