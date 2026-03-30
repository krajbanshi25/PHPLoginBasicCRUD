<?php
$host = "localhost";
$user = "root";    	// Default in XAMPP
$pass = "";        	// No password in XAMPP
$dbname = "user_system";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// This line helps us safely handle special characters in form data.
mysqli_set_charset($conn, "utf8");
?>
