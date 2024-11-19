<?php
session_start();

header('Content-Type: application/json'); // Respuesta en formato JSON

include './config/db.php';

// Verificar que el método de la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Código HTTP: Método no permitido
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$telefono = $data['telefono'] ?? '';
$codigo = $data['codigo'] ?? '';

// Validar campos comunes
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

// Verificar si la tabla está vacía (modo "Registrar Admin")
$sql_check = "SELECT COUNT(*) AS total FROM administrador";
$result_check = $conexion->query($sql_check);
$isEmpty = $result_check->fetch_assoc()['total'] == 0;

// Lógica de registro
if ($isEmpty) {
    if (empty($telefono) || empty($codigo)) {
        echo json_encode(['success' => false, 'message' => 'El teléfono y el código único son obligatorios para registrar.']);
        exit;
    }

    // Registrar el nuevo administrador
    $sql_register = "INSERT INTO administrador (correo, contraseña, telefono_admin, codigo) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_register);
    $stmt->bind_param("ssss", $username, $password, $telefono, $codigo); // En producción, cifra la contraseña con password_hash
    $success = $stmt->execute();

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Administrador registrado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el administrador.']);
    }

    $stmt->close();
    $conexion->close();
    exit;
}

// Lógica de inicio de sesión (si ya existe al menos un administrador)
$sql = "SELECT * FROM administrador WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($password === $user['contraseña']) { // Cambia por password_verify si usas contraseñas cifradas
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
