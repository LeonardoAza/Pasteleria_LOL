<?php
// iniciamos la sesión para que PHP pueda recordar al usuario
session_start();


include 'conexion.php';

// recibimos los datos del loginnn
$correo = $_POST['correo'];
$contra = $_POST['contraseña'];

// buscamos en la base de datos si coinciden el correo y la contraseña y todo el pedo
$sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contra'";
$resultado = $conexion->query($sql);

//  verificamos si encontró alguna fila que coincida
if ($resultado->num_rows > 0) {
    // Guardamos los datos del usuario en un array tlv
    $usuario = $resultado->fetch_assoc();
    
   // aquí es donde guardamos los datos en la memoria de la computadora jejej
    $_SESSION['id_usuario'] = $usuario['id_usuario']; 
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    
    
    header("Location: bienvenido.php");
} else {
    // si los datos están mal le avisamos al weys
    echo "<h3>Correo o contraseña incorrectos.</h3>";
    echo "<a href='login.php'>Volver a intentarlo</a>";
}
?>