<?php include 'include/header.html' ?>

<h1>CSCI 2412 Appointment Calendar Example</h1>

<nav>
	<a href="index.php">Login</a>
</nav>

<form action="register-submit.php" method="post">
	<fieldset>
		<legend>Create account</legend>
		<input type="text" name="username" maxlength="255" placeholder="Username"/>
		<input type="password" name="password" placeholder="Password"/>
		<input type="password" name="confirm" placeholder="Confirm password"/>
		<button type="submit">Submit</button>
	</fieldset>
</form>

<?php include 'include/footer.php' ?>