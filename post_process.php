<?php 
session_start();
require_once('connection.php');
$errors = array();		
$user_id = $_SESSION['logged_user']['id'];

if(isset($_POST['action']) && $_POST['action'] == "post"){
	if(empty($_POST['content'])){
		$errors[] = "Please add some text to your post!";
	}

	if(count($errors) > 0){
		$_SESSION['wall_errors'] = $errors;
		header("location: wall.php");
		exit();
	}else{
		$esc_post = mysqli_real_escape_string($connection, $_POST['content']);

		$wallpost = "INSERT INTO messages (message, created_at, updated_at, user_id) VALUES ('{$esc_post}', NOW(), NOW(), '{$user_id}');";
		mysqli_query($connection, $wallpost);
		header('location: wall.php');
	}
}

if(isset($_POST['action']) && $_POST['action'] == "delete"){
	if($_POST['user_id'] == $user_id){
		$message_id = $_POST['box_id'];
		$delete_query = "DELETE FROM messages WHERE messages.id = {$message_id};";
		mysqli_query($connection, $delete_query);
		header('location:wall.php');
	}else{
		$errors[] = "Cannot delete post created by another user.";
		header('location:wall.php');
	}
	
}
if(isset($_POST['action']) && $_POST['action'] == "comments"){
	$comment_body = mysqli_real_escape_string($connection, $_POST['comment']);
	$post_id = $_POST['post_id'];
	$add_comment = "INSERT INTO comments (comment, created_at, updated_at, post_id, user_id) VALUES ('{$comment_body}', NOW(), NOW(), '{$post_id}', '{$user_id}');";
	mysqli_query($connection, $add_comment);
	header('location:wall.php');
}

 ?>