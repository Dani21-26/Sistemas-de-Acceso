<?php
require_once('../config/db.php');
header('Content-Type: application/json');

session_start(); // Inicia la sesión para acceder a $_SESSION

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer los datos enviados desde el cliente
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['password']) || empty($data['password'])) {
        echo json_encode(['success' => false, 'message' => 'Contraseña no proporcionada']);
        exit;
    }

    $password = $data['password'];

    // Verificar si el ID del administrador está en la sesión
    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(['success' => false, 'message' => 'ID de administrador no encontrado en la sesión']);
        exit;
    }

    $adminId = $_SESSION['admin_id']; // Obtiene el ID del administrador de la sesión

    // Consulta para obtener la contraseña del administrador
    $stmt = $conexion->prepare("SELECT contraseña FROM administrador WHERE id = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $stmt->bind_result($storedPassword);

    if ($stmt->fetch()) {
        // Comparar directamente las contraseñas
        if ($password === $storedPassword) {
            echo json_encode(['success' => true, 'message' => 'Contraseña correcta']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Administrador no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

$conexion->close();
