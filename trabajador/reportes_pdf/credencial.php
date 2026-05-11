<?php
require('../../fpdf/fpdf.php');
require('../../bd/database.php');
require('../../bd/conexion.php');

$idTrabajador = $_REQUEST["idTrabajador"];


        $resulta=mysqli_query($con,"SELECT * FROM trabajador WHERE idTrabajador='$idTrabajador'");
                  $rowcount1=mysqli_num_rows($resulta);
                  while($row = mysqli_fetch_array($resulta)) 
                  {
                    $idTrabajador= $row['idTrabajador'];
                    $rut= $row['rutTrabajador'];
                    $nombre= $row['nombreTrabajador'];
                    $apellido= $row['apellidoTrabajador1'];
                    $qrTrabajador= $row['qrTrabajador'];

                  
                }

                $trabajador=$idTrabajador;
                

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
/*


}

function Footer()
{
*/

}

}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pdf->Ln();
$pdf->Image('../../img/granvia.png',3,4,30);
$pdf->SetMargins(25, 25 , 30);
$pdf->SetFont('Arial');
$pdf->Ln();
$pdf->Cell(10,2,'R.U.T : '.$rut.'' ,0,1);
$pdf->Ln();
$pdf->Cell(10,2,'NOMBRE : '.$nombre.'',0,1);
$pdf->Ln();
$pdf->Cell(10,2,'APELLIDO : '.$apellido.'',0,1);
$pdf->SetMargins(70, 25 , 30); 
$pdf->Ln();
$pdf->Image('../../trabajador/codigosQR/qr_'.$qrTrabajador.'.png',62,4,30);
$pdf->SetMargins(130, 25 , 30);
$pdf->Ln();
$pdf->SetMargins(60, 25 , 30);
$pdf->SetFont('Arial','B','14');
$pdf->Ln();



      
$pdf->Output();?>
