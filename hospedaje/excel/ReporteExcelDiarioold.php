<?php
	//Incluimos librería y archivo de conexión
	require 'Classes/PHPExcel.php';
	require '../../bd/conexionLocal.php';
	
$idHotel = $_REQUEST["idHotel"];
$idEmpresa = $_REQUEST["idEmpresa"];
$desde = $_REQUEST["desde"];

$newDate = date("d-m-Y", strtotime($desde));  
$hasta = $_REQUEST["hasta"]; 
$where="where FechaR BETWEEN '".$desde."' AND '".$hasta."'";


if ($idHotel!="" && $desde!="" && $hasta!="") {
    $where="where hotel.idHotel ='".$idHotel."' and FechaR BETWEEN '".$desde."' AND '".$hasta."'  ";

}

if ($idEmpresa!="" && $desde!="" && $hasta!="") {
    $where="where persona.idEmpresa ='".$idEmpresa."'";

}


if ($idEmpresa!="" && $desde!="" && $hasta!="") {
    $where="where empresa.idEmpresa ='".$idEmpresa."' and FechaR BETWEEN '".$desde."' AND '".$hasta."'  ";
  
}

date_default_timezone_set("America/Santiago");
$hora=date('H:i:s');
$date=date('d-m-Y');

$sql ="SELECT        
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
        INNER JOIN hospedaje ON hospedaje.idHospedaje=resumenhospedaje.idHospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa  

        $where ORDER by hospedaje.idHotel,habitacion.nHabitacion ASC";

	//Consulta

	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	$idEmpresa = $_REQUEST["idEmpresa"];

	if ($idEmpresa==1) {
		$gdImage = imagecreatefrompng('../../img/teching.png');
	}
	if ($idEmpresa==2) {
		$gdImage = imagecreatefrompng('../../img/besalco.png');
	}
	if ($idEmpresa==3) {
		$gdImage = imagecreatefrompng('../../img/mpm.png');
	}
	if ($idEmpresa==4) {
		$gdImage = imagecreatefrompng('../../img/nexxo.png');
	}
	if ($idEmpresa==5) {
		$gdImage = imagecreatefrompng('../../img/fls.png');
	}
	if ($idEmpresa==6) {
		$gdImage = imagecreatefrompng('../../img/sk.png');
	}
	if ($idEmpresa==7) {
		$gdImage = imagecreatefrompng('../../img/baical.png');
	}
	if ($idEmpresa==8) {
		$gdImage = imagecreatefrompng('../../img/cosal.png');
	}
	if ($idEmpresa==9) {
		$gdImage = imagecreatefrompng('../../img/morales.png');
	}
	if ($idEmpresa==10) {
		$gdImage = imagecreatefrompng('../../img/maryland.png');
	}
	if ($idEmpresa==11) {
		$gdImage = imagecreatefrompng('../../img/flesan.png');
	}
	if ($idEmpresa==12) {
		$gdImage = imagecreatefrompng('../../img/ict.png');
	}



	//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Ronald sanchez")->setDescription("Resumen Diario");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Resumen Diario");
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
	
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Logotipo');
	$objDrawing->setDescription('Logotipo');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(150);
	$objDrawing->setWidth(300);
	$objDrawing->setCoordinates('B2');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());




	
	$estiloTituloReporte = array(
    'font' => array(
	'name'      => 'Arial',
	'bold'      => true,
	'italic'    => false,
	'strike'    => false,
	'size' =>10
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_NONE
	)
    ),
    'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloTituloColumnas = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>16,
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => '538DD5')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	$estiloTituloColumnasResultados = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => false,
	'size' =>14,
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	$estiloTituloColumnasResultados2 = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => false,
	'size' =>10,
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    'font' => array(
	'name'  => 'Arial',
	'size' =>10,
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	));

	$estiloTitulos = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>14,
	'color' => array(
	'rgb' => '000000'

	)
    ),
    	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);

	$estiloTitulosBlancos = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'

	)
    ),
    	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);


	$objPHPExcel->getActiveSheet()->mergeCells('A1:D5');
   	$objPHPExcel->getActiveSheet()->setCellValue('B1', '');
   	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($estiloTitulos);

$idEmpresa = $_REQUEST["idEmpresa"];
if ($idEmpresa == '1') {

	$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->applyFromArray($estiloTituloColumnas);
}
else
{
	$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($estiloTituloColumnas);
}
    $objPHPExcel->getActiveSheet()->mergeCells('A1:D5');
	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($estiloTitulos);

$idEmpresa = $_REQUEST["idEmpresa"];
if ($idEmpresa == '1') {	
  
    $objPHPExcel->getActiveSheet()->mergeCells('E1:K5')->getColumnDimension('F')->setWidth(7);
}
else
{
	$objPHPExcel->getActiveSheet()->mergeCells('E1:H5')->getColumnDimension('F')->setWidth(7);
}
    $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($estiloTitulos);
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'REGISTRO DE SERVICIO FECHA: ' .$newDate);
 	$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($estiloTitulosBlancos);
	
	
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'N HAB');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'A. PATERNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'A. MATERNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'NOMBRE');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'R.U.T');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'FIRMA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'HOTEL');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('H6', 'FECHA');
	
