
<form method="post" action="whois.php" >
<input type="text" name="url" />
<input type="submit" value="Go" name="submit"/>
</form>
<?php

	if(isset($_POST['submit']))
		$domain = $_POST['url'];
	else
		$domain = "google.com";

	
  $username="evilgenious.self";
  $password="mypassword";	
  $contents = file_get_contents("http://www.whoisxmlapi.com//whoisserver/WhoisService?domainName=$domain&username=$username&password=$password&outputFormat=JSON");
  //echo $contents;
  $res=json_decode($contents);
  if($res){
  	if(isset($res->ErrorMessage)){
  		echo $res->ErrorMessage->msg;
  	}	
  	else{
  		$whoisRecord = $res->WhoisRecord;
  		if($whoisRecord){
    		echo "Domain name: " . print_r($whoisRecord->domainName,1) ."<br/>";
    		echo "Created date: " .print_r($whoisRecord->createdDate,1) ."<br/>";
    		echo "Updated date: " .print_r($whoisRecord->updatedDate,1) ."<br/>";
    		if($whoisRecord->registrant)echo "Registrant: <br/><pre>" . print_r($whoisRecord->registrant->rawText, 1) ."</pre>";
    		//print_r($whoisRecord);
  		}
  	}
  }
?>
