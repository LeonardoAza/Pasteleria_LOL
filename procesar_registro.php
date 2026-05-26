<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contra = $_POST['contraseña']; 

// Le ponemos los datos automáticos que el cliente no escribe gagggaa
$rol = "cliente"; 
$fecha = date("Y-m-d H:i:s"); // captura la fecha y hora actual de la computadora

// Preparamos la orden SQL con los nombres de tus columnas
$sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol, fecha_registro) 
        VALUES ('$nombre', '$correo', '$contra', '$rol', '$fecha')";


if ($conexion->query($sql) === TRUE) {
    ?> <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>¡Registro Exitoso! - Pastelería Lol 🎂</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="css/animaciones.css">
    </head>
    <body class="bg-pink-50 min-h-screen flex items-center justify-center p-4 font-sans">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-rose-100 overflow-hidden p-8 text-center animar-entrada">
            
            <div class="w-24 h-24 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 shadow-inner animar-flotar">
                🎉
            </div>

            <h2 class="text-3xl font-black text-stone-800 tracking-tight">
                ¡Cuenta Creada!
            </h2>
            <p class="text-rose-500 font-semibold mt-1">¡Ya eres parte de Pastelería Lol!</p>
            
            <p class="text-stone-500 text-sm mt-4 px-2">
                ¡Hola, <b><?php echo htmlspecialchars($nombre); ?></b>! Tu registro se ha completado con éxito en nuestra base de datos. Ya puedes iniciar sesión para explorar nuestro catálogo y armar tu primer pedido de pasteles.
            </p>

            <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 my-6 text-amber-900 text-xs font-medium flex items-center gap-2 text-left">
                <span>💡</span>
                <p>Recuerda utilizar tu correo (<b><?php echo htmlspecialchars($correo); ?></b>) para poder ingresar al sistema.</p>
            </div>

            <div class="pt-2">
                <a href="login.php" 
                   class="animar-latido w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-rose-100 hover:shadow-xl transition tracking-wide text-sm block">
                    Ir a Iniciar Sesión 🔑
                </a>
            </div>

        </div>

    </body>
    </html>
<?php // AQUÍ VOLVEMOS A ABRIR PHP PARA EL ELSE
} else {
    // si algo falla en la base de datos, te avisa aquí abajo
    echo "<div style='color:red; font-family:sans-serif; padding:20px;'>
            <h3>❌ Error al registrar en la base de datos:</h3>" . $conexion->error . "
          </div>";
}
?>