<html>
<head>
</head>
<body>
  <form enctype="multipart/form-data" method="post" action="">
<input type="file" name="image" style="border:solid 1px; padding:20px;margin-left:5px;margin-top:20px;"/>
<input type="number" name="size" placeholder="Size" style="border:solid 1px; padding:6px;" >
<input type="submit" name="submit" value="Create" />
</form>
</body>
<?php

  require_once('connect.php');
  if(isset($_POST['submit']) && !empty($_FILES['image']['name']))
  {
  //header('Content-type: image/jpeg');
  $file = $_FILES['image']['tmp_name'];

if($_POST['size']!= "")
  $size = $_POST['size'];
else
  $size = 100;

  list($old_width, $old_height) = getimagesize($file);

  if($size > $old_width || $size > $old_height){
    $size = 100;
    echo " <br/> <span style='color:red'> Bad Size : Using Default [100] </span> <br/>";
  }
  $new_width = $size;
  $new_height = $size;


  $new_image = imagecreatetruecolor($new_width, $new_height);
  $old_image = imagecreatefromjpeg($file);

  imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

  imagejpeg($new_image, 'thumbnail.jpg', 75);
  imagedestroy($old_image);
  imagedestroy($new_image);
  echo "<img src='thumbnail.jpg'  >";
  }

  function show($a,$b,$c)
  {
    static $n = 1;
    echo "< |$n| 1=>$a , 2=>$b, 3=>$c >";
    $n++;
  }
?>
