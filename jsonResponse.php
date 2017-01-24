<?php
  require_once('connect.php');
  $fname   = $_POST['fname'];
  $lname   = $_POST['lname'];
  $email   = $_POST['email'];
  $contact = $_POST['number'];
  $password = $_POST['password'];
  $dob     = $_POST['dob'];
  $gender  = $_POST['gender'];
  $address = $_POST['address'];
  $city    = $_POST['city'];
  $state   = $_POST['state'];
  $country = $_POST['country'];
  $image = "users/def.jpg";

  if(isset($_FILES['profile_pic']['name'])){
    move_uploaded_file($_FILES['profile_pic']['tmp_name'],"moved.jpg");
  }

  $newdate = date('Y-m-d', strtotime($dob));
  $insert_query = "insert into tbl_register (fname,lname,email,password,image,dob,gender,contact,address,city,state,country) values ('$fname','$lname','$email','$password','$image','$newdate','$gender',$contact,'$address','$city','$state','$country')";

  if(mysqli_query($conn,$insert_query)){
    $obj = json_encode(array("status"=>"success"));
    echo $obj;
  }
  else{
    $obj = json_encode(array("status"=>"failed"));
    echo $obj;
  }

?>
