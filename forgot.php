<?php

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
  <script>

  function sendCode(mail){

    if(mail!=""){
    $.ajax({
      type: "POST",
      url: "forgotAjax.php",
      data:'email='+mail,
      success: function(data){
        if(data == 'sent'){
          alert(" OTP sent to registered mail ");
          $('#otpButton').prop('disabled', false);
        }
        else{
          alert(" Error: "+data);
        }
      },
      error:function (data){
        alert("Ajax error has occured !");
      }
    });
  }
}

  function verifyOTP(otp){
    if(otp!=""){
      $.ajax({
        type: "POST",
        url: "forgotAjax.php",
        data:'OTPkey='+otp,
        success: function(data){
          if(data == 'otp-matched'){
            alert(" OTP Verified ");
            window.open('updatePassword.php', '_blank');
          }
          else{
            alert(" Error: OTP is incorrect !");
          }
        },
        error:function (data){
          alert("Ajax error has occured !");
        }
      });
    }
  }


  </script>
</head>
<body>

  <div class="container">
    <div class="row">

      <div class="col-sm-4">

      </div>

      <div class="col-sm-4">
        <br><br><br><br><br>
        <h2> Recover Password </h2> <br>
        <div id="reset_form">
          <form method="POST" action="" name="forgot">
            <div class="form-group col-xs-12">
              <input class="form-control" type="email" placeholder="Email Address" name="email" id="email">
            </div>
            <div class="form-group">
              <button type="button" class="text-info col-sm-offset-4 btn btn-xs" id="otpButton" disabled data-toggle="modal" data-target="#myModal" >Enter OTP </button>
            </div>
            <div class="form-group col-sm-offset-2 col-xs-8">
              <button class="form-control btn btn-info" type="button" name="recover" id="recover" onclick="sendCode(document.getElementById('email').value);">Recover</button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-sm-4">
        <!-- <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#myModal">Open Modal</button>-->

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter OTP Recieved</h4>
              </div>
              <div class="modal-body">
                <div class="form-group col-md-6">
                  <input type="number" class="form-control" name="otp" id="otp">
                </div>
                <div class="form-group col-md-3">
                  <button onclick="verifyOTP(document.getElementById('otp').value);" class="form-control btn btn-primary" name="verify" id="verify">Verify</button>
                </div><Br><Br/><Br/>
                <div class="text-info">
                  An OTP has been sent to your registered mail ID
                  , please check your mail and enter the OTP here
                </div>

              </div>
              <div class="modal-footer">

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
