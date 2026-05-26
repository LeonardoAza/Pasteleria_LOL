<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_nombre']) || empty($_SESSION['carrito'])) {
    header("Location: catalogo.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario']; 
$total_general = 0;
$fecha_actual = date("Y-m-d H:i:s");
$estado_inicial = "Pendiente"; 

foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
    $sql_precio = "SELECT precio FROM productos WHERE id_prod = '$id_prod'";
    $res_precio = $conexion->query($sql_precio);
    if ($res_precio->num_rows > 0) {
        $prod = $res_precio->fetch_assoc();
        $total_general += ($prod['precio'] * $cantidad);
    }
}

// insertamos en la tabla 'pedidos'
$sql_pedido = "INSERT INTO pedidos (id_usuario, fecha_pedido, total_pagar, estado) 
               VALUES ('$id_usuario', '$fecha_actual', '$total_general', '$estado_inicial')";

if ($conexion->query($sql_pedido) === TRUE) {
    $id_pedido = $conexion->insert_id;

    // insertamos detalles y restamos stock
    foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
        $sql_prod = "SELECT stock FROM productos WHERE id_prod = '$id_prod'";
        $res_prod = $conexion->query($sql_prod);
        
        if ($res_prod->num_rows > 0) {
            // insertamos limpio en la tabla 'detalle_pedido'
            $sql_detalle = "INSERT INTO detalle_pedido (id_pedido, id_prod, cantidad) 
                            VALUES ('$id_pedido', '$id_prod', '$cantidad')";
            $conexion->query($sql_detalle);

            // restamos las piezas del Stock
            $sql_update_stock = "UPDATE productos SET stock = stock - '$cantidad' WHERE id_prod = '$id_prod'";
            $conexion->query($sql_update_stock);
        }
    }

    include 'header.php';
    ?>

    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-xl border border-rose-100 p-8 text-center my-8 animar-entrada">
        <div class="w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center text-5xl mx-auto mb-6 shadow-inner animar-flotar">
            ✓
        </div>

        <h2 class="text-3xl font-black text-stone-800 tracking-tight">
            ¡Pedido Confirmado! 🎉
        </h2>
        <p class="text-emerald-600 font-semibold mt-1">¡Tu orden #<?php echo $id_pedido; ?> ha sido registrada con éxito!</p>
        
        <p class="text-stone-500 text-sm mt-4 px-4">
            Muchas gracias por tu compra, <b><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></b>. Nuestro equipo de reposteros ya está preparando tus pasteles con el toque mágico de Pastelería Lol.
        </p>

        <div class="bg-stone-50 rounded-xl p-5 border border-stone-100 my-6 text-left space-y-3">
            <h4 class="text-xs font-bold text-stone-400 uppercase tracking-wider">Información de entrega</h4>
            <div class="flex items-start gap-2 text-sm text-stone-600">
                <span>📍</span>
                <p>Puedes pasar por tu pedido a nuestra sucursal central presentando tu nombre completo.</p>
            </div>
            <div class="flex items-start gap-2 text-sm text-stone-600">
                <span>🕒</span>
                <p>Tu pedido estará listo en un lapso estimado de 2 a 4 horas.</p>
            </div>
        </div>

        <div class="pt-2">
            <a href="catalogo.php" 
               class="inline-block w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-rose-100 transition tracking-wide text-sm">
                Volver al Catálogo 🍰
            </a>
        </div>
    </div>

    <?php
    $_SESSION['carrito'] = array(); // vaciamos el carrito aquí, al final de todo

} else {
    echo "<div style='color:red; font-family:sans-serif; padding:20px;'>
            <h3>❌ Error de base de datos:</h3>" . $conexion->error . "
          </div>";
}

include 'footer.php';
?>