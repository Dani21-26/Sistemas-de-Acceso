<?php
require_once('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];

    // Validar el nombre
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'error' => 'El nombre es requerido.']);
        exit;
    }

    // Preparar el nombre para evitar inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);

    // Obtener la huella digital de la tabla huellas_temporales
    $sql_huella = "SELECT idHuella FROM huellas_temporales LIMIT 1";
    $result_huella = $conexion->query($sql_huella);

    if ($result_huella->num_rows > 0) {
        $row_huella = $result_huella->fetch_assoc();
        $huella_digital = $row_huella['idHuella'];

        // Preparar la consulta SQL para insertar el nuevo usuario
        $sql_insert = "INSERT INTO usuarios (nombre, huella_digital) VALUES (?, ?)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $nombre, $huella_digital);

        // Ejecutar la consulta de inserción
        if ($stmt_insert->execute()) {
            // Eliminar la huella digital de la tabla huellas_temporales
            $sql_delete = "DELETE FROM huellas_temporales WHERE idHuella = ?";
            $stmt_delete = $conexion->prepare($sql_delete);
            $stmt_delete->bind_param("s", $huella_digital);
            $stmt_delete->execute();
            $stmt_delete->close();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al agregar el usuario.']);
        }
        $stmt_insert->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'No hay huellas disponibles en huellas_temporales.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos o método no permitido.']);
}
?>
