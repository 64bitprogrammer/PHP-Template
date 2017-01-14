<?php
define ("DB_HOST", "localhost"); // Your database host name
define ("DB_USER", "root"); // Your database user
define ("DB_PASS",""); // Your database password
define ("DB_NAME","shrikrishna"); // Your database name

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

  if(isset($_GET["page"]))
    $page = (int)$_GET["page"];
    else
    $page = 1;

    $setLimit = 10;

    $pageLimit = ($page * $setLimit) - $setLimit;
    // Your SQL query go here. This query will display all record by setting the Limit.

    $sql = "SELECT * FROM tbl_register  LIMIT ".$pageLimit." , ".$setLimit;

    $query = mysql_query($sql);

    while ($rec = mysql_fetch_array($query)) {

    ?>

    <div class="show"><a href="http://www.discussdesk.com/<?php echo $rec["id"];?>.htm" target="_blank"><?php echo $rec['fname'];?></a></div>

    <?php }  ?>

    </div>


    <?php

    // Call the Pagination Function to load Pagination.
    echo displayPaginationBelow($setLimit,$page);

    function displayPaginationBelow($per_page,$page){

     $query = "SELECT COUNT(*) as totalCount FROM tbl_register";
     $rec = mysql_fetch_array(mysql_query($query));
     $total = $rec['totalCount'];
       $adjacents = "2";

     $page = ($page == 0 ? 1 : $page);
     $start = ($page - 1) * $per_page;

     $prev = $page - 1;
     $next = $page + 1;
       $setLastpage = ceil($total/$per_page);
     $lpm1 = $setLastpage - 1;

     $setPaginate = "";
     if($setLastpage > 1)
     {
       $setPaginate .= "<ul class='setPaginate'>";
                   $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
       if ($setLastpage < 7 + ($adjacents * 2))
       {
         for ($counter = 1; $counter <= $setLastpage; $counter++)
         {
           if ($counter == $page)
             $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
           else
             $setPaginate.= "<li><a href='?page=$counter'>$counter</a></li>";
         }
       }
       elseif($setLastpage > 5 + ($adjacents * 2))
       {
         if($page < 1 + ($adjacents * 2))
         {
           for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
           {
             if ($counter == $page)
               $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
             else
               $setPaginate.= "<li><a href='?page=$counter'>$counter</a></li>";
           }
           $setPaginate.= "<li class='dot'>...</li>";
           $setPaginate.= "<li><a href='?page=$lpm1'>$lpm1</a></li>";
           $setPaginate.= "<li><a href='?page=$setLastpage'>$setLastpage</a></li>";
         }
         elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
         {
           $setPaginate.= "<li><a href='?page=1'>1</a></li>";
           $setPaginate.= "<li><a href='?page=2'>2</a></li>";
           $setPaginate.= "<li class='dot'>...</li>";
           for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
           {
             if ($counter == $page)
               $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
             else
               $setPaginate.= "<li><a href='?page=$counter'>$counter</a></li>";
           }
           $setPaginate.= "<li class='dot'>..</li>";
           $setPaginate.= "<li><a href='?page=$lpm1'>$lpm1</a></li>";
           $setPaginate.= "<li><a href='?page=$setLastpage'>$setLastpage</a></li>";
         }
         else
         {
           $setPaginate.= "<li><a href='?page=1'>1</a></li>";
           $setPaginate.= "<li><a href='?page=2'>2</a></li>";
           $setPaginate.= "<li class='dot'>..</li>";
           for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
           {
             if ($counter == $page)
               $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
             else
               $setPaginate.= "<li><a href='?page=$counter'>$counter</a></li>";
           }
         }
       }

       if ($page < $counter - 1){
         $setPaginate.= "<li><a href='?page=$next'>Next</a></li>";
               $setPaginate.= "<li><a href='?page=$setLastpage'>Last</a></li>";
       }else{
         $setPaginate.= "<li><a class='current_page'>Next</a></li>";
               $setPaginate.= "<li><a class='current_page'>Last</a></li>";
           }

       $setPaginate.= "</ul>\n";
     }


       return $setPaginate;
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

  <ul class="pagination">
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
  </ul>
</div>

</body>
</html>
