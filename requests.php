<?php 
include("includes/header.php");

?>
<style type="text/css">
	label{
		font-size: 16px;
		margin-bottom: 5px;
		color: #333;
	}
	input[type="submit"]
	{
		border:0px ;
		padding:8px 15px;
		margin: 5px 0px;
		margin-right: 5px;
		color: #000;
		background-color: #ddd;
		border-radius: 4px;
	}
	input[type="submit"]:hover{
		background-color: #bbb;
		transition: background-color 0.5s;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-sm-6" style="margin: 10px auto;">
			<div class="main_column column" style="padding:25px;">
				<h3>Friend Requests</h3>
				<hr>

				<?php

					$query = mysqli_query($con, "SELECT * FROM friend_requests where user_to='$userLoggedIn'");
					if(mysqli_num_rows($query)==0)
					{
						echo "No friend requests right now";
					}else{

						while ($row=mysqli_fetch_array($query)) {
							$user_from = $row['user_from'];
							$user_from_obj = new User($con,$user_from);
?>
<div class="friend_requests" style="margin: 10px 20px;padding: 10px 5px; border-bottom: 0.5px solid #ddd;">
<?php 
							echo "<label><a href='".$user_from_obj->getusername()."'>".$user_from_obj->getFirstAndLastName(). "</a> sent you a friend request</label>";

							$user_from_friend_array = $user_from_obj->getFriendArray();

							if(isset($_POST['accept_request'.$user_from]))
							{
								$add_friend_query = mysqli_query($con,"UPDATE users SET friend_array=CONCAT(friend_array,'$user_from,') WHERE username='$userLoggedIn'");
								$add_friend_query = mysqli_query($con,"UPDATE users SET friend_array=CONCAT(friend_array,'$userLoggedIn,') WHERE username='$user_from'");

								$delete_query=mysqli_query($con,"DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");

								echo "You are now friends!";
								header("Location: requests.php");

							}
							if(isset($_POST['ignore_request'.$user_from]))
							{
								$delete_query=mysqli_query($con,"DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
								echo "Request Ignored.";
								header("Location: requests.php");
							}


							?>
							<form action="requests.php" method="POST"> 
								<input type="submit" name="accept_request<?php echo $user_from;?>" id="accept_button" value="ACCEPT">
								<input type="submit" name="ignore_request<?php echo $user_from;?>" id="ignore_button" value="IGNORE">
							</form></div>
							<?php


						}

					}
				?>
			</div>	
		</div>
	</div>
</div>
</body>
</html>


