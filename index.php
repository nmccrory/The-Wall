<?php 
	session_start();
	if(isset($_SESSION['logged_user'])){
		unset($_SESSION['logged_user']);
	}
	if(isset($_SESSION['success'])){
		unset($_SESSION['success']);
	}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="wall.css">
	</head>
	<body>
		<div id="index_head_container">
			<h1>Welcome to The Wall</h1>
			<h4>Please login or register</h4>
		</div>
		<div id="login_container">
			<form action="process.php" method="post">
				<h2>Login: </h2>
				<label>Email </label><input type="text" name="login_email">
				<label>Password </label><input type="password" name="login_pswrd">
				<input type="hidden" name="action" value="login">
				<input id="loginbutton" type="submit" value="Login">
			</form>
			<form action="process.php" method="post">
				<h2>Register: </h2>
				<?php if(isset($_SESSION['errors'])):
				foreach($_SESSION['errors'] AS $error):?>
				<p class="errors"><?=$error?></p>
				<?php endforeach?>
				<?php unset($_SESSION['errors']); ?>
				<?php endif ?>
				<?php if(isset($_SESSION['success'])): ?><p class="success"><?=$_SESSION['success']?></p><?php unset($_SESSION['success']); endif ?>
				<label>First Name </label><input type="text" name="first_name">
				<label>Last Name </label><input type="text" name="last_name">
				<label>Email </label><input type="text" name="email">
				<label>Password </label><input type="password" name="password">
				<label>Confirm Password </label><input type="password" name="conf_password">
				<input type="hidden" name="action" value="register">
				<input id="reg_button" type="submit" value="Join!">
			</form>
		</div>
	</body>
</html>