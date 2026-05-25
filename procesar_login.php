<?php
// 1. Iniciamos la sesión para que PHP pueda recordar al usuario
session_start();

// 2. Conectamos a la base de datos
include 'conexion.php';

// 3. Recibimos los datos del formulario de login
$correo = $_POST['correo'];
$contra = $_POST['contraseña'];

// 4. Buscamos en la base de datos si coinciden el correo y la contraseña
$sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contra'";
$resultado = $conexion->query($sql);

// 5. Verificamos si encontró alguna fila que coincida
if ($resultado->num_rows > 0) {
    // Guardamos los datos del usuario en un "arreglo"
    $usuario = $resultado->fetch_assoc();
    
   // Aquí es donde guardamos los datos en la memoria de la computadora:
    $_SESSION['id_usuario'] = $usuario['id_usuario']; // <-- ¡ESTA ES LA QUE SEGURO FALTA!
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    
    // ¡Éxito! Lo mandamos a la pantalla de bienvenida
    header("Location: bienvenido.php");
} else {
    // Si los datos están mal, le avisamos
    echo "<h3>Correo o contraseña incorrectos.</h3>";
    echo "<a href='login.php'>Volver a intentarlo</a>";
}
?>