<?php
session_start();

// Si no hay un carrito creado en la sesión, lo inventamos como un arreglo vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// agarrramos el id que viene de la bd
if (isset($_GET['id'])) {
    $id_prod = $_GET['id'];

    //  si el paste ya estaba enel carro le sumamos uno alav
    if (isset($_SESSION['carrito'][$id_prod])) {
        $_SESSION['carrito'][$id_prod]++;
    } else {
        // si solo agregua uno pues solo 1
        $_SESSION['carrito'][$id_prod] = 1;
    }
}

//  Lo mandamos de regreso al catálogo al wey
header("Location: catalogo.php");
exit();