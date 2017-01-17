<?php
  session_start();
  require_once('connect.php');
  if(isset($_POST['email']) )
  {
      $_SESSION['reset_mail'] = $_POST['email'];

      $email = $_POST['email'];
      //$result = mysqli_query($conn,"select * from tbl_register where email = '$email' and is_deleted=0");
      //var_dump($result);
      //$row = mysqli_fetch_assoc($result);
    //  var_dump($row);
      $result = mysqli_query($conn,"select id from tbl_register where email = '$email' and is_deleted=0");
      $row =  mysqli_fetch_assoc($result);
      if($row){
        $OTP = rand(100000,999999);
        $res = mysqli_query($conn,"update tbl_register set recovery_Code='$OTP' where email ='$email' and is_deleted=0 ") or die(" Failed to set OTP ");

        // mail function
        $to = $email;
        $subject = "Password Reset";

        $message = "<b>This is HTML message.</b>";
        $message .= "<h1>This is headline.</h1>";
        $message .= "<br><h3> OTP is $OTP  </h3>";

        $header = "From:test@example.com \r\n";
        $header .= "Cc:test2@example.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html \r\n";

        $retval = mail ($to,$subject,$message,$header);

        if( $retval == true ) {
           echo "sent";
        }else {
           echo "Failed to send OTP ";
        }
      }
      else{
        echo " No Such Email Registered !";
      }
  }

  if(isset($_POST['OTPkey'])){
    $OTP = $_POST['OTPkey'];
    $email = $_SESSION['reset_mail'];
    $result = mysqli_query($conn,"select * from tbl_register where (email='$email' and is_deleted=0) and recovery_Code='$OTP'");
    if($result){
      echo "otp-matched";
      $res = mysqli_query($conn,"update tbl_register set recovery_Code='NULL' where email ='$email' and is_deleted=0 ") or die(" Failed to set OTP ");
    }
      else
      echo "otp-unmatched";
  }
?>
