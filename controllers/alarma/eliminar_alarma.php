<?php
require_once('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAlarma'])) {
    $idAlarma = $_POST['idAlarma']; 

    // Preparar la consulta SQL para eliminar la alarma
    $stmt = $conexion->prepare("DELETE FROM alarmas WHERE idAlarma = ?");
    $stmt->bind_param("i", $idAlarma); 

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}
?>
