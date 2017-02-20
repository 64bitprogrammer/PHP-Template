<?php
	require_once('vendor/autoload.php');
	require_once('connect.php');
	$result = mysqli_query($conn,"select fname,lname,email,dob,contact,image from tbl_register");
    // $html2pdf = new HTML2PDF('P', 'A4', 'en');
	// $html2pdf->pdf->SetAuthor('LAST-NAME Frist-Name');
	// $html2pdf->pdf->SetTitle('HTML2PDF Wiki Example');
	// $html2pdf->pdf->SetSubject('HTML2PDF Wiki');
	// $html2pdf->pdf->SetKeywords('HTML2PDF, TCPDF, example, wiki');
	// $html2pdf->pdf->SetDisplayMode('default');
	// $html2pdf->pdf->SetProtection(array('print'), 'xyz');
    // $html2pdf->writeHTML("<h1 style='color:red;'>This is your first PDF File</h1>");
	// ob_end_clean();
	// $html2pdf->Output('first_PDF_file.pdf');
 ?>
<?php
ob_start(); 
?> 
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm"> 
<page_header> 
 User Records  <hr>
</page_header> 

<page_footer> 
Page Footer 
</page_footer>

	<table border="1"  style="width:100%;">
	<tr>
		<th> First Name </th>
		<th> Last Name </th>
		<th> Email</th>
		<th> DOB </th>
		<th> Contact</th>
		<th> Image </th>
	</tr>
	
<?php
	while($row = mysqli_fetch_assoc($result)){
		$fname = $row['fname'];
		$lname = $row['lname'];
		$email = $row['email'];
		$dob = $row['dob'];
		$image = $row['image'];
		$contact = $row['contact'];
		
		if(!file_exists($image))
			 $image = "users/def.jpg";
		
		$data = <<<EOT
		<tr>
			<td> $fname </td>
			<td> $lname </td>
			<td> $email </td>
			<td> $dob </td>
			<td> $contact </td>
			<td> <img src='$image' style="width:80;height:60;" alt="Error"> </td>
		</tr>
EOT;
		echo $data;
	}
?>
	</table>
</page> 
<?php
		$content = ob_get_clean(); 
		$pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15', array(10, 10, 10, 10)); 
		
		$pdf->writeHTML($content); 
		ob_end_clean();
		$pdf->Output('x.pdf',''); 
?>
