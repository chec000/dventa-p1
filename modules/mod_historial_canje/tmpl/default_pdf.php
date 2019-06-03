<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access

defined('_JEXEC') or die;

if ($cedis_value == 'cedis'){
    $cedis_id = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.names_cedis');
    $cedis_info = modHistorial_canjeHelper::getCedisInfo($cedis_id);
    $street = $cedis_info->street;
    $num_ext = $cedis_info->ext_number;
    $location = $cedis_info->location;
    $pc = $cedis_info->zip_code;
    $city = $cedis_info->city;
    $estate = $cedis_info->estate;
    
}else{
    $street = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.street');
    $num_ext = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.num_ext');
    $location = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.neighborhood');
    $pc = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.pc');
    $city = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.town');
    $estate = modHistorial_canjeHelper::getProfileByKey($user->id, 'profile.estate');
}

$pdf_id = $_GET['pdf'];

require_once dirname(__FILE__) . '/../lib/fpdf.php';
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','',16);
$pdf->Cell(190,10,'Canje #'.$pdf_id,1,1,'C');
$pdf->Cell(190,10,' ',0,1,'C');
$pdf->Cell(190,10,utf8_decode($user->name),0,1,'C');
$pdf->Cell(190,10,utf8_decode('Direcci贸n de entrega:'),0,1,'C');
$pdf->SetFillColor(255, 255, 255);
$pdf->Multicell(190,10,utf8_decode($street.' '.$num_ext.' '.$location.' | '.$pc.' '.$city.', '.$estate),0,'C',false);
$pdf->Cell(190,10,utf8_decode('Fecha de canje:'),0,1,'C');
$pdf->Cell(190,10,utf8_decode($orderDetails->$pdf_id->created_at),0,1,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$header = array("Producto", "SKU","Precio", "Cantidad", "Total");
$pdf->SetFillColor(191, 191, 191);
foreach($header as $col)
$pdf->Cell(38,7,$col,1,0,'C',true);

$pdf->Ln();
$total_cost =0;
$y_base=0;
$pdf->SetFillColor(255, 255, 255);
foreach ($ordersbyid->$pdf_id as $item) {
    $y = $pdf->GetY();
    $y_base = $y;
    $pdf->Multicell(38,7,utf8_decode($item->title),1,'C',true);
    $y_title = $pdf->GetY();
    $y_aux = $y_title - $y_base;
    $x_title = $pdf->GetX();  
    $pdf->SetXY($x_title+38, $y_title-$y_aux);
    $pdf->Cell(38,$y_aux,utf8_decode($item->sku),1,0,'C');
    $pdf->Cell(38,$y_aux,utf8_decode($item->price),1,0,'C');
    $pdf->Cell(38,$y_aux,utf8_decode($item->quantity),1,0,'C');
    $product_sum = $item->quantity*$item->price;
    $total_cost += $product_sum;
    $pdf->Cell(38,$y_aux,utf8_decode($product_sum),1,0,'C');
    $pdf->Ln();
}

$pdf->Cell(38,7,'',0,0,'C');
$pdf->Cell(38,7,'',0,0,'C');
$pdf->Cell(38,7,'',0,0,'C');
$pdf->Cell(38,7,'Total:',1,0,'C');
$pdf->Cell(38,7,utf8_decode($total_cost),1,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Multicell(190,7,utf8_decode($PDF_h1),0,'C',false);
$pdf->SetFont('Arial','',10);
$pdf->Multicell(190,7,utf8_decode($PDF_c1),0,'J',false);
$pdf->SetFont('Arial','B',10);
$pdf->Multicell(190,7,utf8_decode($PDF_h2),0,'C',false);
$pdf->SetFont('Arial','',10);
$pdf->Multicell(190,7,utf8_decode($PDF_c2),0,'J',false);

ob_start();
$pdf->Output();
$output = ob_get_contents();
ob_end_clean();
echo $output; 
exit; 


?>