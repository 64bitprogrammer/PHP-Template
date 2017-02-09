<?php
	require_once('connect.php');
	if(isset($_POST['upload'])){
		
		unset($_POST['upload']);
		$file_name = basename($_FILES['csv_file']['name']);
		$name = pathinfo($file_name, PATHINFO_FILENAME );
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		
		$csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
		//skip first line
        fgetcsv($csvFile);
		$flag = true; // flag set false when query fails for one or more records
		while($line = fgetcsv($csvFile)){
			if(count($line)>0){
				$query = "insert into tbl_import values('$line[0]','$line[1]','$line[2]','$line[4]')";
				if(!mysqli_query($conn,$query))
					$flag = false;					
			}
		}
		if($flag)
			echo "<h1 style='color:limegreen'> All records imported successfully ! </h1>";
		else
			echo " Error while fetching one or more records";
		
		// if(!file_exists("documents/$file_name")){
			// move_uploaded_file($_FILES['csv_file']['tmp_name'],"documents/$file_name") or die("error");
			// echo "moved";
		// }
		// else{
			// move_uploaded_file($_FILES['csv_file']['tmp_name'],"documents/$name.$ext") or die("error");
			// echo " Renamed and moved !";
		// }
		fclose($csvFile);
	}
	
	if(isset($_POST['delete'])){
		if(mysqli_query($conn,"delete from tbl_import"))
			echo "<h1 style='color:red'> All records deleted </h1>";
		else
			echo " Records could not be deleted ";
	}


?>

<form method="post" action="import.php" enctype="multipart/form-data">
	<input type="file" name="csv_file" id="csv_file" accept=".csv" >
	<input type="submit" name="upload" id="upload" >
	<input type="submit" name="delete" value="delete" >
</form>