<?php 
session_start();
require_once('connection.php');

$errors = array();

function alphaOnly($string){
	for($i=0;$i<strlen($string); $i++){
		if(is_numeric($string[$i])){
			return false;
		}
	}
	return true;
}
//registration routine
if(isset($_POST['action']) && $_POST['action'] == 'register'){
	if(strlen($_POST['first_name'])<1 || !alphaOnly($_POST['first_name'])){
		$errors[] = "First name is required/cannot contain numbers.";
	}
	if(strlen($_POST['last_name'])<1 || !alphaOnly($_POST['last_name'])){
		$errors[] = "Last name is required/cannot contain numbers.";
	}
	if(strlen($_POST['email'])<1){
		$errors[] = "Email address required.";
	}else{
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors[] = "Invalid email address.";
		}
		$esc_email = mysqli_real_escape_string($connection, $_POST['email']);
		$lower_email = strtolower($esc_email);
		$checkforemail = "SELECT * FROM users WHERE email='{$lower_email}';";

		$user = fetch($checkforemail);

		if(count($user)>0){
			$errors[] = "Email already in use.";
		}
	}
	if(strlen($_POST['password'])<1){
		$errors[] = "Password is required";
	}elseif($_POST['password'] != $_POST['conf_password']){
		$errors[] = "Passwords must match";
	}

	if(count($errors) > 0 ){
		$_SESSION['errors'] = $errors;
		header("location: index.php");
		exit();
	}else{
		$esc_first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
		$esc_last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
		$esc_email = mysqli_real_escape_string($connection, $_POST['email']);

		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$encrypted_password = md5($_POST['password'] . '' . $salt);

		$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES ('{$esc_first_name}','{$esc_last_name}','{$esc_email}','{$encrypted_password}', NOW(), NOW())";
		mysqli_query($connection, $query);
		header('location: index.php');
	}
}
?>