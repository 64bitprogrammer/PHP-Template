<!DOCTYPE html>
<meta charset="UTF-8" />
<form method="post" action="importExcel.php" enctype="multipart/form-data" accept-charset="UTF-8">
	<input type="file" name="csv_file" id="csv_file" accept=".xlsx,.csv" >
	<input type="submit" name="upload" id="upload" >
	<input type="submit" name="delete" value="delete" >
	<input type="submit" name="show" value="Show" > <br><Br>
</form>
<?php
	//header("Content-Type: text/plain; charset=UTF-8");  // output as text file
	header("Content-Type: text/html; charset=UTF-8");  
	require_once('connect.php');
	mysqli_set_charset($conn, 'utf8mb4');
	if(isset($_POST['upload'])){	
		unset($_POST['upload']);
		$file_name = basename($_FILES['csv_file']['name']);
		$name = pathinfo($file_name, PATHINFO_FILENAME );
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		echo " File-> $file_name";
		
		$csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
		//skip first line
        fgetcsv($csvFile);
		$flag = true; // flag set false when query fails for one or more records
		while($line = fgetcsv($csvFile)){
			//$encode = utf8_encode($line[0]);
			if(count($line)>0){
				if(!mysqli_query($conn,"insert into tbl_csv (types) values ('$line[0]')")){
					$flag=false;
					echo $line[0];
					echo "<h1> ". $conn->error . " </h1> ";
				}
			}
		}
		
		
		
		if($flag)
			echo "<h1 style='color:limegreen'> All records imported successfully ! </h1>";
		else
			echo " Error while fetching one or more records $conn->error";

		fclose($csvFile);
	}
	
	if(isset($_POST['show'])){
		$display = mysqli_query($conn,"select types from tbl_csv");
		
		while($row = mysqli_fetch_assoc($display)){
			echo " " .$row['types']." <hr>";
		}
	}
	
	if(isset($_POST['delete'])){
		if(mysqli_query($conn,"delete from tbl_csv"))
			echo "<h1 style='color:red'> All records deleted </h1>";
		else
			echo " Records could not be deleted ";
	}
?>


