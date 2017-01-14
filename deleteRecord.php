<?php

// Deletes records with id passed
	
	$id = $_POST['id'];
	require_once('connect.php');
	$delete_query = "update tbl_register set is_deleted=1 where id=$id";
	
	if(mysqli_query($conn,$delete_query))
		echo "true";
	else
		echo "false";

?>