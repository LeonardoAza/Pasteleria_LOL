<?php
session_start();
include 'conexion.php';

// ¡AQUÍ CORREGIMOS LA HORA!
date_default_timezone_set('America/Mexico_City');

// Protección de sesión
if (!isset($_SESSION['usuario_nombre']) || empty($_SESSION['carrito'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario']; 
$fecha_actual = date("Y-m-d H:i:s"); // Ahora sí saldrá con tu hora local

// 1. Protección: Si no hay sesión o el carrito está vacío, lo sacamos
if (!isset($_SESSION['usuario_nombre']) || empty($_SESSION['carrito'])) {
    header("Location: login.php");
    exit();
}

// Cambia tu línea 11 por esta para evitar que quede en blanco:
// Deja la línea así para que obligatoriamente use el ID del usuario que inició sesión
$id_usuario = $_SESSION['id_usuario'];
$fecha_actual = date("Y-m-d H:i:s");

// ==========================================================
// NUEVO: CALCULAR EL TOTAL DE LA CUENTA ANTES DE GUARDAR
// ==========================================================
$total_pagar = 0;
foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
    // Buscamos el precio de cada pastel en la base de datos
    $sql_precio = "SELECT precio FROM productos WHERE id_prod = '$id_prod'";
    $res_precio = $conexion->query($sql_precio);
    if ($res_precio->num_rows > 0) {
        $prod = $res_precio->fetch_assoc();
        $total_pagar += ($prod['precio'] * $cantidad); // Sumamos al total
    }
}

// ==========================================================
// PASO A: REGISTRAR EN LA TABLA PEDIDOS (CON TOTAL Y ESTADO)
// ==========================================================
// Agregamos 'estado' en los campos y 'Pendiente' en los VALUES
$sql_pedido = "INSERT INTO pedidos (id_usuario, fecha_pedido, total_pagar, estado) 
                VALUES ('$id_usuario', '$fecha_actual', '$total_pagar', 'Pendiente')";  
if ($conexion->query($sql_pedido) === TRUE) {
    // Recuperamos el ID del pedido que se acaba de crear
    $id_pedido_nuevo = $conexion->insert_id;

    // ==========================================
    // PASO B: REGISTRAR EN DETALLE_PEDIDO
    // ==========================================
    foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
        $sql_detalle = "INSERT INTO detalle_pedido (id_pedido, id_prod, cantidad) 
                        VALUES ('$id_pedido_nuevo', '$id_prod', '$cantidad')";
        $conexion->query($sql_detalle);

        // ==========================================
        // PASO C: RESTAR EL STOCK DEL PRODUCTO
        // ==========================================
        $sql_restar_stock = "UPDATE productos SET stock = stock - $cantidad WHERE id_prod = '$id_prod'";
        $conexion->query($sql_restar_stock);
    }

    // ==========================================
    // PASO D: LIMPIAR EL CARRITO
    // ==========================================
    unset($_SESSION['carrito']); 

    echo "<h1>¡Pedido Confirmado con Éxito! 🎉</h1>";
    echo "<p>Tu orden número <b>#$id_pedido_nuevo</b> por un total de <b>$$total_pagar</b> ha sido guardada.</p>";
    echo "<a href='catalogo.php'>Volver a la tienda</a>";

} else {
    echo "Error al procesar el pedido: " . $conexion->error;
}
?>