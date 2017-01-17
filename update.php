<?php
session_start();
if(!isset($_SESSION['current_user']))
	header("location: login.php");
require_once('connect.php');
// set initial success / error variables to null

// fetch countries list for select control
$success_msg = "";
$error_msg = "";

$country_query = " select Country_ID,Country_Name from countries ORDER BY Country_Name";
$country_result = mysqli_query($conn,$country_query);
$id = $_GET['id'];

// query to load page content , ie. record lists
$select_query = " select * from tbl_register where id=$id ";
$result = mysqli_query($conn,$select_query);
$row = mysqli_fetch_assoc($result);

// display fetched date in proper format
	$newdate = date('d-m-Y', strtotime($row['dob']));



// function to format input variables
	function myFilter($data) {
		$data = trim($data);
		//$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

// on update click set updated data
if(isset($_POST['update'])){

  $fname   = myFilter($_POST['fname']);
  $lname   = myFilter($_POST['lname']);
  $email   = myFilter($_POST['email']);
  $contact = myFilter($_POST['number']);
  $dob     = myFilter($_POST['dob']);
  $gender  = myFilter($_POST['gender']);
  $address = myFilter($_POST['address']);
  $city    = myFilter($_POST['city']);
  $state   = myFilter($_POST['state']);
  $country = myFilter($_POST['country']);

	// modify dob to match sql type
  $newdate = date('Y-m-d', strtotime($dob));

  $insert_query = "update tbl_register set fname='$fname' , lname='$lname' , email='$email' ,contact=$contact, dob='$newdate',gender='$gender',address='$address', country='$country', state='$state',city='$city' where id=$id";

  $conn = mysqli_connect('localhost','root','','shrikrishna') or die("Connection Error !");

  if($conn)
  {
    if(mysqli_query($conn,$insert_query))
    {
	  header("Refresh:0");
	  $success_msg = " Records Updated Successfully ! ";
	}
    else
    {
      $error_msg = 'Update Failed ! ';
    }
  }
  else
  {
	$error_msg = ' Connection Problem ';
  }
}

?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html lang="en">
<head>

  <title>Update</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script type="text/javascript" src="validate.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="custom.css" >
  <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
  <script src="js/bootstrap-datepicker.js"></script>
     <script>
   $(document).ready(function () {
			$('#datepicker').datepicker({
				format: "dd-mm-yyyy"
			});
		});

	var oldEmail = '<?=$row['email']?>' ;
	var oldState = '<?=$row['state']?>' ;
   </script>
</head>

<body style="background-color: grey;" onLoad="loadState(document.getElementById('country').value,oldState);">

	<?php
		include_once('navbar.php');
		?>
<div id="err"></div>
<div class="container">
<div class="jumbotron" >
  <h2 align="center" >Edit</h2><br/>
  <form method="POST" name="myForm" id="myForm" action="" onSubmit="return validateUpdate(oldEmail);">

  <div class="row">
  <div class="col-sm-6">
	<div class="form-group">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" value="<?=$row['fname']?>" id="fname" placeholder="Enter First Name" name="fname" >
      <span class="text-danger" id="fname_help"></span>
    </div>

	<div class="form-group">
      <label for="lname"> Last Name:</label>
      <input type="text" class="form-control" id="lname" value="<?=$row['lname']?>" placeholder="Enter Last Name" name="lname" >
      <span class="text-danger" id="lname_help"></span>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control"  id="email" value="<?=$row['email']?>" placeholder="Enter Email" name="email" >
      <span class="text-danger" id="email_help"></span>
    </div>

	<div class="form-group">
      <label for="datepicker">DOB:</label>
      <div class="input-group date">
    <input type="text" class="form-control" name="dob" id="datepicker" value="<?=$newdate?>">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
	</div>
      <span class="text-danger" id="dob_help"></span>
    </div>

	<label for="gender">Gender:</label>
	<div class="radio">
		<label><input type="radio" id="gender" name="gender" <?php if($row['gender']=='male')echo 'checked';?> value="male">Male</label>
	</div>

	<div class="radio">
		<label><input type="radio" id="gender" name="gender" <?php if($row['gender']=='female')echo 'checked';?> value="female" >Female</label>
	</div>
	<span class="text-danger" id="gender_help"></span>

	<div class="form-group">
      <label for="number"> Contact Number:</label>
      <input type="text" maxlength="10" class="form-control" value="<?=$row['contact']?>" id="number" placeholder="Enter Contact Number" name="number" >
    </div>
    <span class="text-danger" id="number_help"></span>
  </div>
  <div class="col-sm-6">



	<div class="form-group">
		<label for="address">Address:</label>
		<textarea class="form-control" rows="5" id="address"   name="address"><?=$row['address']?></textarea>
		<span class="text-danger" id="address_help"></span>
	</div>

	<div class="form-group">
      <label for="country"> Country:</label>
      <select class="form-control" id="country" name="country"  onChange="getState(this.value)"  >
      <option value="">Select Country</option>
      <?php

      foreach($country_result as $country) {
        ?>
        <option <?php if($row['country']==$country['Country_ID']) echo 'selected="selected"'; ?> value='<?=$country['Country_ID'];?>'><?= utf8_encode($country['Country_Name']) ?></option>
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
      <input type="text" class="form-control" id="city" value="<?=$row['city']?>"  placeholder="Enter City" name="city">
      <span class="text-danger" id="city_help"></span>
    </div>

	<div class="text-danger" id="error_report" >
		<?php if($error_msg!="") echo $error_msg; ?>
    </div><br/>

	<div class="text-success" id="success_report" >
		<?php if($success_msg!="") echo $success_msg; ?>
	</div><br/>

  <input type="hidden" id="country_name" name="country_name"/>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Update" name="update" id="update" >
	</div>

  </form>


  </div>

</div>

</div>
</div>
<div class="footer" id="footer">
  <strong>Test.com &copy; All Rights Reserved 2017.</strong>.
</div>
</body>


</html>
