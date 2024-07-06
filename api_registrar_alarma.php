<?php
// Conexión a la base de datos
$servername = "localhost";
$database = "acceso";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la descripción de la alarma
$descripcion = $_POST['descripcion'];

// Preparar y ejecutar la consulta
$stmt = $conn->prepare("INSERT INTO alarmas (descripcion) VALUES (?)");
$stmt->bind_param("s", $descripcion);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
