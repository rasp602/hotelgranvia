<?php

require('../../fpdf/fpdf.php');
//require('../../bd/database.php');
require('../../bd/conexionLocal.php'); //incluir el archivo de conexion
require('../../bd/conexionh2.php'); //incluir el archivo de conexion
require('../../bd/conexionh3.php'); //incluir el archivo de conexion
require('../../bd/conexionh4.php'); //incluir el archivo de conexion

date_default_timezone_set("America/Santiago");

$tipoComida = 'Almuerzo';
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');
$hoy=date('Y-m-d');


class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        
        $this->Rect($x,$y,$w,$h);

        $this->MultiCell($w,5,$data[$i],0,$a,'true');
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function Header()
{

  $this->SetFont('Arial', '', 10);
  $this->Image('../../img/granvia.png' , 10 ,8, 30 , 30,'PNG');
  $this->Cell(19, 10, '', 0);


  $this->SetFont('Arial', '', 9);
  $this->Cell(130, 8, '', 0);
  $this->Cell(50, 2, 'Hoy: '.date('d-m-Y').'', 0);
  $this->Ln(10);
  $this->Cell(150, 10, '', 0);
  $this->Ln(7);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(2);

  $this->SetFont('Arial', 'B', 12);
  $this->Cell(50, 8, '', 0);
  $this->Cell(100, 8, 'CONTROL DE ALMUERZOS DE LOS HOTELES', 0);
  $this->Ln(5);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(5);
  $this->SetFont('Arial', 'B', 8);
  $this->SetMargins(20,20,20);
  
  $this->Ln(5);
    
  $this->SetWidths(array(30,20,20,20,20,20,20));
  $this->SetFont('Arial','B',8);
  $this->SetFillColor(51, 122, 183);
  $this->SetTextColor(255,255,255);
  $this->SetAligns(['C', 'C','C','C','C','C','C']);

        for($i=0;$i<1;$i++)
            {
                $this->Row(array('FECHA','HOTEL H1','HOTEL H2','HOTEL H3','HOTEL H4','HOTEL H5','TOTAL'));
            }
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','B',8);
    $this->Cell(130, 10, ' ', 0);
    $this->Cell(150,10,'Historial de Comidas',0,0,'L');

}

}
    $pdf=new PDF('P','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(20,20,20);



// Consulta para obtener la información de la primera columna
$query1 = mysqli_query($con,"SELECT 
calendar.fechaComida AS fechaComida,
hotel.nombreHotel,
hotel.idHotel,
COUNT(comida.idComida) AS desayunos
FROM (
SELECT fechaComida
FROM comida
WHERE fechaComida BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY fechaComida
) AS calendar
CROSS JOIN hotel
LEFT JOIN comida ON calendar.fechaComida = comida.fechaComida
AND comida.tipoComida LIKE '%".$tipoComida."%'
LEFT JOIN hospedaje ON comida.idHospedaje = hospedaje.idHospedaje
AND hospedaje.idHotel = hotel.idHotel
WHERE hotel.idHotel = 1
GROUP BY calendar.fechaComida, hotel.nombreHotel, hotel.idHotel
ORDER BY calendar.fechaComida");

$query1extra = mysqli_query($con,"SELECT 
fechas.fecha AS fechaComida,
COALESCE(COUNT(ce.idComidaExtra), 0) AS desayunosextra 
FROM 
(
    SELECT '".$desde."' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS fecha
    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
) AS fechas
LEFT JOIN 
comidaextra AS ce ON fechas.fecha = ce.fechaComida AND tipoComida LIKE '%".$tipoComida."%'
WHERE 
fechas.fecha BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY 
fechas.fecha; ");

// Consulta para obtener la información de la segunda columna (base de datos diferente)
$query2 = mysqli_query($con2,"SELECT 
calendar.fechaComida AS fechaComida,
hotel.nombreHotel,
hotel.idHotel,
hospedaje.idhotel,
COUNT(comida.idComida) AS desayunos
FROM (
SELECT fechaComida
FROM comida
WHERE fechaComida BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY fechaComida
) AS calendar
CROSS JOIN hotel
LEFT JOIN comida ON calendar.fechaComida = comida.fechaComida
AND comida.tipoComida LIKE '%".$tipoComida."%' and hotel.idHotel = 2
LEFT JOIN hospedaje ON comida.idHospedaje = hospedaje.idHospedaje
AND hospedaje.idHotel = hotel.idHotel
GROUP BY calendar.fechaComida
ORDER BY calendar.fechaComida"); // Agrega la consulta para obtener la información de la segunda columna

$query2extra = mysqli_query($con2,"SELECT 
fechas.fecha AS fechaComida,
COALESCE(COUNT(ce.idComidaExtra), 0) AS desayunosextra 
FROM 
(
    SELECT '".$desde."' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS fecha
    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
) AS fechas
LEFT JOIN 
comidaextra AS ce ON fechas.fecha = ce.fechaComida AND tipoComida LIKE '%".$tipoComida."%'
WHERE 
fechas.fecha BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY 
fechas.fecha; ");

$query3 = mysqli_query($con3,"SELECT 
calendar.fechaComida AS fechaComida,
hotel.nombreHotel,
hotel.idHotel,
COUNT(comida.idComida) AS desayunos
FROM (
SELECT fechaComida
FROM comida
WHERE fechaComida BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY fechaComida
) AS calendar
CROSS JOIN hotel
LEFT JOIN comida ON calendar.fechaComida = comida.fechaComida
AND comida.tipoComida LIKE '%".$tipoComida."%'
LEFT JOIN hospedaje ON comida.idHospedaje = hospedaje.idHospedaje
AND hospedaje.idHotel = hotel.idHotel
WHERE hotel.idHotel = 3
GROUP BY calendar.fechaComida, hotel.nombreHotel, hotel.idHotel
ORDER BY calendar.fechaComida"); // Agrega la consulta para obtener la información de la segunda columna


$query3extra = mysqli_query($con3,"SELECT 
fechas.fecha AS fechaComida,
COALESCE(COUNT(ce.idComidaExtra), 0) AS desayunosextra 
FROM 
(
    SELECT '".$desde."' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS fecha
    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
) AS fechas
LEFT JOIN 
comidaextra AS ce ON fechas.fecha = ce.fechaComida AND tipoComida LIKE '%".$tipoComida."%'
WHERE 
fechas.fecha BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY 
fechas.fecha; ");

$query4 = mysqli_query($con4,"SELECT 
calendar.fechaComida AS fechaComida,
hotel.nombreHotel,
hotel.idHotel,
COUNT(comida.idComida) AS desayunos
FROM (
SELECT fechaComida
FROM comida
WHERE fechaComida BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY fechaComida
) AS calendar
CROSS JOIN hotel
LEFT JOIN comida ON calendar.fechaComida = comida.fechaComida
AND comida.tipoComida LIKE '%".$tipoComida."%'
LEFT JOIN hospedaje ON comida.idHospedaje = hospedaje.idHospedaje
AND hospedaje.idHotel = hotel.idHotel
WHERE hotel.idHotel = 4
GROUP BY calendar.fechaComida, hotel.nombreHotel, hotel.idHotel
ORDER BY calendar.fechaComida"); // Agrega la consulta para obtener la información de la segunda columna

$query4extra = mysqli_query($con4,"SELECT 
fechas.fecha AS fechaComida,
COALESCE(COUNT(ce.idComidaExtra), 0) AS desayunosextra 
FROM 
(
    SELECT '".$desde."' + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS fecha
    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
) AS fechas
LEFT JOIN 
comidaextra AS ce ON fechas.fecha = ce.fechaComida AND tipoComida LIKE '%".$tipoComida."%'
WHERE 
fechas.fecha BETWEEN '".$desde."' AND '".$hasta."'
GROUP BY 
fechas.fecha; ");


$query5 = mysqli_query($con,"SELECT 
calendar.fechaComida AS fechaComida,
hotel.nombreHotel,
hotel.idHotel,
COALESCE(SUM(comidaservida.cantidad), 0) AS desayunos
FROM (
SELECT DATE_ADD('".$desde."', INTERVAL numbers.n DAY) AS fechaComida
FROM numbers
WHERE DATE_ADD('".$desde."', INTERVAL numbers.n DAY) <= '".$hasta."'
) AS calendar
CROSS JOIN hotel
LEFT JOIN comidaservida ON calendar.fechaComida = comidaservida.fechaComida
AND comidaservida.tipoComida LIKE '%".$tipoComida."%'
AND comidaservida.idHotel = hotel.idHotel
WHERE hotel.idHotel = 5
GROUP BY calendar.fechaComida, hotel.nombreHotel, hotel.idHotel
ORDER BY calendar.fechaComida"); // Agrega la consulta para obtener la información de la segunda columna


$numfilas1 = mysqli_num_rows($query1);
$numfilas1extra = mysqli_num_rows($query1extra);
$numfilas2 = mysqli_num_rows($query2);
$numfilas2extra = mysqli_num_rows($query2extra);
$numfilas3 = mysqli_num_rows($query3);
$numfilas3extra = mysqli_num_rows($query3extra);
$numfilas4 = mysqli_num_rows($query4);
$numfilas4extra = mysqli_num_rows($query4extra);
$numfilas5 = mysqli_num_rows($query5);

$totalDesayunosHotel1 = 0;
$totalDesayunosHotel2 = 0;
$totalDesayunosHotel3 = 0;
$totalDesayunosHotel4 = 0;
$totalDesayunosHotel5 = 0;

for ($i=1; $i<=max($numfilas1, $numfilas2, $numfilas3, $numfilas4); $i++)
{
    $fila1 = ($i <= $numfilas1) ? mysqli_fetch_array($query1) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila1extra = ($i <= $numfilas1extra) ? mysqli_fetch_array($query1extra) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila2 = ($i <= $numfilas2) ? mysqli_fetch_array($query2) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila2extra = ($i <= $numfilas2extra) ? mysqli_fetch_array($query2extra) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila3 = ($i <= $numfilas3) ? mysqli_fetch_array($query3) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila3extra = ($i <= $numfilas3extra) ? mysqli_fetch_array($query3extra) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila4 = ($i <= $numfilas4) ? mysqli_fetch_array($query4) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila4extra = ($i <= $numfilas4extra) ? mysqli_fetch_array($query4extra) : array(""); // Si no hay datos, inserta un espacio vacío
    $fila5 = ($i <= $numfilas5) ? mysqli_fetch_array($query5) : array(""); // Si no hay datos, inserta un espacio vacío

    $totalDesayunosHotel1 += $fila1['desayunos']+$fila1extra['desayunosextra'];
    $totalDesayunosHotel2 += $fila2['desayunos']+$fila2extra['desayunosextra'];
    $totalDesayunosHotel3 += $fila3['desayunos']+$fila3extra['desayunosextra'];
    $totalDesayunosHotel4 += $fila4['desayunos']+$fila4extra['desayunosextra'];
    $totalDesayunosHotel5 += $fila5['desayunos'];

$total= $fila1['desayunos']+$fila1extra['desayunosextra']+$fila2['desayunos']+$fila2extra['desayunosextra']+$fila3['desayunos']+$fila3extra['desayunosextra']+$fila4['desayunos']+$fila4extra['desayunosextra']+$fila5['desayunos'];



    $pdf->SetFont('Arial','',12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);
    $pdf->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C']);
    $pdf->Row(array($fila2['fechaComida'],$fila1['desayunos']+$fila1extra['desayunosextra'],$fila2['desayunos']+$fila2extra['desayunosextra'],$fila3['desayunos']+$fila3extra['desayunosextra'],$fila4['desayunos']+$fila4extra['desayunosextra'],$fila5['desayunos'],$total));
 
         }

    // Agregar fila adicional con el total de desayunos de todos los hoteles
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C']);
$pdf->Row(array('Total', $totalDesayunosHotel1, $totalDesayunosHotel2, $totalDesayunosHotel3, $totalDesayunosHotel4, $totalDesayunosHotel5, ($totalDesayunosHotel1 + $totalDesayunosHotel2 + $totalDesayunosHotel3 + $totalDesayunosHotel4 + $totalDesayunosHotel5)));  
$pdf->Output();
?>
