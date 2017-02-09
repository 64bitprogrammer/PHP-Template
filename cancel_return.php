<?php
	session_start();
	session_destroy();	
?>

<!DOCTYPE html>
<html lang="en">
<!-- <meta http-equiv="refresh" content="10;url=login.php" /> -->
<head>
  <title>Success</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color:;">

<div class="container">
	<div class="jumbotron" style="background-color:;">
		<div class="alert-danger" style="border:solid 1px;text-align:center;">
			<h1> Payment Cancelled </h1>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-4" style="height:250px;">
		</div>
		<div class="col-md-4" style="height:45px;background-color:white;border:solid 1px black;">
			<div class="table-responsive">
			<table class="table">
				<tr>
					<th><strong>Subscription Status<strong><th>
					<td></td>
					<td>
						<strong>
							<span class="text-warning" style="background-color:white;padding: 2px 4px;border-radius:4px;"> 
								Pending 
							</span>
						<strong>
					</td>
				</tr>
			</table>
			</div>
		</div>
		<div class="col-md-4" style="height:300px;">
		</div>
	</div>
</div>
</body>
</html>
