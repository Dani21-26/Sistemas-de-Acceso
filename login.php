<?php
include './config/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM administrador WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($password === $user['contraseña']) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
}

$stmt->close();
$conexion->close();
?>
