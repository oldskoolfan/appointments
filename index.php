<?php include 'include/header.html' ?>

<h1>CSCI 2412 Appointment Calendar Example</h1>

<nav>
	<a href="register.php">Create user account</a>
	<a href="calendar.php">View calendar</a>
</nav>

<form action="login.php" method="post">
	<fieldset>
		<legend>Login</legend>
		<input type="text" name="username" maxlength="255" placeholder="Username"/>
		<input type="password" name="password" placeholder="Password"/>
		<button type="submit">Login</button>
	</fieldset>
</form>

<?php include 'include/footer.php' ?>