<?php
require_once('../config/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['idAdmin'];
    $correo = $data['correo'];
    $telefono = $data['telefono'];
    $codigo = $data['codigo'];

    $stmt = $conexion->prepare("UPDATE administrador SET correo = ?, telefono_admin = ?, codigo = ? WHERE id = ?");
    $stmt->bind_param('sssi', $correo, $telefono, $codigo, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
