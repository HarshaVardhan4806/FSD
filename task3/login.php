<?php
$conn = new mysqli("localhost", "root", "", "college");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    echo "<span style='color:green'>Login successful</span>";
} else {
    echo "Invalid email or password";
}
?>
    