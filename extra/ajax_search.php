<?php
	require_once('connect.php');
	
	if(isset($_POST['keyword'])){
		
		$key = $_POST['keyword'];
		
		if($key != "")
			$search_query = "select * from tbl_register where fname like '%$key%' or lname like '%$key%' or email like '%$key%' and is_deleted=0";
		else
			$search_query = "select * from tbl_register where is_deleted=0";
		
		if($result = mysqli_query($conn,$search_query)){
			
			?>
				<input type="hidden" id="sort_type" name="sort_type" value="asc" />
				<h2 align="center"> Search Results </h2><br/>
				
				<table class="table table-bordered">
					<tr>
						<th> <a href="#" id="fname" onClick="toggleSortMethod(this.id)"> Firstname </a></th>
						<th> <a href="#" id="lname" onClick="toggleSortMethod(this.id)">Lastname </a></th>
						<th> <a href="#" id="email" onClick="toggleSortMethod(this.id)">Email </a> </th>
						<th> <a href="#" id="gender" onClick="toggleSortMethod(this.id)">Gender </a></th>
						<th> <a href="#" id="dob" onClick="toggleSortMethod(this.id);">DOB </a></th>		
						<th> Actions </th>
					</tr>
				
			<?php
			while($row = mysqli_fetch_assoc($result))
			{
				?>
					<tr>
						<td> <?=$row['fname']?> </td>
						<td> <?=$row['lname']?></td>
						<td> <?=$row['email']?></td>
						<td> <?=$row['gender']?></td>
						<td> <?=$row['dob']?></td>
						<td>	<button class="btn btn-info" title="Edit" value="<?=$row['id'];?>" onClick="callEdit(this.value);"><span class="glyphicon glyphicon-edit"></span> </button>  
								<button class="btn btn-danger" title="Delete" value="<?=$row['id'];?>" onClick="callDelete(this.value);"><span class="glyphicon glyphicon-trash"></span></button>  	
						</td>
					</tr>
				<?php
			}
			
				?>
					</table>
				<?php
			
		}
		else{
			echo "<span class='text-danger'> Search Unsuccessful ! </span>";
		}
		
	}
	else{
		echo " Keyword error ";
	}
	
	
?>