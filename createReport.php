<?php

require_once('connect.php');

$query = "select fname,lname,email,dob,gender,contact from tbl_register";
$result = mysqli_query($conn,$query);

// generate html data to print
$html = "<h1> Users Data Table </h1> <br>";
$html .=	"<table border=\"1\" style=\"font-size:10;\">
		<tr style=\"background-color:black;color:white;line-height:2;\">
			<th style=\"width:17%;\"> First Name </th>
			<th style=\"width:16%;\"> Last Name </th>
			<th style=\"width:38%;\"> Email </th>
			<th style=\"width:14%;\"> DOB </th>
			<th style=\"width:15%;\"> Contact </th>
		</tr>";

while($row = mysqli_fetch_assoc($result)){
	$fname = $row['fname'];
	$lname = $row['lname'];
	$email = $row['email'];
	$dob = $row['dob'];
	$contact = $row['contact'];
	
	$html .= "<tr style=\"line-height:2\">
				<td style=\"width:17%;\"> $fname </td> 
				<td style=\"width:16%;\"> $lname </td>
				<td style=\"width:38%;\"> $email </td>
				<td style=\"width:14%;\"> $dob </td>
				<td style=\"width:15%;\"> $contact </td>
			</tr>";
	
}

$html.= "</table>";

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('PDF 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('KAKA.png', PDF_HEADER_LOGO_WIDTH, ' User Records', 'This is the title', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('testing.pdf', 'I');
?>