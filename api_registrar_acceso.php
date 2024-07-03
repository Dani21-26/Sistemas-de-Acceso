<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acceso";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos de acceso
$idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : '';
$tipo_acceso = isset($_POST['tipo_acceso']) ? $_POST['tipo_acceso'] : '';

$response = array();

if ($idUsuario && $tipo_acceso) {
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO acceso_de_user (idUsuario, tipo_acceso) VALUES (?, ?)");
    $stmt->bind_param("is", $idUsuario, $tipo_acceso);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = $stmt->error;
    }

    $stmt->close();
} else {
    $response['error'] = "idUsuario o tipo_acceso no proporcionado";
}

$conn->close();

echo json_encode($response);
?>
