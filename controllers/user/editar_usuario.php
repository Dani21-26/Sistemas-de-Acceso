<?php
header('Content-Type: application/json');


include_once '../../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['idUsuario']) && isset($data['nombre']) && isset($data['cedula']) && isset($data['celular'])) {
    $idUsuario = $data['idUsuario'];
    $nombre = $data['nombre'];
    $cedula = $data['cedula'];
    $celular = $data['celular'];

    // Actualizar los datos del usuario en la base de datos
    $query = "UPDATE usuarios SET nombre = ?, cedula = ?, celular = ? WHERE idUsuario = ?";
    if ($stmt = mysqli_prepare($conexion, $query)) {
        mysqli_stmt_bind_param($stmt, "sssi", $nombre, $cedula, $celular, $idUsuario);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "No se pudo actualizar el usuario"]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

mysqli_close($conexion);
