<?php
require('tcpdf/tcpdf.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "water_bill_mgt_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve data from the "flowread" column
$sql = "SELECT flowread FROM liquid_quantity";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize the sum
    $sum = 0;

    // Sum the "flowread" values
    while ($row = $result->fetch_assoc()) {
        $sum += $row["flowread"];
    }

    // Create a PDF invoice
    $pdf = new TCPDF();
    $pdf->AddPage();
	
	//Image
	$imageFile = 'H2OVue.JPG';
	$pdf->Image($imageFile, 10, 14, 45, 0, 'JPG');

	//Right align texts
	$pdf->SetFont('helvetica', 'B', 30);
	$pdf->Cell(0, 20, 'WATER BILL', 0, 1, 'R');	
	$pdf->Cell(0, 0, 'INVOICE', 0, 1, 'R');
	$pdf->SetFont('courier', 'R', 20);	
    $pdf->Cell(0, 10, 'H2OVue Company (Pvt)LTD.', 0, 1, 'R');
	
	//HR line
	$pdf->SetY(57);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
	
	//Description Text
	$pdf->SetY(60);
	$pdf->SetFont('helvetica', 'R', 11);
	$cellWidth = 190;
	$text = 'This text is generated automatically by our system based on your water usage over a specific time period. It includes details such as the unit price of water, the number of units you have consumed, and the total cost, which is calculated by multiplying the unit price by the number of units used. This invoice provides a transparent breakdown of your water charges, helping you understand and manage your water consumption.';
	$pdf->MultiCell($cellWidth, 10, $text);
	$pdf->SetY(72);
	$pdf->Cell(0, 20, 'For any inquiries, please don not hesitate to reach out to us at h2ovue.support@gmail.com.', 0, 1, 'L');
	
	//tagline
	$pdf->SetFillColor(230, 230, 230);
	$pdf->SetFont('helvetica', 'R', 12);
	$pdf->MultiCell(0, 6, 'Water Consumption', 0, 'C', 1);
	$pdf->Ln(8);
	$pdf->SetFont('times', '', 12);
	$pdf->SetFillColor(255, 255, 255);
	
	$totalInvoiceAmount = $sum * 25;
	
	//table
	$tbl = <<<EOD
		<table border="1" cellpadding="5">
		<tr><th>Name</th><th colspan="2">Usage</th></tr>
		<tr><td rowspan="3">Sachindu Malshan</td><td>Unit Price</td><td>LKR 25.00</td></tr>
		<tr><td>Units</td><td>$sum</td></tr>
		<tr><td>Total Invoice Amount</td><td>LKR $totalInvoiceAmount.00</td></tr>
		</table>
	EOD;
	
	$pdf->writeHTML($tbl,true,false,false,false,'');
	
	//rights
	$pdf->SetY(266);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
	$pdf->SetFont('helvetica', 'R', 10);	
    $pdf->Cell(0, 10, 'ALL RIGHTS RESERVED | H2OVue Company (Pvt)LTD.', 0, 1, 'L');

    // Output the PDF to the browser or save it to a file
    $pdf->Output('water_bill_invoice.pdf', 'D');

} else {
    echo "No records found in the database.";
}

$conn->close();
?>
