<?php
	//Incluimos librería y archivo de conexión
	require 'Classes/PHPExcel.php';
	require '../../bd/conexionLocal.php';
	

    $nombresPersona = $_REQUEST['nombresPersona'];
    $id_user = $_REQUEST['id_user'];

   /* $descripcion = $_REQUEST["descripcion"];
	$idHotel = $_REQUEST["idHotel"];
	$idHabitacion = $_REQUEST["idHabitacion"];
	$idCama = $_REQUEST["idCama"];
	$estado = $_REQUEST["estado"];*/
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$idEmpresa = $_REQUEST["idEmpresa"];



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
        persona.qrPersona,
        persona.card,

        empresa.idEmpresa,
        empresa.nombreEmpresa

        
        FROM hospedaje
        INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
        INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
        INNER JOIN cama ON hospedaje.idCama=cama.idCama 
        INNER JOIN persona ON hospedaje.idPersona=persona.idPersona 
        INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa        
        ORDER by hospedaje.idHospedaje";

	//Consulta

	$resultado = $mysqli->query($sql);
	$fila = 2; //Establecemos en que fila inciara a imprimir los datos
	
	
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Ronald sanchez")->setDescription("Reporte de Hoteles");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Hoteles");
	

	
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






	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '*Person ID');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('B1', '*Organization');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('C1', '*Person Name');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('D1', '*Gender');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Contact');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Email');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Effective Time');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Expiry Time');
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Card No.');
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Room No.');
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Floor No.');	

	$genero="1";
	$contacto="";
	$email="";
	

	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch_assoc()){
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'K'.$fila)->applyFromArray($estiloTituloColumnasResultados);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['idPersona']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nombreHotel']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['nombresPersona']." ".$rows['apellidoPersona1']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $genero);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $contacto);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $email);	

		$newDateDesde = date("Y/m/d", strtotime($rows['desde']));
		$newDateHasta = date("Y/m/d", strtotime($rows['hasta'])); 

		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $newDateDesde);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $newDateHasta);
		


$objPHPExcel -> getActiveSheet()->getCell('I'.$fila)-> setValue($rows['qrPersona']); 
$objPHPExcel -> getActiveSheet()->getStyle('I'.$fila)->getNumberFormat()->setFormatCode('0000000000'); 

		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $rows['qrPersona']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $rows['idHabitacion']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $rows['idCama']);
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
header('Content-Disposition: attachment;filename="Hospedajes.xls"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>