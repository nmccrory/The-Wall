<?php 
	include('process.php');
	//making sure that session variables are available for query 
	if(isset($_SESSION['get_posts'])){
		$_SESSION['get_posts'] = "SELECT messages.id, message,users.first_name, user_id,users.last_name, DATE_FORMAT(messages.updated_at, '%l%p %M %e %Y') AS updated_at FROM messages 
		LEFT JOIN users ON messages.user_id = users.id 
		ORDER BY messages.updated_at DESC;";
	}
	if(isset($_SESSION['posts'])){
		$_SESSION['posts'] = mysqli_query($connection, $_SESSION['get_posts']);
	}
	if(!isset($_SESSION['get_posts'])){
		$_SESSION['get_posts'] = "SELECT messages.id, message,users.first_name, user_id, users.last_name, DATE_FORMAT(messages.updated_at, '%l%p %M %e %Y') AS updated_at FROM messages 
		LEFT JOIN users ON messages.user_id = users.id 
		ORDER BY messages.updated_at DESC;";
	}
	if(!isset($_SESSION['posts'])){
		$_SESSION['posts'] = mysqli_query($connection, $_SESSION['get_posts']);
	}
	if(!isset($_SESSION['wall_errors'])){
		$_SESSION['wall_errors'] = array();
	}
	
 ?>
 <!DOCTYPE html>
 <html>
 	<head>
 		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 		 <script src="animation.js"></script>
 		<link rel="stylesheet" href="wall.css">
 	</head>
 	<body>
 		<div id="navbar">
 			<span id="left_navbar">
 				<h3><?=$_SESSION['logged_user']['first_name']?>'s Wall</h3>
 			</span>
 			<span id="right_navbar">
 				<p>Welcome, <?=$_SESSION['logged_user']['first_name']?> <?=$_SESSION['logged_user']['last_name']?></p>
 				<form action="process.php" method="post" id="logout_form">
 					<input type="hidden" name="action" value="logout">
 					<input type="submit" value="Log Out">
 				</form>
 			</span>
 		</div>
 		<div id="post_container">
 			<form id="message_form" action="post_process.php" method="post">
 				<h2>Post a message</h2>
 				<?php 
 				//error handling
 				foreach($_SESSION['wall_errors'] as $error):?><p class="errors"><?=$error?></p><?php endforeach; unset($_SESSION['wall_errors']); ?>
 				<input type="hidden" name="action" value="post">
 				<textarea name="content"></textarea>
 				<div id="post_but_container">
 					<input class="message_post" type="submit" value="Post">
 				</div>
 			</form>
 		</div>
 		<div id="content_wrapper">
 			<?php foreach($_SESSION['posts'] as $post):
 			 ?><div class="user_post"><h5><?php echo "{$post['first_name']} {$post['last_name']}";?> - <?php echo "{$post['updated_at']}"; ?></h5>
 			 	<form class="delete_form" action="post_process.php" method="post">
 			 		<input type="hidden" name="action" value="delete">
 			 		<input type="hidden" name="box_id" value=<?=$post['id']?>>
 			 		<input type="hidden" name="user_id" value=<?=$post['user_id']?>>
 			 		<?php if($_SESSION['logged_user']['id']==$post['user_id']): ?>
 			 			<input class="delete_button" type="submit" value="x">
 			 		<?php endif; ?>
 			 	</form>
 			 	<p><?php echo "{$post['message']}";?></p>
		 	</div>
		 	<div class="expander">EXPAND COMMENTS</div>
		 	<div class="comment_holder">
		 		<?php 
		 			//comment querying
		 			$post_id = $post['id'];
		 			$comment_query = "SELECT users.first_name, users.last_name, comments.comment, DATE_FORMAT(comments.updated_at, '%l%p %M %e %Y') AS updated_at FROM messages
						LEFT JOIN comments ON messages.id = comments.post_id
						LEFT JOIN users ON comments.user_id = users.id
						WHERE comments.post_id = '{$post_id}'
						ORDER BY comments.updated_at ASC;";
					$comment_results = mysqli_query($connection, $comment_query);
					$comment_array = $comment_results->fetch_all();
					//checking if post contains any comments - if no, display message
					if(count($comment_array) === 0):?>
				 		<p>No Comments yet!</p>
					<?php endif; ?>
					<?php
					//broadcasting comments
					foreach($comment_results as $comment):?><h5><?php echo "{$comment['first_name']} {$comment['last_name']} - {$comment['updated_at']}"; ?></h5>
						<p><?php echo "{$comment['comment']}";?></p><hr class="breaker">
					<?php endforeach; ?>
					<section id="comment_submit">
			 		<form class="comment_form" action="post_process.php" method="post">
			 			<input type='hidden' name='action' value="comments">
			 			<input type="hidden" name="post_id" value=<?=$post['id']?>>
			 			<textarea type="text" placeholder="Add your comment here..." name="comment"></textarea>
			 			<input type="submit" value="COMMENT">
			 		</form>
		 		</section>				
		 	</div>
		 	<div class="collapse">COLLAPSE COMMENTS</div>
		 	<?php endforeach;?>
 		</div> 
 	</body>
 </html>