<?php
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");
 
if(isset($_SESSION['username']))
{
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}else{
	header("Location: register.php");
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Webbdd.xyz</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	  
    <!-- Files -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
	<script src="https://kit.fontawesome.com/6ed19eb2cf.js"></script>
	<link rel="stylesheet" type="text/css" href="assests/css/style.css">
	<script src="assests/js/demo.js"></script>
	<script src="assests/js/jquery.jcrop.js"></script>
	<script src="assests/js/jcrop_bits.js"></script>
	<link rel="stylesheet" href="assests/css/jquery.Jcrop.css" type="text/css" />

	<script>
		
	</script>
	<style>
	.main_profile_pics
	{
		border-radius: 50%;
		object-fit: cover;
	    height: 200px;
	 	width:200px;
		box-shadow:  2px 2px 1px #d3d3d3;
	 	margin: 10px 0px 20px 0px;
	}
	.frnd_button
	{
		border: none;
		width: 90%;
		padding: 15px;
		margin-left: 15px;
		margin-right: 15px;
		padding-bottom: 15px;
		padding-left: 5px;
		background-color: #ececec;
		color: #747474;
		font-weight: bold;
		letter-spacing: 0.5px;
		border-radius: 4px;
		box-shadow:  1.5px 1.5px 1px #d3d3d3;
	}

	</style>
 
</head>
<body>
	<div class="top_bar" style="">
		<div class="logo">
			<p style="float: left; width: 21%;">
				 <a href="index.php"> <img src="assests/images/misc/logo.png"/> </a>
			</p>
			 <div class="search" style="float: right; width: 79%;">
			 	<div class="search_bar_area"><form action="search.php" method="GET" name="search_form">
			 			<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input" class="search_bar">
			 			<div class="search_button button_holder"><ion-icon name="search"></ion-icon></div>
			 	</form>	</div>
			 	<div class="search_results_area">
				 	<div class="search_results"></div>
				 	<div class="search_results_footer_empty"></div>
				 </div>
			 </div>
		</div>
		<nav>
			<?php
				//Unread messages
				$messages = new Message($con, $userLoggedIn);
				$num_messages = $messages->getUnreadNumber();


				//Unread notifications
				$notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();


				//Unseen Friend Request
				$requests = new User($con, $userLoggedIn);
				$num_requests = $requests->getFriendRequestNumber();
			?>
			<a href="requests.php">
				<ion-icon name="person-add"></ion-icon>
				<?php 

				if($num_requests>0)
				{
					echo '<span class="notification_baddge" id="unread_message">'.$num_requests.'</span>';
				}

				?>
			</a>
			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn;?>', 'message')">
				<ion-icon name="chatbubbles"></ion-icon>
				<?php 

				if($num_messages>0)
				{
					echo '<span class="notification_baddge" id="unread_message">'.$num_messages.'</span>';
				}

				?>
			</a>
			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn;?>', 'notification')"> 
				<ion-icon name="notifications-outline"></ion-icon>
				<?php 

				if($num_notifications>0)
				{
					echo '<span class="notification_baddge" id="unread_notification">'.$num_notifications.'</span>';
				}

				?>
			</a>
			<a href="">
				<ion-icon name="settings"></ion-icon>
			</a>
			<a href="<?php echo $userLoggedIn ?>"> 
				<ion-icon name="contact"></ion-icon>
			</a>
			<a href="includes/handlers/logout.php">
				<ion-icon name="log-out"></ion-icon>
			</a>
		</nav>
		<div class="dropdown_data_window" style="height:0px;border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">
	</div>

	<div class="wrapper">