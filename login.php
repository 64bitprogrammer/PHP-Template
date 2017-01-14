<?php
session_start();

if(isset($_COOKIE["current_user"]) && $_COOKIE["current_user"]!= ""){
  $_SESSION['current_user'] = $_COOKIE["current_user"];
}
if(isset($_SESSION["current_user"])){
  header("location:pagination.php");
}

$login_message = "";

if(isset($_POST['submit'])){
  require_once('connect.php');
  $email = $_POST['email'];
  $password =$_POST['password'];

  $select_query = "select password from tbl_register where email = '$email'";
  $result = mysqli_query($conn,$select_query);

  if($row=mysqli_fetch_assoc($result)){
    if($row['password'] == $password){
      if($_POST['checkbox_value']== "checked"){
        $cookie_name = "current_user";
        $cookie_value = $email;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
      }
      $_SESSION['current_user'] = $email;
      header("location: pagination.php");
    }
    else{
      $login_message = "Password does not match";
    }
  }
  else{
    $login_message = "Login Failed ";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="listing.js"></script>
</head>
<body>

<div class="container">
<div class="row">
  <h2>Login </h2>
  <form class="form-horizontal" name="loginForm" onSubmit="return checkLogin();" action="login.php" method="POST">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name='email' id="email" placeholder="Enter email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="password">Password:</label>
      <div class="col-sm-3">
        <input type="password" name='password' class="form-control" id="password" placeholder="Enter password">
        <div class="text-danger" id="pass_help"></div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-3">
        <div class="checkbox">
          <label><input type="checkbox" name='rememberMe' id='rememberMe'> Remember me</label>
        </div><br/>
        <div class="text-danger" id="login_help"> <?=$login_message?> </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-3">
        <input type="hidden" name="checkbox_value" id="checkbox_value" />
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>
</div>

</body>
</html>
