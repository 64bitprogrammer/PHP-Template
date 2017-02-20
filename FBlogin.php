<?php
	session_start();
	require_once('connect.php');
	if(isset($_POST['user'])){
		$obj = json_decode($_POST['user'], true);
		$fname = $obj['first_name'];
		$lname = $obj['last_name'];
		$email = $obj['email'];
		$id = $obj['id'];
		$gender= $obj['gender'];
		$result = mysqli_query($conn,"select * from tbl_register where email='$email' and is_deleted=0");
		if($result){
			$_SESSION['current_user'] = $email;
			echo "Success";
		}else{
			if(mysqli_query($conn,"insert into tbl_register (fname,lname,email,gender) values ('$fname','$lname','$email','$gender')")){
				$_SESSION['current_use'] = $email;
				echo "Success";
			}else{
				echo " Insert fail $conn->error";
			}
		}
	}
	else
		echo "error";
?>