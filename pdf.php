<?php
include_once "a_common.php";
$h= 5;
$w= 190;
$X_a = 10; $Y_a = 10;    $X_b = 20; $Y_b = $Y_a;
$id = 14;
$candidate = $db->fetch_all_data("candidates",[],"id='".$id."'")[0];

require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
	$pdf->Cell($w,$h,'COMPREHENSIVE RESUME','',1,'C');
	$pdf->Ln($h);
	$Y_a = ($h*3)+1; 
	$pdf->Rect($X_a, $Y_a, $w, 0.5 , 'F');

$pdf->SetFont('Arial','',12);
$Y_a = $Y_a+5;
$pdf->SetY($Y_a);
	$pdf->Cell('',$h,'Full Name','',1,'L');
	$pdf->Cell('',$h,'Nick Name','',1,'L');
	$pdf->Cell('',$h,'Place Of Birth','',1,'L');
	$pdf->Cell('',$h,'Date Of Birth','',1,'L');
	$pdf->SetY($Y_a);
		$pdf->SetX(40); $pdf->Cell('',$h,':','',1,'L');
		$pdf->SetX(40); $pdf->Cell('',$h,':','',1,'L');
		$pdf->SetX(40); $pdf->Cell('',$h,':','',1,'L');
		$pdf->SetX(40); $pdf->Cell('',$h,':','',1,'L');
		$pdf->SetY($Y_a);
			$pdf->SetX(42); $pdf->Cell('',$h,$candidate["name"],'',1,'L');
			$pdf->SetX(42); $pdf->Cell('',$h,$candidate["nickname"],'',1,'L');
			$pdf->SetX(42); $pdf->Cell('',$h,$candidate["birthplace"],'',1,'L');
			$pdf->SetX(42); $pdf->Cell('',$h,format_tanggal($candidate["birthdate"],"d-M-Y"),'',1,'L');
			$pdf->SetY($Y_a); $X_a = 105;
				$pdf->SetX($X_a+10); $pdf->Cell('',$h,'Sex','',1,'L');
				$pdf->SetX($X_a+10); $pdf->Cell('',$h,'Marital Status','',1,'L');
				$pdf->SetX($X_a+10); $pdf->Cell('',$h,'Nationality','',1,'L');
				$pdf->SetX($X_a+10); $pdf->Cell('',$h,'Religion','',1,'L');
				$pdf->SetY($Y_a);
					$pdf->SetX($X_a+38); $pdf->Cell('',$h,':','',1,'L');
					$pdf->SetX($X_a+38); $pdf->Cell('',$h,':','',1,'L');
					$pdf->SetX($X_a+38); $pdf->Cell('',$h,':','',1,'L');
					$pdf->SetX($X_a+38); $pdf->Cell('',$h,':','',1,'L');
					$pdf->SetY($Y_a);
						$pdf->SetX($X_a+40); $pdf->Cell('',$h,$candidate["name"],'',1,'L');
						$pdf->SetX($X_a+40); $pdf->Cell('',$h,$candidate["nickname"],'',1,'L');
						$pdf->SetX($X_a+40); $pdf->Cell('',$h,$candidate["birthplace"],'',1,'L');
						$pdf->SetX($X_a+40); $pdf->Cell('',$h,format_tanggal($candidate["birthdate"],"d-M-Y"),'',1,'L');
	$Y_a = $Y_a+($h*5);
	$pdf->Rect(10, $Y_a, 85, $h , 'D');		$pdf->SetXY(10, $Y_a);	$pdf->SetFont('Arial','B',12);	$pdf->Cell(85,$h,'HOME ADDRESS','',1,'C');
	$pdf->Rect(110, $Y_a, 85, $h , 'D');	$pdf->SetXY(110, $Y_a);	$pdf->SetFont('Arial','B',12);	$pdf->Cell(85,$h,'SUPPORTING DATA','',1,'C');
$pdf->Output();
?>