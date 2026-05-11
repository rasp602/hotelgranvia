<?php

require('../../fpdf/fpdf.php');
//require('../../bd/database.php');


$idHotel = $_REQUEST["idHotel"];
if ($idHotel=="") {
    require('../../bd/conexionLocal.php'); //incluir el archivo de conexion
  

}
if ($idHotel==1) {
    require('../../bd/conexionLocal.php'); //incluir el archivo de conexion
  

}

if ($idHotel==2) {
    require('../../bd/conexionLocalh2.php');//incluir el archivo de conexion
  

}
if ($idHotel==3) {
    require('../../bd/conexionLocalh3.php'); //incluir el archivo de conexion
  

}
if ($idHotel==4) {
    require('../../bd/conexionLocalh4.php'); //incluir el archivo de conexion
  

}

$tipoComida = $_REQUEST["tipoComida"];
$idPersona = $_REQUEST["idPersona"];
$idEmpresa = $_REQUEST["idEmpresa"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');
$hoy=date('Y-m-d');

$where="";
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
  $this->Image('../../img/granvia.png' , 30 ,8, 40 , 30,'PNG');
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
  $this->Cell(150, 8, '', 0);
  $this->Cell(180, 8, 'Registro de Comidas', 0);
  $this->Ln(5);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(5);
  $this->SetFont('Arial', 'B', 8);
  $this->SetMargins(20,20,20);
  
  $this->Ln(5);
    
  $this->SetWidths(array(15,30,30, 30, 30, 60, 60, 50, 50));
  $this->SetFont('Arial','B',8);
  $this->SetFillColor(51, 122, 183);
  $this->SetTextColor(255,255,255);
  $this->SetAligns(['C', 'C', 'C','C','C','C','C','C','C']);

        for($i=0;$i<1;$i++)
            {
                $this->Row(array('ITEMS','HOTEL','HABITACION','FECHA','HORA','TIPO COMIDA','PERSONA','EMPRESA'));
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
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(20,20,20);

if ($idHotel!="") {
    $where="where hospedaje.idHotel = '".$idHotel."'";
    
  //echo "Busca hotel solo"; 
}
if ($idHotel!="" && $tipoComida!="" && $idEmpresa=="" && $desde=="" && $hasta=="" && $idPersona=="" ) {
    $where="where hospedaje.idHotel = '".$idHotel."' AND comida.tipoComida LIKE'%".$tipoComida."%'";
    
  //echo "Busca hotel solo"; 
}

if ($idEmpresa!="" ) {
    $where="where empresa.idEmpresa = '".$idEmpresa."' ";
    
  //echo "Busca empresa sola"; 
}

if ($desde!="") {
    $where="where comida.fechaComida BETWEEN '".$desde."' AND '".$fecha1."'";
    
  //echo "Busca fechas sola"; 
}

if ($desde!="" && $hasta!="") {
    $where="where comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."' ";
    
  //echo "Busca nombre con fechas"; 
}


error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ob_end_clean();
/*El codigo de arriba quita el error del codigo de abajo*/
list($nombre, $apellido) = explode(" ", $idPersona);

if ($idPersona!="") {
    $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%'";
    
 //echo "1.1- Busca nombre con apellido "; 
}
if ($idPersona!=""  && $desde!="" && $hasta!="") {
    $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%' and comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."' ";
    
  //echo "Busca nombre con fechas"; 
}
if ($desde!="" && $hasta!=""  && $idHotel!="" && $tipoComida!="") {
    $where="where comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."' and hospedaje.idHotel = '".$idHotel."' and comida.tipoComida = '".$tipoComida."' GROUP BY persona.idPersona";
  //echo "Busca tipo COMIDA con fechas"; 
}


if ($tipoComida!="" && $desde!="" && $hasta!="") {
    $where="where comida.tipoComida LIKE'%".$tipoComida."%' and comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
  //echo "Busca tipo COMIDA con fechas"; 
}

/*
if ($idHotel!="" && $idHabitacion!=""  && $desde!="" && $hasta!="") {
    $where="where hospedaje.idHotel = '".$idHotel."' and hospedaje.idHabitacion= '".$idHabitacion."'";
    
  //echo "Busca hotel , habitacion y fechas"; 
}*/



if ($idEmpresa!="" && $desde!="" && $hasta!="") {
    $where="where empresa.idEmpresa = '".$idEmpresa."' and comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
    
  //echo "Busca empresa con fechas sola"; 
}

if ($idEmpresa!="" && $tipoComida!="" && $desde!="" && $hasta!="") {
    $where="where comida.tipoComida = '".$tipoComida."' and empresa.idEmpresa = '".$idEmpresa."' and comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."'";
  //echo "Busca empresa con tipo de comida y fechas"; 
}

if ($desde!="" && $hasta!="" && $idEmpresa!="" && $idHotel!="" && $tipoComida!="") {
  $where="where comida.tipoComida = '".$tipoComida."' and empresa.idEmpresa = '".$idEmpresa."' and comida.fechaComida BETWEEN '".$desde."' AND '".$hasta."'and hospedaje.idHotel = '".$idHotel."'";
  
//echo "Busca fechas sola"; 
}

$query3 = mysqli_query($con,"SELECT 

comida.idComida,
comida.idPersona,
comida.tipoComida,
comida.fechaComida,
comida.horaComida,
comida.idHospedaje,

persona.idPersona,
persona.rutPersona,
persona.nombresPersona,
persona.apellidoPersona1,
persona.apellidoPersona2,
persona.qrPersona,
persona.idEmpresa,

empresa.idEmpresa,
empresa.nombreEmpresa,

hospedaje.idHospedaje,
hospedaje.idHabitacion,
hospedaje.idPersona,
hospedaje.idHotel,

hotel.idHotel,
hotel.nombreHotel,

habitacion.idHabitacion,
habitacion.nHabitacion,
habitacion.idHotel
FROM comida 
 INNER JOIN persona ON comida.idPersona=persona.idPersona
 INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
 INNER JOIN hospedaje ON comida.idHospedaje=hospedaje.idHospedaje        
 INNER JOIN hotel ON hospedaje.idHotel=hotel.idHotel
 INNER JOIN habitacion ON hospedaje.idHabitacion=habitacion.idHabitacion
 $where  ORDER BY comida.idComida,comida.tipoComida,comida.horaComida");



$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {             
              $espacio = "";
                $fila = mysqli_fetch_array($query3);
                $pdf->SetFont('Arial','',12);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);
                $pdf->SetAligns(['C', 'C', 'C','C','C','C','C','C']);
                $pdf->Row(array($i,$fila['nombreHotel'],$fila['nHabitacion'],$fila['fechaComida'],$fila['horaComida'],$fila['tipoComida'],$fila['nombresPersona']." ".$fila['apellidoPersona1'],$fila['nombreEmpresa']));
 
         }

      
$pdf->Output();
?>
