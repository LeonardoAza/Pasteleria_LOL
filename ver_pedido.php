<?php
session_start();
include 'conexion.php';

// Protección: Si no ha iniciado sesión, al login.
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

// INYECTAMOS EL HEADER CON EL MENÚ
include 'header.php';
?>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-stone-800 tracking-tight flex items-center gap-2">
        🛒 Tu Carrito de Compras
    </h2>
    <p class="text-stone-600 mt-2">Revisa los pasteles que has seleccionado antes de confirmar tu pedido.</p>
</div>

<?php
// Verificamos si el carrito tiene productos
if (!empty($_SESSION['carrito'])) {
    $total_general = 0;
    ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-md border border-rose-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-500 text-white text-sm font-bold uppercase tracking-wider">
                            <th class="p-4 pl-6">Pastel</th>
                            <th class="p-4 text-center">Precio</th>
                            <th class="p-4 text-center">Cantidad</th>
                            <th class="p-4 text-right pr-6">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        <?php
                        foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
                            // Buscamos los detalles de cada pastel en la base de datos
                            $sql = "SELECT * FROM productos WHERE id_prod = '$id_prod'";
                            $res = $conexion->query($sql);
                            
                            if ($res->num_rows > 0) {
                                $prod = $res->fetch_assoc();
                                $subtotal = $prod['precio'] * $cantidad;
                                $total_general += $subtotal;
                                ?>
                                <tr class="hover:bg-rose-50/50 transition duration-150">
                                    <td class="p-4 pl-6 flex items-center gap-4">
                                        <img class="w-12 h-12 object-cover rounded-lg border border-stone-200" 
                                             src="imagenes/<?php echo htmlspecialchars($prod['imagen']); ?>" 
                                             alt="<?php echo htmlspecialchars($prod['nombre_pastel']); ?>">
                                        <div>
                                            <span class="font-bold text-stone-800 block"><?php echo htmlspecialchars($prod['nombre_pastel']); ?></span>
                                            <span class="text-xs text-stone-400">Código: #<?php echo $id_prod; ?></span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center font-medium text-stone-600">
                                        $<?php echo number_format($prod['precio'], 2); ?>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-block bg-stone-100 text-stone-800 font-bold px-3 py-1 rounded-full text-sm border border-stone-200">
                                            <?php echo $cantidad; ?> pzas
                                        </span>
                                    </td>
                                    <td class="p-4 text-right pr-6 font-bold text-stone-800 text-lg">
                                        $<?php echo number_format($subtotal, 2); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-stone-50 border-t border-stone-100 flex justify-start">
                <a href="catalogo.php" class="text-rose-600 hover:text-rose-700 font-bold text-sm flex items-center gap-1 transition">
                    ← Seguir agregando pasteles
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-rose-100 p-6 h-fit flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-stone-800 border-b border-stone-100 pb-3 mb-4">
                    Resumen del Pedido
                </h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-stone-500">
                        <span>Productos seleccionados:</span>
                        <span class="font-semibold text-stone-700"><?php echo array_sum($_SESSION['carrito']); ?> piezas</span>
                    </div>
                    <div class="flex justify-between text-sm text-stone-500">
                        <span>Envío / Recolección:</span>
                        <span class="text-emerald-600 font-semibold">Gratis</span>
                    </div>
                    <hr class="border-stone-100 my-2">
                    <div class="flex justify-between items-end pt-2">
                        <span class="font-bold text-stone-800 text-base">Total a Pagar:</span>
                        <span class="text-3xl font-black text-rose-600">$<?php echo number_format($total_general, 2); ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="guardar_pedido.php" 
                   class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-4 rounded-xl block text-center shadow-lg shadow-rose-100 hover:shadow-xl transition tracking-wide text-sm">
                    Confirmar y Finalizar Pedido 🎂
                </a>
                <p class="text-center text-xs text-stone-400 mt-3">
                    Al confirmar, se descontará el stock y se registrará tu orden.
                </p>
            </div>
        </div>

    </div>

    <?php
} else {
    // Alerta estilizada si el carrito está vacío
    ?>
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-md border border-rose-100 p-8 text-center my-12">
        <span class="text-5xl block mb-4">🛒</span>
        <h3 class="text-xl font-bold text-stone-800">Tu carrito está vacío</h3>
        <p class="text-stone-500 text-sm mt-2 mb-6">Parece que aún no has añadido ningún pastel a tu orden.</p>
        <a href="catalogo.php" 
           class="inline-block bg-rose-500 hover:bg-rose-600 text-white font-bold py-2.5 px-6 rounded-xl text-sm shadow-md transition">
            Ir al Catálogo de Pasteles
        </a>
    </div>
    <?php
}

// INYECTAMOS EL FOOTER
include 'footer.php';
?>