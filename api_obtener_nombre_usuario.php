<?php
header('Content-Type: application/json');

// Obtener el ID de la huella del parámetro GET
$idHuella = $_GET['idHuella'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acceso";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener el nombre del usuario
$sql = "SELECT nombre FROM usuarios WHERE huella_digital = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idHuella);
$stmt->execute();
$result = $stmt->get_result();

$response = array();

if ($row = $result->fetch_assoc()) {
    $response['nombre'] = $row['nombre'];
} else {
    $response['nombre'] = "";
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
