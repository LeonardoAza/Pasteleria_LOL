<?php
//Conexion a la base de datos lol
include 'conexion.php';


$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contra = $_POST['contraseña']; // Usamos la ñ para cachar el dato exacto

// 3. Asignamos los datos automáticos que el cliente no escribe
$rol = "cliente"; 
$fecha = date("Y-m-d H:i:s"); // Captura la fecha y hora actual de la computadora

// 4. Preparamos la orden SQL con los nombres EXACTOS de tus columnas
$sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol, fecha_registro) 
        VALUES ('$nombre', '$correo', '$contra', '$rol', '$fecha')";

// 5. Ejecutamos la orden y revisamos si todo salió bien
if ($conexion->query($sql) === TRUE) {
    echo "<h1>¡Éxito!</h1>";
    echo "<p>El usuario <b>$nombre</b> ha sido registrado correctamente en la base de datos.</p>";
    echo "<a href='registro.php'>Volver al registro</a>";
} else {
    echo "Error al registrar: " . $conexion->error;
}
?>