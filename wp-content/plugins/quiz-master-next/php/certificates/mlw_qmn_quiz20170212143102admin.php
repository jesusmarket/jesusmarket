<?php
include("/var/www/html/wp-content/plugins/quiz-master-next/php//fpdf/WriteHTML.php");
$pdf=new PDF_HTML();
$pdf->AddPage('L');$pdf->Ln(20);
$pdf->SetFont('Arial','B',24);
$pdf->MultiCell(280,20,'Enter title here',0,'C');
$pdf->Ln(15);
$pdf->SetFont('Arial','',16);
$pdf->WriteHTML("<p align='center'>Enter text here</p>");$pdf->Output('mlw_qmn_certificate.pdf','D');