<?php

require('../../fpdf/fpdf.php');
require('../../bd/database.php');
require('../../bd/conexion.php');


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
  $this->Cell(180, 8, 'Registro de Salidas', 0);
  $this->Ln(5);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(5);
  $this->SetFont('Arial', 'B', 8);
  $this->SetMargins(20,20,20);
  
  $this->Ln(5);
    
  $this->SetWidths(array(150,40,60,60));
  $this->SetFont('Arial','B',8);
  $this->SetFillColor(51, 122, 183);
  $this->SetTextColor(255,255,255);
  $this->SetAligns(['C', 'C', 'C','C']);

        for($i=0;$i<1;$i++)
            {
                $this->Row(array('TRABAJADOR','HOTEL','FECHA SALIDA','HORA SALIDA'));
            }
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','B',8);
    $this->Cell(130, 10, ' ', 0);
    $this->Cell(150,10,'Historial de Salidas',0,0,'L');

}

}
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(20,20,20);

$where="ORDER BY idSalidaT";

$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$idHotel = $_REQUEST["idHotel"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');

if ($nombreTrabajador!="") {
    $where="where trabajador.nombreTrabajador LIKE'%".$nombreTrabajador."%'";

}

if ($idHotel!="") {
    $where="where trabajador.idHotel LIKE'%".$idHotel."%'";

}


if ($desde!="" && $hasta=="") {
    $where="where fechaSalidaT BETWEEN '".$desde."' AND '".$fecha1."'";
 
}

if ($desde!="" && $hasta!="") {
    $where="where fechaSalidaT BETWEEN '".$desde."' AND '".$hasta."'";

}

$query3 = mysqli_query($con,"SELECT 
        salidat.idSalidaT,
        salidat.idTrabajador,
        salidat.fechaSalidaT,
        salidat.horaSalida,

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
        trabajador.idHotel,
        hotel.idHotel,
        hotel.nombreHotel
        
      
        FROM salidat
        INNER JOIN trabajador ON salidat.idTrabajador=trabajador.idTrabajador
        INNER JOIN hotel ON trabajador.idHotel=hotel.idHotel $where");



$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {             
            
                $fila = mysqli_fetch_array($query3);
                $pdf->SetFont('Arial','',12);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);
                $pdf->SetAligns(['C', 'C', 'C','C']);
                $pdf->Row(array($fila['nombreTrabajador'],$fila['nombreHotel'],$fila['fechaSalidaT'], $fila['horaSalida']));
 
         }

      
$pdf->Output();
?>
