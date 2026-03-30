<?php
session_start();
include("db.php");

if (!isset($_SESSION["username"])) {
	header("Location: index.php");
	exit();
}

if (!isset($_GET["id"])) {
	header("Location: users.php?msg=Invalid user selected.");
	exit();
}

$id = (int) $_GET["id"];
$currentUserId = 0;

if (isset($_SESSION["user_id"])) {
	$currentUserId = (int) $_SESSION["user_id"];
} else {
	$currentUsername = mysqli_real_escape_string($conn, $_SESSION["username"]);
	$currentUserResult = mysqli_query($conn, "SELECT id FROM users WHERE username='$currentUsername'");
	if ($currentUserResult && mysqli_num_rows($currentUserResult) == 1) {
		$currentUser = mysqli_fetch_assoc($currentUserResult);
		$currentUserId = $currentUser["id"];
		$_SESSION["user_id"] = $currentUserId;
	}
}

if ($id == $currentUserId) {
	header("Location: users.php?msg=You cannot delete your own logged in account from this page.");
	exit();
}

$deleteSql = "DELETE FROM users WHERE id='$id'";

if (mysqli_query($conn, $deleteSql)) {
	header("Location: users.php?msg=User deleted successfully.");
	exit();
} else {
	header("Location: users.php?msg=Delete failed.");
	exit();
}
?>
