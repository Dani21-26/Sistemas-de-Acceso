<?php

require_once('../../config/db.php');

function actualizarUsuario($conexion, $idUsuario, $nombre, $huellaDigital) {
    $sql = "UPDATE usuarios SET nombre =?, huella_digital =? WHERE idUsuario =?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sis", $nombre, $huellaDigital, $idUsuario); 
    $resultado = $stmt->execute();
    if ($resultado) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_POST['id'];
    $nombre = $_POST['nombre'];
    $huellaDigital = file_get_contents('ruta/a/la/huella_digital.bin'); 

    // Realiza la actualización del usuario en la base de datos
    if (actualizarUsuario($conexion, $idUsuario, $nombre, $huellaDigital)) {
        echo "Usuario actualizado con éxito.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

