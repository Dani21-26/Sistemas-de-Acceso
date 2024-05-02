<?php
$servername = "localhost";
$database = "acceso";
$username = "root";
$password = "123";

//creamos conecion
$conexion = mysqli_connect($servername,  $username, $password, $database);
//comprovamos que la conexion fue exitosa
if($conexion->connect_errno){
    die("coneccion Erronea-Error en la conexion: ".$conexion->connect_errno);
}


?>