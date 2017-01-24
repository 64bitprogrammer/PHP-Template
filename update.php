<?php
session_start();
$image_error = "";
if(!isset($_SESSION['current_user']) && !isset($_SESSION['current_user_id']))
header("location: login.php");
//$id1 = $_SESSION['current_user_id'];
//$id2 = $_GET['id'];


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

  if(!empty($_FILES['profile_pic']['name'])){
    // fetch extension
    $oldName  = basename($_FILES['profile_pic']['name']);
    $image_size = $_FILES['profile_pic']['size']; //file size
    $image_temp = $_FILES['profile_pic']['tmp_name']; //file temp
    $image_type = $_FILES['profile_pic']['type']; //file type
    $max_image_size = 2048000; // 2MB size limit

    $extension = end(explode('.', $oldName));

    if(($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif') && $image_size <=$max_image_size) {
      $image_name =  "profile".".$extension";
      $target = "users/$id/$image_name";
      move_uploaded_file($_FILES['profile_pic']['tmp_name'],$target) or die(" Image Storage Failed !");
      $image_uploaded = true;
      $image_error = "";
    }
    else{
      $image_uploaded = false;
      $image_error = "Invalid Image Format !";
    }
  }
  else{
    $image_uploaded = true;
    $image_error = "";
  }

  // modify dob to match sql type
  $newdate = date('Y-m-d', strtotime($dob));

  $insert_query = "update tbl_register set fname='$fname' , lname='$lname' , email='$email' ,contact=$contact, dob='$newdate',gender='$gender',address='$address', country='$country', state='$state',city='$city' where id=$id";

  $conn = mysqli_connect('localhost','root','','shrikrishna') or die("Connection Error !");

  if($conn && $image_uploaded)
  {
    if(mysqli_query($conn,$insert_query))
    {
      $success_msg = " Records Updated Successfully ! ";
      //header("Refresh:3");
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
  <script type="text/javascript" src="ajax.js">
  </script>

  <script>
  $(document).ready(function () {
    $('#datepicker').datepicker({
      format: "dd-mm-yyyy"
    });
  });

  var oldEmail = '<?=$row['email']?>' ;
  var oldState = '<?=$row['state']?>' ;

  function getQueryVariable(variable)
  {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable){return pair[1];}
    }
    return(false);
  }
  var x = getQueryVariable('id');
  var userid = Number(x);

  jQuery.ajax({
    url: "jsonUpdate.php",
    data:{ id:userid},
    type: "POST",
    success:function(data){
      var result = JSON.parse(data);
      //alert(JSON.stringify(result));
      if(result.status =="success"){
        var numb = Number(result.number);
        $("#fname").val(result["fname"]);
        $("#lname").val(result.lname);
        $("#email").val(result.email);
        // format date from sql to datepicker
        var res = result.dob.split("-");
        res.reverse();
        var dt = res.join("-");
        $("#datepicker").val(dt);
        $("#number").val(numb);
        $("#address").val(result.address);
        $("#city").val(result.city);
        $("#profile_pic").attr("src",result.image);
        if(result.gender == "male")
        $("#male").prop("checked", true);
        else
        $("#female").prop("checked", true);



      }
      else{
        $("#error_report").html("Insert Failed !");
      }
    },
    error:function (){

    }
  });
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
      <form method="POST" enctype="multipart/form-data" name="myForm" id="myForm" action="" onSubmit="return validateUpdate(oldEmail);">

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
              <input type="text" class="form-control"  id="email" value="" placeholder="Enter Email" name="email" >
              <span class="text-danger" id="email_help"></span>
            </div>

            <div class="form-group">
              <label for="datepicker">DOB:</label>
              <div class="input-group date">
                <input type="text" class="form-control" name="dob" id="datepicker" value="">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
                </div>
              </div>
              <span class="text-danger" id="dob_help"></span>
            </div>

            <label for="gender">Gender:</label>
            <div class="radio">
              <label><input type="radio" id="male" name="gender"  value="male">Male</label>
            </div>

            <div class="radio">
              <label><input type="radio" id="female" name="gender"  value="female" >Female</label>
            </div>
            <span class="text-danger" id="gender_help"></span>

            <div class="form-group">
              <label for="number"> Contact Number:</label>
              <input type="text" maxlength="10" class="form-control" value="" id="number" placeholder="Enter Contact Number" name="number" >
            </div>
            <span class="text-danger" id="number_help"></span>
          </div>
          <div class="col-sm-6">

            <?php
            if($row['image']=="" and $row['gender']=='male')
            $dp = "users/male.jpg";
            else if($row['image']=="" and $row['gender']=='female')
            $dp = "users/female.png";
            else
            $dp = $row['image'];
            ?>
            <label>Profile Picture</label>

            <img src=<?=$dp?> width='100' alt="profile" height="150" style="display:block;">
            <div class="form-group"><br>
              <input class="form-control" type="file" name="profile_pic" id="profile_pic"  >
            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <textarea class="form-control" rows="5" id="address"   name="address"></textarea>
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
              <?php /*if($error_msg!="" && $image_error!="")*/ echo $error_msg . $image_error; ?>
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
