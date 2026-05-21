<?php
$servidor = "localhost";
$usuario = "root";       
$contrasena = "";        
$base_datos = "pasteleria_lol"; 

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Si hay un error, nos va a avisar
if ($conexion->connect_error) {
    die("Error al conectar: " . $conexion->connect_error);
}

// Si llega hasta aquí, imprimirá esto en tu pantalla:
echo "¡Felicidades! La conexión a la base de datos pasteleria_lol fue un ÉXITO. 😎";
?>