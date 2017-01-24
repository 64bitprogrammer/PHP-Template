<?php
session_start();
$error_msg = "";
$success_message = "";
require_once('connect.php');
header('Content-Type: text/html; charset=utf-8' );

// fetch countries list for select control
$country_query = "select Country_ID,Country_Name from countries ORDER BY Country_Name";
$country_result = mysqli_query($conn,$country_query);

if(isset($_POST['submit']) && isset($_FILES['profile_pic']['name']))
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

  if(!isset($_FILES['profile_pic']['name'])){
    $error_msg = "Profile Pic Not Selected !";
  }




  $newdate = date('Y-m-d', strtotime($dob));

  $insert_query = "insert into tbl_register (fname,lname,email,password,dob,gender,contact,address,city,state,country) values ('$fname','$lname','$email','$password','$newdate','$gender',$contact,'$address','$city','$state','$country')";

  //$conn = mysqli_connect('localhost','root','','shrikrishna') or die("Connection Error !");

  if($conn)
  {
    if(mysqli_query($conn,$insert_query))
    {
      $row = mysqli_fetch_assoc(mysqli_query($conn,"select id from tbl_register where email='$email' and is_deleted=0"));
      $id = $row['id'];
      $directory = 'users/' . $id;
      if(!is_dir($directory))
      {
        mkdir($directory);
      }

      $directory = "users/".$id ;
      $image  = basename($_FILES['profile_pic']['name']);
      $extension = end(explode('.', $image));
      $target = $directory . "/profile" . ".$extension";
      //move_uploaded_file($_FILES['profile_pic']['tmp_name'],$target) or die(" Image Storage Failed !");
      watermarkProfile($email,$id,$extension,$conn);
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

function watermarkProfile($email,$id,$extension,$conn){
  //require_once('connect.php');
  $destination_folder = "users/".$id ;
  $watermark_png_file = "images/watermark.png";
  $newFileName = "water.png";
  $max_size = 800;

  //$image_name = $_FILES['profile_pic']['name']; //file name
  $image_name =  "profile".".$extension";
	$image_size = $_FILES['profile_pic']['size']; //file size
	$image_temp = $_FILES['profile_pic']['tmp_name']; //file temp
	$image_type = $_FILES['profile_pic']['type']; //file type

	switch(strtolower($image_type)){ //determine uploaded image type
			//Create new image from file
			case 'image/png':
				$image_resource =  imagecreatefrompng($image_temp);
				break;
			case 'image/gif':
				$image_resource =  imagecreatefromgif($image_temp);
				break;
			case 'image/jpeg': case 'image/pjpeg':
				$image_resource = imagecreatefromjpeg($image_temp);
				break;
			default:
				$image_resource = false;
		}

	if($image_resource && $image_size <= 2048000){
		//Copy and resize part of an image with resampling
		list($img_width, $img_height) = getimagesize($image_temp);

	    //Construct a proportional size of new image
		$image_scale        = min($max_size / $img_width, $max_size / $img_height);
		$new_image_width    = ceil($image_scale * $img_width);
		$new_image_height   = ceil($image_scale * $img_height);
		$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);

		if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height))
		{

			//if(!is_dir($destination_folder)){
				//mkdir($destination_folder);//create dir if it doesn't exist
		//	}

			//center watermark
			$watermark_left = ($new_image_width/2)-(300/2); //watermark left
			$watermark_bottom = ($new_image_height/2)-(100/2); //watermark bottom

			$watermark = imagecreatefrompng($watermark_png_file); //watermark image
			imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 100); //merge image

			//output image direcly on the browser.
			//header('Content-Type: image/jpeg');
			//imagejpeg($new_canvas, NULL , 90);

			//Or Save image to the folder
			imagejpeg($new_canvas, $destination_folder.'/'.$image_name , 90);
      $image_path = "users/$id/$image_name";
      mysqli_query($conn,"update tbl_register set Image='$image_path' where email='$email' and is_deleted=0 ") or die(" Failed to set profile image ");
			//free up memory
			imagedestroy($new_canvas);
			imagedestroy($image_resource);
		}
	}


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
<link rel="stylesheet" href="custom.css" >

</head>

<body style="background-color: grey;">
  <div class="jumbotron" id="header">
    <div  align="center">
      <h2> Registration Page </h2>
    </div>
  </div>
<div id="err"></div>
<div class="container">
<div class="jumbotron" >
  <h2 align="center" >Registration</h2>
  <form method="POST" enctype="multipart/form-data" name="myForm" id="myForm" action="" onsubmit="return validateForm();">

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
      <label for="image"> Image </label>
      <input  type="file" name="profile_pic" id="profile_pic" accept="image/x-png,image/gif,image/jpeg"  />
    </div>
    <span class="text-danger" id="image_Help"></span>
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
      <select class="form-control" id="country" name="country" onChange="getState(this.value);"  >
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

    <div class="form-group" id="show_state">
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
<div class="footer" id="footer">
  <strong>Test.com &copy; All Rights Reserved 2017.</strong>.
</div>
</body>
<script type="text/javascript" src="validate.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
  <script src="js/bootstrap-datepicker.js"></script>

  <script type="text/javascript" src="validate.js"> </script>
  <script type="text/javascript" src="ajax.js"> </script>
   <script>
	    $(document).ready(function () {
			$('#datepicker').datepicker({
				format: "dd-mm-yyyy"
			});
		});


   </script>
</html>
