<?php
$dsn = 'mysql:host=190.101.222.6;dbname=hoteleria';
$username = 'hotel';
$password = 'chile2023$';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $searchTerm = $_GET['searchTerm'] ?? '';

    // Consulta SQL para buscar productos similares
    $stmt = $pdo->prepare("SELECT idProducto, nombreProducto,codigoBarra FROM producto WHERE nombreProducto LIKE :term OR idProducto LIKE :term LIMIT 10");
    $stmt->execute(['term' => '%' . $searchTerm . '%']);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
