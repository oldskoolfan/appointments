<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Appointment Example</title>
	<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<nav>
	<?php if (isset($_SESSION['user'])): ?>
		<a href="calendar.php">View calendar</a>
		<a href="logout.php">Logout</a>
	<?php else: ?>
		<a href="index.php">Login</a>
		<a href="register.php">Create user account</a>
	<?php endif; ?>
</nav>
<?php if (isset($_SESSION['msg'])): ?>
	<p class="msg"><?=$_SESSION['msg']?></p>
	<?php $_SESSION['msg'] = null; ?>
<?php endif; ?>