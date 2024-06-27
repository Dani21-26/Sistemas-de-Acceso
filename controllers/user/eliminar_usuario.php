<?php
require_once('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];

    // Preparar la consulta SQL para eliminar el usuario
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE idUsuario = ?");
    $stmt->bind_param("i", $idUsuario);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}
?>
