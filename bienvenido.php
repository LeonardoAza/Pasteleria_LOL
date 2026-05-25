<?php
session_start();

// Si no hay una sesión activa, lo pateamos de regreso al login por seguridad
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
// INYECTAMOS EL HEADER CON EL MENÚ INTELIGENTE
include 'header.php';

$rol = $_SESSION['usuario_rol'];
?>

<div class="bg-white rounded-2xl shadow-md border border-rose-100 p-8 max-w-4xl mx-auto text-center md:text-left mb-8">
    <div class="flex flex-col md:flex-row items-center gap-6">
        <div class="bg-rose-100 w-20 h-20 rounded-full flex items-center justify-center text-4xl shadow-inner">
            <?php echo ($rol == 'admin') ? '👑' : '🍰'; ?>
        </div>
        
        <div class="flex-grow">
            <h2 class="text-3xl font-black text-stone-800 tracking-tight">
                ¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>! 👋
            </h2>
            <p class="text-stone-500 mt-1">
                Tipo de cuenta: 
                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wider ml-1">
                    <?php echo ($rol == 'admin') ? 'Administrador' : 'Cliente'; ?>
                </span>
            </p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-4 text-center md:text-left">
        Accesos rápidos del sistema
    </h3>

    <?php if ($rol == 'admin'): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="agregar_producto.php" 
               class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-200 transition duration-200 flex items-center gap-4 group">
                <div class="bg-emerald-50 text-emerald-600 w-12 h-12 rounded-xl flex items-center justify-center text-xl font-bold group-hover:scale-105 transition">
                    ➕
                </div>
                <div>
                    <h4 class="font-bold text-stone-800 text-base">Agregar Nuevos Pasteles</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Sube imágenes, precios y actualiza el inventario.</p>
                </div>
            </a>
            
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm opacity-60 flex items-center gap-4">
                <div class="bg-stone-50 text-stone-400 w-12 h-12 rounded-xl flex items-center justify-center text-xl font-bold">
                    📊
                </div>
                <div>
                    <h4 class="font-bold text-stone-500 text-base">Panel de Ventas (Próximamente)</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Aquí podrás revisar las ganancias de los pedidos.</p>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="catalogo.php" 
               class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-200 transition duration-200 flex items-center gap-4 group">
                <div class="bg-rose-50 text-rose-500 w-12 h-12 rounded-xl flex items-center justify-center text-xl font-bold group-hover:scale-105 transition">
                    🎂
                </div>
                <div>
                    <h4 class="font-bold text-stone-800 text-base">Ir al Catálogo</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Explora y añade deliciosos pasteles a tu orden.</p>
                </div>
            </a>

            <a href="ver_pedido.php" 
               class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-200 transition duration-200 flex items-center gap-4 group">
                <div class="bg-amber-50 text-amber-600 w-12 h-12 rounded-xl flex items-center justify-center text-xl font-bold group-hover:scale-105 transition">
                    🛒
                </div>
                <div>
                    <h4 class="font-bold text-stone-800 text-base">Ver mi Carrito</h4>
                    <p class="text-xs text-stone-400 mt-0.5">Revisa tus productos y finaliza tu pedido actual.</p>
                </div>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
// INYECTAMOS EL FOOTER
include 'footer.php';
?>