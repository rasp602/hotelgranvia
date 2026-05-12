<?php
   DEFINE ('DB_USER', 'daltile_user');
   DEFINE ('DB_PASSWORD', 'daltile123');
   DEFINE ('DB_HOST', '127.0.0.1');
   DEFINE ('DB_NAME', 'daltile');
   use PhpOffice\PhpSpreadsheet\IOFactory;
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   require_once '../excel/Classes/PHPExcel/IOFactory.php';
   require_once '../excel/Classes/PHPExcel.php';
   //$objPHPExcel = IOFactory::load("../excel/reporte.xlsx"); 
   $orden =str_replace('"','',$_POST['eOrden2']);
   $remision =str_replace('"','',$_POST['eRemision2']);
   $item =str_replace('"','',$_POST['eItem2']); 
   $nombre =str_replace('"','',$_POST['eNombre2']); 
   $ifecha =str_replace('"','',$_POST['eFechaIni2']); 
   $efecha =str_replace('"','',$_POST['eFechaFin2']); 

   $objPHPExcel = PHPExcel_IOFactory::load("../excel/reporte.xlsx"); 
   $sheet = $objPHPExcel->getActiveSheet();  
   $objPHPExcel->getActiveSheet()->setCellValue('C7', 'Del dia: '. $ifecha);
   $objPHPExcel->getActiveSheet()->setCellValue('C8', 'Al dia: '. $efecha);
	
   $query = "SELECT * FROM orden WHERE 1=1";
        if($orden != ''){
            $query .= " AND orden LIKE '%". $orden ."%'";
        }
        if($remision != ''){
            $query .= " AND remision LIKE '%". $remision ."%'";
        }
        if($item != ''){
            $query .= " AND item LIKE '%". $item ."%'";
        }
        if($nombre != ''){
            $query .= " AND nombre LIKE '%". $nombre ."%'";
        }
         if($ifecha != ''){
            $query .= " AND DATE_FORMAT(LEFT(fecha, 10), '%Y-%m-%d')  >= '". $ifecha ."'";
        }
        if($efecha != ''){
            $query .= " AND DATE_FORMAT(LEFT(fecha, 10), '%Y-%m-%d') <= '".$efecha ."'";
        }         
        $query .= " ORDER BY idorden DESC";
    $conectID = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD); mysqli_select_db($conectID, DB_NAME);
    $result = mysqli_query($conectID, $query);
    if(mysqli_num_rows($result)<1){
        echo  "<script type='text/javascript'>";
        echo "window.close();";
        echo "</script>";
        return;
    }
    $cont = 11;   
    while($row = mysqli_fetch_array($result))
    {   
        $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $row['orden']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $row['remision']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'. $cont, $row['fecha']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'. $cont, $row['item']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'. $cont, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'. $cont, $row['unidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'. $cont, $row['entrada']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'. $cont, $row['salida']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'. $cont, $row['neto']);

       
        $cont++;
        $sheet->insertNewRowBefore($cont);
        $sheet->setCellValue('A'. $cont, 'Updated');
    }
    
  
    $now = new DateTime();
    $filename = "Reporte de ingresos materia prima ". $now->format('Y-m-d H-i-s');
    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
    header('Cache-Control: max-age=0'); 
    $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $writer->setIncludeCharts(TRUE);
    $writer->save('php://output');  
  
?>
