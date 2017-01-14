<?php
// fname , lname , email , address , gender , dob , country , state , contact
require_once('connect.php');

$country_query = " select Country_ID,Country_Name from countries ORDER BY Country_Name";
$country_result = mysqli_query($conn,$country_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="validate.js"> </script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
   
   
   <script>
	 $( function() {
    $( "#datepicker" ).datepicker({ minDate: -30, maxDate: "+0Y +0M +1D" });

	$( "#datepicker" ).datepicker( "option", "dateFormat",'dd-mm-yy' );
  } );
  
	 
   </script>
   
</head>

<body style="background-color: grey;">

<div class="container">
<div class="jumbotron" >
  <h2 align="center" >Registration</h2><br/>
  <form method="POST" name="myForm" action="reg.php" onsubmit="return validateForm()">
  
  <div class="row">
  <div class="col-sm-6">
	<div class="form-group">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" value="Shrikrishna" id="fname" placeholder="Enter First Name" name="fname" >
      <span class="text-danger" id="fname_help"></span>
    </div>
	
	<div class="form-group">
      <label for="lname"> Last Name:</label>
      <input type="text" class="form-control" id="lname" value="Shanbhag" placeholder="Enter Last Name" name="lname" >
      <span class="text-danger" id="lname_help"></span>
    </div>
	
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" value="shrikrishna.shanbhag@gmail.com" placeholder="Enter Email" name="email" >
      <span class="text-danger" id="email_help"></span>
    </div>
	
	
	<div class="form-group">
      <label for="datepicker">DOB:</label>
      <input type="text" class="form-control" id="datepicker"  placeholder="Select DOB" name="dob" >
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
	
	<div class="form-group">
      <label for="number"> Contact Number:</label>
      <input type="text" maxlength="10" class="form-control" value="9876543210" id="number" placeholder="Enter Contact Number" name="number" >
    </div>
    <span class="text-danger" id="number_help"></span>
  </div>
  <div class="col-sm-6">
  
	
	
	<div class="form-group">
		<label for="address">Address:</label>
		<textarea class="form-control" rows="5" id="address"   name="address">Tilakwadi</textarea>
		<span class="text-danger" id="address_help"></span>
	</div>
	
	<div class="form-group">
      <label for="country"> Country:</label>
      <select class="form-control" id="country" name="country" onChange="getState(this)"  required>
      <option value="">Select Country</option>
      <?php
      foreach($country_result as $country) {
        ?>
        <option value='<?= $country['Country_ID']; ?>'><?= $country['Country_Name'] ?></option>
        <?php
      }
      ?>
    </select> 
      <span class="text-danger" id="country_help"></span>
    </div>

    <div class="form-group">
      <label for="state"> State:</label>
      <select  class="form-control" name="state" id="state" required>
      <option value="">Select State</option>
    </select> 
      <span class="text-danger" id="state_help"></span>
    </div>

	<div class="form-group">
      <label for="city"> City: </label>
      <input type="text" class="form-control" id="city" value="Belgaum"  placeholder="Enter City" name="city">
      <span class="text-danger" id="city_help"></span>
    </div>

  <input type="hidden" id="country_name" name="country_name"/>

	<div class="text-danger" id="error_report" >
		
	</div><br/>
	<div class="text-success" id="success_report" >
		
	</div><br/>

	<div class="form-group">
		<button type="submit" class="btn btn-primary">Submit</button>
		<button type="reset" class="btn btn-warning">Reset</button>
	</div>
	
  </form>
	
  </div>

</div>

</div>
</div>

</body>
</html>