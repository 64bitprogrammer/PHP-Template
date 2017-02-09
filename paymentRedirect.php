<?php
  session_start();
  require_once('connect.php');
  echo "<h2> Redirecting to payment gateway ... </h2>";

   if(!isset($_SESSION['payers_id']) || !isset($_SESSION['payers_plan'])){
    header("location:redirect_error.php");
  }
  
  $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
  $paypal_id='merchant@intecons.com'; // Business email ID
  $id = $_SESSION['payers_id'];
  $plan = $_SESSION['payers_plan'];
  $email = $_SESSION['payers_email'];
  
  $updatePaymentQuery = "insert into tbl_payment(user_id,transaction_id,currency,amount_paid,selected_plan) 
  values ($id,'NIL','NIL',0.0,'$plan')";
	
	if(!mysqli_query($conn,$updatePaymentQuery))
	die("Payments Update Failed ");	
	
  $amount = 0; 
  $combo = $id . ":" . $email . ":" . $plan;

  switch($plan){
    case 'silver': $amount = 25; break;
    case 'gold' : $amount = 50; break;
    case 'platinum': $amount = 100; break;
    default: die(" Invalid plan selected !");
  }
  // disabled for testing
  //session_destroy();
?>

<html>

<body onload="submitForm();">

  <form action="<?php echo $paypal_url; ?>" method="post" name="paypalForm">
    <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" value="Subscription Payment">
    <input type="hidden" name="item_number" value="1">
    <input type="hidden" name="credits" value="510">
    <input type="hidden" name="custom" value="<?=$combo?>">
    <input type="hidden" name="amount" value="<?=$amount?>">
    <input type="hidden" name="cpp_header_image" value="http://cdn.bulbagarden.net/upload/thumb/0/0d/025Pikachu.png/250px-025Pikachu.png">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="handling" value="0">
    <input type="hidden" name="cancel_return" value="http://127.0.0.1/test/cancel_return.php">
    <input type="hidden" name="return" value="http://127.0.0.1/test/success.php">
    </form>

</body>
<script>
  function submitForm(){
    document.forms["paypalForm"].submit();
  }
</script>
</html>
