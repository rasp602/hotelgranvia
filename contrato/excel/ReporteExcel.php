<?php
	//Incluimos librería y archivo de conexión
	require 'Classes/PHPExcel.php';
	require '../../bd/conexionLocal.php';
	

	$campo = $_REQUEST['campo'];
    $id_user = $_REQUEST['id_user'];

$where="";
if ($campo!="") {
    $where="where empresa.nombreEmpresa='".$campo."'";
   /* echo "if actividad"; */
}
date_default_timezone_set("America/Santiago");
$hora=date('H:i:s');
$date=date('d-m-Y');
$sql ="SELECT * FROM empresa $where ORDER by empresa.idEmpresa ASC";

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
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'EMPRESAS REGISTRADAS');
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
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'NOMBRE EMPRESA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CONTRATO');
	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch_assoc()){
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'G'.$fila)->applyFromArray($estiloTituloColumnasResultados);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['rutEmpresa']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nombreEmpresa']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['ContratoEmpresa']);
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
header('Content-Disposition: attachment;filename="empresas registradas.xls"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>