$idEmpresa = $_REQUEST["idEmpresa"];
if ($idEmpresa == '1') {
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('I6', 'DESAYUNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('J6', 'ALMUERZO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('K6', 'CENA');
}
else
{

}
/************************************************************************************************* */

// [El código anterior permanece igual hasta la parte donde defines los estilos]



$fila = 7; // Fila inicial para los datos
$contador = 0; // Contador de registros
$hoja = 0; // Contador de hojas

while($rows = $resultado->fetch_assoc()){
    $idEmpresa = $_REQUEST["idEmpresa"];
    
    // Crear nueva hoja cada 20 registros (excepto la primera)
    if ($contador % 20 == 0 && $contador > 0) {
        $hoja++;
        $objPHPExcel->createSheet($hoja);
        $objPHPExcel->setActiveSheetIndex($hoja);
        $objPHPExcel->getActiveSheet()->setTitle("Resumen Diario ".($hoja+1));
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        
        $fila = 1; // Reiniciamos la fila para la nueva hoja
        
        // 1. Insertar logo (ahora en A1:D5)
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Logotipo');
        $objDrawing->setDescription('Logotipo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(150); // Reducido para mejor alineación
        $objDrawing->setWidth(300);  // Reducido para mejor alineación
        $objDrawing->setCoordinates('B2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        // Combinar celdas para el logo (A1:D5)
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':D'.($fila+4));
        
        // 2. Insertar título principal (E1:J5 o E1:G5 según empresa) - al lado del logo
        $mergeTitulo = ($idEmpresa == '1') ? 'E'.$fila.':J'.($fila+4) : 'E'.$fila.':H'.($fila+4);
        $objPHPExcel->getActiveSheet()->mergeCells($mergeTitulo);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, 'REGISTRO DE SERVICIO FECHA: ' .$newDate);
        
        // Aplicar estilos al título
        $styleTitulo = array(
            'font' => array(
                'name' => 'Arial',
                'bold' => true,
                'size' => 14,
                'color' => array('rgb' => '000000')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleTitulo);
        
        $fila += 5; // Avanzamos a la fila de encabezados (fila 6)
        
        // 3. Encabezados de columnas
        $rangeHeaders = ($idEmpresa == '1') ? 'A'.$fila.':J'.$fila : 'A'.$fila.':H'.$fila;
        
        // Aplicar estilos de fondo azul y texto blanco
        $objPHPExcel->getActiveSheet()->getStyle($rangeHeaders)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getStyle($rangeHeaders)->applyFromArray($estiloTitulosBlancos);
        
        // Valores de encabezados

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'N HAB');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 'A. PATERNO');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, 'A. MATERNO');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, 'NOMBRE');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, 'R.U.T');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, 'FIRMA');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'HOTEL');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, 'FECHA');
        
        if ($idEmpresa == '1') {
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, 'DESAYUNO');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, 'ALMUERZO');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, 'CENA');
        }
        
        $fila++; // Avanzar a la primera fila de datos
    }
    
    // Insertar datos
$rangeData = ($idEmpresa == '1') ? 'A'.$fila.':J'.$fila : 'A'.$fila.':H'.$fila;
$objPHPExcel->getActiveSheet()->getStyle($rangeData)->applyFromArray($estiloTituloColumnasResultados);

// Ajustar el alto de la fila (en puntos, 20 es un ejemplo, puedes cambiarlo)
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(25); // <- Aquí se establece el alto de la fila

// Aplicar alineación izquierda solo a la celda F
$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

// Establecer valores en las celdas
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['nHabitacion']);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['apellidoPersona1']);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['apellidoPersona2']);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['nombresPersona']);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['rutPersona']);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['Act']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['nombreHotel']);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $newDate);
    
    if ($idEmpresa == '1') {
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, '');
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, '');
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, '');
    }
    
    $fila++;
    $contador++;
}


// [El resto del código permanece igual]

/*******************************************************************************************************/
	
	$fila = $fila-1;
	/*
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:E".$fila);
	
	$filaGrafica = $fila+2;
	
	// definir origen de los valores
	$values = new PHPExcel_Chart_DataSeriesValues('Number', 'Productos!$D$7:$D$'.$fila);
	
	// definir origen de los rotulos
	$categories = new PHPExcel_Chart_DataSeriesValues('String', 'Productos!$B$7:$B$'.$fila);
	
	// definir  gráfico
	$series = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_BARCHART, // tipo de gráfico
	PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,
	array(0),
	array(),
	array($categories), // rótulos das columnas
	array($values) // valores
	);
	$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	
	// inicializar gráfico
	$layout = new PHPExcel_Chart_Layout();
	$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
	
	// inicializar o gráfico
	$chart = new PHPExcel_Chart('exemplo', null, null, $plotarea);
	
	// definir título do gráfico
	$title = new PHPExcel_Chart_Title(null, $layout);
	$title->setCaption('Gráfico PHPExcel Chart Class');
	
	// definir posiciondo gráfico y título
	$chart->setTopLeftPosition('B'.$filaGrafica);
	$filaFinal = $filaGrafica + 10;
	$chart->setBottomRightPosition('E'.$filaFinal);
	$chart->setTitle($title);
	
	// adicionar o gráfico à folha
	$objPHPExcel->getActiveSheet()->addChart($chart);
	
	$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	// incluir gráfico
	$writer->setIncludeCharts(TRUE);
	*/
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Resumen de Servicios.xls"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>