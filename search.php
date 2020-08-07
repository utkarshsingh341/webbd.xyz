<?php 

include("includes/header.php");

if(isset($_GET['q']))
{
	$query = $_GET['q'];
}else{
	$query = "";
}

if(isset($_GET['type']))
{
	$type = $_GET['type'];
}else{
	$type = "name";
}

?>
<div class="container">
	<div class="row">
		<div class="col-sm-6" style="margin: 10px auto;">
			<div class="main_column column" style="padding:25px;">
				<h3>Search Results</h3>
				<hr>
				<div id="main_column">
					<?php
						
						if($query == "")
							echo "You must enter something in the search box!";
						else{


							
							//If query contains an underscore, assume username is to be searched
							if($type == "username"){

								$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where username LIKE '$query%' AND user_closed='no'");
							}else{

								$names = explode(" ", $query);

								//If theres a space, assume first and last name is being searched
								if (count($names)==3){


								$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where (first_name LIKE '$names[0]%' AND last_name LIKE '$names[2]%') AND user_closed='no'");
								//If query has one word, seach firstname or last name
								}else if(count($names)==2){
								$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no'");

								}else{
								$usersReturnedQuery = mysqli_query($con,"SELECT * FROM users where (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no'");
								}

							}

							//Check if results were found
							if(mysqli_num_rows($usersReturnedQuery)==0)
								echo "Sorry! We can't find anyone with the above search.";
							else{
								echo mysqli_num_rows($usersReturnedQuery) . " results found!";
							}


							while ($row = mysqli_fetch_array($usersReturnedQuery)) {
							$user = new User($con, $userLoggedIn);
							if ($row['username'] != $userLoggedIn) {
								$mututal_friends = $user->getMutualFriends($row['username']). " friends in common";
							}else{
								$mututal_friends = "";
							}

							echo "<div class='resultDisplay' style='margin-top:15px;'>
									<a href='".$row['username']."' style=''>
										<div class='LiveSearchProfilePic' style='width:15%;'>
											<img src='".$row['profile_pic']."'>
										</div>
										<div class='LiveSearchText' style='width:85%;'>
											<span style='font-size:14px;'><span style='font-weight:bold;font-size:15px;'> ".$row['first_name']." ".$row['last_name']."</span> &middot; ".$row['username']."</span>
											<p style='font-size:14px;'>".$mututal_friends."</p>
										</div>

									</a>
									</div>";
						}
							


						}

					?>
				</div>
			</div>	
		</div>
	</div>
</div>
</div>
</body>
</html>


