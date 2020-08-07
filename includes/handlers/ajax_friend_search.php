<?php 

include("../../config/config.php");
include("../classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

$names= explode(" ",$query);

if(strpos($query, "_") !== false)
{
	$usersReturned = mysqli_query($con, "SELECT * FROM users where username LIKE '$query%' AND user_closed='no' LIMIT 8 ");
}else if(count($names) == 2){
	$usersReturned = mysqli_query($con, "SELECT * FROM users where (first_name LIKE '%$names[0]%' AND  last_name LIKE '%$names[1]%') AND user_closed='no' LIMIT 8 ");
}else{
	$usersReturned = mysqli_query($con, "SELECT * FROM users where (first_name LIKE '%$names[0]%' OR  last_name LIKE '%$names[0]%' ) AND user_closed='no' LIMIT 8 ");
}

if($query != "")
{
	while($row = mysqli_fetch_array($usersReturned))
	{
		$user = new User($con, $userLoggedIn);
		if($row['username'] !=  $userLoggedIn)
		{
			$mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
		}else{
			$mutual_friends="";
		}

		if($user->isFriend($row['username']))
		{
			echo "<div class='resultDisplay' style='	padding-top: 10px;'> 
					<a href='messages.php?u=".$row['username']."'>
					<div class='LiveSearchProfilePic'>
						<img src='".$row['profile_pic']."'>
					</div>
					<div class ='LiveSearchText'>
						<span style='font-size:14px;'><span style='font-weight:bold;font-size:15px;'> ".$row['first_name']." ".$row['last_name']."</span> &middot; ".$row['username']."</span>
						<p style='font-size:14px;'>".$mutual_friends."</p>
					</div>
					</a>
				</div>

			";
		}
	}
}

?>