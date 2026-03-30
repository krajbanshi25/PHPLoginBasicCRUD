<?php
session_start();
include("db.php");

$message = "";
$messageClass = "success";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = mysqli_real_escape_string($conn, trim($_POST["username"]));
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

	// Check if user already exists
	$checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
	if (mysqli_num_rows($checkUser) > 0) {
		$message = "Username already exists. Please try another one.";
		$messageClass = "error";
	} else {
    	$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    	if (mysqli_query($conn, $sql)) {
			header("Location: index.php?msg=Registration successful. Please login.");
			exit();
    	} else {
			$message = "Error: " . mysqli_error($conn);
			$messageClass = "error";
    	}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
	<div class="card form-card">
		<h2>Register</h2>
		<p class="subtitle">Create a new account for this simple PHP project.</p>

		<?php if ($message != "") { ?>
			<div class="message <?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></div>
		<?php } ?>

		<form method="POST" action="register.php">
			<label>Username</label>
			<input type="text" name="username" required>

			<label>Password</label>
			<input type="password" name="password" required>

			<button type="submit">Register</button>
		</form>
		<p class="small-text">Already have an account? <a href="index.php">Login</a></p>
	</div>
</div>
</body>
</html>
