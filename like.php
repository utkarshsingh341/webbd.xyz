<html>
<head>
	<title>Likes</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	  
    <!-- Files -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
	<script src="https://kit.fontawesome.com/6ed19eb2cf.js"></script>
	<link rel="stylesheet" type="text/css" href="assests/css/style.css">
	<style>
		body{
			background-color:#fff;
			font-size: 14px;
		}
	</style>
</head>
<body>
	<?php  
		require 'config/config.php';
		include("includes/classes/User.php");
		include("includes/classes/Post.php");
		include("includes/classes/Notification.php");

		if (isset($_SESSION['username'])) {
			$userLoggedIn = $_SESSION['username'];
			$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
			$user = mysqli_fetch_array($user_details_query);
		}
		else {
			header("Location: register.php");
		}


		//Get id of post
		if(isset($_GET['post_id'])) {
			$post_id = $_GET['post_id'];
		}
		$get_likes = mysqli_query($con, "SELECT likes,added_by FROM posts WHERE id='$post_id'");
		$row=mysqli_fetch_array($get_likes);
		$total_likes = $row['likes'];
		$user_liked = $row['added_by'];


		$user_details_query = mysqli_query($con, "SELECT * FROM users where username='$user_liked'");
		$row = mysqli_fetch_array($user_details_query);
		$total_user_likes = $row['num_likes'];

		//Like button
		if(isset($_POST['unlike_button']))
		{
			$total_likes--;
			$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' where id='$post_id'");
			$total_user_likes--;
			$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' where username='$user_liked'");
			$insert_user = mysqli_query($con, "DELETE FROM likes where username='$userLoggedIn' AND post_id='$post_id' ");

			//Insert Notification
			if($user_liked!=$userLoggedIn)
			{
				$notification = new Notification($con, $userLoggedIn);
				$notification->insertNotification($post_id,$user_liked,"like");
			}
		}

		//Dislike button
		if(isset($_POST['like_button']))
		{
			$total_likes++;
			$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' where id='$post_id'");
			$total_user_likes++;
			$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' where username='$user_liked'");
			$insert_user = mysqli_query($con, "INSERT INTO likes VALUES('','$userLoggedIn','$post_id')");
		}


		//Check for previous likes
		$check_query = mysqli_query($con, "SELECT * FROM likes where username='$userLoggedIn' AND post_id='$post_id'");
		$num_rows=mysqli_num_rows($check_query);

		if($num_rows)
		{
			echo '<form action="like.php?post_id='.$post_id.'" method="POST">
				<ul class="likes-ul">
					<li><input type="submit" class="comment_like" name="unlike_button"value="Unlike!" style="background-color: #727272"></li>
					<li>'.$total_likes.' Likes</li>
				</ul>
				</form>';
		}else{
			echo '<form action="like.php?post_id='.$post_id.'" method="POST">
				<ul class="likes-ul">
					<li><input type="submit" class="comment_like" name="like_button"value="Like!" style="background-color: #133ab9;"></li>
					<li>'.$total_likes.' Likes</li>
				</ul>
				</form>';
		}


	?>
</body>
</html>