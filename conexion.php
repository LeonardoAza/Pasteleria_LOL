<?php
$servidor = "localhost";
$usuario = "root";       
$contrasena = "";        
$base_datos = "pasteleria_lol"; 

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// si hay un error nos avisa
if ($conexion->connect_error) {
    die("Error al conectar: " . $conexion->connect_error);
}



?>