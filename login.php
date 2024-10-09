<?php
session_start();

header('Content-Type: application/json'); // Asegurarte de que la respuesta sea JSON

include './config/db.php';

// Verificar que el método de la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $password = $data['password'];

    // Consulta a la base de datos
    $sql = "SELECT * FROM administrador WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['contraseña']) {
            $_SESSION['usuario'] = $user['id'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }

    $stmt->close();
    $conexion->close();
} else {
    // Manejar el método no permitido
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
