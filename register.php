<?php
session_start();
$error_msg = "";
$success_message = "";
header('Content-Type: text/html; charset=utf-8' );

require_once('connect.php');

// fetch countries list for select control
$country_query = " select Country_ID,Country_Name from countries ORDER BY Country_Name";
$country_result = mysqli_query($conn,$country_query);

if(isset($_POST['submit']))
{
  $fname   = myFilter($_POST['fname']);
  $lname   = myFilter($_POST['lname']);
  $email   = myFilter($_POST['email']);
  $contact = myFilter($_POST['number']);
  $password = myFilter($_POST['password']);
  $dob     = $_POST['dob'];
  $gender  = myFilter($_POST['gender']);
  $address = myFilter($_POST['address']);
  $city    = myFilter($_POST['city']);
  $state   = myFilter($_POST['state']);
  $country = myFilter($_POST['country']);


  $newdate = date('Y-m-d', strtotime($dob));

  $insert_query = "insert into tbl_register (fname,lname,email,password,dob,gender,contact,address,city,state,country) values ('$fname','$lname','$email','$password','$newdate','$gender',$contact,'$address','$city','$state','$country')";

  $conn = mysqli_connect('localhost','root','','shrikrishna') or die("Connection Error !");

  if($conn)
  {
    if(mysqli_query($conn,$insert_query))
    {
      $success_message = " Records Inserted Successfully ! ";
	}
    else
    {
      $error_msg = 'Insertion Failed ! ';
    }
  }
  else
  {
	$error_msg = ' Connection Problem ';
  }
}

function myFilter($data) {
  $data = trim($data);
 // $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html lang="en">
<head>

  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


</head>

<body style="background-color: grey;">
<div id="err"></div>
<div class="container">
<div class="jumbotron" >
  <h2 align="center" >Registration</h2>
  <form method="POST" name="myForm" id="myForm" action="" onsubmit="return validateForm();">

  <div class="row">
  <div class="col-sm-6">
	<div class="form-group">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" value="" id="fname" placeholder="Enter First Name" name="fname" >
      <span class="text-danger" id="fname_help"></span>
    </div>

	<div class="form-group">
      <label for="lname"> Last Name:</label>
      <input type="text" class="form-control" id="lname" value="" placeholder="Enter Last Name" name="lname" >
      <span class="text-danger" id="lname_help"></span>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" value="" placeholder="Enter Email" name="email" onchange="checkAvailability();" >
      <span class="text-danger" id="email_help"></span>
    </div>

    <div class="form-group">
        <label for="password"> Password:</label>
        <input type="text" onchange="validatePassword();"class="form-control" id="password" value="" placeholder="Enter Password" name="password" >
      </div>

      <div class="form-group">
          <label for="confirmPassword"> Confirm Password:</label>
          <input type="text" class="form-control" id="confirmPassword" value="" placeholder="Confirm Password" name="confirmPassword" >
          <span class="text-danger" id="password_help"></span>
        </div>

	<div class="form-group">
		<label for="datepicker">DOB:</label>
		<div class="input-group date">
			<input type="text" class="form-control" name="dob" id="datepicker" >
			<div class="input-group-addon">				<span class="glyphicon glyphicon-th"></span>
			</div>
		</div>
		<span class="text-danger" id="dob_help"></span>
    </div>

	<label for="gender">Gender:</label>
	<div class="radio">
		<label><input type="radio" id="gender" name="gender"  value="male">Male</label>
	</div>

	<div class="radio">
		<label><input type="radio" id="gender" name="gender" value="female" >Female</label>
	</div>
	<span class="text-danger" id="gender_help"></span>

  </div>
  <div class="col-sm-6">
    <div class="form-group">
        <label for="number"> Contact Number:</label>
        <input type="text" maxlength="10" class="form-control" value="" id="number" placeholder="Enter Contact Number" name="number" >
        <span class="text-danger" id="number_help"></span>
      </div>

	<div class="form-group">
		<label for="address">Address:</label>
		<textarea class="form-control" rows="5" id="address"   name="address"></textarea>
		<span class="text-danger" id="address_help"></span>
	</div>

	<div class="form-group">
      <label for="country"> Country:</label>
      <select class="form-control" id="country" name="country" onChange="getState(this.value)"  >
      <option value="">Select Country</option>
      <?php
      foreach($country_result as $country) {
        ?>
        <option value='<?= $country['Country_ID']; ?>'><?= utf8_encode($country['Country_Name']) ?></option>
        <?php
      }
      ?>
    </select>
      <span class="text-danger" id="country_help"></span>
    </div>

    <div class="form-group">
      <label for="state"> State:</label>
      <select  class="form-control" name="state" id="state" >
      <option value="">Select State</option>
    </select>
      <span class="text-danger" id="state_help"></span>
    </div>

	<div class="form-group">
      <label for="city"> City: </label>
      <input type="text" class="form-control" id="city" value=""  placeholder="Enter City" name="city">
      <span class="text-danger" id="city_help"></span>
    </div>

	<div class="text-danger" id="error_report" >
    <?php if($error_msg!= "")
		echo $error_msg; ?>
    </div><br/>

	<div class="text-success" id="success_report" >
	   <?php if($success_message!= "")
			echo $success_message; ?>
	</div><br/>

	<div class="form-group">
		<input type="submit" class="btn btn-primary"  name="submit" id="register" >
    <button type="reset" class="btn btn-warning">Reset</button>
	</div>

  </form>

  </div>

</div>

</div>
</div>

</body>
<script type="text/javascript" src="validate.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
  <script src="js/bootstrap-datepicker.js"></script>

  <script type="text/javascript" src="validate.js"> </script>
   <script>
	    $(document).ready(function () {
			$('#datepicker').datepicker({
				format: "dd-mm-yyyy"
			});
		});


   </script>
</html>
