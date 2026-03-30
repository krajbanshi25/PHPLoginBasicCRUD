<?php
session_start();
include("db.php");

if (!isset($_SESSION["username"])) {
	header("Location: index.php");
	exit();
}

$userId = 0;
if (isset($_SESSION["user_id"])) {
	$userId = (int) $_SESSION["user_id"];
} else {
	$currentUsername = mysqli_real_escape_string($conn, $_SESSION["username"]);
	$currentUserResult = mysqli_query($conn, "SELECT id FROM users WHERE username='$currentUsername'");
	if ($currentUserResult && mysqli_num_rows($currentUserResult) == 1) {
		$currentUser = mysqli_fetch_assoc($currentUserResult);
		$userId = $currentUser["id"];
		$_SESSION["user_id"] = $userId;
	}
}

if ($userId == 0) {
	header("Location: index.php?msg=Session expired. Please login again.");
	exit();
}

$message = "";
$messageClass = "success";

$userResult = mysqli_query($conn, "SELECT * FROM users WHERE id='$userId'");
$userData = mysqli_fetch_assoc($userResult);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$newUsername = mysqli_real_escape_string($conn, trim($_POST["username"]));
	$newPassword = trim($_POST["password"]);

	$checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$newUsername' AND id != '$userId'");

	if (mysqli_num_rows($checkUser) > 0) {
		$message = "This username is already used by another user.";
		$messageClass = "error";
	} else {
		if ($newPassword != "") {
			$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$updateSql = "UPDATE users SET username='$newUsername', password='$hashedPassword' WHERE id='$userId'";
		} else {
			// If password is empty, keep the old password.
			$updateSql = "UPDATE users SET username='$newUsername' WHERE id='$userId'";
		}

		if (mysqli_query($conn, $updateSql)) {
			$_SESSION["username"] = $newUsername;
			header("Location: welcome.php?msg=Your details were updated successfully.");
			exit();
		} else {
			$message = "Update failed: " . mysqli_error($conn);
			$messageClass = "error";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Profile</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
	<div class="card form-card">
		<h2>Update My Details</h2>
		<p class="subtitle">You can change your username and password here.</p>

		<?php if ($message != "") { ?>
			<div class="message <?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></div>
		<?php } ?>

		<form method="POST" action="profile.php">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo htmlspecialchars($userData["username"]); ?>" required>

			<label>New Password</label>
			<input type="password" name="password" placeholder="Leave blank to keep old password">

			<button type="submit">Update Details</button>
		</form>

		<p class="small-text"><a class="inline-link" href="welcome.php">Back to Welcome Page</a></p>
	</div>
</div>
</body>
</html>
