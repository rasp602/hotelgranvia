<?php
ob_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);
ini_set('html_errors', 0);

require_once 'Classes/PHPExcel.php';
require_once '../../bd/conexionLocal.php';

date_default_timezone_set("America/Santiago");

$idHotel   = isset($_REQUEST["idHotel"]) ? trim($_REQUEST["idHotel"]) : "";
$idEmpresa = isset($_REQUEST["idEmpresa"]) ? trim($_REQUEST["idEmpresa"]) : "";
$desde     = isset($_REQUEST["desde"]) ? trim($_REQUEST["desde"]) : "";
$hasta     = isset($_REQUEST["hasta"]) ? trim($_REQUEST["hasta"]) : "";

$newDate = (!empty($desde)) ? date("d-m-Y", strtotime($desde)) : date("d-m-Y");

/*
|--------------------------------------------------------------------------
| OBTENER NOMBRE DEL HOTEL SELECCIONADO
|--------------------------------------------------------------------------
*/
$nombreHotelSeleccionado = 'TODOS LOS HOTELES';

if ($idHotel != "") {
    $sqlHotel = "SELECT nombreHotel
                 FROM hotel
                 WHERE idHotel = '".$mysqli->real_escape_string($idHotel)."'
                 LIMIT 1";
    $resHotel = $mysqli->query($sqlHotel);
    if ($resHotel && $resHotel->num_rows > 0) {
        $rowHotel = $resHotel->fetch_assoc();
        $nombreHotelSeleccionado = $rowHotel['nombreHotel'];
    }
}

/*
|--------------------------------------------------------------------------
| ARMAR WHERE
|--------------------------------------------------------------------------
*/
$where = array();

if ($desde != "" && $hasta != "") {
    $where[] = "resumenhospedaje.FechaR BETWEEN '".$mysqli->real_escape_string($desde)."' AND '".$mysqli->real_escape_string($hasta)."'";
}

if ($idHotel != "") {
    $where[] = "hotel.idHotel = '".$mysqli->real_escape_string($idHotel)."'";
}

if ($idEmpresa != "") {
    $where[] = "empresa.idEmpresa = '".$mysqli->real_escape_string($idEmpresa)."'";
}

$whereSql = "";
if (!empty($where)) {
    $whereSql = " WHERE " . implode(" AND ", $where);
}

/*
|--------------------------------------------------------------------------
| CONSULTA
|--------------------------------------------------------------------------
*/
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
        $whereSql
        ORDER BY hotel.nombreHotel ASC,
                 habitacion.nHabitacion ASC,
                 persona.apellidoPersona1 ASC,
                 persona.apellidoPersona2 ASC,
                 persona.nombresPersona ASC";

$resultado = $mysqli->query($sql);

if (!$resultado) {
    ob_end_clean();
    die("Error en la consulta SQL: " . $mysqli->error);
}

/*
|--------------------------------------------------------------------------
| LOGO EMPRESA IZQUIERDA
|--------------------------------------------------------------------------
*/
$gdImageEmpresa = null;
if ($idEmpresa == '1'  && file_exists('../../img/teching.png'))    $gdImageEmpresa = @imagecreatefrompng('../../img/teching.png');
if ($idEmpresa == '2'  && file_exists('../../img/besalco.png'))    $gdImageEmpresa = @imagecreatefrompng('../../img/besalco.png');
if ($idEmpresa == '3'  && file_exists('../../img/mpm.png'))        $gdImageEmpresa = @imagecreatefrompng('../../img/mpm.png');
if ($idEmpresa == '4'  && file_exists('../../img/nexxo.png'))      $gdImageEmpresa = @imagecreatefrompng('../../img/nexxo.png');
if ($idEmpresa == '5'  && file_exists('../../img/fls.png'))        $gdImageEmpresa = @imagecreatefrompng('../../img/fls.png');
if ($idEmpresa == '6'  && file_exists('../../img/sk.png'))         $gdImageEmpresa = @imagecreatefrompng('../../img/sk.png');
if ($idEmpresa == '7'  && file_exists('../../img/baical.png'))     $gdImageEmpresa = @imagecreatefrompng('../../img/baical.png');
if ($idEmpresa == '8'  && file_exists('../../img/cosal.png'))      $gdImageEmpresa = @imagecreatefrompng('../../img/cosal.png');
if ($idEmpresa == '9'  && file_exists('../../img/morales.png'))    $gdImageEmpresa = @imagecreatefrompng('../../img/morales.png');
if ($idEmpresa == '10' && file_exists('../../img/maryland.png'))   $gdImageEmpresa = @imagecreatefrompng('../../img/maryland.png');
if ($idEmpresa == '15' && file_exists('../../img/flesan.png'))     $gdImageEmpresa = @imagecreatefrompng('../../img/flesan.png');
if ($idEmpresa == '12' && file_exists('../../img/ict.png'))        $gdImageEmpresa = @imagecreatefrompng('../../img/ict.png');
if ($idEmpresa == '26' && file_exists('../../img/fegrande.png'))   $gdImageEmpresa = @imagecreatefrompng('../../img/fegrande.png');

