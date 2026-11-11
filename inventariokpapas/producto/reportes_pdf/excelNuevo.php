<?php
require_once 'vendor/autoload.php';
include('mysql.php');

$mes = $_GET['mes'];

// Consultar el último día del mes para obtener el número de días
$sql = "SELECT RIGHT(LAST_DAY('". $mes ."'),2) dias;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$num_days = $row['dias'];

$datos_productos = [];
$total_existencias = 0;

// Consultar datos de la tabla producto
$sql = "SELECT producto.idProducto, producto.nombreProducto, producto.existenciaProducto, producto.idTipoProducto,tipoProducto.nombreTipoProducto 

FROM producto 
INNER JOIN tipoProducto ON producto.idTipoProducto=tipoProducto.idTipoProducto

ORDER BY producto.idProducto ASC;";


if ($result = mysqli_query($conn, $sql)) {   
    while ($row = mysqli_fetch_assoc($result)) {
        $idProducto = $row['idProducto'];
        $nombreProducto = $row['nombreProducto'];
        $existenciaProducto = $row['existenciaProducto'];
        $idTipoProducto = $row['idTipoProducto'];
        $nombreTipoProducto = $row['nombreTipoProducto'];

        $datos_productos[$idProducto] = [
            'nombre' => $nombreProducto,
            'existencia' => $existenciaProducto,
            'tipo' => $nombreTipoProducto,
            'movimientos' => array_fill(1, $num_days, ['I' => 0, 'E' => 0]) // Inicializar movimientos
        ];
        
        // Consultar las sumas de ingreso y egreso por día para el producto
        $sql_movimientos = "
            SELECT DAY(fechaRegistro) as dia, tipoRegistro, SUM(cantRegistro) as total
            FROM inventario
            WHERE idProducto = $idProducto AND MONTH(fechaRegistro) = MONTH('$mes') AND YEAR(fechaRegistro) = YEAR('$mes')
            GROUP BY DAY(fechaRegistro), tipoRegistro";
        
        $result_movimientos = mysqli_query($conn, $sql_movimientos);
        
        while ($row_mov = mysqli_fetch_assoc($result_movimientos)) {
            $dia = $row_mov['dia'];
            $tipo = $row_mov['tipoRegistro'];
            $datos_productos[$idProducto]['movimientos'][$dia][$tipo] = $row_mov['total'];
        }

        $total_existencias += $existenciaProducto;
    }
}

use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use \PhpOffice\PhpSpreadsheet\Style\Fill;

// Crear un nuevo archivo de Excel
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Estilos comunes
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],
];

// Generar encabezados de las columnas
$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'Producto');
$sheet->setCellValue('C1', 'Existencia');
$sheet->setCellValue('D1', 'Tipo de Producto');

// Generar encabezados de los días del mes con columnas Ingreso y Egreso
$columna = 5; // 'E' corresponde a la columna 5
for ($i = 1; $i <= $num_days; $i++) {
    $col_stock = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columna);
    $col_ingreso = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columna + 1);
    $col_egreso = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columna + 2);

    $sheet->mergeCells($col_stock . '1:' . $col_egreso . '1');
    $sheet->setCellValue($col_stock . '1', $i);
    $sheet->getStyle($col_stock . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue($col_stock . '2', 'Stock');
    $sheet->setCellValue($col_ingreso . '2', 'Ingreso');
    $sheet->setCellValue($col_egreso . '2', 'Egreso');

    // Colores
    $sheet->getStyle($col_ingreso . '2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');
    $sheet->getStyle($col_egreso . '2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF6347');

    // Bordes
    $sheet->getStyle($col_stock . '1:' . $col_egreso . '2')->applyFromArray($styleArray);

    $columna += 3;
}

// Llenar los datos de productos en las filas correspondientes
$fila = 3;
foreach ($datos_productos as $idProducto => $producto) {
    $sheet->setCellValue('A' . $fila, $fila - 2); // Númeración
    $sheet->setCellValue('B' . $fila, $producto['nombre']);
    $sheet->setCellValue('C' . $fila, $producto['existencia']);
    $sheet->setCellValue('D' . $fila, $producto['tipo']);

    // Aplicar bordes a la fila de producto
    $sheet->getStyle("A$fila:D$fila")->applyFromArray($styleArray);

    // Llenar los movimientos por día
    $columna = 5; // 'E' corresponde a la columna 5
    $columna = 5;
    $stock_diario = $producto['existencia']; // Partimos del stock actual
    
    // Vamos hacia atrás en el tiempo: necesitamos reconstruir el stock desde el día 1 hasta hoy
    // Así que primero calculamos al revés: retrocedemos los movimientos
    for ($d = $num_days; $d >= 1; $d--) {
        $ingreso = $producto['movimientos'][$d]['I'] ?? 0;
        $egreso = $producto['movimientos'][$d]['E'] ?? 0;
        $stock_diario -= $ingreso;
        $stock_diario += $egreso;
    }
    
    // Ahora que tenemos el stock inicial estimado del día 1, volvemos a avanzar y llenamos cada fila
    for ($i = 1; $i <= $num_days; $i++) {
        $ingreso = $producto['movimientos'][$i]['I'] ?? 0;
        $egreso = $producto['movimientos'][$i]['E'] ?? 0;
    
        $col_stock = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columna);
        $col_ingreso = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columna + 1);
        $col_egreso = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columna + 2);
    
        // Escribimos stock antes de modificarlo con los movimientos del día
        $sheet->setCellValue($col_stock . $fila, $stock_diario);
        $sheet->setCellValue($col_ingreso . $fila, $ingreso);
        $sheet->setCellValue($col_egreso . $fila, $egreso);
    
        // Colores y bordes
        $sheet->getStyle($col_ingreso . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('90EE90');
        $sheet->getStyle($col_egreso . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF6347');
        $sheet->getStyle($col_stock . $fila . ':' . $col_egreso . $fila)->applyFromArray($styleArray);
    
        // Actualizar stock para el día siguiente
        $stock_diario += $ingreso;
        $stock_diario -= $egreso;
    
        $columna += 3;
    }
    
    $fila++;
}

// Total de existencias al final
$sheet->setCellValue('C' . $fila, 'Total');
$sheet->setCellValue('D' . $fila, $total_existencias);
$sheet->getStyle("C$fila:D$fila")->applyFromArray($styleArray);

// Descargar el archivo
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$filename = 'Inventario_' . date('Y-m-d_H-i-s') . '.xlsx';
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();

?>
