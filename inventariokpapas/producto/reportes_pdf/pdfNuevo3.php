<?php 
require_once 'vendor/autoload.php';
include('mysql.php');

$css = file_get_contents('style.css');
$mes = $_GET['mes'];

// Consultar el último día del mes para obtener el número de días
$sql = "SELECT RIGHT(LAST_DAY('". $mes ."'),2) dias;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$num_days = $row['dias'];

$dias_html = '';
$datos_productos_html = '';
$total_existencias = 0;

// Consultar datos de la tabla producto
$sql = "SELECT idProducto, nombreProducto, existenciaProducto, idTipoProducto FROM producto ORDER BY idProducto ASC;";
if ($result = mysqli_query($conn, $sql)) {   
    $con = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $idProducto = $row['idProducto'];
        $nombreProducto = $row['nombreProducto'];
        $existenciaProducto = $row['existenciaProducto'];
        $idTipoProducto = $row['idTipoProducto'];

        $datos_productos_html .= '
            <tr>
                <td class="t-center">' . $con . '</td>
                <td class="t-left">' . $nombreProducto . '</td>
                <td class="t-center">' . $existenciaProducto . '</td>
                <td class="t-center">' . $idTipoProducto . '</td>';
        
        // Consultar las sumas de ingreso y egreso por día para el producto
        $sql_movimientos = "
            SELECT DAY(fechaRegistro) as dia, tipoRegistro, SUM(cantRegistro) as total
            FROM inventario
            WHERE idProducto = $idProducto AND MONTH(fechaRegistro) = MONTH('$mes') AND YEAR(fechaRegistro) = YEAR('$mes')
            GROUP BY DAY(fechaRegistro), tipoRegistro";
        
        $result_movimientos = mysqli_query($conn, $sql_movimientos);
        
        // Crear un arreglo para almacenar los valores de ingreso y egreso por cada día
        $movimientos_dia = array_fill(1, $num_days, ['I' => 0, 'E' => 0]);

        while ($row_mov = mysqli_fetch_assoc($result_movimientos)) {
            $dia = $row_mov['dia'];
            $tipo = $row_mov['tipoRegistro'];
            $movimientos_dia[$dia][$tipo] = $row_mov['total'];
        }

        // Generar las celdas para cada día con ingreso y egreso
        for ($i = 1; $i <= $num_days; $i++) {
            $ingreso = $movimientos_dia[$i]['I'];
            $egreso = $movimientos_dia[$i]['E'];
            $datos_productos_html .= '<td class="t-center">' . $ingreso . '</td>';
            $datos_productos_html .= '<td class="t-center">' . $egreso . '</td>';
        }

        $datos_productos_html .= '</tr>';
        $con++;
        $total_existencias += $existenciaProducto;
    }
}

// Generar encabezados de los días del mes con columnas Ingreso y Egreso
$new_date = substr($mes, 0, -2); 
for ($i = 1; $i <= $num_days; $i++) {
    $dias_html .= '<th class="t-center" colspan="2">' . $i . '</th>';
}
$dias_html .= '<th class="t-center">TOTAL</th>';

// Subencabezado de Ingreso y Egreso para cada día
$dias_subhtml = '';
for ($i = 1; $i <= $num_days; $i++) {
    $dias_subhtml .= '<th class="t-center">Ingreso</th><th class="t-center">Egreso</th>';
}
$dias_subhtml .= '<th class="t-center"></th>';

// Obtener el nombre del mes en texto
$sql = "SELECT CONCAT(ELT(MONTH('". $mes ."'), 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE')) AS MesName;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$MesName = $row['MesName'];

// Generar el contenido del PDF
$inventario = '
<body>
    <h1>INVENTARIO</h1>
    <h3>Inventario de ' . $MesName . '</h3> 

    <table cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Existencia</th>
                <th>Tipo de Producto</th>
                ' . $dias_html . '
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                ' . $dias_subhtml . '
            </tr>
        </thead>
        <tbody>
            ' . $datos_productos_html . '
            <tr>
                <td class="t-center" colspan="3">Total</td>
                <td class="t-center">' . $total_existencias . '</td>
            </tr>
        </tbody>
    </table>
</body>';

// Generar el PDF
mysqli_close($conn);
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);
$inventario = mb_convert_encoding($inventario, 'UTF-8', 'UTF-8');
$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->writeHtml($inventario, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();
?>
