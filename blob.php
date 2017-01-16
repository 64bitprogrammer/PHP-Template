<html>
<head>
</head>
<body>
  <form enctype="multipart/form-data" method="post" action="">
<input type="file" name="image"/>
<input type="submit" name="submit" value="sup!" />
</form>
</body>
<?php

  require_once('connect.php');
  if(isset($_POST['submit']))
  {
  $img = mysqli_real_escape_string($conn,file_get_contents($_FILES['image']['tmp_name']));
  $sql = "insert into tbl_images (id,image) values('','$img')";

  $result = mysqli_query($conn,$sql);

if($result)
  echo " Success";
else
  echo "Failed";

  //header('Content-type: image/jpg');
  $res = mysqli_fetch_assoc(mysqli_query($conn,"select id from tbl_images order by id desc limit 1"));
  $id = $res['id'];
  $sql = "SELECT * FROM tbl_images WHERE id = $id";
  $sth = mysqli_query($conn,$sql);
  $result=mysqli_fetch_array($sth);
  echo '<img widht="200" height="100" src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';

  }
?>
