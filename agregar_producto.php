<?php
session_start();

// SÚPER IMPORTANTE: Si no es admin, lo mandamos al login
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    echo "<h3>Acceso denegado. Esta página es solo para administradores.</h3>";
    echo "<a href='login.php'>Ir al Login</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Agregar Pastel</title>
</head>
<body>

    <h2>Panel de Administración - Registrar Nuevo Pastel</h2>
    <p>Bienvenido Administrador: <b><?php echo $_SESSION['usuario_nombre']; ?></b></p>
    <a href="bienvenido.php">Volver al Inicio</a> | <a href="cerrar_sesion.php">Cerrar Sesión</a>
    <hr><br>

    <form action="procesar_producto.php" method="POST">
        
        <label>Nombre del Pastel:</label><br>
        <input type="text" name="nombre_pastel" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion_pastel" rows="4" cols="30" required></textarea><br><br>

        <label>Precio (Ej: 299.50):</label><br>
        <input type="number" name="precio" step="0.01" min="0" required><br><br>

        <label>Cantidad en Stock:</label><br>
        <input type="number" name="stock" min="0" required><br><br>

        <label>Nombre del archivo de imagen (Ej: chocolate.jpg):</label><br>
        <input type="text" name="imagen" required><br><br>

        <button type="submit">Guardar Pastel en Catálogo</button>
    </form>

</body>
</html>