<?php
	session_start();
	var_dump($_POST);
	require_once('connect.php');
	// Process the data only if data is posted.
	if(isset($_POST)){
		$totalAmountPaid = $_POST['mc_gross'];
		$paymentStatus = $_POST['payment_status'];
		list($userId,$userEmail,$subscriptionType) = explode(":",$_POST['custom']);
		$transactionId = $_POST['txn_id'];
		$currency = $_POST['mc_currency'];
		$ipnTracker = $_POST['ipn_track_id'];
		$itemName = $_POST['item_name'];
		$payeeEmail = $_POST['payer_email'];
		
		$updateQuery = "update tbl_payment set amount_paid = $totalAmountPaid , currency = '$currency' , 
		transaction_id='$transactionId',selected_plan='$subscriptionType',ipn_track_id='$ipnTracker',
		item_name='$itemName' ,payer_email ='$payer_email' where user_id=$userId";
		
		if(mysqli_query($conn,$updateQuery))
			mkdir("Notify/$transactionId");
		else{
			$error = $conn->error;
			mkdir("Notify/$error");
		}
	}
	else
		mkdir("Notify/NoDataPosted");
?>