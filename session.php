<?php
session_start();
//echo $_SESSION["current_user"];
//echo $_COOKIE["current_user"];
session_destroy();
unset($_COOKIE["current_user"]);
setcookie("current_user","",time() -3600, "/","", 0);
header("location: login.php");
?>
