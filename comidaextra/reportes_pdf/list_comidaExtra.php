<?php

require('../../fpdf/fpdf.php');
/*require('../../bd/databaseServer.php');
require('../../bd/conexionLocal.php');*/
$tipoComida = $_REQUEST["tipoComida"] ?? "";
$persona = $_REQUEST["persona"] ?? "";
$idEmpresa = $_REQUEST["idEmpresa"] ?? "";
$desde = $_REQUEST["desde"] ?? "";
$hasta = $_REQUEST["hasta"] ?? "";
$idHotel = $_REQUEST["idHotel"] ?? "";

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
    $this->Image('../../img/granvia.png', 30, 8, 40, 30, 'PNG');
    
    // Fecha en la esquina derecha con estilo
    $this->SetXY(-60, 10);
    $this->SetFont('Arial', 'B', 10);
    $this->SetTextColor(0, 51, 102);
    $this->Cell(50, 5, 'Hoy: ' . date('d-m-Y'), 0, 0, 'R');
    
    // Contenedor para los filtros
    $this->SetXY(-80, 20);
    $this->SetFillColor(230, 230, 230);
    $this->SetDrawColor(200, 200, 200);
    $this->Cell(70, 6, "Filtros aplicados", 1, 1, 'C', true);
    $this->SetFont('Arial', '', 9);
    $this->SetX(-80);
    $this->Cell(70, 6, "Hotel: " . ($_REQUEST["idHotel"] ?? ""), 1, 1, 'L');
    $this->SetX(-80);
    $this->Cell(70, 6, "Empresa: " . ($_REQUEST["idEmpresa"] ?? ""), 1, 1, 'L');
    $this->SetX(-80);
    $this->Cell(70, 6, "Desde: " . ($_REQUEST["desde"] ?? ""), 1, 1, 'L');
    $this->SetX(-80);
    $this->Cell(70, 6, "Hasta: " . ($_REQUEST["hasta"] ?? ""), 1, 1, 'L');
    $this->SetX(-80);
    $this->Cell(70, 6, "Tipo de Comida: " . ($_REQUEST["tipoComida"] ?? ""), 1, 1, 'L');
    
    // Mover el título a la altura adecuada
    $this->SetY(50);
    $this->SetFont('Arial', 'B', 14);
    $this->SetTextColor(0, 0, 0);
    $this->Cell(0, 8, 'Registro de Comidas Extras', 0, 1, 'C');
    $this->Ln(10);
    
    // Estilo para la tabla
    $this->SetFont('Arial', 'B', 9);
    $this->SetFillColor(51, 122, 183);
    $this->SetTextColor(255, 255, 255);
    $this->SetMargins(25, 20, 20); // Ajuste de margen izquierdo para mover la tabla a la derecha
    $this->SetWidths(array(12, 30, 30, 30, 70, 70, 60));
    $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C']);
    $this->Ln(5);
    $this->Row(['ITEMS', 'HOTEL', 'FECHA', 'HORA', 'COMIDA', 'PERSONA', 'EMPRESA']);
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial', 'B', 8);
    $this->SetTextColor(0, 51, 102);
    $this->Cell(0, 10, 'Historial de Comidas', 0, 0, 'C');
}



}
    $pdf=new PDF('L','mm','Legal');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->SetMargins(20,20,20);






    if ($idHotel=="") {
      include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
      
    
    }
    if ($idHotel==1) {
      include '../../bd/conexionLocal.php'; //incluir el archivo de conexion
      
    
    }
    
    if ($idHotel==2) {
      include '../../bd/conexionLocalh2.php'; //incluir el archivo de conexion
      
    
    }
    if ($idHotel==3) {
      include '../../bd/conexionLocalh3.php'; //incluir el archivo de conexion
      
    
    }
    if ($idHotel==4) {
      include '../../bd/conexionLocalh4.php'; //incluir el archivo de conexion
      
    
    }
    $fecha1 = "3000-01-01";
    
    $whereClauses = [];
    
    if (!empty($idHotel)) {
        if (!empty($tipoComida) && empty($desde) && empty($hasta) && empty($idEmpresa)) {
            $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%'";
        }
        
        if (!empty($idEmpresa) && empty($tipoComida) && empty($desde) && empty($hasta)) {
            $whereClauses[] = "empresa.idEmpresa LIKE '%" . addslashes($idEmpresa) . "%'";
        }
        
        if (!empty($persona) && empty($tipoComida) && empty($idEmpresa)) {
            $whereClauses[] = "comidaextra.persona LIKE '%" . addslashes($persona) . "%'";
        }
        
        if (!empty($desde) && empty($hasta) && empty($idEmpresa)) {
            $whereClauses[] = "comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($fecha1) . "'";
        }
        if (!empty($idHotel) && !empty($desde) && !empty($hasta)) {
            $whereClauses[] = "comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($hasta) . "'";
        }
        
        if (!empty($tipoComida) && !empty($idEmpresa) && !empty($desde) && !empty($hasta)) {
            $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%' AND comidaextra.idEmpresa = '" . addslashes($idEmpresa) . "' AND comidaextra.fechaComida BETWEEN '" . addslashes($desde) . "' AND '" . addslashes($hasta) . "'";
        }
        
        if (!empty($tipoComida) && !empty($idEmpresa) && empty($desde) && empty($hasta)) {
            $whereClauses[] = "comidaextra.tipoComida LIKE '%" . addslashes($tipoComida) . "%' AND comidaextra.idEmpresa = '" . addslashes($idEmpresa) . "'";
        }
    }
    
    $where = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";


$query3 = mysqli_query($con,"SELECT comidaextra.idComidaExtra,comidaextra.fechaComida,comidaextra.horaComida,comidaextra.tipoComida,comidaextra.persona,comidaextra.observacion,comidaextra.idEmpresa,empresa.idEmpresa,
            empresa.nombreEmpresa,comidaextra.idHotel,hotel.idHotel,hotel.nombreHotel     
             FROM comidaextra
             INNER JOIN empresa ON comidaextra.idEmpresa = empresa.idEmpresa
             INNER JOIN hotel ON comidaextra.idHotel = hotel.idHotel $where ORDER by idComidaExtra");



$numfilas = mysqli_num_rows($query3);

for ($i=1; $i<=$numfilas; $i++)
        {             
              $espacio = "";
                $fila = mysqli_fetch_array($query3);
                $pdf->SetFont('Arial','',12);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0);
                $pdf->SetAligns(['C', 'C', 'C','C','C','C','C']);
                $pdf->Row(array($i,$fila['nombreHotel'],$fila['fechaComida'],$fila['horaComida'],$fila['tipoComida'],$fila['persona'],$fila['nombreEmpresa']));
 
         }

      
$pdf->Output();
?>
