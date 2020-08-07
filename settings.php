<?php 

include("includes/header.php");
include("includes/form_handlers/settings_handler.php");

?>
<div class="container">
	<div class="row">
		<div class="col-sm-6" style="margin: 10px auto;">
			<div class="main_column column" style="padding:25px;">
				<h3>Account Settings</h3><hr>
				<div class="settings_image">

					<?php
						echo "<img src='".$user['profile_pic']."' id='small_profile_pic'>";
					?>
					<br>
					<a href="upload.php">Upload new profile picture!</a>
				</div>
				<hr>
				<h6 style="font-size: 17px;">Modify the values and click 'Update Details' </h6>


				<form action="settings.php" method="POST" style="margin-bottom: 40px;">
					<span style="text-align: center;"><?php echo $message; ?></span>
					<div class="form-group">
					    <label style="font-size: 14px;" for="exampleInputEmail1">First Name:</label>
					    <input name="first_name" type="text" class="form-control" value="<?php echo $user['first_name']; ?>">
					  </div>
					  <div class="form-group">
					    <label style="font-size: 14px;" for="exampleInputPassword1">Last Name:</label>
					    <input name="last_name" type="text" class="form-control" value="<?php echo $user['last_name']; ?>">
					  </div>
					  <div class="form-group">
					    <label style="font-size: 14px;" for="exampleInputPassword1">Email Address:</label>
					    <input name="email" type="text" class="form-control" value="<?php echo $user['email']; ?>">
					  </div>
					  <div>
					  	<input type="submit" name="update_details" id="save_details" value="Update Details!"class="btn btn-primary btn-block">
					  </div>
				</form>
				<hr>
				<h6 style="margin-top: 10px;font-size: 17px;">Change Password</h6>
				<span style="text-align: center;"><?php echo $password_message; ?></span>
				<form action="settings.php" method="POST">
					<div class="form-group">
					    <label style="font-size: 14px;" for="exampleInputEmail1">Old Password:</label>
					    <input name="old_password" type="password" class="form-control">
					  </div>
					  <div class="form-group">
					    <label style="font-size: 14px;" for="exampleInputPassword1">New Password:</label>
					    <input name="new_password1" type="password" class="form-control">
					  </div>
					  <div class="form-group">
					    <label style="font-size: 14px;" for="exampleInputPassword1">Confirm New Password:</label>
					    <input name="new_password2" type="password" class="form-control">
					  </div>
					  <div>
					  	<input type="submit" name="update_password" id="save_details" value="Update Password!"class="btn btn-primary btn-block">
					  </div>
				</form>
				<br><hr>
				<form action="settings.php" method="POST" style="margin-top: 20px;">

					<!-- Button trigger modal -->
					<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal">
					  Close your Webbd.xyz account
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Are you sure? </h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        If you close your account now: all your posts, messages and activities on this account will be hidden from other users.<br><br>
					        You can reactivate your ID anytime by simply logging in again!
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Don't close account</button>
					        <input type="submit" name="close_account" id="close_account" value="Go ahead and close account" class="btn btn-outline-danger btn-sm">
					      </div>
					    </div>
					  </div>
					</div>
				</form>
			</div>	
		</div>
	</div>
</div>
</div>
</body>
</html>