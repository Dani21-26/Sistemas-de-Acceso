<?php
// Verificar si se recibieron los datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuración de conexión a la base de datos (debes ajustar esto según tu configuración)
    require_once('../../config/db.php');

    // Obtener los datos del formulario de edición
    $idUsuario = $_POST['editIdUsuario'];
    $nombre = $_POST['editNombre'];
    $cedula = $_POST['editCedula'];
    $celular = $_POST['editCelular'];

    // Preparar la consulta SQL para actualizar el usuario
    $sql = "UPDATE usuarios SET nombre = ?, cedula = ?, celular = ? WHERE idUsuario = ?";
    $stmt = $conexion->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta']);
        exit();
    }

    // Vincular los parámetros a la consulta preparada
    $stmt->bind_param("sssi", $nombre, $cedula, $celular, $idUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Éxito al actualizar
        echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado correctamente']);
    } else {
        // Error al actualizar
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el usuario']);
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();
} else {
    // Si no es una solicitud POST, retornar error
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>
