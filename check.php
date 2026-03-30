<?php
session_start();
include("db.php");

$username = mysqli_real_escape_string($conn, trim($_POST["username"]));
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
	$row = mysqli_fetch_assoc($result);
    
	// Verify hashed password
	if (password_verify($password, $row["password"])) {
		$_SESSION["user_id"] = $row["id"];
    	$_SESSION["username"] = $username;
    	header("Location: welcome.php");
    	exit();
	} else {
		header("Location: index.php?msg=Wrong password. Please try again.");
		exit();
	}
} else {
	header("Location: index.php?msg=User not found. Please try again.");
	exit();
}
?>
