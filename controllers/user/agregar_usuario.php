<?php
require_once('../../config/db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['huella_digital'])) {
    $nombre = $_POST['nombre'];
    $huella_digital = $_POST['huella_digital'];

    // Validar
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'error' => 'El nombre es requerido.']);
        exit;
    }

    // Preparar 
    $nombre = mysqli_real_escape_string($conexion, $nombre); 
    $huella_digital = mysqli_real_escape_string($conexion, $huella_digital);

    //consulta SQL para insertar
    $sql = "INSERT INTO usuarios (nombre, huella_digital) VALUES (?,?)";
    // Preparar
    $stmt = $conexion->prepare($sql);
    // Enlazar los parámetros a la sentencia SQL
    $stmt->bind_param("ss", $nombre, $huella_digital);
    // Ejecutar
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al agregar el usuario.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos o método no permitido.']);
}
?>
