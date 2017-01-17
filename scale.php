<html>
<head>
</head>
<body>
  <form enctype="multipart/form-data" method="post" action="">
<input type="file" name="image" style="border:solid 1px; padding:20px;margin-left:5px;margin-top:20px;"/>
<input type="number" name="width" placeholder="Width" style="border:solid 1px; padding:6px;" >
<input type="submit" name="submit" value="Create" />
</form>
</body>
<?php

  require_once('connect.php');
  if(isset($_POST['submit']) && !empty($_FILES['image']['name'])){

    $adjusted_width = $_POST['width'];

    // aspect ration = width: height
    $file = $_FILES['image']['tmp_name'];
    list($original_width,$original_height) = getimagesize($file);
    $adjusted_height = $adjusted_width * ( $original_height / $original_width);

    $new_image = imagecreatetruecolor($adjusted_width, $adjusted_height);
    $old_image = imagecreatefromjpeg($file);

    $red = imagecolorallocate($new_image, 0, 0, 0);
    imagefill($new_image, 0, 0, $red);

    $new_image = imagescale ( $old_image , $adjusted_width, $adjusted_height, $mode = IMG_BILINEAR_FIXED);

    imagejpeg($new_image, 'scaled.jpg', 100);
    imagedestroy($old_image);
    imagedestroy($new_image);
    echo "<img src='scaled.jpg'  >";
  }
?>
