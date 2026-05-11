<?php
	//Incluimos librería y archivo de conexión
	require 'Classes/PHPExcel.php';
	require '../../bd/conexionLocal.php';
	





$idHotel = $_REQUEST["idHotel"];
$idEmpresa = $_REQUEST["idEmpresa"];
$desde = $_REQUEST["desde"];
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

        $where ORDER by hospedaje.idHospedaje DESC";

	//Consulta

	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	$idEmpresa = $_REQUEST["idEmpresa"];

	if ($idEmpresa==1) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==2) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==3) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==4) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==5) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==6) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==7) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==8) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==9) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==10) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==11) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}
	if ($idEmpresa==12) {
		$gdImage = imagecreatefrompng('../../img/granvia.png');
	}



	//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Ronald sanchez")->setDescription("Resumen Diario");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Resumen Diario");
	
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Logotipo');
	$objDrawing->setDescription('Logotipo');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(90);
	$objDrawing->setWidth(90);
	$objDrawing->setCoordinates('A1');
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


	$objPHPExcel->getActiveSheet()->mergeCells('A1:A5');
   	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'LOGO DE LA EMPRESA');
   	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($estiloTitulos);

	$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->mergeCells('B1:D5');

	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($estiloTitulos);
	
  
    $objPHPExcel->getActiveSheet()->mergeCells('E1:J5')->getColumnDimension('F')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($estiloTitulos);
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'REGISTRO DE SERVICIO FECHA: ' .$desde);



 	$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->applyFromArray($estiloTitulosBlancos);


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'HOTEL');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'N HAB');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'A. PATERNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'A. MATERNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'NOMBRE');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'R.U.T');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'ALOJAMIENTO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('H6', 'DESAYUNO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('I6', 'ALMUERZO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('J6', 'CENA');

	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch_assoc()){
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'J'.$fila)->applyFromArray($estiloTituloColumnasResultados);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['nombreHotel']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nHabitacion']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['apellidoPersona1']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['apellidoPersona2']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['nombresPersona']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['rutPersona']);
$idEmpresa = $_REQUEST["idEmpresa"];
if ($idEmpresa == '8') {
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['Act']);
}
else
{
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['FechaR']);
}

	
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,'');
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,'');
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila,'');
		/*$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, utf8_encode($rows['descripcion']));*/


		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	
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