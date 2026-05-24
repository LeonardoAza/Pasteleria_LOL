<?php
session_start();
include 'conexion.php';

// Protección: Si no ha iniciado sesión, al login.
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

// Jalamos todos los productos de la base de datos
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Pasteles - Pasteles LOL</title>
    <style>
        /* Un diseño muy básico para que no se amontone todo mientras le ponemos Bootstrap */
        .contenedor-pasteles { display: flex; flex-wrap: wrap; gap: 20px; }
        .tarjeta-pastel { border: 1px solid #ccc; padding: 15px; width: 250px; border-radius: 8px; text-align: center; }
        .tarjeta-pastel img { max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px; }
        .precio { color: green; font-weight: bold; font-size: 1.2em; }
        .agotado { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h2>🍰 Nuestro Catálogo de Pasteles 🍰</h2>
    <p>Hola, <b><?php echo $_SESSION['usuario_nombre']; ?></b> (Rol: <?php echo $_SESSION['usuario_role'] ?? $_SESSION['usuario_rol']; ?>)</p>
    <a href="bienvenido.php">Volver al Inicio</a> | <a href="cerrar_sesion.php">Cerrar Sesión</a>
    <hr><br>

    <div class="contenedor-pasteles">

        <?php
        // Verificamos si hay productos en la base de datos
        if ($resultado->num_rows > 0) {
            // Este "while" va a repetir la tarjeta por cada pastel que encuentre
            while ($pastel = $resultado->fetch_assoc()) {
                ?>
                <div class="tarjeta-pastel">
                    <img src="imagenes/<?php echo $pastel['imagen']; ?>" alt="<?php echo $pastel['nombre_pastel']; ?>">
                    
                    <h3><?php echo $pastel['nombre_pastel']; ?></h3>
                    <p><?php echo $pastel['descripción_pastel']; ?></p>
                    
                    <p class="precio">$<?php echo $pastel['precio']; ?></p>
                    
                    <p>Disponibles: <?php echo $pastel['stock']; ?></p>

                   <?php if ($pastel['stock'] > 0) { ?>
    <a href="agregar_carrito.php?id=<?php echo $pastel['id_prod']; ?>">
        <button type="button" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer;">
            Agregar al Pedido 🛒
                </button>
                    </a>
            <?php } else { ?>
            <span class="agotado">Temporalmente Agotado ❌</span>
            <?php } ?>
                </div>
                <?php
            }
        } else {
            echo "<p>No hay pasteles registrados en este momento. Vuelve más tarde.</p>";
        }
        ?>

    </div>

</body>
</html>