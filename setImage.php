<?php
	require_once('connect.php');

	$result = mysqli_query($conn,"select * from tbl_register");
	$i=0;
	while($row = mysqli_fetch_assoc($result))
	{
		$id = $row['id'];
		$image = $row['image'];
		$image_path = "users/" . $id . "/profile.jpg";
		if($image == "users/id/profile.jpg"){
			if(mysqli_query($conn,"update tbl_register set image='$image_path' where id=$id "))
				$i++;
			else
				echo "error";
		}
	}
	echo "<h1> $i Records Updated </h1> ";
?>