<?php
require 'config/config.php';
 
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
	<title><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?> &middot; @<?php echo $user['username']; ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	  
    <!-- Files -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
	<script src="https://kit.fontawesome.com/6ed19eb2cf.js"></script>
	<link rel="stylesheet" type="text/css" href="assests/css/style.css">
 
</head>
<body>

	<div class="top_bar" style="">
		<div class="logo">
			 <a href="index.php"> <img src="assests/images/misc/logo.png"/> </a>
		</div>
		<nav>
			<a href="">
				<ion-icon name="person-add"></ion-icon>
			</a>
			<a href="">
				<ion-icon name="chatbubbles"></ion-icon>
			</a>
			<a href="">
				<ion-icon name="notifications-outline"></ion-icon>
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
	</div>
	<div class="wrapper">