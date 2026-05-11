<?php
require 'Classes/PHPExcel.php';
require '../../bd/conexionLocal.php';

date_default_timezone_set("America/Santiago");

$idHotel   = isset($_REQUEST["idHotel"]) ? $_REQUEST["idHotel"] : "";
$idEmpresa = isset($_REQUEST["idEmpresa"]) ? $_REQUEST["idEmpresa"] : "";
$desde     = isset($_REQUEST["desde"]) ? $_REQUEST["desde"] : "";
$hasta     = isset($_REQUEST["hasta"]) ? $_REQUEST["hasta"] : "";

$newDate = "";
if (!empty($desde)) {
    $newDate = date("d-m-Y", strtotime($desde));
}

$where = " WHERE resumenhospedaje.FechaR BETWEEN '".$desde."' AND '".$hasta."' ";

if ($idHotel != "" && $desde != "" && $hasta != "") {
    $where = " WHERE hotel.idHotel = '".$idHotel."' 
               AND resumenhospedaje.FechaR BETWEEN '".$desde."' AND '".$hasta."' ";
}

if ($idEmpresa != "" && $desde != "" && $hasta != "") {
    $where = " WHERE empresa.idEmpresa = '".$idEmpresa."' 
               AND resumenhospedaje.FechaR BETWEEN '".$desde."' AND '".$hasta."' ";
}

$sql = "SELECT
            hospedaje.idHospedaje,
            hospedaje.idPersona,
            hospedaje.idHotel,
            hospedaje.idHabitacion,
            hospedaje.idCama,
            hospedaje.desde,
            hospedaje.hasta,
            hospedaje.estado,

            resumenhospedaje.idResumen,
            resumenhospedaje.idHospedaje,
            resumenhospedaje.FechaR,
            resumenhospedaje.Act,

            hotel.idHotel,
            hotel.nombreHotel,
            hotel.capacidadHotel,
            hotel.direccion,

            habitacion.idHabitacion,
            habitacion.idHotel,
            habitacion.nHabitacion,
            habitacion.capacidadHabitacion,

            cama.idCama,
            cama.idHabitacion,
            cama.nCama,
            cama.estadoCama,

            persona.idPersona,
            persona.nombresPersona,
            persona.apellidoPersona1,
            persona.apellidoPersona2,
            persona.rutPersona,

            empresa.idEmpresa,
            empresa.nombreEmpresa
        FROM resumenhospedaje
        INNER JOIN hospedaje ON hospedaje.idHospedaje = resumenhospedaje.idHospedaje
        INNER JOIN hotel ON hospedaje.idHotel = hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion = habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama = cama.idCama
        INNER JOIN persona ON hospedaje.idPersona = persona.idPersona
        INNER JOIN empresa ON persona.idEmpresa = empresa.idEmpresa
        $where
        ORDER BY hospedaje.idHotel, hospedaje.idHabitacion ASC";

$resultado = $mysqli->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $mysqli->error);
}

/*
|--------------------------------------------------------------------------
| CARGAR LOGO SEGÚN EMPRESA
|--------------------------------------------------------------------------
*/
$gdImage = null;

if ($idEmpresa == 1)  $gdImage = @imagecreatefrompng('../../img/teching.png');
if ($idEmpresa == 2)  $gdImage = @imagecreatefrompng('../../img/besalco.png');
if ($idEmpresa == 3)  $gdImage = @imagecreatefrompng('../../img/mpm.png');
if ($idEmpresa == 4)  $gdImage = @imagecreatefrompng('../../img/nexxo.png');
if ($idEmpresa == 5)  $gdImage = @imagecreatefrompng('../../img/fls.png');
if ($idEmpresa == 6)  $gdImage = @imagecreatefrompng('../../img/sk.png');
if ($idEmpresa == 7)  $gdImage = @imagecreatefrompng('../../img/baical.png');
if ($idEmpresa == 8)  $gdImage = @imagecreatefrompng('../../img/cosal.png');
if ($idEmpresa == 9)  $gdImage = @imagecreatefrompng('../../img/morales.png');
if ($idEmpresa == 10) $gdImage = @imagecreatefrompng('../../img/maryland.png');
if ($idEmpresa == 11) $gdImage = @imagecreatefrompng('../../img/flesan.png');
if ($idEmpresa == 12) $gdImage = @imagecreatefrompng('../../img/ict.png');

