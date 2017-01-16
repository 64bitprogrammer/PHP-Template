<?php
$db = mysqli_connect('localhost','root','','lt');

$query = "select recipient_settings.Privacy,profiles.* from profiles,recipient_settings where profiles.Profiles_ID BETWEEN 20 and 100 and profiles.Profiles_ID = recipient_settings.Profiles_ID
and (Privacy='PRIVATE' or Privacy='SEMI-PRIVATE')
GROUP BY Profiles_ID";

$res = mysqli_query($db,$query);
// echo "size = " . sizeof(mysqli_num_rows($res)) . "<br/>";
$i=0;
while($row = mysqli_fetch_array($res)){
	echo "$row[0]  &nbsp; <==> &nbsp; $row[1] <==> $row[2]<br/>";
		$i++;
}
echo "Count = $i";
?>
