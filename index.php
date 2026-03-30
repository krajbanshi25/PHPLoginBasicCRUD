<?php
session_start();
if (isset($_SESSION["username"])) {
	header("Location: welcome.php");
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
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
	<div class="card form-card">
		<h2>Login</h2>
		<p class="subtitle">Enter your username and password to continue.</p>

		<?php if ($message != "") { ?>
			<div class="message success"><?php echo htmlspecialchars($message); ?></div>
		<?php } ?>

		<form action="check.php" method="POST">
			<label>Username</label>
			<input type="text" name="username" required>

			<label>Password</label>
			<input type="password" name="password" required>

			<button type="submit">Login</button>
		</form>
		<p class="small-text">Don't have an account? <a href="register.php">Register</a></p>
	</div>
</div>
</body>
</html>
