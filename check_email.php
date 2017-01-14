<?php
	session_start();
	require_once('connect.php');

	$email_id = $_POST['emailID'];

	if(!empty($_POST["emailID"])) {
		// checks for any existing emails with is_deleted = 0
		$query_result = mysqli_query($conn,"SELECT count(*) FROM tbl_register WHERE email='$email_id' && is_deleted=0");
		$row = mysqli_fetch_row($query_result);
		$user_count = $row[0];

		if($user_count>0) {
			echo "not_available";
		}
		else{
			echo "available";
		}
	}
	else{
		echo " AJAX Post Error !";
	}
?>
