<?php
require __DIR__ . "/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 
$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Aquí va el creador, como cadena")
    ->setLastModifiedBy('Parzibyte') // última vez modificado por
    ->setTitle('Mi primer documento creado con PhpSpreadSheet')
    ->setSubject('El asunto')
    ->setDescription('Este documento fue generado para parzibyte.me')
    ->setKeywords('etiquetas o palabras clave separadas por espacios')
    ->setCategory('La categoría');
 
$hoja = $documento->getActiveSheet();
$hoja->setTitle("El título de la hoja");
$hoja->setCellValueByColumnAndRow(1, 1, "Un valor en 1, 1");
$hoja->setCellValue("B2", "Este va en B2");
$hoja->setCellValue("A3", "Parzibyte");
 
$writer = new Xlsx($documento);
 
# Le pasamos la ruta de guardado
$writer->save('ejemplo3.xlsx');