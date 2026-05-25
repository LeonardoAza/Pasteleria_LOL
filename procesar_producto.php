<?php
session_start();
include 'conexion.php';

// protección por si quieren ser admins alav
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// Recibimos los datos con los nombres XD del HTML
$nombre = $_POST['nombre_pastel'];
$descripcion = $_POST['descripcion_pastel'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_POST['imagen'];

// preparamos la consulta SQL con tus columnas exactas (mantenemos 'descripción_pastel' con acento)
$sql = "INSERT INTO productos (nombre_pastel, descripción_pastel, precio, imagen, stock) 
        VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$stock')";

// ejecutamos y revisamos si se guardó
if ($conexion->query($sql) === TRUE) {
    // SI EL PASTEL SE GUARDÓ EN LA BD, PINTAMOS LA INTERFAZ DE ADMINISTRADOR CHULA:
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>¡Pastel Guardado! - Panel Admin 👩‍🍳</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="css/animaciones.css">
    </head>
    <body class="bg-pink-50 min-h-screen flex items-center justify-center p-4 font-sans">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-rose-100 overflow-hidden p-8 text-center animar-entrada">
            
            <div class="w-24 h-24 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 shadow-inner animar-flotar">
                ✨
            </div>

            <h2 class="text-3xl font-black text-stone-800 tracking-tight">
                ¡Pastel Agregado!
            </h2>
            <p class="text-emerald-600 font-semibold mt-1">Inventario actualizado con éxito</p>
            
            <div class="bg-stone-50 rounded-xl p-4 border border-stone-100 my-6 text-left flex gap-4 items-center">
                <?php if (!empty($imagen)): ?>
                    <img src="imagenes/<?php echo htmlspecialchars($imagen); ?>" 
                         alt="Vista previa" 
                         class="w-20 h-20 object-cover rounded-lg border border-stone-200 shadow-sm flex-shrink-0">
                <?php else: ?>
                    <div class="w-20 h-20 bg-stone-200 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🎂</div>
                <?php endif; ?>
                
                <div class="overflow-hidden w-full">
                    <h4 class="font-bold text-stone-800 text-base truncate"><?php echo htmlspecialchars($nombre); ?></h4>
                    <p class="text-xs text-stone-400 line-clamp-1 mt-0.5"><?php echo htmlspecialchars($descripcion); ?></p>
                    
                    <div class="flex gap-4 mt-2 border-t border-stone-200/60 pt-2">
                        <div>
                            <span class="block text-[10px] text-stone-400 uppercase font-bold">Precio</span>
                            <span class="text-sm font-extrabold text-rose-500">$<?php echo number_format($precio, 2); ?></span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-stone-400 uppercase font-bold">Disponibles</span>
                            <span class="text-sm font-extrabold text-stone-700"><?php echo $stock; ?> pzas</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <a href="agregar_producto.php" 
                   class="bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold py-3 px-4 rounded-xl text-xs transition tracking-wide text-center">
                    ➕ Agregar otro
                </a>
                
                <a href="bienvenido.php" 
                   class="animar-latido bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-4 rounded-xl text-xs shadow-md shadow-rose-100 hover:shadow-lg transition tracking-wide text-center">
                    Ir al Inicio 🏠
                </a>
            </div>

        </div>

    </body>
    </html>
<?php
} else {
    // Mensaje controlado si la consulta truena
    echo "<div style='color:red; font-family:sans-serif; padding:20px;'>
            <h3>❌ Error al guardar el producto en el inventario:</h3>" . $conexion->error . "
          </div>";
}
?>