<?php
// Incluir el archivo de conexión
require_once('./config/db.php');

// Verificar que se ha recibido el idHuella
if (!isset($_POST['idHuella'])) {
    die(json_encode(["success" => false, "error" => "Datos incompletos."]));
}

// Obtener el idHuella del POST
$idHuella = $_POST['idHuella'];

// Almacenar el idHuella temporalmente en una tabla separada
$sql = "INSERT INTO huellas_temporales (idHuella) VALUES (?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idHuella);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
