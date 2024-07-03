<?php
$servername = "localhost";
$database = "";
$username = "id22363861_sistemadeaccesogrupo2";
$password = "Maderadia22*";

// Crear conexión
$conexion = mysqli_connect($servername, $username, $password, $database);

// Comprobar conexión
if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_errno);
}
?>
