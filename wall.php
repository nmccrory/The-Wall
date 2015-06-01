<?php 
	include('process.php');
	if(isset($_SESSION['get_posts'])){
		$_SESSION['get_posts'] = "SELECT messages.id, message,users.first_name, users.last_name, DATE_FORMAT(messages.updated_at, '%l%p %M %e %Y') AS updated_at FROM messages 
		LEFT JOIN users ON messages.user_id = users.id 
		ORDER BY updated_at DESC;";
	}
	if(isset($_SESSION['posts'])){
		$_SESSION['posts'] = mysqli_query($connection, $_SESSION['get_posts']);
	}
	
 ?>
 <!DOCTYPE html>
 <html>
 	<head>
 		<link rel="stylesheet" href="wall.css">
 	</head>
 	<body>
 		<div id="navbar">
 			<h3><?=$_SESSION['logged_user']['first_name']?>'s Wall</h3>
 			<span>
 				<p>Welcome, <?=$_SESSION['logged_user']['first_name']?> <?=$_SESSION['logged_user']['last_name']?></p>
 			</span>
 		</div>
 		<div id="post_container">
 			<form id="message_form" action="post_process.php" method="post">
 				<h2>Post a message</h2>
 				<input type="hidden" name="action" value="post">
 				<textarea name="content"></textarea>
 				<input type="submit" value="post">
 			</form>
 		</div>
 		<div id="content_wrapper">
 			<?php foreach($_SESSION['posts'] as $post):
 			 ?><div class="user_post"><h5><?php echo "{$post['first_name']} {$post['last_name']}";?> - <?php echo "{$post['updated_at']}"; ?></h5>
 			 	<p><?php echo "{$post['message']}";?></p>
		 	</div>
		 	<div class="comment_holder">
		 		<form id="comment_form" action="post_process.php" method="post">
		 			<input type='hidden' name='action' value="comments">
		 			<input type="hidden" name="post_id" value=<?=$post['id']?>>
		 			<input type="text" name="comment">
		 			<input type="submit" value="Show comments">
		 		</form>
		 		<?php 
		 			$post_id = $post['id'];
		 			$comment_query = "SELECT users.first_name, users.last_name, comments.comment, comments.updated_at FROM messages
						LEFT JOIN users ON messages.user_id = users.id
						LEFT JOIN comments ON messages.id = comments.post_id
						WHERE comments.post_id = '{$post_id}'
						ORDER BY comments.updated_at DESC";
					$comment_results = mysqli_query($connection, $comment_query);
					foreach($comment_results as $comment):?><h5><?php echo "{$comment['first_name']} {$comment['last_name']} - {$comment['updated_at']}"; ?></h5>
						<p><?php echo "{$comment['comment']}";?></p>;
					<?php endforeach; ?>				
		 	</div>
		 	<?php endforeach;?>
 		</div> 
 	</body>
 </html>