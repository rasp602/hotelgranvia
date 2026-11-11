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

}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','B',8);
    $this->Cell(130, 10, ' ', 0);
    $this->Cell(150,10,'Historial de trabajadores',0,0,'L');

}

}
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(10,20,20);

$fechaInicio=Date('2000-01-01');
$fechaFin=Date('3000-01-01');
$rutTrabajador = $_REQUEST["rutTrabajador"];
$nombreTrabajador = $_REQUEST["nombreTrabajador"];
$genero = $_REQUEST["genero"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"]; 
$idHotel= $_REQUEST["idHotel"]; 
$estado= $_REQUEST["estado"]; 
$fecha1= Date('3000-01-01');
$where="";


if ($rutTrabajador=="" && $nombreTrabajador=="" && $idHotel=="0" && $estado=="" && $desde=="" && $hasta="") {
$where="where hotel.idHotel!=''";
}


if ($rutTrabajador!="") {
    $where="where rutTrabajador LIKE'%".$rutTrabajador."%'";

}

if ($nombreTrabajador!="") {
    $where="where nombreTrabajador LIKE'%".$nombreTrabajador."%'";

}

if ($idHotel!="0") {
    $where="where hotel.idHotel LIKE'%".$idHotel."%'";

}


if ($estado!="") {
    $where="where trabajador.estado LIKE'%".$estado."%'";

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
$query3 = mysqli_query($con,"SELECT 

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
 $where ORDER by hotel.idHotel ASC");


$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {             
            
            $fila = mysqli_fetch_array($query3);
            $pdf->SetFont('Arial','',10);

            $fechaIngreso = $fila['fechaIngreso'];
            $newDate1 = date("d-m-Y", strtotime($fechaIngreso));   
            $horaCreado = date("g:i a",strtotime($fila['horaCreado']));
            $espacio = "";
            $genero = $fila['genero'];
            $idTrabajador = $fila['idTrabajador'];
            
            $imagen1="../../img/granvia.png";
            $pdf->Cell( 60, 20, $pdf->Image($imagen1, $pdf->GetX()+1, $pdf->GetY()+1, 35), 10, 10, 'C', false );


                $pdf->SetAligns(['L']);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);

                $pdf->Row(array("R.U.T: ".$fila['rutTrabajador']));
                $pdf->Row(array("Nombre: ".$fila['nombreTrabajador']));
                $pdf->Row(array("Apellido: ".$fila['apellidoTrabajador1']));

            $imagen="../../trabajador/codigosQR/qr_".$fila['idTrabajador'].".png";
            $pdf->Cell( 60, 20, $pdf->Image($imagen, $pdf->GetX()+1, $pdf->GetY()+1, 30), 10, 10, 'C', false );

   
               
 
         }

      
$pdf->Output();?>
