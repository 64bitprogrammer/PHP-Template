<?php
session_start();
require_once('connect.php');
// $id = $_SESSION['payers_id'];
// $email = $_SESSION['payers_email'];
// $plan = $_SESSION['payers_plan'];
$id = rand(1,100);
$plan = "gold";
$email = "kaka@baka.com";
$amt = 0;
  switch($plan){
    case 'silver': $amt = 25; break;
    case 'gold' : $amt = 50; break;
    case 'platinum': $amt = 100; break;
    default: die(" Invalid plan selected !");
  }

if(isset($_POST['pay'])){
  require_once('config.php');
  
  $acct = $_POST['ACCT'];
  $expdate = $_POST['month'] . $_POST['year'];
  $firstname = $_POST['FIRSTNAME'];
  $lastname = $_POST['LASTNAME'];
  $street = $_POST['STREET'];
  $cvv2 = $_POST['CVV2'];
  
  $request_params = array
  (
  'METHOD' => 'DoDirectPayment', 
  'USER' => $api_username, 
  'PWD' => $api_password, 
  'SIGNATURE' => $api_signature, 
  'VERSION' => $api_version, 
  'PAYMENTACTION' => 'Sale',                   
  'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
  'CREDITCARDTYPE' => 'MasterCard', 
  'ACCT' => $acct,                        
  'EXPDATE' => $expdate,           
  'CVV2' => $cvv2, 
  'FIRSTNAME' => $firstname, 
  'LASTNAME' => $lastname, 
  'STREET' => $street, 
  'CITY' => 'Largo', 
  'STATE' => 'FL',                     
  'COUNTRYCODE' => 'US', 
  'ZIP' => '33770', 
  'AMT' => $amt, 
  'CURRENCYCODE' => 'USD', 
  'DESC' => 'Testing Payments Pro'
  );
  //var_dump($request_params);
  $nvp_string = '';
  foreach($request_params as $var=>$val)
  {
    $nvp_string .= '&'.$var.'='.urlencode($val);    
  }
  
  echo $nvp_string;
  
  // Send NVP string to PayPal and store response
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_VERBOSE, 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($curl, CURLOPT_TIMEOUT, 60);
  curl_setopt($curl, CURLOPT_URL, $api_endpoint);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
  
  $result = curl_exec($curl);     
  curl_close($curl);
  var_dump($result); echo "<br><Br>";

  parse_str($result,$response);
  //var_dump($response);
  // foreach($response as $key => $value) {
    
    // echo "<br /> $key: $value";
  // }
  if($response['ACK']=='Success'){
	  $ack = $response['ACK'];
	  $amt = (int)($response['AMT']);
	  $curr = $response['CURRENCYCODE'];
	  $avscode = $response['AVSCODE'];
	  $cvv = $response['CVV2MATCH'];
	  $transaction_id = $response['TRANSACTIONID'];
	  $version = $response['VERSION'];
	  $timestamp = $response['TIMESTAMP'];
	  $correlation_id = $response['CORRELATIONID'];
	  
	$success = "insert into tbl_directpay (user_id,paypal_timestamp,correlation_id,ack,version,amt,currency_code,avscode,cvv2code,transaction_id) 
	values ($id,'$timestamp','$correlation_id','$ack','$version',$amt,'$curr','$avscode','$cvv','$transaction_id');";
	
	if(mysqli_query($conn,$success))
		echo "<h1 style='color:limegreen;'> Success <h1>";
	else
		echo " Error in query : $conn->error ";
  }
  else{
	  $errorMsg = $response['L_LONGMESSAGE0'];
	echo "<h1 style='color:red;'> Transaction failed: $errorMsg  </h1>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  
  <div class="container">
    <div class="row">
      <!-- You can make it whatever width you want. I'm making it full width
      on <= small devices and 4/12 page width on >= medium devices -->
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <!-- Panel Starts for card -->
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3> Payments Processing </h3>
              <img class="img-responsive" src="http://i76.imgup.net/accepted_c22e0.png">
            </div>
            <div class="panel-body">
              
              <form  class="form" method="POST" action="cardPay.php" name="form1">
                <div class="form-group">
                  <label class="sr-only" for="email">First Name:</label>
                  <div class="">
                    <input type="text" value="Shrikrishna" class="form-control" name="FIRSTNAME" placeholder="First Name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="sr-only" for="email">Last Name:</label>
                  <div class="">
                    <input type="text" value="Shanbhag" class="form-control" name="LASTNAME" placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="sr-only" for="email">Card Number:</label>
                  <div class="">
                    <input type="number" value="5110922776285406" class="form-control" name="ACCT" placeholder="Card Number">
                  </div>
                </div>
                <div class="form-group">
                  <label class="sr-only" for="email">CVV:</label>
                  <div class="">
                    <input type="number" value="000" class="form-control" name="CVV2" placeholder="CVV">
                  </div>
                </div>
                <div class="form-group">
                  <div class="">
                    <label class="sr-only" for="email">Month:</label>
                    <input type="number" class="form-control" value="02" name="month" placeholder="Month">
                  </div>
                </div>
                <div class="form-group">
                  <div class="">
                    <label class="sr-only" for="email">Year:</label>
                    <input type="number" class="form-control"  value="2022" name="year" placeholder="Year">
                  </div>
                </div>
                <div class="form-group">
                  <div class="">
                    <label class="" for="address">Billing Address:</label>
                    <textarea class="form-control" name="STREET" id="address" >Go Goa Gone</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="">
                    <div class="">
                      <label class="" for="address">Total:</label>
                      <input type="text" readonly class="form-control" value="<?=$amt?>" name="AMT" placeholder="First Name">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="">
                    <div class="">
                      <input onclick="lockButton();" type="submit" id="pay" value="pay" name="pay" class="form-control btn btn-warning">
                    </div>
                  </div>
                </div>
				<input type="hidden" name="IPADDRESS" value="<?=$_SERVER['REMOTE_ADDR']?>" >
                
                
              </form>
              <!-- row end -->
            </div>
          </div>
          <!--Panel ends-->
        </div>
        <div class="col-md-3">
        </div>
      </div>
      
      <div class="col-xs-12 col-md-8" style="font-size: 12pt; line-height: 2em;">
        
      </div>
      
    </div>
  </div>
  
</body>
<script>
	function lockButton(btn){
		//document.getElementById('pay').disabled = true;
	}
</script>
</html>
