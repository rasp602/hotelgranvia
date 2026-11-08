<?php
require "bd/conexionHost.php";

header('Content-Type: application/json; charset=utf-8');

function obtenerRutaImagenProducto($idProducto) {
    // Ruta física para comprobar si existe el archivo
    $rutaBaseFisica = dirname(__DIR__) . "../../hotelgranvia/img/productos/";

    // Ruta web para mostrar en el navegador
    $rutaBaseWeb = "../../hotelgranvia/img/productos/";

    $extensiones = ['jpg', 'png', 'jpeg', 'webp', 'JPG', 'PNG', 'JPEG', 'WEBP'];

    foreach ($extensiones as $ext) {
        $archivoFisico = $rutaBaseFisica . $idProducto . "." . $ext;
        if (file_exists($archivoFisico)) {
            return $rutaBaseWeb . $idProducto . "." . $ext;
        }
    }

    return "../../hotelgranvia/img/product.png";
}

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $searchTerm = isset($_GET['searchTerm']) ? trim($_GET['searchTerm']) : '';

    $sql = "SELECT idProducto, nombreProducto, codigoBarra, existenciaProducto
            FROM producto";

    $params = [];

    if ($searchTerm !== '') {
        $sql .= " WHERE nombreProducto LIKE :term
                  OR codigoBarra LIKE :term
                  OR idProducto LIKE :term";
        $params['term'] = '%' . $searchTerm . '%';
    }

    $sql .= " ORDER BY nombreProducto ASC LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $salida = [];

    foreach ($results as $item) {
        $salida[] = [
            'idProducto' => $item['idProducto'],
            'codigoBarra' => $item['codigoBarra'],
            'nombreProducto' => $item['nombreProducto'],
            'existenciaProducto' => (int)$item['existenciaProducto'],
            'imagen' => obtenerRutaImagenProducto($item['idProducto']),
            'text' => $item['nombreProducto'] . ' | Stock: ' . (int)$item['existenciaProducto']
        ];
    }

    echo json_encode($salida);

} catch (PDOException $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Error al buscar productos: ' . $e->getMessage()
    ]);
}
?>