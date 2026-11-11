<?php
	//Incluimos librería y archivo de conexión
	require 'Classes/PHPExcel.php';
	require '../../bd/conexion.php';
	

	$usuario = $_REQUEST['id_user'];
    $where="where usuario.id_user = '".$usuario."'";
    $tipoA= $_REQUEST['tipoA'];
    $idLinea= $_REQUEST['idLineaA'];
    $estado= $_REQUEST['estado'];
    $descripcion = $_REQUEST['descripcion'];
    $desde = $_REQUEST['desde'];
	$hasta = $_REQUEST['hasta'];


if ($tipoA!="") {
    $where="where actividad.tipoA='".$tipoA."' AND usuario.id_user = '".$usuario."'";
   /* echo "if actividad"; */
}

if ($idLinea!="") {
    $where="where linea.idLinea ='".$idLinea."' AND usuario.id_user = '".$usuario."'";
  /*  echo "if idlinea"; */
}

if ($estado!="") {
    $where="where actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "if status"; */
}

if ($descripcion!="") {
    $where="where actividad.descripcion LIKE '%".$descripcion."%' OR maquina.nMaquina LIKE '%".$descripcion."%' AND usuario.id_user = '".$usuario."'";
    /*echo "if descripcion"; */
}


if ($tipoA!="" && $idLinea!="" && $estado=="" && $descripcion=="") {
    $where="where actividad.tipoA LIKE '".$tipoA."' AND linea.idLinea ='".$idLinea."' AND usuario.id_user = '".$usuario."'";
   /* echo "actividad y linea";    */
}

if ($tipoA!="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND linea.idLinea ='".$idLinea."' AND  actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "actividad,linea,estado"; */  
}
if ($tipoA=="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where linea.idLinea ='".$idLinea."' AND  actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "linea,estado";   */
}

if ($tipoA!="" && $idLinea==""  && $estado!="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND actividad.StatusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "actividad,estado";    */
}

if ($tipoA=="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where linea.idLinea ='".$idLinea."' AND  actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
    /*echo "linea,estado"; */
}
if ($tipoA=="" && $idLinea!=""  && $estado=="" && $descripcion=="") {
    $where="where linea.idLinea ='".$idLinea."' AND usuario.id_user = '".$usuario."'";
   /* echo "linea";  */  
}

if ($tipoA!="" && $idLinea!="" && $estado=="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND linea.idLinea ='".$idLinea."'  AND usuario.id_user = '".$usuario."'";
    /*echo "actividad,linea"; */   
}
if ($tipoA!="" && $idLinea!="" && $estado!="" && $descripcion=="") {
    $where="where actividad.tipoA ='".$tipoA."' AND linea.idLinea ='".$idLinea."' AND actividad.StatusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "actividad,linea,estado";    */
}
if ($tipoA=="" && $idLinea=="" && $estado=="" && $descripcion=="" && $desde!="" && $hasta!="") {
    $where="where actividad.fechaA BETWEEN '".$desde."' AND '".$hasta."' AND usuario.id_user = '".$usuario."'";
   /* echo "actividad,linea,estado";    */
}

elseif ($tipoA!="" && $idLinea!="" && $estado!="" && $descripcion!=""){
     $where="where actividad.tipoA LIKE '".$tipoA."' AND linea.idLinea ='".$idLinea."' AND actividad.statusA ='".$estado."' AND usuario.id_user = '".$usuario."'";
   /* echo "if todo"; */
}


$sql ="SELECT 
            actividad.idActividad,
            actividad.descripcion,
            actividad.tipoA,
            actividad.idMaquina,
            actividad.fechaA,
            actividad.horaA,
            actividad.id_user,
            actividad.statusA,

            maquina.idMaquina,
            maquina.nMaquina,
            maquina.idLinea,
            maquina.patente,

            linea.idLinea,
            linea.nLinea,
            usuario.id_user,
            usuario.email,
            usuario.password,
            usuario.nivel,
            usuario.idUsuario,

            tblusuario.idUsuario,
            tblusuario.rut,
            tblusuario.nombre,
            tblusuario.apellido,
            tblusuario.fechaCrea,
            tblusuario.genero
           
            FROM actividad
            INNER JOIN maquina ON maquina.idMaquina=actividad.idMaquina  
            INNER JOIN linea ON linea.idLinea=maquina.idLinea
            INNER JOIN usuario ON actividad.id_user=usuario.id_user
            INNER JOIN tblusuario ON tblusuario.idUsuario=usuario.idUsuario
            $where ORDER by actividad.fechaA ASC";




	//Consulta

	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	
	$gdImage = imagecreatefrompng('../../img/logo1.png');//Logotipo
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Ronald sanchez")->setDescription("Reporte de Actividades");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Actividades");
	
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Logotipo');
	$objDrawing->setDescription('Logotipo');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(100);
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
	);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:H4')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->getStyle('E2:E4')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->getStyle('F2:F4')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->getStyle('C1:C1')->applyFromArray($estiloTitulos);

	
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'INFORME SEMANAL');
	$objPHPExcel->getActiveSheet()->setCellValue('E2', 'TECNICO');
	$objPHPExcel->getActiveSheet()->setCellValue('E3', 'FECHA DESDE');
	$objPHPExcel->getActiveSheet()->setCellValue('E4', 'FECHA HASTA');
	$objPHPExcel->getActiveSheet()->setCellValue('F2', 'RONALD SANCHEZ');
	$objPHPExcel->getActiveSheet()->setCellValue('F3', date("d-m-Y", strtotime($desde)));
	$objPHPExcel->getActiveSheet()->setCellValue('F4', date("d-m-Y", strtotime($hasta)));
	$objPHPExcel->getActiveSheet()->mergeCells('C1:H1');
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'FECHA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'CLIENTE');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'PATENTE');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'MAQUINA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'PROBLEMA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(80);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'SOLUCION');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'TECNICO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('H6', 'ESTADO');

	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch_assoc()){
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'D'.$fila)->applyFromArray($estiloTituloColumnasResultados);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$fila.':'.'H'.$fila)->applyFromArray($estiloTituloColumnasResultados);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila.':'.'F'.$fila)->applyFromArray($estiloTituloColumnasResultados2);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila.':'.'F'.$fila)->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, date("d-m-Y", strtotime($rows['fechaA'])));
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nLinea']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['patente']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['nMaquina']);
		/*$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, utf8_encode($rows['descripcion']));*/
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, utf8_encode($rows['descripcion']));
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['nombre'].' '.$rows['apellido']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Perfecto Estado");

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
header('Content-Disposition: attachment;filename="Informe Semanal.xls"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>