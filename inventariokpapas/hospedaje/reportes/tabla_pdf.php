<?php
include 'tabla.php';

$now = new DateTime();


$titulo = '
    <h1>RESUMEN OCUPADO</h1>
    <h3>'. $now->format('d/m/Y H:i:s') .'</h3>
';

$reporte = $titulo . $tabla_pdf;

require_once '../reportes_pdf/vendor/autoload.php';
$css = file_get_contents('style_table.css');

$tabla = mb_convert_encoding($reporte, 'UTF-8', 'UTF-8');
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHtml($tabla, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();

?>