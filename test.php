<?php


if(isset($_POST['submit'])){
header('Content-type: image/jpeg');
    if(!is_dir('imageDir')){
      mkdir('imageDir');
    }
    if(!is_dir('imageDir/test')){
      mkdir('imageDir/test');
    }

    $image  = basename($_FILES['myimage']['name']);
    $ext =  pathinfo($image, PATHINFO_EXTENSION);
    $target = "imageDir/test/" .'Email' . ".$ext";
    //echo $target . " " . $ext ;
    //echo "<Br/>" . $image;


      // Create Image From Existing File
      $jpg_image = imagecreatefromjpeg('images/Penguins.jpg');

      // Allocate A Color For The Text
      $white = imagecolorallocate($jpg_image, 0, 0, 0);

      // Set Path to Font File
      $font_path = 'fonts/arial.TTF';

      // Set Text to Be Printed On Image
      $text = "T!@#$%^&*()_+";

      // Print Text On Image
      imagettftext($jpg_image, 15, 0, 400, 400, $white, $font_path, $text);

      // Send Image to Browser
      imagejpeg($jpg_image);

      // Clear Memory
      imagedestroy($jpg_image);
    //move_uploaded_file($_FILES['myimage']['tmp_name'],$target) or die(" Image Storage Failed !");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="row">
    <form name="image_form" method="post" action="test.php" enctype="multipart/form-data">
      <input type="file" name="myimage" id="myimage" />
      <input type="submit" name="submit" value="go" />
    </form>
  </div>
</div>

</body>
</html>
