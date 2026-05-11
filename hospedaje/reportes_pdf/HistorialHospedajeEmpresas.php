
<?php
require('../../fpdf/fpdf.php');

$idHotel = $_REQUEST["idHotel"];

// Validar hotel
if (!$idHotel || !in_array($idHotel, ['1','2','3','4','25'])) {
    echo "<div class='container'><br><div class='alert alert-danger'>Debe seleccionar un hotel válido antes de continuar.</div></div>";
    exit;
}

// Selección de conexión según hotel
switch ($idHotel) {
    case '1':
    case '25':
        include '../../bd/conexionLocal.php';
        break;
    case '2':
        include '../../bd/conexionLocalh2.php';
        break;
    case '3':
        include '../../bd/conexionLocalh3.php';
        break;
    case '4':
        include '../../bd/conexionLocalh4.php';
        break;
}
$where = " WHERE 1=1 ";

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
  $this->Cell(140, 8, '', 0);
  $this->Cell(140, 8, 'REGISTRO DE HOSPEDAJES', 0);
  $this->Ln(5);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(5);
  $this->SetFont('Arial', 'B', 8);
  $this->SetMargins(10,20,20);
  
  $this->Ln(5);
    
  $this->SetWidths(array(12,40,40,40,60, 30, 20, 30, 30,30));
  $this->SetFont('Arial','B',10);
  $this->SetFillColor(51, 122, 183);
  $this->SetTextColor(255,255,255);
  $this->SetAligns(['C', 'C', 'C','C','C','C','C','C','C','C']);

        for($i=0;$i<1;$i++)
            {
                $this->Row(array('#','HOTEL','EMPRESA','RUT','PERSONA','HABITACION', 'CAMA', 'F.ENTRADA','F.SALIDA'
                    ,'ESTADO'));
            }
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','B',8);
    $this->Cell(130, 10, ' ', 0);
    $this->Cell(150,10,'Historial de Hospedajes',0,0,'L');

}

}
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(10,20,20);

$fechaInicio=Date('2000-01-01');
$fechaFin=Date('3000-01-01');

$descripcion   = $_REQUEST["descripcion"];
$idHabitacion  = $_REQUEST["idHabitacion"];
$idCama        = $_REQUEST["idCama"];
$idEmpresa     = $_REQUEST["idEmpresa"];
$estado        = $_REQUEST["estado"];
$desde         = $_REQUEST["desde"];
$hasta         = $_REQUEST["hasta"];


$where .= " AND hotel.idHotel = '$idHotel' ";





if ($descripcion!="") {

     $where="where persona.nombresPersona LIKE'%".$nombre."%' and apellidoPersona1 LIKE'%".$apellido."%' OR persona.rutPersona LIKE'%".$descripcion."%' OR apellidoPersona1 LIKE'%".$descripcion."%'";
   // echo "1.-Busca  por descripcion"; 
}

if ($idHotel!=""  && $idEmpresa!="" && $idHabitacion==""&& $idCama=="") {
    $where="where hotel.idHotel ='".$idHotel."'";
    // echo "2.-Busca Hotel,empresa "; 

  }

if ($idHotel!="" && $idHabitacion!=""&& $idCama=="" && $idEmpresa!="") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' ";
    // echo "3.-Busca Hotel,Habitacion y empresa "; 

  }

 
  if ($idHotel!="" && $idHabitacion!="" && $idCama!="" && $idEmpresa!="" && $estado=="") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' AND cama.idCama ='".$idCama."' and persona.idEmpresa ='".$idEmpresa."' ";
//echo "7.-Busca hotel, habitacion,Cama y empresa"; 
}

  if ($idHotel!="" && $idHabitacion!="" && $idCama!="" && $idEmpresa!="" && $estado!="") {
    $where="where hotel.idHotel ='".$idHotel."' and habitacion.idHabitacion ='".$idHabitacion."' AND cama.idCama ='".$idCama."' and persona.idEmpresa ='".$idEmpresa."' and hospedaje.estado ='$estado'";
  //echo "8.-.-Busca hotel, habitacion,Cama,empresa y estado"; 
}

   if ($idHotel!="" && $idEmpresa!=""  && $estado!="") {
    $where="where hotel.idHotel ='".$idHotel."' and hospedaje.estado ='$estado' and persona.idEmpresa ='".$idEmpresa."'";
  //echo "9.-Busca hotel ,empresa y  Estado"; 
}




 

$query3 = mysqli_query($con,"
SELECT 
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

    habitacion.idHabitacion,
    habitacion.nHabitacion,

    cama.idCama,
    cama.nCama,

    persona.idPersona,
    persona.nombresPersona,
    persona.apellidoPersona1,
    persona.rutPersona,
    persona.idEmpresa,

    empresa.idEmpresa,
    empresa.nombreEmpresa

FROM hospedaje
INNER JOIN hotel ON hospedaje.idHotel = hotel.idHotel
INNER JOIN habitacion ON hospedaje.idHabitacion = habitacion.idHabitacion
INNER JOIN cama ON hospedaje.idCama = cama.idCama 
INNER JOIN persona ON hospedaje.idPersona = persona.idPersona 
INNER JOIN empresa ON persona.idEmpresa = empresa.idEmpresa       
$where AND persona.idEmpresa= 26
ORDER BY hospedaje.idHabitacion
");

$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {    
            
            $fila = mysqli_fetch_array($query3);
            $pdf->SetFont('Arial','',10);

            $desde1 = $fila['desde'];
            $newDate1 = date("d-m-Y", strtotime($desde1));
            $hasta1 = $fila['hasta'];
            $newDate2 = date("d-m-Y", strtotime($hasta1));   
        
             $espacio = "";
          

 
       $pdf->SetWidths(array(12,40,40,40,60, 30, 20, 30, 30,30));
                $pdf->SetAligns(['C', 'C', 'C','C','L','C','C','C','C','C']);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);


                $pdf->Row(array($i,$fila['nombreHotel'],$fila['nombreEmpresa'],$fila['rutPersona'],$fila['nombresPersona']." ".$fila['apellidoPersona1'] ,$fila['nHabitacion'],$fila['nCama'],$newDate1,$newDate2,$fila['estado']));
 
         }

      
$pdf->Output();?>
