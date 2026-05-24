<?php
session_start();
include 'conexion.php';

// Protección extra por si intentan entrar directo al procesar sin ser admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// Recibimos los datos con los names del HTML
$nombre = $_POST['nombre_pastel'];
$descripcion = $_POST['descripcion_pastel'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_POST['imagen'];

// Preparamos la consulta SQL con tus columnas exactas
$sql = "INSERT INTO productos (nombre_pastel, descripción_pastel, precio, imagen, stock) 
        VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$stock')";

// Ejecutamos y revisamos si se guardó
if ($conexion->query($sql) === TRUE) {
    echo "<h1>¡Pastel Agregado!</h1>";
    echo "<p>El pastel <b>$nombre</b> se registró correctamente en el inventario.</p>";
    echo "<a href='agregar_producto.php'>Agregar otro pastel</a> o <a href='bienvenido.php'>Ir al inicio</a>";
} else {
    echo "Error al guardar el producto: " . $conexion->error;
}
?>