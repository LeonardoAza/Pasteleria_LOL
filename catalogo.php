<?php
session_start();
include 'conexion.php';


if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

// jalamos los prods a la base de datos ylv
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);


include 'header.php';
?>

<div class="mb-8 text-center md:text-left">
    <h2 class="text-3xl font-extrabold text-stone-800 tracking-tight flex items-center justify-center md:justify-start gap-2">
         Nuestro Catálogo de Pasteles
    </h2>
    <p class="text-stone-600 mt-2">
        Elige tus sabores favoritos hechos con los mejores ingredientes frescos.
    </p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    <?php
    // Verificamos si hay productos en la base de datos
    if ($resultado->num_rows > 0) {
        // Este "while" va a repetir la tarjeta por cada pastel que encuentre
        while ($pastel = $resultado->fetch_assoc()) {
            $stock = $pastel['stock'];
            ?>
            
           <div class="animar-entrada bg-white rounded-2xl shadow-md overflow-hidden ...">
                
                <div class="relative bg-rose-50 h-48 overflow-hidden">
                    <img class="w-full h-full object-cover" 
                         src="imagenes/<?php echo htmlspecialchars($pastel['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($pastel['nombre_pastel']); ?>">
                    
                    <?php if ($stock > 0 && $stock <= 3): ?>
                        <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow">
                            ¡Últimas <?php echo $stock; ?> piezas!
                        </span>
                    <?php endif; ?>
                </div>

                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-stone-800 line-clamp-1">
                            <?php echo htmlspecialchars($pastel['nombre_pastel']); ?>
                        </h3>
                        <p class="text-sm text-stone-500 mt-2 line-clamp-2 min-h-[40px]">
                            <?php echo htmlspecialchars($pastel['descripción_pastel']); ?>
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-stone-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-stone-400 block font-semibold uppercase tracking-wider">Precio</span>
                            <span class="text-2xl font-black text-rose-600">$<?php echo number_format($pastel['precio'], 2); ?></span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-stone-400 block font-semibold uppercase tracking-wider">Disponibles</span>
                            <span class="text-sm font-bold <?php echo ($stock > 0) ? 'text-emerald-600' : 'text-red-500'; ?>">
                                <?php echo ($stock > 0) ? $stock . ' pzas' : 'Agotado'; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <?php if ($stock > 0): ?>
                        <a href="agregar_carrito.php?id=<?php echo $pastel['id_prod']; ?>" 
                           class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl block text-center shadow-md shadow-emerald-100 hover:shadow-lg transition flex items-center justify-center gap-2 text-sm">
                            <span>Agregar al Pedido</span> 🛒
                        </a>
                    <?php else: ?>
                        <button disabled 
                                class="w-full bg-stone-100 text-stone-400 font-bold py-3 px-4 rounded-xl block text-center text-sm cursor-not-allowed border border-stone-200">
                            Temporalmente Agotado 
                        </button>
                    <?php endif; ?>
                </div>

            </div>

            <?php
        }
    } else {
        // Alerta si no hay prodsss
        ?>
        <div class="col-span-full bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex items-center">
                <span class="text-xl mr-3">💡</span>
                <p class="text-amber-800 font-medium">No hay pasteles registrados en este momento. Vuelve más tarde.</p>
            </div>
        </div>
        <?php
    }
    ?>

</div>

<?php

include 'footer.php';
?>