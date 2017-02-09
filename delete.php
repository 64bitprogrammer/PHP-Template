<?php

$x = <<<EOD
	<div class="table-responsive">
      <table class="table table-bordered table-hover" style="background-color:#d2d7dd;">
        <thead>
          <tr>
            <th style="width:5%"> No. </th>
            <th style="width:10%"> <a href="?column1=fname&orderBy1=<?=$nextSortOrder?>&key1=<?=$key?>&limit=<?=$recordsPerPage?>" id="fname" > Firstname </a></th>
            <th style="width:10%"> <a href="?column1=lname&orderBy1=<?=$nextSortOrder?>&key1=<?=$key?>&limit=<?=$recordsPerPage?>" id="lname" >Lastname </a></th>
            <th style="width:20%"> <a href="?column1=email&orderBy1=<?=$nextSortOrder?>&key1=<?=$key?>&limit=<?=$recordsPerPage?>" id="email" >Email </a> </th>
            <th style="width:10%;padding:0;"> Image </th>
            <th style="width:5%"> <a href="?column1=gender&orderBy1=<?=$nextSortOrder?>&key1=<?=$key?>&limit=<?=$recordsPerPage?>" id="gender" >Gender </a></th>
            <th style="width:10%"> <a href="?column1=dob&orderBy1=<?=$nextSortOrder?>&key1=<?=$key?>&limit=<?=$recordsPerPage?>" id="dob">DOB </a></th>
            <th style="width:10%"> Action </th>
          </tr>
        </thead>
        <tbody>
          <?php $n = 1;


          while($row = mysqli_fetch_assoc($result))
          {
            if($row['image'] == "" && $row['gender'] == 'male')
              $dp = "users/male.jpg";
            else if($row['image'] == "" && $row['gender'] == 'female')
              $dp = "users/female.png";
            else
              $dp = $row['image'];
            ?>
            <tr>
              <td > <?=$n++?> </td>
              <td> <?=$row['fname']?> </td>
              <td> <?=$row['lname']?></td>
              <td> <?=$row['email']?></td>
              <?php
              echo "<td> <img src='$dp' style='border: solid 1px;'width='90' height='64' alt='image'>";
              ?>
              <td> <?=$row['gender']?></td>
              <td> <?=$row['dob']?></td>
              <td>
                <button class="btn btn-default" title="Edit" value="<?=$row['id'];?>" onClick="callEdit(this.value);"><span class="glyphicon glyphicon-edit"></span> </button>
    							<button class="btn btn-default" title="Delete" value="<?=$row['id'];?>" onClick="callDelete(this.value);"><span class="glyphicon glyphicon-trash"></span></button>
              </td>
            </tr>
            <?php
          }

          ?>
        </tbody>
      </table>
    </div>
EOD;
echo $x;
?>