<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php?msg=You have logged out successfully.");
exit();
?>
