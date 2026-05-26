<?php
session_start();


if (!isset($_SESSION['usuario_nombre']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
include 'header.php';


$sql_kpi = "SELECT COUNT(*) AS total_ordenes, SUM(total_pagar) AS ingresos_totales FROM pedidos";
$res_kpi = $conexion->query($sql_kpi);
$datos_kpi = $res_kpi->fetch_assoc();

$total_ordenes = $datos_kpi['total_ordenes'] ?? 0;
$ingresos_totales = $datos_kpi['ingresos_totales'] ?? 0;

//  JOIN lmao Unimos pedidos con usuarios usando el id usuario
$sql_reporte = "SELECT pedidos.id_pedido, usuarios.nombre AS nombre_cliente, pedidos.fecha_pedido, pedidos.total_pagar, pedidos.estado 
                FROM pedidos 
                INNER JOIN usuarios ON pedidos.id_usuario = usuarios.id_usuario 
                ORDER BY pedidos.fecha_pedido DESC";
$resultado = $conexion->query($sql_reporte);
?>

<div class="max-w-6xl mx-auto px-4 py-6">
    
    <div class="mb-8">
        <h2 class="text-3xl font-black text-stone-800 tracking-tight"> Reporte de Ventas Globales</h2>
        <p class="text-sm text-stone-500 mt-1">Historial transaccional y rendimiento económico de Pastelería Lol.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Ingresos Totales</p>
                    <h3 class="text-3xl font-black text-stone-800 mt-1">
                        $<?php echo number_format((float)$ingresos_totales, 2); ?> MXN
                    </h3>
                </div>
                <div class="bg-emerald-500 text-white w-12 h-12 rounded-xl flex items-center justify-center text-2xl shadow-md">
                    💵
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-rose-700 uppercase tracking-wider">Pedidos Procesados</p>
                    <h3 class="text-3xl font-black text-stone-800 mt-1">
                        <?php echo (int)$total_ordenes; ?> órdenes
                    </h3>
                </div>
                <div class="bg-rose-500 text-white w-12 h-12 rounded-xl flex items-center justify-center text-2xl shadow-md">
                    📦
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 border-b border-stone-100 text-stone-400 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Folio</th>
                        <th class="py-4 px-6">Cliente</th>
                        <th class="py-4 px-6">Fecha y Hora</th>
                        <th class="py-4 px-6">Total Pagado</th>
                        <th class="py-4 px-6 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700 text-sm">
                    <?php if ($resultado && $resultado->num_rows > 0) { ?>
                        <?php while ($pedido = $resultado->fetch_assoc()) { ?>
                            <tr class="hover:bg-rose-50/30 transition duration-150">
                                <td class="py-4 px-6 font-bold text-stone-800">
                                    #<?php echo str_pad($pedido['id_pedido'], 5, "0", STR_PAD_LEFT); ?>
                                </td>
                                <td class="py-4 px-6 font-medium">
                                    <?php echo htmlspecialchars($pedido['nombre_cliente']); ?>
                                </td>
                                <td class="py-4 px-6 text-stone-500">
                                    <?php echo date("d/m/Y h:i A", strtotime($pedido['fecha_pedido'])); ?>
                                </td>
                                <td class="py-4 px-6 font-bold text-stone-900">
                                    $<?php echo number_format((float)$pedido['total_pagar'], 2); ?>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <?php 
                                    $estado = $pedido['estado'];
                                    if (strtolower($estado) == 'completado') {
                                        echo '<span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Completado</span>';
                                    } else {
                                        echo '<span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Pendiente</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="py-12 text-center text-stone-400 font-medium">
                                📭 Aún no se han registrado compras en el sistema.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include 'footer.php';
?>