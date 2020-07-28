<?php

require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Webbd.xyz</title>

	<!-- CSS only -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<!-- JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="assests/css/register_style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="assests/js/register.js"></script>
</head>
<body>

	<?php

        if(isset($_POST['register_button']))
        {
            echo '
                <script>
                    $(document).ready(function(){
                        $("#first").hide();
                        $("#second").show();
                    });
                </script>
            ';
        }

    ?>

    <div class="wrapper">
    	<div class="login_box">
    		<div id="first">
    			<h3 class="box-label">Login!</h3>
    			<form action="register.php" method="POST">

    				<span class="alert-error">
    					<?php if(in_array("Invalid credentials!<br>", $error_array)) echo "Invalid credentials!<br>"; ?>
    				</span>
					

					<input type="email" name="log_email"  class="form-control" placeholder="Email Address" value="<?php 
						if(isset($_SESSION['log_email']))
						{
							echo $_SESSION['log_email'];
						}
					?>"required>
					<input type="password" name="log_password" class="form-control" placeholder="Password">
					<input type="submit" name="login_button" class="btn btn-primary mb-2" value="Login!">
					<a href="#" id="signup" class="signup">Need an account? Register Here!</a>
				</form>

    		</div>
    		<div id="second">
	    			<h3 class="box-label">Register!</h3>
				<form action="register.php" method="POST">

					<span class="alert-error">
						<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; ?>
						<?php if(in_array("Email invalid format<br>", $error_array)) echo "Email invalid format<br>"; ?>
						<?php if(in_array("Emails dont match!<br>", $error_array)) echo "Emails dont match!<br>"; ?>
						<?php if(in_array("Passwords dont match!<br>", $error_array)) echo "Passwords dont match!<br>"; ?>
						<?php if(in_array("You're all set! Go ahead and login!<br>", $error_array)) echo "You're all set! Go ahead and login!<br>"; ?>
					</span>

					<input type="text" name="reg_fname" class="form-control" placeholder="First Name" value="<?php 
						if(isset($_SESSION['reg_fname']))
						{
							echo $_SESSION['reg_fname'];
						}
					?>"required>
					<input type="text" name="reg_lname" class="form-control" placeholder="Last Name" value="<?php 
						if(isset($_SESSION['reg_lname']))
						{
							echo $_SESSION['reg_lname'];
						}
					?>"required>
					<input type="email" name="reg_email"  class="form-control"placeholder="Email Address" value="<?php 
						if(isset($_SESSION['reg_email']))
						{
							echo $_SESSION['reg_email'];
						}
					?>"required>
					<input type="email" name="reg_email2" class="form-control" placeholder="Confirm Email" value="<?php 
						if(isset($_SESSION['reg_email2']))
						{
							echo $_SESSION['reg_email2'];
						}
					?>"required>
					<input type="password" name="reg_password" class="form-control" placeholder="Password"required>
					<input type="password" name="reg_password2" class="form-control"placeholder="Confirm Password"required>
					<input type="submit" name="register_button" value="Register" class="btn btn-primary mb-2"><br>
					<a href="#" id="signin" class="signup">Already have an account? Login here!</a>
				</form>

    		</div>
			<br>

    	</div>
    </div>
	

</body>
</html>