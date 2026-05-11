<?php
// Incluir autoload de Composer
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$archivo = 'ospedaje/reportes_pdf/excel/resumenfegrande.xlsx';

// Verificar que el archivo existe
if (!file_exists($archivo)) {
    die('El archivo Excel no se encuentra en el servidor.');
}

try {
    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($archivo);

    // Seleccionar la primera hoja
    $hoja = $spreadsheet->getActiveSheet();

    // Leer valores de celdas (ejemplo: A1 y B2)
    $valorA1 = $hoja->getCell('A1')->getValue();
    $valorB2 = $hoja->getCell('B2')->getValue();

    echo "Valor en A1: $valorA1 <br>";
    echo "Valor en B2: $valorB2 <br>";

    // Recorrer filas (si necesitas todos los datos)
    foreach ($hoja->getRowIterator() as $fila) {
        $celdaIterator = $fila->getCellIterator();
        $celdaIterator->setIterateOnlyExistingCells(false);

        foreach ($celdaIterator as $celda) {
            echo $celda->getValue() . " | ";
        }
        echo "<br>";
    }

} catch (Exception $e) {
    die('Error al cargar el archivo Excel: ' . $e->getMessage());
}
?>






