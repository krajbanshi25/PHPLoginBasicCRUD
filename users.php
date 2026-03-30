<?php
session_start();
include("db.php");

if (!isset($_SESSION["username"])) {
	header("Location: index.php");
	exit();
}

$message = "";
if (isset($_GET["msg"])) {
	$message = $_GET["msg"];
}

$result = mysqli_query($conn, "SELECT id, username FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Users</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
	<div class="card table-card">
		<h2>User List</h2>
		<p class="subtitle">This page shows a simple Read, Update, and Delete example.</p>

		<div class="top-links">
			<a class="button-link" href="register.php">Create New User</a>
			<a class="button-link secondary" href="welcome.php">Back to Welcome</a>
		</div>

		<?php if ($message != "") { ?>
			<div class="message success"><?php echo htmlspecialchars($message); ?></div>
		<?php } ?>

		<table>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Actions</th>
			</tr>
			<?php while ($row = mysqli_fetch_assoc($result)) { ?>
				<tr>
					<td><?php echo $row["id"]; ?></td>
					<td><?php echo htmlspecialchars($row["username"]); ?></td>
					<td>
						<a class="inline-link" href="edit_user.php?id=<?php echo $row["id"]; ?>">Edit</a>
						|
						<a class="inline-link" href="delete_user.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
</body>
</html>
