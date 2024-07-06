<?php
// Conexión a la base de datos
$servername = "localhost";
$database = "acceso";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la huella
$idHuella = $_GET['idHuella'];

$response = array();

if ($idHuella) {
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT idUsuario, nombre FROM usuarios WHERE huella_digital = ?");
    $stmt->bind_param("i", $idHuella);
    $stmt->execute();
    $stmt->bind_result($idUsuario, $nombre);

    if ($stmt->fetch()) {
        $response['idUsuario'] = $idUsuario;
        $response['nombre'] = $nombre;
    } else {
        $response['error'] = "Usuario no encontrado";
    }

    $stmt->close();
} else {
    $response['error'] = "idHuella no proporcionado";
}

$conn->close();

echo json_encode($response);
?>
