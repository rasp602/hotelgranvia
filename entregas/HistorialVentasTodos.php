<?php
require('fpdf/fpdf.php');
require('bd/conexionLocal.php');
date_default_timezone_set("America/Santiago");
session_start();
$usuario = $_SESSION['usuario'];

class PDF extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function Row($data)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        $this->CheckPageBreak($h);
        for ($i = 0; $i < count($data); $i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $data[$i], 0, $a, 'true');
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb)
        {
            $c = $s[$i];
            if ($c == "\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax)
            {
                if ($sep == -1)
                {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
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
        $this->Image('img/ventas.png', 30, 8, 40, 30, 'PNG');
        $this->Cell(25, 50, '', 0);

        $this->SetFont('Arial', '', 9);
        $this->Cell(130, 8, '', 0);
        $this->Cell(50, 2, 'FECHA: ' . date('d-m-Y'), 0);
        $this->Ln(10);
        $this->Cell(150, 10, '', 0);
        $this->Ln(7);
        $this->Cell(150, 10, ' ', 0);
        $this->Ln(2);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(130, 8, '', 0);
        $this->Cell(150, 8, 'REGISTRO DE VENTAS TODOS', 0);
        $this->Ln(5);
        $this->Cell(150, 10, ' ', 0);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetMargins(10, 20, 20);

        $this->Ln(5);

        $this->SetWidths(array(12, 30, 20, 60, 20, 60, 60, 60));
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(51, 122, 183);
        $this->SetTextColor(255, 255, 255);
        $this->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);

        for ($i = 0; $i < 1; $i++)
        {
            $this->Row(array('#', 'Fecha', 'Hora', 'Usuario', 'Tipo Pago', 'Total Venta', 'Ganancia Garzon','Ganacia Restante'));
        }
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 10, ' ', 0);
        $this->Cell(150, 10, 'Historial de Ventas', 0, 0, 'L');
    }

    function AddSummaryTables($totalEfectivo, $gananciaEfectivo, $totalTransbank, $gananciaTransbank)
    {
        $this->Ln(10); // Add some space before the summary tables
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);

        // Draw the summary table for Efectivo
        $this->SetWidths(array(80, 40));
        $this->SetAligns(['L', 'R']);
        
        $this->Cell(80, 10, 'Tipo de Pago', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Total', 1, 1, 'C', true);

        $this->Cell(80, 10, 'Efectivo', 1);
        $this->Cell(40, 10, '$' . number_format($totalEfectivo, 0), 1, 1, 'R');
        
        $this->Cell(80, 10, 'Ganancia Restante Efectivo', 1);
        $this->Cell(40, 10, '$' . number_format($gananciaEfectivo, 0), 1, 1, 'R');
        
        $this->Ln(5); // Space between tables

        // Draw the summary table for Transbank
        $this->SetWidths(array(80, 40));
        $this->SetAligns(['L', 'R']);
        
        $this->Cell(80, 10, 'Tipo de Pago', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Total', 1, 1, 'C', true);

        $this->Cell(80, 10, 'Transbank', 1);
        $this->Cell(40, 10, '$' . number_format($totalTransbank, 0), 1, 1, 'R');
        
        $this->Cell(80, 10, 'Ganancia Restante Transbank', 1);
        $this->Cell(40, 10, '$' . number_format($gananciaTransbank, 0), 1, 1, 'R');
    }
}

$pdf = new PDF('L', 'mm', 'Legal');
$pdf->Open();
$pdf->AddPage();
$pdf->SetMargins(10, 20, 20);

$fechaInicio = Date('0000-00-00');
$fechaFin = Date('3000-01-01');

$where = "";

$fecha1 = Date('3000-01-01');

$query3 = mysqli_query($con, "SELECT ventas.id,ventas.fecha,ventas.total,ventas.idUsuario,ventas.idCliente,ventas.tipoPago,ventas.gananciaG,usuarios.idUsuario,usuarios.nombre,usuarios.usuario FROM ventas
 INNER JOIN usuarios ON usuarios.idUsuario=ventas.idUsuario 

ORDER by id DESC");

$numfilas = mysqli_num_rows($query3);

// Initialize totals
$totalSum = 0;
$gananciaSum = 0;
$totalEfectivo = 0;
$gananciaEfectivo = 0;
$totalTransbank = 0;
$gananciaTransbank = 0;

for ($i = 1; $i <= $numfilas; $i++)
{
    $fila = mysqli_fetch_array($query3);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);

    // Extract and format date and time
    $fechaCompleta = new DateTime($fila['fecha']);
    $fecha = $fechaCompleta->format('d-m-Y');
    $hora = $fechaCompleta->format('H:i');

    // Translate payment type
    $tipoPago = '';
    if ($fila['tipoPago'] == 'E') {
        $tipoPago = 'Efectivo';
        $totalEfectivo += $fila['total'];
        $gananciaEfectivo += $fila['total'] - $fila['gananciaG'];
    } elseif ($fila['tipoPago'] == 'T') {
        $tipoPago = 'Transbank';
        $totalTransbank += $fila['total'];
        $gananciaTransbank += $fila['total'] - $fila['gananciaG'];
    }
    
    $gananciaRestante = $fila['total'] - $fila['gananciaG'];

    $pdf->Row(array($i, $fecha, $hora, $fila['nombre'], $tipoPago, '$' . number_format($fila['total'], 0), '$' . number_format($fila['gananciaG'], 0), '$' . number_format($gananciaRestante, 0)));

    // Accumulate totals
    $totalSum += $fila['total'];
    $gananciaSum += $fila['gananciaG'];

    $totalRestante = $totalSum - $gananciaSum;
}

// Add totals row
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->SetTextColor(0);
$pdf->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);
$pdf->Row(array('', '', '', '', 'Total', '$' . number_format($totalSum, 0), '$' . number_format($gananciaSum, 0), '$' . number_format($totalRestante, 0)));

// Add summary tables
$pdf->AddSummaryTables($totalEfectivo, $gananciaEfectivo, $totalTransbank, $gananciaTransbank);

$pdf->Output();
?>

