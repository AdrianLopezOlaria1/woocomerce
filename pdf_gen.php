<?php 
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
   
ob_start();
include 'prueba.php';
$html = ob_get_clean();

$mpdf->WriteHTML($html);
$mpdf->Output();
?>