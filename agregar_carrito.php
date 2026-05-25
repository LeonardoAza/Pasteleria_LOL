<?php
session_start();

// 1. Si no hay un carrito creado en la sesión, lo inventamos como un arreglo vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// 2. Atrapamos el ID que viene desde el catálogo
if (isset($_GET['id'])) {
    $id_prod = $_GET['id'];

    // 3. Si el pastel YA ESTABA en el carrito, le sumamos 1 a la cantidad
    if (isset($_SESSION['carrito'][$id_prod])) {
        $_SESSION['carrito'][$id_prod]++;
    } else {
        // 4. Si es la primera vez que lo agrega, empezamos la cantidad en 1
        $_SESSION['carrito'][$id_prod] = 1;
    }
}

// 5. Lo mandamos de regreso al catálogo instantáneamente
header("Location: catalogo.php");
exit();