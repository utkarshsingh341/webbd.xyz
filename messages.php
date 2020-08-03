<?php 

include ("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if(isset($_GET['u']))
{
	$user_to = $_GET['u'];
}else{
	$user_to = $message_obj->getMostRecentUser();
	if($user_to== false)
	{
		$user_to = 'new';
	}
}

if($user_to != "new")
{
	$user_to_obj = new User($con, $user_to);
}


if(isset($_POST['post_message']))
{
	if(isset($_POST['message_body']))
	{
		$body = mysqli_real_escape_string($con, $_POST['message_body']);
		$date = date("Y-m-d H:i:s");
		$message_obj->sendMessage($user_to,$body,$date);
	}
}


 ?>
 <div class="container">
		<div class="row">
	    	<div class="col-4">
	      		<div class="profile_details column" id="conversations" style="padding: 30px;">
					<h5 class='you-and-h5'>Conversations</h5>
					<div class="loaded_conversations">
						<?php echo $message_obj->getConvos(); ?>
					</div>
					<br>
						<a href="messages.php?u=new">Send a new message</a>
					<br>
				</div>
			</div>
			<div class="col-8">
	      		<div class="main_column column" style="padding: 40px;">
	      			<?php

	      				if($user_to != "new"){
	      					echo "<h5 class='you-and-h5'>You and <a href='$user_to'>".$user_to_obj->getFirstAndLastName() ."</a></h5>";
	      					echo "<div class='loaded_messages' id='scroll_messages'>";
	      						echo $message_obj->getMessages($user_to);
	      					echo "</div>";
	      				}else{
	      					echo "<h5>New Message</h5>";
	      				}

	      			?>

	      			<div class="message_post">
	      				<form action="" method="POST">
	      					<?php
	      						if($user_to == "new")
	      						{
	      							echo "Select the friend you want to message<br>";
	      							echo "To: <input type='text'";
	      							echo "<div class='results'></div>";
	      						}else{
	      							echo "<div class='message_box'>";
	      							echo "<textarea name='message_body' class='message-textarea' id='message_textarea' placeholder='Write your message (100 characters limit)' maxlength='100'></textarea>";
	      							echo "<button name='post_message' class='info' id='message_submit' type='submit'><i class='fa fa-send-o' style='font-size:21px'></i> </button' >";
	      							echo "</div>";
	      							
	      					
	      						}
	      					?>
	      				</form>
	      				
	      			</div>

	      			<script>
	      				var div = document.getElementById("scroll_messages");
	      				div.scrollTop = div.scrollHeight;
	      			</script>


	      		</div>
	      	</div>
		</div>
</div>
