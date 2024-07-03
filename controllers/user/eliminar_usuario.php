<?php
require_once('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];

    // Iniciar una transacción
    $conexion->begin_transaction();

    try {
        // Preparar la consulta SQL para eliminar las entradas en acceso_de_user
        $stmt1 = $conexion->prepare("DELETE FROM acceso_de_user WHERE idUsuario = ?");
        if (!$stmt1) {
            throw new Exception("Error en la preparación de la consulta para eliminar de acceso_de_user: " . $conexion->error);
        }
        $stmt1->bind_param("i", $idUsuario);
        if (!$stmt1->execute()) {
            throw new Exception("Error al ejecutar la consulta para eliminar de acceso_de_user: " . $stmt1->error);
        }
        $stmt1->close();

        // Preparar la consulta SQL para eliminar el usuario de la tabla usuarios
        $stmt2 = $conexion->prepare("DELETE FROM usuarios WHERE idUsuario = ?");
        if (!$stmt2) {
            throw new Exception("Error en la preparación de la consulta para eliminar de usuarios: " . $conexion->error);
        }
        $stmt2->bind_param("i", $idUsuario);
        if (!$stmt2->execute()) {
            throw new Exception("Error al ejecutar la consulta para eliminar de usuarios: " . $stmt2->error);
        }
        $stmt2->close();

        // Confirmar la transacción
        $conexion->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Si algo falla, revertir la transacción
        $conexion->rollback();

        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
