<?php 

class Message {
	private $user_obj;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	public function getMostRecentUser()
	{
		$userLoggedIn = $this->user_obj->getUsername();


		$query=mysqli_query($this->con,"SELECT user_to,user_from FROM messages where user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");

		if(mysqli_num_rows($query)==0)
		{
			return false;
		}
		$row = mysqli_fetch_array($query);
		$user_to = $row['user_to'];
		$user_from = $row['user_from'];


		if($user_to != $userLoggedIn)
			return $user_to;
		else
			return $user_from;
	}

	public function sendMessage($user_to,$body,$date)
	{
		if($body != "")
		{
			$userLoggedIn = $this->user_obj->getUsername();
			$query = mysqli_query($this->con,"INSERT INTO messages VALUES('','$user_to','$userLoggedIn','$body','$date','no','no','no')");
		}
	}

	public function getMessages($otherUser)
	{
		$userLoggedIn = $this->user_obj->getUsername();
		$data = "";

		$query = mysqli_query($this->con, "UPDATE messages set opened='yes' where user_to='$userLoggedIn' and user_from='$otherUser' ");
		$get_messages_query = mysqli_query($this->con, "SELECT * FROM messages WHERE (user_to='$userLoggedIn' and user_from='$otherUser') OR  (user_to='$otherUser' and user_from='$userLoggedIn')");

		while ($row = mysqli_fetch_array($get_messages_query))
		{
			$user_to = $row['user_to'];
			$user_from = $row['user_from'];
			$body = $row['body'];

			$div_top = ($user_to == $userLoggedIn) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";
			$data = $data . $div_top . $body . "</div><br><br><br>";
		}
		return $data;
	}

	public function getLatestMessage($userLoggedIn,$user2)
	{
		$details_array = array();
		$query = mysqli_query($this->con,"SELECT body, user_to, date FROM messages where (user_to='$userLoggedIn' AND user_from='$user2') OR (user_to='$user2' AND user_from='$userLoggedIn') ORDER BY id DESC LIMIT 1");
		$row = mysqli_fetch_array($query);
		$sent_by = ($row['user_to']==$userLoggedIn)? "" : "You: ";

					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($row['date']); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					$time_message="";
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . "y"; //1 year ago
						else 
							$time_message = $interval->y . "y"; //1+ year ago
					}
					else if ($interval-> m >= 1) {
						if($interval->d == 0) {
							$days = "";
						}
						else if($interval->d == 1) {
							$days = $interval->d . "d";
						}
						else {
							$days = $interval->d . "d";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . "m". $days;
						}
						else {
							$time_message = $interval->m . "m". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . "d";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . "h";
						}
						else {
							$time_message = $interval->h . "h";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . "min";
						}
						else {
							$time_message = $interval->i . "min";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
					}


		array_push($details_array,$sent_by);
		array_push($details_array,$row['body']);
		array_push($details_array,$time_message);

		return $details_array;
	}

	public function getConvos()
	{

		$userLoggedIn = $this->user_obj->getUsername();
		$return_string = "";
		$convos=array();

		$query = mysqli_query($this->con, "SELECT user_to,user_from FROM messages where user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC");
		while ($row = mysqli_fetch_array($query))
		{
			$user_to_push = ($row['user_to'] != $userLoggedIn)? $row['user_to'] : $row['user_from'];
			if(!in_array($user_to_push, $convos))
			{
				array_push($convos, $user_to_push);
			}
		}
		foreach ($convos as $username)
		{
			$user_found_obj = new User($this->con, $username);
			$latest_message_details = $this->getLatestMessage($userLoggedIn,$username);

			$dots = (strlen($latest_message_details[1]) > 12)? "..." : "";
			$split = str_split($latest_message_details[1],12);
			$split = $split[0].$dots;

			$return_string .= "<a href='messages.php?u=$username'><div class='user_found_message'>

			<div class='convo_img'>
				<img src='".$user_found_obj->getProfilePic()."' height='40' width='40'>
			</div>
			<div class='convo_body'><span style='font-weight:bold;'>
				".$user_found_obj->getUsername()."</span> &middot; " .$latest_message_details[2]."
							<p id='grey' style='margin:2px 0px;'>".$latest_message_details[0]. $split."
							</p>
			</div>

			</div></a>";

		}
		return $return_string;
	}

}

?>