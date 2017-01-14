<?php
session_start();



require_once('connect.php');
require_once('pagination.php');

if(isset($_GET["page"]))
	$page = (int)$_GET["page"];
	else
	$page = 1;

	$setLimit = 5;
	$pageLimit = ($page * $setLimit) - $setLimit;
// code to handle sort functionality

$sortOrder="asc";
$orderBy = "fname";
$nextSortOrder= "asc";
if(isset($key))
$key ="";

// Code to handle the search request
if(isset($_POST['submit']) || isset($_GET['column']) || isset($_GET["page"])){
$key ="";
	if(isset($_POST['searchbox']))
	$key = $_POST['searchbox'];

	if(!empty($_GET["column"]) && !empty($_GET["orderBy"]))
	{
		$orderBy = $_GET['column'];
		$sortOrder = $_GET['orderBy'];
		$key = $_GET['key'];
	}

	$currentSortOrder = $sortOrder;

	if($sortOrder == 'asc' )
	$nextSortOrder = 'desc';
	else
	$nextSortOrder = 'asc';
// pagination code

	//echo $nextSortOrder;
	if($key != "")
	$search_query = "select * from tbl_register where fname like '%$key%' or lname like '%$key%' or email like '%$key%' and is_deleted=0 ORDER BY $orderBy $sortOrder LIMIT $pageLimit , $setLimit" ;
	else
	$search_query = "select * from tbl_register where is_deleted=0 ORDER BY $orderBy $sortOrder LIMIT $pageLimit , $setLimit";

	if($result = mysqli_query($conn,$search_query)){
		$rowCount = mysqli_num_rows($result);

		?>
		<div class='container'>


			<h2 align="center"> Search Results </h2><br/>

			<table class="table table-bordered">
				<tr>
					<th> No. </th>
					<th> <a href="?column=fname&orderBy=<?=$nextSortOrder?>&key=<?=$key?>" id="fname" > Firstname </a></th>
					<th> <a href="?column=lname&orderBy=<?=$nextSortOrder?>&key=<?=$key?>" id="lname" >Lastname </a></th>
					<th> <a href="?column=email&orderBy=<?=$nextSortOrder?>&key=<?=$key?>" id="email" >Email </a> </th>
					<th> <a href="?column=gender&orderBy=<?=$nextSortOrder?>&key=<?=$key?>" id="gender" >Gender </a></th>
					<th> <a href="?column=dob&orderBy=<?=$nextSortOrder?>&key=<?=$key?>" id="dob">DOB </a></th>
					<th> Actions </th>
				</tr>

				<?php $n = 1;
				while($row = mysqli_fetch_assoc($result))
				{
					?>
					<tr>
						<td> <?=$n++?> </td>
						<td> <?=$row['fname']?> </td>
						<td> <?=$row['lname']?></td>
						<td> <?=$row['email']?></td>
						<td> <?=$row['gender']?></td>
						<td> <?=$row['dob']?></td>
						<td>	<button class="btn btn-default" title="Edit" value="<?=$row['id'];?>" onClick="callEdit(this.value);"><span class="glyphicon glyphicon-edit"></span> </button>
							<button class="btn btn-default" title="Delete" value="<?=$row['id'];?>" onClick="callDelete(this.value);"><span class="glyphicon glyphicon-trash"></span></button>
						</td>
					</tr>
					<?php
				}

				?>
			</table>
			<?php
			echo "<div align='center'>";
			echo displayPaginationBelow($setLimit,$page,$key);
			echo "</div>";
		}
		else{
			echo "<span class='text-danger'> Search Unsuccessful ! </span>";
		}
		?>
	</div>
	<?php

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="listing.js"></script>

	<script>
	</script>


</head>
<body>

	<div class="container">

		<h2 align="center"> Search </h2>

		<form method="post" action="listing.php" name="search_form" id="search_form">
			<div class="input-group col-md-6 col-md-offset-3" >
				<input type="text" id="searchbox" name="searchbox" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" name="submit">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>

		</form>

	</div>

</body>


</html>
