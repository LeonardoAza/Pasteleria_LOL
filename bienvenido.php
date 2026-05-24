<?php
session_start();

// Si no hay una sesión activa, lo pateamos de regreso al login por seguridad
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Inicio - Pasteles LOL</title>
</head>
<body>

    <h1>¡Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?>! 👋</h1>
    <p>Tu rol en el sistema es: <b><?php echo $_SESSION['usuario_rol']; ?></b></p>
    
    <hr>
    <p>Aquí irá el menú de tu pastelería...</p>
    
    <br>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>

</body>
</html>