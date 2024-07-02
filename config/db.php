<?php
$servername = "localhost";
$database = "acceso";
$username = "root";
$password = "";

// Crear conexión
$conexion = mysqli_connect($servername, $username, $password, $database);

// Comprobar conexión
if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_errno);
}
?>
