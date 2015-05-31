<?php 
	session_start();

 ?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="wall.css">
	</head>
	<body>
		<div id="login_container">
			<h1>Welcome to The Wall</h1>
			<h4>Please login or register</h4>
			<form action="process.php" method="post">
				<h2>Register: </h2>
				<?php if(isset($_SESSION['errors'])):
				foreach($_SESSION['errors'] AS $error):?>
				<p class="errors"><?=$error?></p>
				<?php endforeach?>
				<?php endif?>
				<label>First Name </label><input type="text" name="first_name">
				<label>Last Name </label><input type="text" name="last_name">
				<label>Email </label><input type="text" name="email">
				<label>Password </label><input type="password" name="password">
				<label>Confirm Password </label><input type="password" name="conf_password">
				<input type="hidden" name="action" value="register">
				<input type="submit" value="Join!">
			</form>
			<form action="process.php" method="post">
				<h2>Login: </h2>
				<label>Email </label><input type="text" name="login_email">
				<label>Password </label><input type="password" name="login_pswrd">
				<input type="hidden" name="action" value="login">
			</form>
		</div>
	</body>
</html>