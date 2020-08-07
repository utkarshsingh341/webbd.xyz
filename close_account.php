<?php 

if(isset($_POST['close_account'])
{
	$close_query = mysqli_query($con,"UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
	session_destroy();
	header("Location:register.php");
}

?>