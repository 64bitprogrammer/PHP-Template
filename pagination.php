<?php
session_start();
if(isset($_COOKIE["current_user"]) && $_COOKIE["current_user"]!= ""){
  $_SESSION['current_user'] = $_COOKIE["current_user"];
}
if(!isset($_SESSION['current_user']) && !isset($_SESSION['current_user_id']))
	header("location: login.php");

require_once('connect.php');
// set default variables
$path = "pagination.php";

if(isset($_GET['limit']))
  $recordsPerPage = $_GET['limit'];
else if(isset($_POST['limit']))
  $recordsPerPage = $_POST['limit'];
else
  $recordsPerPage = 5;

$orderBy = "fname";
if(!isset($sortOrder))
$sortOrder = 'asc';

if(!isset($nextSortOrder))
$nextSortOrder = "asc";

if(!isset($_SESSION['sortOrder'])) // for remembering for pagination
$_SESSION['sortOrder'] = 'asc';


if(isset($_GET['pageno']))
$page = $_GET['pageno'];
else
$page = 1;

if(isset($_GET['orderBy1']) && isset($_GET['key1'])){
  $orderBy = $_GET['column1'];
  $key = $_GET['key1'];
  $sortOrder = $_GET['orderBy1'];

  if($sortOrder == "asc")
  $nextSortOrder = "desc";
  else
  $nextSortOrder = "asc";
}
if(isset($_GET['orderBy1'])){
  $sortOrder= $_GET['orderBy1'];
  $_SESSION['sortOrder'] = $_GET['orderBy1'];
}
if(!isset($_GET['orderBy1']) && isset($_GET['orderBy'])){
  $sortOrder= $_GET['orderBy'];
  $_SESSION['sortOrder'] = $_GET['orderBy'];
}

if(isset($_GET['key']))
$key = $_GET['key'];


if(isset($_POST['form_submit']))
  $key = $_POST['searchbox'];

if(!isset($key))
  $key="";

$offset = ($page * $recordsPerPage) - $recordsPerPage; // simple calculation
/*  offset sets the location from where to fetch result and $limit specified
the upto where to be displayed i.e. sets the range
*/
$limit = $recordsPerPage;

if($key == "")
$countQuery = "select * from tbl_register where is_deleted=0 ORDER BY $orderBy $sortOrder ";
else
$countQuery = "select * from tbl_register where is_deleted=0 and fname like '%$key%' or lname like '%$key%' or email like '%$key%' ORDER BY fname $sortOrder ";

//echo "<== $countQuery ==> ";

$totalRecords = mysqli_num_rows(mysqli_query($conn,$countQuery));

//echo " order by" . $orderBy . " key=" . $key . " sort order =" . $sortOrder ;

if($key == "")
$query = "select * from tbl_register where is_deleted=0 ORDER BY $orderBy $sortOrder LIMIT $offset,$limit";
else
$query = "select * from tbl_register where fname like '%$key%' or lname like '%$key%' or email like '%$key%' and is_deleted=0 ORDER BY fname $sortOrder LIMIT $offset,$limit";

$result = mysqli_query($conn,$query);
$totalPages = ceil($totalRecords/$recordsPerPage);

//  echo "Total Records = $totalRecords , totalPages = $totalPages , recordsPerPage = $recordsPerPage";

if(isset($_POST['form_submit']))
$key = $_POST['searchbox'];

// echo " SortOrder = $sortOrder , nextSortOrder = $nextSortOrder , curr = " . $_SESSION['sortOrder'] ;

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
    <link rel="stylesheet" href="custom.css" >
  <script type="text/javascript" src="listing.js"></script>
  <style>
  table {
      //table-layout: fixed;
      word-wrap: break-word;
  }
  </style>
</head>
<body>
    <?php
      include_once('navbar.php');
      ?>
  <div align="center">

      <form method="POST" action="pagination.php" id="myForm"  name="form1">
        <div class="input-group add-on col-md-4">
      <input class="form-control" value="<?=$key?>" placeholder="Search For .." name="searchbox" id="searchbox" type="text">
      <div class="input-group-btn">
        <button class="btn btn-danger" name="form_submit" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
    <br>
    <div class="form-group" >
      <label for"limit"> Records Per Page :
      <select class="form-control" name="limit" required width="5%" onchange="submitForm();">
        <option value="5"  <?php if($recordsPerPage==5) echo "selected";?>>5</option>
        <option value="10" <?php if($recordsPerPage==10) echo "selected";?>>10</option>
        <option value="15" <?php if($recordsPerPage==15) echo "selected";?>>15</option>
      </select>
    </label>
    </div>
  </form><br>
  <br> <a title="Generate PDF" href="createReport.php" class="btn btn-default"><span class="glyphicon glyphicon-file"></span></a>&nbsp;&nbsp;<a title="Generate PDF with Images" target="_blank" href="html2pdf.php" class="btn btn-default"><span class="glyphicon glyphicon-file"></span></a>
  &nbsp;&nbsp;<a title="Generate Excel" target="_blank" href="excel.php" class="btn btn-default"><span class="	glyphicon glyphicon-list-alt"></span></a>

  <br/><br/>
  <div class="container">

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

    <?php
    // Prints the entire pagination menue
    echo " <div class='container' align='center'> ";
    echo "<ul class='pagination'>";
    $currentSortOrder = $_SESSION['sortOrder'];
    //echo "key = $key, SortOrder = $sortOrder , nextSortOrder = $nextSortOrder , curr = $currentSortOrder ";
    for($i=1;$i<=$totalPages;$i++)
    {
      if($totalPages>1 && $i==1 ){
        if($page!=1)
        $next = $page - 1;
        else
        $next = 1;
        echo "<li> <a href='$path?pageno=$next&key=$key&orderBy=$currentSortOrder&column=$orderBy&limit=$recordsPerPage'> <span class='glyphicon glyphicon-chevron-left'></span> </a></li> ";
      }
      if($i == $page)
      $active = " class='active'";
      else
      $active = "";
      echo "<li $active> <a href='$path?pageno=$i&key=$key&orderBy=$currentSortOrder&column=$orderBy&limit=$recordsPerPage'> $i </a></li> ";
    //  if($totalPages>1 && $i ==$totalPages){
        if($totalPages>1 && $i==$totalPages ){
          if($page<$totalPages)
          $prev = $page + 1;
          else
          $prev = $totalPages;
          echo "<li> <a href='$path?pageno=$prev&key=$key&orderBy=$currentSortOrder&column=$orderBy&limit=$recordsPerPage'> <span class='glyphicon glyphicon-chevron-right'></span> </a></li> ";
        }
    //  }
    }
    echo "</ul> </div>";
    ?>
  </div>

  <div class="footer" id="footer">
    <strong>Test.com &copy; All Rights Reserved 2017.</strong>.
  </div>
</body>
<script>
  function submitForm(){
    document.forms["myForm"].submit();
  }
</script>
</html>
