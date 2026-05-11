<?php
// Conexión a la base de datos (ajusta los valores según tu configuración)
$servername = "190.101.222.6";
$username = "hotel";
$password = "chile2023$";
$dbname = "hoteleria";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener personas desde la tabla 'persona' con filtro de búsqueda
$query = "SELECT idPersona, nombresPersona FROM persona WHERE nombresPersona LIKE ?";

// Preparar la declaración
$stmt = $conn->prepare($query);

// Vincular el parámetro de búsqueda
$searchTerm = '%' . $_GET['q'] . '%';
$stmt->bind_param('s', $searchTerm);

// Ejecutar la consulta
$stmt->execute();

// Obtener resultados
$result = $stmt->get_result();

// Construir las opciones del ComboBox
$options = [];
while ($row = $result->fetch_assoc()) {
    $options[] = [
        'id' => $row['idPersona'],
        'text' => $row['nombresPersona']
    ];
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();

// Devolver las opciones al script.js en formato JSON
echo json_encode($options);
?>