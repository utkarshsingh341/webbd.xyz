<?php
//Declaring variables
$fname ="";
$lname="";
$em="";
$em2="";
$password="";
$password2="";
$date="";
$error_array=array();


if(isset($_POST['register_button']))
{
	//Regiter form values

	//FIRST NAME
	$fname = strip_tags($_POST['reg_fname']); //Removes html tags 
	$fname = str_replace(' ', '', $fname);//Removes empty spaces
	$fname = ucfirst(strtolower($fname));//Firsr letter uppercase
	$_SESSION['reg_fname'] = $fname; //Stores first name in session

	//LAST NAME
	$lname = strip_tags($_POST['reg_lname']); //Removes html tags 
	$lname = str_replace(' ', '', $lname);//Removes empty spaces
	$lname = ucfirst(strtolower($lname));//Firsr letter uppercase
	$_SESSION['reg_lname'] = $lname; //Stores first name in session

	//EMAIL
	$em = strip_tags($_POST['reg_email']); //Removes html tags 
	$em = str_replace(' ', '', $em);//Removes empty spaces
	$_SESSION['reg_email'] = $em; //Stores first name in session	

	//EMAIL2
	$em2 = strip_tags($_POST['reg_email2']); //Removes html tags 
	$em2 = str_replace(' ', '', $em2);//Removes empty spaces
	$_SESSION['reg_email2'] = $em2; //Stores first name in session

	//PASSWORD
	$password = strip_tags($_POST['reg_password']); //Removes html tags 

	//PASSWORD2
	$password2 = strip_tags($_POST['reg_password2']); //Removes html tags 

	//DATE
	$date = date("Y-m-d"); //Current date


	//Form Handling

	if($em==$em2)//Checks if emails match
	{
		//Check if email is in valid format
		if(filter_var($em, FILTER_VALIDATE_EMAIL))
		{
			$em=filter_var($em, FILTER_VALIDATE_EMAIL);

			//CHECK IF EMAIL EXISTS
			$e_check = mysqli_query($con, "SELECT email FROM users where email='$em' ");
			//Count number of rows returened
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows>0)
			{
				array_push($error_array, "Email already in use<br>");
			}

		}else{
			array_push($error_array, "Email invalid format<br>");
		}
	}else{
		array_push($error_array,  "Emails dont match!<br>");
	}
	if($password!=$password2)
	{
		array_push($error_array,  "Passwords dont match!<br>");
	}


	//Entering Values in the database

	if(empty($error_array))
	{
		//Generating username
        //Generate username by concatenating first name and last name
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");   
        $i = 0;
        //If username exists add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++; //Add 1 to i
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

		//Profile Picture assignment
		$rand = rand(1,2);
		if($rand==1)
		{
			$profile_pic = "assests/images/profile_pics/defaults/head_blue.png";
		}else if($rand==2){
			$profile_pic = "assests/images/profile_pics/defaults/head_green.png";
		}
		
		//Finally
		$query = mysqli_query($con, "INSERT INTO users VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");
		array_push($error_array,"You're all set! Go ahead and login!<br>");

		//Clear sessions
		$_SESSION['reg_fname'] = "";
    	$_SESSION['reg_lname'] = "";
    	$_SESSION['reg_email'] = "";
    	$_SESSION['reg_email2'] = "";

	}
}

?>