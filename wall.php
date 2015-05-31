<?php 
	session_start();

 ?>
 <!DOCTYPE html>
 <html>
 	<head>
 		<link rel="stylesheet" href="wall.css">
 	</head>
 	<body>
 		<div id="navbar">
 			<h3><?=$_SESSION['logged_user']['first_name']?></h3>
 			<span>
 				<p>Welcome, <?=$_SESSION['logged_user']['first_name']?> <?=$_SESSION['logged_user']['last_name']?></p>
 			</span>
 		</div>
 		<div id="post_container">
 			<form id="message_form" action="process.php" method="post">
 				Post a message
 				<input type="hidden" name="action" value="post">
 				<textarea name="content"></textarea>
 				<input type="submit" value="post">
 			</form>
 		</div>
 	</body>
 </html>