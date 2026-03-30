<?php
session_start();
if (!isset($_SESSION["username"])) {
	header("Location: index.php");
	exit();
}

$message = "";
if (isset($_GET["msg"])) {
	$message = $_GET["msg"];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
	<div class="card dashboard-card">
		<h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
		<p class="subtitle">You are now logged in using PHP, MySQLi, sessions, and a database table.</p>

		<?php if ($message != "") { ?>
			<div class="message success"><?php echo htmlspecialchars($message); ?></div>
		<?php } ?>

		<div class="button-group">
			<a class="button-link" href="profile.php">Update My Details</a>
			<a class="button-link secondary" href="users.php">View All Users</a>
			<a class="button-link danger" href="logout.php">Logout</a>
		</div>
	</div>
</div>
</body>
</html>
