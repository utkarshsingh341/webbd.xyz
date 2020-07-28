<?php 
include("includes/header.php");

?>

	<div class="container">
		<div class="row">
	    	<div class="col-sm">
	      		<div class="user_details column">
					<a href="<?php echo $userLoggedIn ?>"> <img src="<?php echo $user['profile_pic']; ?>" class="main_profile_pic"></a>
					<h4 class="card-title" style="font-weight: bold; margin-bottom: 8px;"><a style="color: #444;" href="<?php echo $userLoggedIn ?>"><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></a></h4>
	    			<h6 class="card-subtitle mb-2 text-muted">@<?php echo $user['username']; ?></h6>
	    			<div class="wh-sp"></div>
	    			<table class="count_table">
	    				<thead><tr>
	    					<th style="border-right: 1px solid #000;">
	    						Posts
	    					</th>
	    					<th>
	    						Likes
	    					</th>
	    				</tr></thead>
	    				<tr>
	    					<td style="border-right: 1px solid #000;">
	    						<?php echo $user['num_posts']; ?> 
	    					</td>
	    					<td>
	    						<?php echo $user['num_likes']; ?> 
	    					</td>
	    				</tr>
	    			</table>
				</div>
				</div>
			</div>
		</div>
		</body>
		</html>