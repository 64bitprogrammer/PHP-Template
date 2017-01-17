// crop images
<?php
if(isset($_POST['crop'])){
  $xoffset = $_POST['xoffset'];
  $yoffset = $_POST['yoffset'];
  $xsize = $_POST['xsize'];
  $ysize = $_POST['ysize'];

  if($xoffset == "" || $xoffset ==0)
    $xoffset = 0;

    if($yoffset == "" || $yoffset == 0)
      $yoffset = 0;

      if($xsize == "" || $xsize ==0)
        $xsize = 1024;

        if($ysize == "" || $ysize == 0)
          $ysize = 768;
// Original image
$filename = 'Koala.jpg';
$newfilename = 'cropped.jpg';

// Get dimensions of the original image
list($current_width, $current_height) = getimagesize($filename);

// The x and y coordinates on the original image where we
// will begin cropping the image
$left = $xoffset;
$top = $yoffset;

// This will be the final size of the image (e.g. how many pixels
// left and down we will be going)
$crop_width = $xsize ;
$crop_height = $ysize;

// Resample the image
$canvas = imagecreatetruecolor($crop_width, $crop_height);
$current_image = imagecreatefromjpeg($filename);
imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
imagejpeg($canvas, $newfilename, 100);

echo "<h2> Cropped Image </h2>";
echo " <img src='$newfilename' alt='imageNotFound' width='300' height='200' />";
}
?>

<html>
  <body>
    <form method="POST" name="form1">
      <h2> Image to crop </h2>
      <img src="Koala.jpg" width="30%" height="20%" > <br/>
      <input type="number" name="xoffset" placeholder="xoffset" />
      <input type="number" name="yoffset" placeholder="yoffset" />
      <input type="number" name="xsize" placeholder="Width" />
      <input type="number" name="ysize" placeholder="Height" />
      <input type="submit" name="crop" value="crop" />

    </form>
  </body>
</html>
