<?php
	session_start();
	
	$x = $_POST;
	echo "========";
	//var_dump($x);
	$xyz = "=>\n";
	foreach(array_keys($x) as $paramName)
		$xyz = $xyz . "$paramName" . "=" . $x[$paramName] . "\n";
		
	$to = "shrikrishna.shanbhag@intecons.com";
    $subject = "This is the subject";
	

    $message = "<b>This is HTML message.</b>";
    $message .= "<h1> Content of array = $xyz </h1>";

    $header = "From:abc@somedomain.com \r\n";
    $header .= "Cc:afgh@somedomain.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html \r\n";

    $retval = mail ($to,$subject,$message,$header);

    if( $retval == true ) {
		echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }
?>