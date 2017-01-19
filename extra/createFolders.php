<?php
require_once('connect.php');
$result = mysqli_query($conn,"select id from tbl_register");
$i=0;
while($row = mysqli_fetch_assoc($result)){
  $id = $row['id'];
  $directory = 'users/' . $id;
  if(!is_dir($directory))
  {
    mkdir($directory);
    $i++;
    echo "$id,";
  }

}
echo "<br><Br> <h2> Total Directories created : $i </h2>";
?>
