<?php
require_once('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['cedula'], $_POST['celular'])) {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $celular = $_POST['celular'];

    // Validar campos
    if (empty($nombre) || empty($cedula) || empty($celular)) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son requeridos.']);
        exit;
    }

    // Preparar campos para evitar inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $cedula = mysqli_real_escape_string($conexion, $cedula);
    $celular = mysqli_real_escape_string($conexion, $celular);

    // Obtener la huella digital de la tabla huellas_temporales
    $sql_huella = "SELECT idHuella FROM huellas_temporales LIMIT 1";
    $result_huella = $conexion->query($sql_huella);

    if ($result_huella->num_rows > 0) {
        $row_huella = $result_huella->fetch_assoc();
        $huella_digital = $row_huella['idHuella'];

        // Preparar la consulta SQL para insertar el nuevo usuario
        $sql_insert = "INSERT INTO usuarios (nombre, huella_digital, cedula, celular) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $nombre, $huella_digital, $cedula, $celular);

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
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido o datos incompletos.']);
}
$conexion->close();
?>