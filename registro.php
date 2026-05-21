<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Pasteles LOL</title>
</head>
<body>

    <h2>Crear una cuenta en Pasteles LOL</h2>

    <form action="procesar_registro.php" method="POST">
        
        <label>Nombre completo:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Correo electrónico:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br><br>

        <button type="submit">Registrarme</button>
    </form>

</body>
</html>