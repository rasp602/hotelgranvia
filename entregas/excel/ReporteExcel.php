<?php
// Incluimos la librería PHPExcel
require '../Classes/PHPExcel.php';

// Crear un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades del documento
$objPHPExcel->getProperties()->setCreator("Ronald Sanchez")
                             ->setDescription("Reporte de Ventas");

// Establecer la pestaña activa y su nombre
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte");

// Aplicar estilo para el título
$estiloTitulo = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 16,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

// Establecer el título en la celda A1
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Reporte de Ventas');

// Aplicar el estilo al título
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTitulo);

// Ajustar el tamaño de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);

// Configurar los encabezados para la descarga del archivo Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_ventas.xls"');
header('Cache-Control: max-age=0');

// Guardar el archivo Excel en el flujo de salida
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
