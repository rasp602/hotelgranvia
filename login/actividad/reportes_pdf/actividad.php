<?php
 /*header('Content-type: application/vnd.ms-word');
 header("Content-Disposition: attachment; filename=archivo.doc");
 header("Pragma: no-cache");
 header("Expires: 0");
*/

?>
<?php

require('../../fpdf/fpdf.php');
require('../../bd/database.php');
require('../../bd/conexion.php');
    $usuario = $_REQUEST['id_user'];

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
  $this->Image('../../img/logo.png' , 30 ,8, 60 , 20,'PNG');
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
  $this->Cell(180, 8, 'Actividades', 0);
  $this->Ln(5);
  $this->Cell(150, 10, ' ', 0);
  $this->Ln(5);
  $this->SetFont('Arial', 'B', 8);
  $this->SetMargins(10,20,20);
  
  $this->Ln(5);
    
  $this->SetWidths(array(12,40,20,180, 20, 20, 20, 20));
  $this->SetFont('Arial','B',8);
  $this->SetFillColor(51, 122, 183);
  $this->SetTextColor(255,255,255);
  $this->SetAligns(['C', 'C', 'C','C','C','C','C','C']);

        for($i=0;$i<1;$i++)
            {
                $this->Row(array('ITEMS','FECHA DE ACTIVIDAD','TIPO','ACTIVIDAD','LINEA', 'MAQUINA', 'PATENTE', 'HORA'));
            }
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','B',8);
    $this->Cell(130, 10, ' ', 0);
    $this->Cell(150,10,'Historial de Actividades',0,0,'L');

}

}
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(10,20,20);
    
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


$query3 = mysqli_query($con,"SELECT 
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
            $where ORDER by actividad.fechaA DESC");




$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {             
            
            $fila = mysqli_fetch_array($query3);
            $pdf->SetFont('Arial','',8);

            $fechaA = $fila['fechaA'];
            $newDate1 = date("d-m-Y", strtotime($fechaA));   
            $horaA = date("g:i a",strtotime($fila['horaA']));
            $gps = "gps";
            $camaras = "camaras";
            $tipo = $fila['tipoA'];

                $pdf->SetAligns(['C', 'C', 'C','','C','C','C','C']);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);
                $pdf->Row(array($i, $newDate1,$tipo, $fila['descripcion'],$fila['nLinea'], $fila['nMaquina'], $fila['patente'],$horaA));
 
         }

      
$pdf->Output();
?>
