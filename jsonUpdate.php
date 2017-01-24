<?php

require_once('connect.php');
$id = $_POST['id'];

$result = mysqli_query($conn,"select * from tbl_register where id=$id");
$row = mysqli_fetch_assoc($result);

if($row){
  $obj = json_encode(array("status"=>"success","id"=>$row['id'],"fname"=>$row['fname'],
        "lname"=>$row['lname'],"email"=>$row['email'],"city"=>$row['city'],
        "address"=>$row['address'],"dob"=>$row['dob'],"image"=>$row['image'],"number"=>$row['contact']));
  echo $obj;
}
else{
  $obj = json_encode(array("status"=>"failed"));
  echo $obj;
}

?>
