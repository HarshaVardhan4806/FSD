<?php

/*
-----------------------------------------
DATABASE CONFIGURATION
-----------------------------------------
Change username & password only when 
moving to live hosting server
*/

$host = "localhost";

/* LOCALHOST (XAMPP) */
$user = "root";
$password = "";

/* LIVE SERVER EXAMPLE
$user = "your_host_username";
$password = "strong_password";
*/

$database = "inventory_db";


/*
-----------------------------------------
CREATE DATABASE CONNECTION
-----------------------------------------
*/

$conn = new mysqli($host, $user, $password, $database);


/*
-----------------------------------------
CHECK CONNECTION
-----------------------------------------
*/

if ($conn->connect_error) {

die("Database connection failed: " . $conn->connect_error);

}


/*
-----------------------------------------
SET CHARACTER ENCODING
-----------------------------------------
Supports ₹ symbols & special characters
*/

$conn->set_charset("utf8mb4");


/*
-----------------------------------------
SET TIMEZONE
-----------------------------------------
*/

date_default_timezone_set("Asia/Kolkata");

?>