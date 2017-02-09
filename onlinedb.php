<?php
	require_once('http://shrikrishnashanbhag.com/connect.php');
	print_r(get_defined_vars());
	$result = mysqli_query($con,"show tables;");
	$row = mysqli_fetch_assoc($result);
	var_dump($row);
?>