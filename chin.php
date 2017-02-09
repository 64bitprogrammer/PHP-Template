<?php
require_once('connect.php');
mysqli_set_charset($conn, 'utf8mb4');
$res = mysqli_query($conn,"insert into tbl_csv values('アイリッシュ・セッター')");
$result = mysqli_query($conn,"select * from tbl_csv");
while($row = mysqli_fetch_assoc($result))
	echo $row['types'] . "<br>";
$data = "アイリッシュ・セッター";
echo "$data";
?>