<?php
// aseguramos que la sesión esté activa en cualquier página que use el header
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastelería Lol </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/animaciones.css">
</head>
</head>
<body class="bg-pink-50 min-h-screen flex flex-col font-sans">

    <nav class="bg-rose-500 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="bienvenido.php" class="text-2xl font-extrabold tracking-wider flex items-center gap-2">
    <span class="animar-flotar">🎂</span> Pastelería <span class="text-amber-200">Lol</span>
</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <?php if (isset($_SESSION['usuario_nombre'])): ?>
                        <span class="bg-rose-600 px-3 py-1 rounded-full text-xs font-semibold mr-2">
                             Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                        </span>
                        
                        <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] == 'admin'): ?>
                            <a href="bienvenido.php" class="hover:bg-rose-600 px-3 py-2 rounded-md text-sm font-medium transition">Inicio Admin</a>
                            <a href="agregar_producto.php" class="hover:bg-rose-600 px-3 py-2 rounded-md text-sm font-medium transition">➕ Agregar Pastel</a>
                        
                        <?php else: ?>
                            <a href="bienvenido.php" class="hover:bg-rose-600 px-3 py-2 rounded-md text-sm font-medium transition">Inicio</a>
                            <a href="catalogo.php" class="hover:bg-rose-600 px-3 py-2 rounded-md text-sm font-medium transition">🍰 Ver Catálogo</a>
                            <a href="ver_pedido.php" class="hover:bg-rose-600 px-3 py-2 rounded-md text-sm font-medium transition bg-rose-700">
                                🛒 Mi Carrito 
                                <?php 
                                $cant_carrito = isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0;
                                if ($cant_carrito > 0) {
    
    echo "<span class='animate-pulse ml-1 bg-yellow-400 text-rose-900 font-bold px-2 py-0.5 rounded-full text-xs'>$cant_carrito</span>";
}
                                ?>
                            </a>
                        <?php endif; ?>

                        <a href="cerrar_sesion.php" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded-md text-sm font-medium transition ml-4">Cerrar Sesión</a>
                    
                    <?php else: ?>
                        <a href="login.php" class="hover:bg-rose-600 px-3 py-2 rounded-md text-sm font-medium transition">Iniciar Sesión</a>
                        <a href="registro.php" class="bg-amber-400 hover:bg-amber-500 text-rose-900 px-3 py-2 rounded-md text-sm font-medium transition font-bold">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8">