<?php
//This is the file that generates the PDF file for the GWA Certificate. The generation of the PDF uses the fpdf library 
session_start();
require "../Database.php";
$PDO = Database::letsconnect();

//SESSION ID CHECK
    if (empty($_SESSION['UserID']))
         header("Location: ../Log_In/login.php");
    $scan=null;
    foreach ($PDO->query("SELECT * FROM certificate WHERE user_id = '".$_SESSION['UserID']."'") as $row) 
        $scan=$row['gwa'];
    if ($scan==null)
         header("Location: ../Main/main.php");
     if ($_SESSION['Type'] == "Admin")
         header("Location: ../Main/admin.php");

//fpdf library
require ('fpdf/fpdf.php');

//Obtaining the certificate information from the database
foreach ($PDO->query("SELECT * FROM certificate WHERE user_id = '".$_SESSION['UserID']."'") as $row) {
	$gwa = $row['gwa'];
	 if(preg_match("/[a-z]/i",$row['middle_initial']))   
        $mi=$row['middle_initial'].". ";
    else
         $mi="";
         
	$name = $row['first_name']." ".$mi.$row['last_name'];
	$lastname = $row['last_name'];
	$firstname = $row['first_name'];
    //Identifying the pronouns
	if ($row['gender'] == "F") {
		$title = "Ms.";		
		$title2 = "her";
	}
	else if ($row['gender'] == "M") {	
		$title = "Mr.";
		$title2 = "his";
	}
    else{
        $title = "Mx.";
		$title2 = "their";
    }
	$degree = $row['degree'];
	$purpose = $row['purpose'];
	$date = $row['date'];
	$date_split = explode("-", $date);
	$college = $row['college'];	
	$is_laude = " ";
	if ($row['is_laude'] != "0"){
		$is_laude = ", ".$row['is_laude']." ";
	}
	$add_info = $row['add_info'];
	$college_sec = $row['college_sec'];
	$secretary = "Secretary, ".$row['college'];
    
}
if (!empty($add_info)){
     $add_info= " in the ".trim($add_info)." ";
}

//A4 width = 210mm, 148mm writable
$pdf = new FPDF('p', 'mm', array(210,297));
$pdf->SetMargins(31, 25.4, 31);
$pdf->AddPage();

//College Logo
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(29, 30, "", 0, 0, 'C');
$currentX = $pdf->GetX();
$currentY = $pdf->GetY();
     if ($college=="College of Arts and Communication") {
         $info1='Tel. (074) 444-8393';
         $info2='E-mail Address: cac-ocs.upbaguio@up.edu.ph';
         $image='cac.jpg';
         $im1=$currentX - 29;
         $im2=$currentY + 5;
         $im3=27;
     }               
    else if ($college=="College of Social Science"){
         $info1='Tel. (074) 442-2427';
         $info2='E-mail Address: css-ocs.upbaguio@up.edu.ph';
         $image='';
    }
    else{
         $info1='Tel. (074) 442-7231';
         $info2='E-mail Address: cs-ocs.upbaguio@up.edu.ph';
         $image='cs.jpg';
        $im1= $currentX - 27;
         $im2=$currentY + 3;
         $im3=24;
    }

$nextX = $currentX;
if($college!="College of Social Science"){
    $pdf->Image('../images/'.$image, $im1, $im2, $im3);}
else 
    $pdf->Image('../images/up.png', $currentX -28, $currentY + 3, 24);
//Header
$pdf->SetFont('Arial', 'B', 12.2);
$pdf->Cell(90, 12, strtoupper($college), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
//Univ Logo
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(29, 30, '', 0, 0, 'C');
$currentX = $pdf->GetX();
$currentY = $pdf->GetY();
if($college!="College of Social Science")
    $pdf->Image('../images/up.png', $currentX -28, $currentY + 3, 24);
//Header cont.
$pdf->SetFont('Arial', '', 12);
$pdf->SetY($pdf->GetY() + 7);
$pdf->SetX($pdf->GetX() - 181);
$pdf->Cell(90, 8, 'University of the Philippines Baguio', 0, 0, 'L');
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 181);
$pdf->Cell(90, 8, 'Governor Pack Road, Baguio City 2600', 0, 0, 'L');
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 181);
$pdf->Cell(90, 8, $info1, 0, 0, 'L');
$pdf->SetY($pdf->GetY() + 5);
$pdf->SetX($pdf->GetX() - 181);
$pdf->Cell(90, 8, $info2, 0, 0, 'L');


$pdf->SetX($currentX);
$pdf->SetX($pdf->GetX() - 400);
$pdf->Ln();
$pdf->Cell(148, 3, '', 'B', 0, 'C'); // Horizontal Line
$pdf->Ln();
$pdf->Cell(148, 17.5, '', 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(148, 5, 'C E R T I F I C A T I O N', 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(148, 17.5, '', 0, 0, 'C');
$pdf->Ln();
$pdf->SetDrawColor(255, 255, 255);
$pdf->Rect($pdf->GetX(), $pdf->GetY(), .01, .01);
$pdf->SetFont('Arial', '', 12);
$pdf->Write(5, 'This is to certify that ');
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Write(5, strtoupper($title.' '.$name));
$pdf->SetFont('Arial', '', 12);
$pdf->Write(5, ' obtained a General Weighted Average (GWA) of ');
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Write(5, $gwa);
$pdf->SetFont('Arial', 'I', 12);
$pdf->Write(5, $is_laude);
$pdf->SetFont('Arial', '', 12);
$pdf->Write(5, $add_info.'in the '.$degree.".");

$pdf->Ln();$pdf->Ln();
$pdf->Rect($pdf->GetX(), $pdf->GetY(), .01, .01);
$pdf->Write(5, 'Issued this '.$date_split[0]." day of ".$date_split[1]." ".$date_split[2].' upon the request of '.$title.' '.$lastname.' for '.$title2.' '.$purpose.'.');
$pdf->SetDrawColor(0, 0, 0);

$pdf->Ln();
$pdf->Cell(148, 22.5, '', 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(148, 8, strtoupper($college_sec), 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->SetY($pdf->GetY() - 3);
$pdf->Cell(148, 8, $secretary, 0, 0, 'L');
$filename = strtoupper($lastname) .", ". $firstname."_GWA";
$pdf->Output('D', $filename.".pdf");
header("Location:certsample.php");
?>