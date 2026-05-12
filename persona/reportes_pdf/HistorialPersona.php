<?php
require('../../fpdf/fpdf.php');
require('../../bd/database.php');
require('../../bd/conexionLocal.php');

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
  $this->Cell(25, 50, '', 0);


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
  $this->Cell(180, 8, 'REGISTRO DE PERSONAS', 0);
  $this->Ln(5);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(5);
  $this->SetFont('Arial', 'B', 8);
  $this->SetMargins(10,20,20);
  
  $this->Ln(5);
    
  $this->SetWidths(array(10,40,40,50, 30, 30, 30, 50,50));
  $this->SetFont('Arial','B',10);
  $this->SetFillColor(51, 122, 183);
  $this->SetTextColor(255,255,255);
  $this->SetAligns(['C', 'C', 'C','C','C','C','C','C']);

        for($i=0;$i<1;$i++)
            {
                $this->Row(array('#','RUT','NOMBRES','APELLIDOS','FECHA REG', 'HORA REG', 'GENERO','EMPRESA'
                    ,'OBSERVACION'));
            }
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','B',10);
    $this->Cell(130, 10, ' ', 0);
    $this->Cell(150,10,'Historial de Personas',0,0,'L');

}

}
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(10,20,20);

$fechaInicio=Date('0000-00-00');
$fechaFin=Date('3000-01-01');

$campo = $_REQUEST["campo"];
$genero = $_REQUEST["genero"];
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"]; 
$idEmpresa = $_REQUEST["idEmpresa"]; 

    $where="where fechaCreado BETWEEN '".$fechaInicio."' AND '".$fechaFin."'";




$fecha1= Date('3000-01-01');



if ($campo!="") {
    $where="where nombresPersona LIKE'%".$campo."%'";

}

if ($genero!="" && $campo=="" && $idEmpresa=="" ) {
    $where="where genero ='".$genero."'";

}


if ($desde!="" && $hasta=="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$fecha1."'";

}

if ($desde!="" && $hasta!="" && $campo=="" && $nombresPersona=="" && $idEmpresa=="" && $genero=="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."'";

}

if ($desde!="" && $hasta!="" && $genero!="" && $idEmpresa!="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."' AND genero ='".$genero."' AND empresa.idEmpresa LIKE'%".$idEmpresa."%'";
 
}

if ($desde!="" && $hasta!="" && $genero!="" && $idEmpresa=="") {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."' AND genero ='".$genero."'";

}

if ($desde!="" && $hasta!="" && $idEmpresa!="" ) {
    $where="where fechaCreado BETWEEN '".$desde."' AND '".$hasta."' AND empresa.idEmpresa LIKE'%".$idEmpresa."%'";

}

if ($idEmpresa!=""  && $genero==""&& $desde=="" && $hasta=="") {
    $where="where empresa.idEmpresa LIKE'%".$idEmpresa."%'";

}

if ($idEmpresa!="" && $genero!="" && $desde=="" && $hasta=="") {
    $where="where persona.idEmpresa LIKE'%".$idEmpresa."%' and persona.genero ='".$genero."'";

}  


$query3 = mysqli_query($con,"SELECT 

        persona.idPersona,
        persona.rutPersona,
        persona.nombresPersona,
        persona.apellidoPersona1,
        persona.apellidoPersona2,
        persona.genero,
        persona.fechaCreado,
        persona.horaCreado,
        persona.fotoPersona,
        persona.qrPersona,
        persona.idEmpresa,

        empresa.idEmpresa,
        empresa.nombreEmpresa


 FROM persona 
INNER JOIN empresa ON persona.idEmpresa=empresa.idEmpresa
 $where ORDER by idPersona DESC");




$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {             
            
            $fila = mysqli_fetch_array($query3);
            $pdf->SetFont('Arial','',10);

            $fechaCreado = $fila['fechaCreado'];
            $newDate1 = date("d-m-Y", strtotime($fechaCreado));   
            $horaCreado = date("g:i a",strtotime($fila['horaCreado']));
             $espacio = "";
            $genero = $fila['genero'];

                $pdf->SetAligns(['C', 'C', 'C','C','C','C','C','C','C','C']);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);
                $pdf->Row(array($i,$fila['rutPersona'],$fila['nombresPersona'],$fila['apellidoPersona1']." ".$fila['apellidoPersona2'] ,$fechaCreado,$horaCreado,$genero,$fila['nombreEmpresa'],$espacio));
 
         }

      
$pdf->Output();?>
