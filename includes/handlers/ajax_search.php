<?php 

include("../../config/config.php");
include("../classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

$names = explode(" ", $query);

//If query contains an underscore, assume username is to be searched
if(strpos($query, '_')!== false)
	$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where username LIKE '$query%' AND user_closed='no' LIMIT 4");
//If theres a space, assume first and last name is being searched
else if (count($names)==2)
	$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no' LIMIT 4");
//If query has one word, seach firstname or last name
else
	$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no' LIMIT 4");


if($query != "")
{
	while ($row = mysqli_fetch_array($usersReturnedQuery)) {
		$user = new User($con, $userLoggedIn);
		if ($row['username'] != $userLoggedIn) {
			$mututal_friends = $user->getMutualFriends($row['username']). " friends in common";
		}else{
			$mututal_friends = "";
		}

		echo "<div class='resultDisplay' style='height:85px;'>
				<a href='".$row['username']."' style=''>
					<div class='LiveSearchProfilePic' style='width:20%;'>
						<img src='".$row['profile_pic']."'>
					</div>
					<div class='LiveSearchText' style='width:80%; padding-top:10px;'>
						<span style='font-size:14px;'><span style='font-weight:bold;font-size:15px;'> ".$row['first_name']." ".$row['last_name']."</span> &middot; ".$row['username']."</span>
						<p style='font-size:14px;'>".$mututal_friends."</p>
					</div>

				</a>
				</div>";
	}
}

?>