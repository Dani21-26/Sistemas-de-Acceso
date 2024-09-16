<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "acceso";

// Crear conexión
$conexion = mysqli_connect($servername, $username, $password, $database);

// Comprobar conexión
if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_errno);
}
