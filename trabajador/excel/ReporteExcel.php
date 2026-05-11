<?php
	//Incluimos librería y archivo de conexión
	require 'Classes/PHPExcel.php';
	require '../../bd/conexion.php';
	


    $id_user = $_REQUEST['id_user'];
$rutTrabajador = $_REQUEST["rutTrabajador"];
$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$genero = $_REQUEST["genero"];
$estado = $_REQUEST["estado"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$idHotel = $_REQUEST["idHotel"];
$fecha1= Date('3000-01-01');


if ($rutTrabajador!="") {
    $where="where rutTrabajador LIKE'%".$rutTrabajador."%'";

}

if ($nombreTrabajador!="") {
    $where="where nombreTrabajador LIKE'%".$nombreTrabajador."%' OR apellidoTrabajador1 LIKE'%".$nombreTrabajador."%' OR rutTrabajador LIKE'%".$nombreTrabajador."%' ";

}

if ($idHotel!="") {
    $where="where hotel.idHotel LIKE'%".$idHotel."%'";

}

if ($rutTrabajador=="" && $genero=="M") {
    $where="where genero ='".$genero."'";

}
if ($rutTrabajador=="" && $genero=="F") {
    $where="where genero ='".$genero."'";

}

if ($desde!="" && $hasta=="") {
    $where="where fechaIngreso BETWEEN '".$desde."' AND '".$fecha1."'";

}

if ($desde!="" && $hasta!="") {
    $where="where fechaIngreso BETWEEN '".$desde."' AND '".$hasta."'";

}


date_default_timezone_set("America/Santiago");
$hora=date('H:i:s');
$date=date('d-m-Y');

$sql ="SELECT 
        trabajador.idTrabajador,
        trabajador.rutTrabajador,
        trabajador.nombreTrabajador,
        trabajador.apellidoTrabajador1,
        trabajador.apellidoTrabajador2,
        trabajador.genero,
        trabajador.fechaCreado,
        trabajador.horaCreado,
        trabajador.fotoTrabajador,
        trabajador.qrTrabajador,
        trabajador.idhotel,
        trabajador.estado,
        trabajador.fechaIngreso,
        trabajador.jornada,
        trabajador.labor,
        trabajador.diasTrabajo,
        trabajador.sueldo,
        hotel.idhotel,
        hotel.nombreHotel

		FROM trabajador 
		INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel
		$where and trabajador.estado='A' ORDER by trabajador.idTrabajador ASC";

	//Consulta

	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
	$gdImage = imagecreatefrompng('../../img/granvia.png');//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Ronald sanchez")->setDescription("Reporte de Hoteles");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Hoteles");
	
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
	'size' =>10,
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
    $objPHPExcel->getActiveSheet()->getStyle('A1:A5')->applyFromArray($estiloTituloColumnasResultados);
	$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->mergeCells('B1:D5');
    $objPHPExcel->getActiveSheet()->getStyle('B1:D5')->applyFromArray($estiloTituloColumnasResultados);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($estiloTitulos);
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'TRABAJADORES REGISTRADOS');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA:')->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->mergeCells('F1:G1')->getColumnDimension('F')->setWidth(7);
    $objPHPExcel->getActiveSheet()->mergeCells('F2:G2');
    $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
    $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
    $objPHPExcel->getActiveSheet()->mergeCells('F5:G5');

    $objPHPExcel->getActiveSheet()->setCellValue('F1', ''.$date);
    $objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($estiloTituloColumnasResultados);
    $objPHPExcel->getActiveSheet()->setCellValue('E2', 'HORA:');
    $objPHPExcel->getActiveSheet()->setCellValue('F2', ''.$hora);
    $objPHPExcel->getActiveSheet()->getStyle('E2:G2')->applyFromArray($estiloTituloColumnasResultados);
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'USUARIO:');
    $objPHPExcel->getActiveSheet()->setCellValue('F3', ''.$id_user);
    $objPHPExcel->getActiveSheet()->getStyle('E3:G3')->applyFromArray($estiloTituloColumnasResultados);
    $objPHPExcel->getActiveSheet()->setCellValue('E4', '');
    $objPHPExcel->getActiveSheet()->setCellValue('F4', '');
    $objPHPExcel->getActiveSheet()->getStyle('E4:G4')->applyFromArray($estiloTituloColumnasResultados);
    $objPHPExcel->getActiveSheet()->setCellValue('E5', '');
    $objPHPExcel->getActiveSheet()->setCellValue('F5', '');
    $objPHPExcel->getActiveSheet()->getStyle('E5:G5')->applyFromArray($estiloTituloColumnasResultados);


 	$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($estiloTitulosBlancos);


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'R.U.T');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'TRABAJADOR');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'APELLIDO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'LABOR');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'F.HOTEL');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'F.IMAGEN');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch_assoc()){
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'G'.$fila)->applyFromArray($estiloTituloColumnasResultados);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['rutTrabajador']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nombreTrabajador']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['apellidoTrabajador1']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['labor']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['nombreHotel']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['qrTrabajador'],);
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
header('Content-Disposition: attachment;filename="trabajadores registrados.xls"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>