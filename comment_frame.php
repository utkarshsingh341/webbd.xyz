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

?>
<html>
<head>
	<title>Comments</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	  
    <!-- Files -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
	<script src="https://kit.fontawesome.com/6ed19eb2cf.js"></script>
	<link rel="stylesheet" type="text/css" href="assests/css/style.css">
	<link rel="stylesheet" type="text/css" href="assests/css/comments.css">
</head>
<body>
	<script>
		function toggle() {
			var element = document.getElementById("comment_section");

			if(element.style.display == "block") 
				element.style.display = "none";
			else 
				element.style.display = "block";
		}
	</script>

	<?php  
	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($user_query);

	$posted_to = $row['added_by'];
	$user_to = $row['user_to'];

	if(isset($_POST['postComment' . $post_id])) {
		$post_body = strip_tags($_POST['post_body']); //Removes html tags
		$post_body = mysqli_escape_string($con, $post_body);
		$date_time_now = date("Y-m-d H:i:s");
		$insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");
		
		if($posted_to!=$userLoggedIn)
		{
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id,$posted_to,"comment");
		}
		if ($user_to != 'none' && $user_to != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id,$user_to,"profile_comment");
		}

		$get_commenters = mysqli_query($con, "SELECT * FROM comments where post_id='$post_id'");
		$notified_users = array();
		while ($row = mysqli_fetch_array($get_commenters)) {
			if($row['posted_by']!=$posted_to && $row['posted_by']!=$user_to	&& $row['posted_by']!=$userLoggedIn && in_array($row['posted_by'], $notified_users))
			{
				$notification = new Notification($con, $userLoggedIn);
				$notification->insertNotification($post_id,$row['posted_by'],"comment_non_owner");
				array_push($notified_users, $row['posted_by']);
			}
		}

		echo "<p>Comment Posted! </p>";

	}
	?>
	<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" class="post_form" method="POST">
		<textarea placeholder="Comment Something..." name="post_body"></textarea>
		<input type="submit" name="postComment<?php echo $post_id; ?>" value="Post!">
	</form>

	<!-- Load comments -->
	<?php

		$get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id DESC");
		$count = mysqli_num_rows($get_comments);

		if($count!=0)
		{
			while($comment=mysqli_fetch_array($get_comments))
			{
				$comment_body=$comment['post_body'];
				$posted_to=$comment['posted_to'];
				$posted_by=$comment['posted_by'];
				$date_added=$comment['date_added'];
				$removed=$comment['removed'];


				//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_added); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval-> m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}


					$user_obj= new User($con, $posted_by);



	?>
			<div class="comment_section">
				<div class="main_column column">
					<div class="media">
						<a href="<?php echo $posted_by ?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic() ?>" height=40 width=40 class='mr-3 profile_pic_post'></a>
						<div class='media-body'>
							<h5 class='card-title post_name'><a href='<?php echo $posted_by ?>'  target="_parent"><?php echo $user_obj->getFirstAndLastName() ?></a> &middot; <?php echo $time_message ?></h5>
							<div id='post_body'><?php echo $comment_body; ?></div>

						</div>
					</div>
				</div>
			</div>


	<?php
			} //end of while

		}else{ //else of count, ie. if count is actually 0

	?>

			<div class="comment_section">
				<div class="main_column column">
					<div class="media">
						<div class='media-body'>
								   
							<div id='post_body'>Be the first one to post a comment!</div>

						</div>
					</div>
				</div>
			</div>




	<?php

		}

	?>
	
</body>
</html>