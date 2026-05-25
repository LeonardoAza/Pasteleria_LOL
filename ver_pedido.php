<?php
session_start();
include 'conexion.php';

// Protección: Si no ha iniciado sesión, al login
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

$total_cuenta = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Pedido - Pasteles LOL</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-size: 1.5em; font-weight: bold; text-align: right; margin-top: 20px; color: green; }
        .btn-confirmar { background-color: #ff4757; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em; display: block; margin: 20px 0 0 auto; }
    </style>
</head>
<body>

    <h2>🛒 Tu Carrito de Pedidos</h2>
    <a href="catalogo.php">Volver al Catálogo</a> | <a href="cerrar_sesion.php">Cerrar Sesión</a>
    <hr>

    <?php
    // Verificamos si el carrito tiene productos acumulados
    if (!empty($_SESSION['carrito'])) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Pastel</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Recorremos el carrito: $id_prod es la llave, $cantidad es el valor
                foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
                    
                    // Buscamos los datos reales de ese pastel en XAMPP
                    $sql = "SELECT * FROM productos WHERE id_prod = '$id_prod'";
                    $resultado = $conexion->query($sql);
                    
                    if ($resultado->num_rows > 0) {
                        $pastel = $resultado->fetch_assoc();
                        $subtotal = $pastel['precio'] * $cantidad;
                        $total_cuenta += $subtotal; // Vamos sumando al total global
                        ?>
                        <tr>
                            <td>
                                <b><?php echo $pastel['nombre_pastel']; ?></b>
                            </td>
                            <td><?php echo $pastel['descripcion_pastel'] ?? $pastel['descripción_pastel']; ?></td>
                            <td>$<?php echo $pastel['precio']; ?></td>
                            <td><?php echo $cantidad; ?> piezas</td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="total">
            Total a Pagar: $<?php echo number_format($total_cuenta, 2); ?>
        </div>

        <a href="guardar_pedido.php">
            <button class="btn-confirmar">Confirmar y Finalizar Pedido 🎂</button>
        </a>

        <?php
    } else {
        echo "<br><p>Tu carrito está vacío. ¡Ve al catálogo y agrega unos deliciosos pasteles!</p>";
    }
    ?>

</body>
</html>