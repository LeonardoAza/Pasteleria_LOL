<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Pasteles LOL</title>
</head>
<body>

    <h2>Iniciar Sesión</h2>

    <form action="procesar_login.php" method="POST">
        
        <label>Correo electrónico:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <br>
    <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>

</body>
</html>