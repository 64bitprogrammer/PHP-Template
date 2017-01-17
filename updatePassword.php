<?php
session_start();
$error = "";
require_once('connect.php');
if(isset($_SESSION['reset_mail']))
{
  $email = $_SESSION['reset_mail'];
}

if(isset($_POST['update'])){
  $pass = $_POST['password'];
  $cpass = $_POST['cpassword'];

  if($pass != "" && $cpass!=""){
    if($pass == $cpass){
      $result = mysqli_query($conn,"update tbl_register set password ='$pass' where email='$email' and is_deleted=0");
      if($result){
        $_SESSION['success_msg'] = " Password Updated Successfully !";
        unset($_SESSION['reset_mail']);
        header('location: login.php');
      }
        else
        $error = " Password Update Failed !";
    }
    else{
      echo " Password does not match !";
    }
  }
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
  <Script>
    function updatePassword(email)
    {
      var pass = document.getElementById('password').value;
      var cpass = document.getElementById('cpassword').value;

      if(pass!="" && cpass !=""){
        if(pass == cpass)
          return true;
      }
      else
        return false;
    }
  </script>
</head>
<body>

  <div class="container">
    <div class="row">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <?php
        if(isset($_SESSION['reset_mail'])){

          ?>
          <h2> Update Password </h2> <br/><br/>
          <form method="post" action="updatePassword.php" onsubmit="return updatePassword(document.getElementById('email').value);" name="form1">
            <div class="form-group">
              <input class="form-control" type="email" readonly value="<?=$email?>" id="email" name="email">
            </div>
            <div class="form-group">
              <input class="form-control" type="password"  id="password" name="password">
            </div>
            <div class="form-group">
              <input class="form-control" type="password"   id="cpassword" name="cpassword">
            </div>

            <div class="form-group">
                <span class="text-danger"><?=$error?></span>
            </div>
            <div class="form-group">
              <input class="form-control btn btn-primary" type="submit" value="Update Password" id="update" name="update">
            </div>

          </form>

          <?php

        }
        ?>
      </div>
      <div class="col-sm-4">
      </div>
    </div>
  </div>

</body>
</html>
