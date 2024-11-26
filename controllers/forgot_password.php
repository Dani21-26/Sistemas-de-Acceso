
<?php
header('Content-Type: application/json');

require_once('../config/db.php');

// Verificar que el método sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener el correo enviado
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

// Validar que el correo no esté vacío
if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'El correo es obligatorio.']);
    exit;
}

// Verificar si el correo existe en la tabla del administrador
$sql = "SELECT * FROM administrador WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si el correo existe, enviar un mensaje de recuperación (simulado)
    $admin = $result->fetch_assoc();
    $recoveryMessage = "Hola, tu contraseña actual es: " . $admin['contraseña']; // En producción, usa tokens seguros.
    // Aquí puedes implementar el envío de correo real.

    echo json_encode(['success' => true, 'message' => $recoveryMessage]);
} else {
    echo json_encode(['success' => false, 'message' => 'El correo no está registrado.']);
}

$stmt->close();
$conexion->close();
