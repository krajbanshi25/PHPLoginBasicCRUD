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
$message = "";
$messageClass = "success";

$userResult = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
if (!$userResult || mysqli_num_rows($userResult) == 0) {
	header("Location: users.php?msg=User not found.");
	exit();
}

$userData = mysqli_fetch_assoc($userResult);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = mysqli_real_escape_string($conn, trim($_POST["username"]));
	$password = trim($_POST["password"]);

	$checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND id != '$id'");

	if (mysqli_num_rows($checkUser) > 0) {
		$message = "Username already exists. Try another username.";
		$messageClass = "error";
	} else {
		if ($password != "") {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$updateSql = "UPDATE users SET username='$username', password='$hashedPassword' WHERE id='$id'";
		} else {
			$updateSql = "UPDATE users SET username='$username' WHERE id='$id'";
		}

		if (mysqli_query($conn, $updateSql)) {
			if (!isset($_SESSION["user_id"])) {
				$currentUsername = mysqli_real_escape_string($conn, $_SESSION["username"]);
				$currentUserResult = mysqli_query($conn, "SELECT id FROM users WHERE username='$currentUsername'");
				if ($currentUserResult && mysqli_num_rows($currentUserResult) == 1) {
					$currentUser = mysqli_fetch_assoc($currentUserResult);
					$_SESSION["user_id"] = $currentUser["id"];
				}
			}

			if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $id) {
				$_SESSION["username"] = $username;
			}
			header("Location: users.php?msg=User updated successfully.");
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
	<title>Edit User</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
	<div class="card form-card">
		<h2>Edit User</h2>
		<p class="subtitle">This page is part of the CRUD example. You can update username and password.</p>

		<?php if ($message != "") { ?>
			<div class="message <?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></div>
		<?php } ?>

		<form method="POST" action="edit_user.php?id=<?php echo $id; ?>">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo htmlspecialchars($userData["username"]); ?>" required>

			<label>New Password</label>
			<input type="password" name="password" placeholder="Leave blank to keep old password">

			<button type="submit">Save Changes</button>
		</form>

		<p class="small-text"><a class="inline-link" href="users.php">Back to User List</a></p>
	</div>
</div>
</body>
</html>
