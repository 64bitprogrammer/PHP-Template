<?php
require_once("connect.php");

# Function call
if(isset($_POST['keyword']))
	$key = $_POST['keyword'];
else
	$key = "";

if(isset($_POST['offst']))
	$offset = $_POST['offst'];
else
	$offset = 0;

if(isset($_POST['cp']))
	$currentPage = $_POST['cp'];
else
	$currentPage = 1;
$limit = 5;

fetchRows($conn,$key,$offset,$limit);

function fetchRows($conn,$key,$offset,$limit=5,$sortOrder="asc",$orderBy="fname"){

	if($key == "")
		$query = "select *  from tbl_register where is_deleted=0 ORDER BY $orderBy $sortOrder LIMIT $offset,$limit";
	else
		$query = "select *  from tbl_register where fname like '%$key%' or lname like '%$key%' or email like '%$key%' and is_deleted=0 ORDER BY $orderBy $sortOrder LIMIT $offset,$limit";

	if($result = mysqli_query($conn,$query)){

		// for fetching count now
		if($key == "")
			$countQuery = "select count(*) as cnt from tbl_register where is_deleted=0 ORDER BY $orderBy $sortOrder";
		else
			$countQuery = "select count(*) as cnt from tbl_register where fname like '%$key%' or lname like '%$key%' or email like '%$key%' and is_deleted=0 ORDER BY $orderBy $sortOrder";

			$count = mysqli_fetch_assoc(mysqli_query($conn,$countQuery));

		$i=0;
		while($row = mysqli_fetch_assoc($result)){
			$final_obj[$i]['fname']= $row['fname'];
			$final_obj[$i]['lname']= $row['lname'];
			$final_obj[$i]['gender']= $row['gender'];
			$final_obj[$i]['dob']= $row['dob'];
			$final_obj[$i]['email']= $row['email'];
			$i++;
		}
		$final_obj['cnt'] = $count['cnt'];
		$final_obj["msg"] = "success";
	}
	else
	{
		$final_obj['msg'] = "error";
		$final_obj['cnt'] = "error-in-fetch";
	}

	print_r(JSON_ENCODE($final_obj));
}
?>