/*
|--------------------------------------------------------------------------
| LOGO HOTEL DERECHA
|--------------------------------------------------------------------------
*/
$gdImageHotel = null;
if (file_exists('../../img/granvian.png')) {
    $gdImageHotel = @imagecreatefrompng('../../img/granvian.png');
}

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
    ->setDescription("Registro de Servicio");

$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setTitle("Registro Servicio");

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN DE PÁGINA
|--------------------------------------------------------------------------
*/
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

$sheet->getPageMargins()->setTop(0.1);
$sheet->getPageMargins()->setBottom(0.1);
$sheet->getPageMargins()->setLeft(0.1);
$sheet->getPageMargins()->setRight(0.1);

$sheet->getPageSetup()->setFitToPage(true);
$sheet->getPageSetup()->setFitToWidth(1);
$sheet->getPageSetup()->setFitToHeight(1);

$sheet->getPageSetup()->setHorizontalCentered(true);
$sheet->getPageSetup()->setVerticalCentered(false);
$sheet->getHeaderFooter()->setOddFooter('&CPágina &P de &N');

/*
|--------------------------------------------------------------------------
| ESTILOS
|--------------------------------------------------------------------------
*/
$estiloTituloPrincipal = array(
    'font' => array(
        'name'  => 'Agency FB',
        'bold'  => true,
        'size'  => 24,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloTituloSecundario = array(
    'font' => array(
        'name'  => 'Agency FB',
        'bold'  => true,
        'size'  => 24,
        'color' => array('rgb' => 'C00000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true
    )
);

$estiloCabecera = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'size'  => 12,
        'color' => array('rgb' => '000000')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'       => true
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '7FC0DE')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$estiloDatoCentro = array(
    'font' => array(
        'name'  => 'Arial',
        'size'  => 12,
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
        'size'  => 12,
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

$estiloDatoFirma = array(
    'font' => array(
        'name'  => 'Arial',
        'size'  => 12,
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
| ANCHOS DE COLUMNAS A:G
|--------------------------------------------------------------------------
*/
$sheet->getColumnDimension('A')->setWidth(9);   // CC
$sheet->getColumnDimension('B')->setWidth(10);  // N HAB
$sheet->getColumnDimension('C')->setWidth(24);  // APELLIDO PATERNO
$sheet->getColumnDimension('D')->setWidth(24);  // APELLIDO MATERNO
$sheet->getColumnDimension('E')->setWidth(20);  // NOMBRE
$sheet->getColumnDimension('F')->setWidth(18);  // RUT
$sheet->getColumnDimension('G')->setWidth(42);  // ALOJAMIENTO / FIRMA

/*
|--------------------------------------------------------------------------
| FUNCIÓN PARA DIBUJAR ENCABEZADO
|--------------------------------------------------------------------------
*/
function dibujarBloque($sheet, $filaInicio, $newDate, $gdImageEmpresa, $gdImageHotel, $nombreHotelSeleccionado)
{
    global $estiloTituloPrincipal, $estiloTituloSecundario, $estiloCabecera;

// 🔥 CONFIGURACIÓN DE TAMAÑOS (AJUSTA AQUÍ)
$altoLogoEmpresa = 55;
$altoLogoHotel   = 70;

$offsetXEmpresa = 12;
$offsetYEmpresa = 4;

$offsetXHotel = 12;
$offsetYHotel = 4;

// 🔥 ALTURA MÁS PEQUEÑA DEL ENCABEZADO
$sheet->getRowDimension($filaInicio)->setRowHeight(30);
$sheet->getRowDimension($filaInicio + 1)->setRowHeight(28);
$sheet->getRowDimension($filaInicio + 2)->setRowHeight(20);

    // Combinar celdas
    $sheet->mergeCells('A'.$filaInicio.':C'.($filaInicio + 1));
    $sheet->mergeCells('D'.$filaInicio.':F'.$filaInicio);
    $sheet->mergeCells('D'.($filaInicio + 1).':F'.($filaInicio + 1));
    $sheet->mergeCells('G'.$filaInicio.':G'.($filaInicio + 1));

    // TITULO
    $sheet->setCellValue('D'.$filaInicio, 'REGISTRO DE SERVICIO');
    $sheet->getStyle('D'.$filaInicio.':F'.$filaInicio)->applyFromArray($estiloTituloPrincipal);

    // TEXTO HOTEL + FECHA
    $richText = new PHPExcel_RichText();

    $run1 = $richText->createTextRun('HOTEL: ');
    $run1->getFont()->setName('Agency FB')->setBold(true)->setSize(24)->setColor(new PHPExcel_Style_Color('000000'));

    $run2 = $richText->createTextRun($nombreHotelSeleccionado.'   ');
    $run2->getFont()->setName('Agency FB')->setBold(true)->setSize(24)->setColor(new PHPExcel_Style_Color('C00000'));

    $run3 = $richText->createTextRun('FECHA: ');
    $run3->getFont()->setName('Agency FB')->setBold(true)->setSize(24)->setColor(new PHPExcel_Style_Color('000000'));

    $run4 = $richText->createTextRun($newDate);
    $run4->getFont()->setName('Agency FB')->setBold(true)->setSize(24)->setColor(new PHPExcel_Style_Color('C00000'));

    $sheet->setCellValue('D'.($filaInicio + 1), $richText);
    $sheet->getStyle('D'.($filaInicio + 1).':F'.($filaInicio + 1))->applyFromArray($estiloTituloSecundario);

    // Bordes
    $sheet->getStyle('A'.$filaInicio.':G'.($filaInicio + 1))->applyFromArray(array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    ));

    // CABECERA TABLA
    $filaCabecera = $filaInicio + 2;

    $sheet->setCellValue('A'.$filaCabecera, 'CC');
    $sheet->setCellValue('B'.$filaCabecera, 'N HAB');
    $sheet->setCellValue('C'.$filaCabecera, 'APELLIDO PATERNO');
    $sheet->setCellValue('D'.$filaCabecera, 'APELLIDO MATERNO');
    $sheet->setCellValue('E'.$filaCabecera, 'NOMBRE');
    $sheet->setCellValue('F'.$filaCabecera, 'RUT');
    $sheet->setCellValue('G'.$filaCabecera, 'ALOJAMIENTO');

    $sheet->getStyle('A'.$filaCabecera.':G'.$filaCabecera)->applyFromArray($estiloCabecera);

    /*
    |--------------------------------------------------------------------------
    | LOGO EMPRESA (IZQUIERDA - GRANDE Y CENTRADO)
    |--------------------------------------------------------------------------
    */
    if ($gdImageEmpresa) {
        $objDrawing1 = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing1->setImageResource($gdImageEmpresa);
        $objDrawing1->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing1->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);

        // 🔥 TAMAÑO AJUSTABLE
        $objDrawing1->setHeight($altoLogoEmpresa);

        // POSICIÓN
        $objDrawing1->setCoordinates('A'.$filaInicio);
        $objDrawing1->setOffsetX($offsetXEmpresa);
        $objDrawing1->setOffsetY($offsetYEmpresa);

        $objDrawing1->setWorksheet($sheet);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGO GRAN VIA (DERECHA - MÁS GRANDE Y CENTRADO)
    |--------------------------------------------------------------------------
    */
    if ($gdImageHotel) {
        $objDrawing2 = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing2->setImageResource($gdImageHotel);
        $objDrawing2->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing2->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);

        // 🔥 TAMAÑO AJUSTABLE
        $objDrawing2->setHeight($altoLogoHotel);

        // POSICIÓN
        $objDrawing2->setCoordinates('G'.$filaInicio);
        $objDrawing2->setOffsetX($offsetXHotel);
        $objDrawing2->setOffsetY($offsetYHotel);

        $objDrawing2->setWorksheet($sheet);
    }

    return $filaCabecera + 1;
}

/*
|--------------------------------------------------------------------------
| DATOS CON PAGINACIÓN
|--------------------------------------------------------------------------
*/
$registrosPorPagina = 16;
$contadorEnPagina   = 0;
$filaActual         = 1;
$totalRegistros     = 0;

$filaDatos = dibujarBloque(
    $sheet,
    $filaActual,
    $newDate,
    $gdImageEmpresa,
    $gdImageHotel,
    $nombreHotelSeleccionado
);

$filaActual = $filaDatos;

while ($rows = $resultado->fetch_assoc()) {

    if ($contadorEnPagina == $registrosPorPagina) {
        $sheet->setBreak('A'.$filaActual, PHPExcel_Worksheet::BREAK_ROW);

        $filaActual += 1;

        $filaDatos = dibujarBloque(
            $sheet,
            $filaActual,
            $newDate,
            $gdImageEmpresa,
            $gdImageHotel,
            $nombreHotelSeleccionado
        );

        $filaActual = $filaDatos;
        $contadorEnPagina = 0;
    }

    $sheet->getRowDimension($filaActual)->setRowHeight(27);

    $sheet->setCellValue('A'.$filaActual, strtoupper($rows['nombreHotel']));
    $sheet->setCellValue('B'.$filaActual, $rows['nHabitacion']);
    $sheet->setCellValue('C'.$filaActual, strtoupper($rows['apellidoPersona1']));
    $sheet->setCellValue('D'.$filaActual, strtoupper($rows['apellidoPersona2']));
    $sheet->setCellValue('E'.$filaActual, strtoupper($rows['nombresPersona']));
    $sheet->setCellValue('F'.$filaActual, $rows['rutPersona']);
    $sheet->setCellValue('G'.$filaActual, '1');

    $sheet->getStyle('A'.$filaActual.':B'.$filaActual)->applyFromArray($estiloDatoCentro);
    $sheet->getStyle('C'.$filaActual.':F'.$filaActual)->applyFromArray($estiloDatoIzquierda);
    $sheet->getStyle('G'.$filaActual)->applyFromArray($estiloDatoFirma);

    $filaActual++;
    $contadorEnPagina++;
    $totalRegistros++;
}

/*
|--------------------------------------------------------------------------
| SI NO HAY REGISTROS
|--------------------------------------------------------------------------
*/
if ($totalRegistros == 0) {
    $sheet->mergeCells('A'.$filaActual.':G'.$filaActual);
    $sheet->setCellValue('A'.$filaActual, 'NO SE ENCONTRARON REGISTROS PARA LOS FILTROS SELECCIONADOS');
    $sheet->getStyle('A'.$filaActual.':G'.$filaActual)->applyFromArray(array(
        'font' => array(
            'name'  => 'Arial',
            'bold'  => true,
            'size'  => 12,
            'color' => array('rgb' => 'C00000')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ));
    $sheet->getRowDimension($filaActual)->setRowHeight(30);
}

/*
|--------------------------------------------------------------------------
| ÁREA DE IMPRESIÓN
|--------------------------------------------------------------------------
*/
$ultimaFila = max($filaActual, 10);
$sheet->getPageSetup()->setPrintArea('A1:G'.$ultimaFila);

/*
|--------------------------------------------------------------------------
| NOMBRE ARCHIVO
|--------------------------------------------------------------------------
*/
$nombreArchivo = 'Registro_de_Servicio_'.$newDate;
if ($idHotel != '') {
    $nombreArchivo .= '_Hotel_'.$idHotel;
}
$nombreArchivo .= '.xls';

/*
|--------------------------------------------------------------------------
| SALIDA
|--------------------------------------------------------------------------
*/
if (ob_get_length()) {
    ob_clean();
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombreArchivo.'"');
header('Cache-Control: max-age=0');
header('Pragma: public');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
ob_end_flush();
exit;
?>