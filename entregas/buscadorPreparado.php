<?php
require "bd/conexionHost.php";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $searchTerm = $_GET['searchTerm'] ?? '';

    // Consulta SQL para buscar productos similares
    $stmt = $pdo->prepare("SELECT idProductoPreparado, nombreProducto,imagenProducto FROM producto_prepa WHERE nombreProducto LIKE :term OR idProductoPreparado LIKE :term LIMIT 10");
    $stmt->execute(['term' => '%' . $searchTerm . '%']);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
