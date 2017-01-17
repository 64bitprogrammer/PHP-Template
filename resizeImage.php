
<?php
if(isset($_POST['resize'])){
  $scale = $_POST['scale'];

  if($scale == "" || $scale ==0 || $scale<10)
  $scale = 50;

  $scale = $scale / 100;

  // File and new size
  //the original image has 800x600
  $filename = 'Koala.jpg';
  //the resize will be a percent of the original size
  $percent = $scale;

  // Content type
//  header('Content-Type: image/jpeg');

  // Get new sizes
  list($width, $height) = getimagesize($filename);
  $newwidth = $width * $percent;
  $newheight = $height * $percent;

  // Load
  $thumb = imagecreatetruecolor($newwidth, $newheight);
  $source = imagecreatefromjpeg($filename);

  // Resize
  imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

  // Output and free memory
  //the resized image will be 400x300
  imagejpeg($thumb, 'resized.jpg', 100);
  imagedestroy($thumb);
  echo "<h2> Resized Image </h2>";
  echo "<img src='resized.jpg'  >";
}
?>

<html>
<body>
  <form method="POST" name="form1">
    <h2> Image to Resize </h2>
    <img src="Koala.jpg"  > <br/>
    <input type="number" name="scale" placeholder="Scale [ 1% - 100% ]" />
    <input type="submit" name="resize" value="Resize" />

  </form>
</body>
</html>
