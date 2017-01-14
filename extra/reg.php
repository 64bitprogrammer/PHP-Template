<?php

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
    $dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$country = $_POST['country'];
	
	//echo $fname . " " . $lname  . " " . $email  . " " .  $contact  . " " .  $gender  . " " .  $address  . " " . 
	//$city  . " " . $state  . " " .  $country ;
	
	$insert_query = "insert into tbl_register values ('$fname','$lname','$email',$dob,'$gender',$contact,'$address','$city','$state','$country')";
	
	$conn = mysqli_connect('localhost','root','','shrikrishna') or die("Connection Error !");
	
	if($conn)
	{
		if(mysqli_query($conn,$insert_query))
        {
			echo " <h1> Data Inserted ! <h1> ";
        }
		else
        {
			echo " <h1> Insert Failed ! <h1> ";
        }
	}
	else
			echo " <h1> Connection Failed ! <h1> ";
		
	
	
?>