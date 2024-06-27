<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $huella_digital = $_POST['huella_digital'];

    if (empty($nombre) || empty($huella_digital)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    $sql = $conexion->prepare("INSERT INTO usuarios (nombre, huella_digital) VALUES (?, ?)");
    $sql->bind_param('ss', $nombre, $huella_digital);

    if ($sql->execute()) {
        echo json_encode(['success' => true, 'message' => 'Usuario agregado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el usuario.']);
    }

    $sql->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}
?>