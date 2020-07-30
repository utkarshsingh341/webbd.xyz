<?php 
include("includes/header.php");



if(isset($_GET['profile_username']))
{
	$username = $_GET['profile_username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users where username='$username'");
	$user_array=mysqli_fetch_array($user_details_query);
}

$num_friends = (substr_count($user_array['friend_array'], ","))-1;

if(isset($_POST['remove_friend']))
{
	$user = new User($con, $userLoggedIn);
	$user->removeFriend($username);
}

if(isset($_POST['add_friend']))
{
	$user = new User($con, $userLoggedIn);
	$user->sendRequest($username); 
}
if(isset($_POST['respond_request']))
{
	$user = new User($con, $userLoggedIn);
	header("Location: requests.php");
}
if(isset($_POST['post_button']))
{
	$post = new Post($con, $userLoggedIn);
	$post->submitPost($_POST['post_body'],$_POST['user_to']);
	header("Location:index.php");
}


?>

	<div class="container">
		<div class="row">
			<div class="col-4">
				 	
	      		<div class="user_details column">
					<img src="<?php echo $user_array['profile_pic']; ?>" class="main_profile_pics">
					<h4 class="card-title" style="font-weight: bold; margin-bottom: 8px;"><?php echo $user_array['first_name']; ?> <?php echo $user_array['last_name']; ?></h4>
	    			<h6 class="card-subtitle mb-2 text-muted">@<?php echo $user_array['username']; ?></h6>
	    			<div class="wh-sp"></div>
	    			<table class="count_table">
	    				<thead><tr>
	    					<th style="border-right: 1px solid #000;">
	    						Posts
	    					</th>
	    					<th style="border-right: 1px solid #000;">
	    						Friends
	    					</th>
	    					<th>
	    						Likes
	    					</th>
	    				</tr></thead>
	    				<tr>
	    					<td style="border-right: 1px solid #000;">
	    						<?php echo $user_array['num_posts']; ?> 
	    					</td>
	    					<td style="border-right: 1px solid #000;">
	    						<?php echo $num_friends; ?>
	    					</td>
	    					<td>
	    						<?php echo $user_array['num_likes']; ?> 
	    					</td>
	    				</tr>
	    			</table>
				</div>
				<div class="card" style="border: 1px solid #eee;">
				  <div class="card-body" style="padding: 0px;">
				  	<form action="<?php echo $username; ?>" method="POST">

				  		<?php
				  			$profile_user_obj = new User($con, $username);
				  			if($profile_user_obj->isClosed())
				  			{
				  				header("Location: user_closed.php");
				  			}

				  			$logged_in_user_obj = new User($con, $userLoggedIn);
				  			if($userLoggedIn!=$username)
				  			{
				  				if($logged_in_user_obj->isFriend($username))
				  				{
				  					echo '<input type="submit" name="remove_friend" class="frnd_button" value="Remove Friend"> ';
				  				}else if($logged_in_user_obj->didRecieveRequest($username)){
				  					echo '<input type="submit" name="respond_request" class="frnd_button" value="Respond to Request"> ';

				  				}else if($logged_in_user_obj->didSendRequest($username))
				  				{
				  					echo '<input type="submit" name="respond_request" class="frnd_button" value="Request Sent"> ';
				  				}else{
				  					echo '<input type="submit" name="add_friend" class="frnd_button" value="Add Friend"> ';
				  				}
				  			}

				  		?>
				  	</form>
				  </div>
				</div>
	      	</div>
			<div class="col-8">
				<div class="main_column column">
					<!-- Button trigger modal -->
					<input type="submit" data-toggle="modal" data-target="#post_form" value="Post Something!" name="" class="btn btn-primary">

					<!-- Modal -->
					<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Post on <?php echo $user_array['first_name']; ?>'s profile!</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<form class="profile_post" action="" method="POST">
					      		<div class="form-group">
					      			<textarea class="form-control" name="post_body" placeholder="Write Something..." style="height: 200px;max-height: 200px;"></textarea>
					      			<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
					      			<input type="hidden" name="user_to" value="<?php echo $username; ?>">
					      		</div>
					      	</form>
					      	<p style="font-size: 13px; padding-left: 5px;">This will appear on @<?php echo $user_array['username']; ?>'s profile and also on the newsfeed for your friends to see!</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post!</button>
					      </div>
					    </div>
					  </div>
					</div>
		      	</div>
		    </div>
		</div>
	</div>
</body>
</html>