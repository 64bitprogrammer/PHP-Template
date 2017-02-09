<?php
	require_once('connect.php');
	
	// For excel sheet
	//header("Content-Type: application/vnd.ms-excel"); //
	//header("Content-disposition: attachment; filename=spreadsheet.xls");
	
	// For CSV file
	header("Content-type: text/x-csv");
	header("Content-disposition: attachment; filename=spreadsheet.csv"); 
	
	
	$query = "select fname,lname,email,contact,dob from tbl_register where is_deleted = 0";
	$result = mysqli_query($conn,$query);
	
	echo "First Name,Last Name,Email,Contact,DOB\n";
	while($row = mysqli_fetch_assoc($result)){
		echo "$row[fname],$row[lname],$row[email],$row[contact],$row[dob] \n";
	}
?>