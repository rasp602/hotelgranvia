<?php
include('../../bd/mysql.php');
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Style\Color;
    use PhpOffice\PhpSpreadsheet\Style\Conditional;
    use PhpOffice\PhpSpreadsheet\Style\Font;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    require_once 'excel/Classes/PHPExcel/IOFactory.php';
    require_once 'excel/Classes/PHPExcel.php';

    $idHotel = 0;
    $idHabitacion = 0;
    $idCama = 0;
    $estado = 'A';
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $idEmpresa = 0;

    $where = " ";
    if($idHotel != "" || $idHotel > 0)
        $where .= " AND hospedaje.idHotel = " . $idHotel;
    if($idHabitacion != "" || $idHabitacion > 0)
        $where .= " AND hospedaje.idHabitacion = " . $idHabitacion;
    if($idCama != "" || $idCama > 0)
        $where .= " AND hospedaje.idCama = " . $idCama;
    if($estado != "")
        $where .= " AND hospedaje.estado = '" . $estado . "'";
    if($desde != "")
        $where .= " AND hospedaje.desde >= '" . $desde . "'";
    if($hasta != "")
        $where .= " AND hospedaje.hasta <= '" . $hasta . "'";
    if($idEmpresa != "" || $idEmpresa > 0)
        $where .= " AND empresa.idEmpresa = " . $idEmpresa;

    $objPHPExcel = PHPExcel_IOFactory::load("excel/reporte3.xlsx"); 
    $sheet = $objPHPExcel->getActiveSheet();  


   $sql = "SELECT   persona.idPersona,CONCAT(persona.nombresPersona,' ',persona.apellidoPersona1) AS nombre,IF(persona.genero = 'M',1,2) AS genero,CONCAT('00', persona.qrPersona) AS card,persona.fechaCreado,persona.idEmpresa,empresa.idEmpresa FROM persona INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa WHERE persona.idEmpresa=2 and persona.fechaCreado='2023-03-14';";

    $cont = 2;   

    if( $result = mysqli_query($conn, $sql))
    {  
        while($row = mysqli_fetch_assoc($result))
        {   
            $idPersona = $row['idPersona'];
            $nombreHotel = "BESALCO 14-03 AL 28-03";
            $nombre = $row['nombre'];
            $genero = $row['genero'];
            $desde = '2023-03-14';
            $hasta = '2023-03-28';
            $card = $row['card'];
            $idHabitacion = "";
            $idCama = "";

        $newDateDesde = date("Y/m/d", strtotime($desde));
        $newDateHasta = date("Y/m/d", strtotime($hasta));

            $objPHPExcel->getActiveSheet()->setCellValue('A'. $cont, $idPersona);
            $objPHPExcel->getActiveSheet()->setCellValue('B'. $cont, $nombreHotel);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $cont, $nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('D'. $cont, $genero);
            $objPHPExcel->getActiveSheet()->setCellValue('G'. $cont, $newDateDesde);
            $objPHPExcel->getActiveSheet()->setCellValue('H'. $cont, $newDateHasta);
            $objPHPExcel->getActiveSheet()->setCellValue('I'. $cont, $card);
            $objPHPExcel->getActiveSheet()->setCellValue('J'. $cont, $idHabitacion);
            $objPHPExcel->getActiveSheet()->setCellValue('K'. $cont, $idCama);
            
            
            $cont++;
            $sheet->insertNewRowBefore($cont);
        }
    }


    $now = new DateTime();
    $filename = "Reporte carga de datos ". $now->format('Y-m-d H-i-s');
    header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
    header('Cache-Control: max-age=0');         
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $writer->setIncludeCharts(TRUE);
    $writer->save('php://output');  

    return;
?>