/*
|--------------------------------------------------------------------------
| CREAR EXCEL
|--------------------------------------------------------------------------
*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator("Ronald Sanchez")
    ->setLastModifiedBy("Ronald Sanchez")
    ->setTitle("Registro de Servicio")
    ->setSubject("Registro de Servicio")
    ->setDescription("Reporte tipo formulario de registro de servicio");

$sheet = $objPHPExcel->setActiveSheetIndex(0);
$sheet->setTitle("Registro Servicio");

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN DE PÁGINA
|--------------------------------------------------------------------------
*/
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$sheet->getPageSetup()->setFitToPage(true);
$sheet->getPageSetup()->setFitToWidth(1);
$sheet->getPageSetup()->setFitToHeight(0);

$sheet->getPageMargins()->setTop(0.3);
$sheet->getPageMargins()->setRight(0.2);
$sheet->getPageMargins()->setLeft(0.2);
$sheet->getPageMargins()->setBottom(0.3);

$sheet->getHeaderFooter()->setOddFooter('&RPágina &P de &N');

/*
|--------------------------------------------------------------------------
| ESTILOS
|--------------------------------------------------------------------------
*/
$estiloTituloPrincipal = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 16,
        'color' => array('rgb' => 'C00000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloSubTitulo = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 10,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9EAF7')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$estiloCabeceraNormal = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 9,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true,
        'textRotation' => 90
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9EAF7')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$estiloCabeceraHorizontal = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 9,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9EAF7')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$estiloDato = array(
    'font' => array(
        'name'  => 'Arial',
        'size'  => 10,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$estiloDatoIzquierda = array(
    'font' => array(
        'name'  => 'Arial',
        'size'  => 10,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
*/
if ($gdImage) {
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Logotipo');
    $objDrawing->setDescription('Logotipo');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setHeight(60);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($sheet);
}

/*
|--------------------------------------------------------------------------
| DIMENSIONES DE COLUMNAS
|--------------------------------------------------------------------------
| A-G son columnas principales
| H-V serán columnas pequeñas tipo H3
|--------------------------------------------------------------------------
*/
$sheet->getColumnDimension('A')->setWidth(10); // HOTEL
$sheet->getColumnDimension('B')->setWidth(8);  // N HAB
$sheet->getColumnDimension('C')->setWidth(18); // APELLIDO PATERNO
$sheet->getColumnDimension('D')->setWidth(18); // APELLIDO MATERNO
$sheet->getColumnDimension('E')->setWidth(18); // NOMBRE
$sheet->getColumnDimension('F')->setWidth(15); // RUT
$sheet->getColumnDimension('G')->setWidth(14); // ALOJAMIENTO

foreach (range('H', 'V') as $columna) {
    $sheet->getColumnDimension($columna)->setWidth(4);
}

/*
|--------------------------------------------------------------------------
| ALTURAS DE FILAS
|--------------------------------------------------------------------------
*/
$sheet->getRowDimension(1)->setRowHeight(25);
$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(3)->setRowHeight(8);
$sheet->getRowDimension(4)->setRowHeight(42);

for ($i = 5; $i <= 40; $i++) {
    $sheet->getRowDimension($i)->setRowHeight(22);
}

/*
|--------------------------------------------------------------------------
| ENCABEZADO SUPERIOR
|--------------------------------------------------------------------------
*/
$sheet->mergeCells('C1:V1');
$sheet->mergeCells('C2:V2');

$sheet->setCellValue('C1', 'REGISTRO DE SERVICIO');
$sheet->setCellValue('C2', '(H3)   FECHA   '.$newDate);

$sheet->getStyle('C1:V1')->applyFromArray($estiloTituloPrincipal);
$sheet->getStyle('C2:V2')->applyFromArray(array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 14,
        'color' => array('rgb' => 'C00000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
));

/*
|--------------------------------------------------------------------------
| FILA DE CABECERAS
|--------------------------------------------------------------------------
*/
$filaCabecera = 4;

$sheet->setCellValue('A'.$filaCabecera, 'HOTEL');
$sheet->setCellValue('B'.$filaCabecera, 'N HAB');
$sheet->setCellValue('C'.$filaCabecera, 'APELLIDO PATERNO');
$sheet->setCellValue('D'.$filaCabecera, 'APELLIDO MATERNO');
$sheet->setCellValue('E'.$filaCabecera, 'NOMBRE');
$sheet->setCellValue('F'.$filaCabecera, 'R.U.T');
$sheet->setCellValue('G'.$filaCabecera, 'ALOJAMIENTO');

$sheet->getStyle('A'.$filaCabecera.':G'.$filaCabecera)->applyFromArray($estiloCabeceraHorizontal);

// Columnas pequeñas tipo H3
foreach (range('H', 'V') as $columna) {
    $sheet->setCellValue($columna.$filaCabecera, 'H3');
    $sheet->getStyle($columna.$filaCabecera)->applyFromArray($estiloCabeceraNormal);
}

/*
|--------------------------------------------------------------------------
| DATOS
|--------------------------------------------------------------------------
*/
$fila = 5;
$maxFilasFormulario = 40;

while ($rows = $resultado->fetch_assoc()) {

    if ($fila > $maxFilasFormulario) {
        break;
    }

    $sheet->setCellValue('A'.$fila, 'H3');
    $sheet->setCellValue('B'.$fila, $rows['nHabitacion']);
    $sheet->setCellValue('C'.$fila, strtoupper($rows['apellidoPersona1']));
    $sheet->setCellValue('D'.$fila, strtoupper($rows['apellidoPersona2']));
    $sheet->setCellValue('E'.$fila, strtoupper($rows['nombresPersona']));
    $sheet->setCellValue('F'.$fila, $rows['rutPersona']);
    $sheet->setCellValue('G'.$fila, '1');

    // Si quieres marcar una columna H3 automáticamente, puedes usar esto.
    // Por ahora se deja vacía la zona de firmas/marcas manuales como en la hoja.
    foreach (range('H', 'V') as $columna) {
        $sheet->setCellValue($columna.$fila, '');
    }

    $sheet->getStyle('A'.$fila.':B'.$fila)->applyFromArray($estiloDato);
    $sheet->getStyle('C'.$fila.':E'.$fila)->applyFromArray($estiloDatoIzquierda);
    $sheet->getStyle('F'.$fila.':V'.$fila)->applyFromArray($estiloDato);

    $fila++;
}

/*
|--------------------------------------------------------------------------
| FILAS VACÍAS PARA QUE SE VEA COMO FORMULARIO
|--------------------------------------------------------------------------
*/
for ($i = $fila; $i <= $maxFilasFormulario; $i++) {
    $sheet->setCellValue('A'.$i, 'H3');

    foreach (range('B', 'V') as $columna) {
        $sheet->setCellValue($columna.$i, '');
    }

    $sheet->getStyle('A'.$i.':B'.$i)->applyFromArray($estiloDato);
    $sheet->getStyle('C'.$i.':E'.$i)->applyFromArray($estiloDatoIzquierda);
    $sheet->getStyle('F'.$i.':V'.$i)->applyFromArray($estiloDato);
}

/*
|--------------------------------------------------------------------------
| BORDE EXTERIOR MÁS MARCADO
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A4:V40')->applyFromArray(array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array('rgb' => '000000')
        )
    )
));

/*
|--------------------------------------------------------------------------
| ALINEACIÓN GENERAL
|--------------------------------------------------------------------------
*/
$sheet->getStyle('A1:V40')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

/*
|--------------------------------------------------------------------------
| ÁREA DE IMPRESIÓN
|--------------------------------------------------------------------------
*/
$sheet->getPageSetup()->setPrintArea('A1:V40');

/*
|--------------------------------------------------------------------------
| SALIDA
|--------------------------------------------------------------------------
*/
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Registro_de_Servicio_'.$newDate.'.xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>