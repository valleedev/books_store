<?php
// filepath: c:\wamp64\www\books_store\src\store\bussines_logic\cart\actualiza_carrito.php

session_start();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'empty') {
        // Vaciar el carrito
        unset($_SESSION['cart']);
    } elseif (isset($_POST['index'])) {
        $index = (int)$_POST['index'];

        // Verifica si el producto existe en el carrito
        if (isset($_SESSION['cart'][$index])) {
            if ($action === 'increase') {
                // Aumentar la cantidad
                $_SESSION['cart'][$index]['cantidad']++;
            } elseif ($action === 'decrease') {
                // Disminuir la cantidad, pero no permitir que sea menor a 1
                if ($_SESSION['cart'][$index]['cantidad'] > 1) {
                    $_SESSION['cart'][$index]['cantidad']--;
                }
            } elseif ($action === 'delete') {
                // Eliminar el producto del carrito
                unset($_SESSION['cart'][$index]);
                // Reindexar el array para evitar problemas con índices desordenados
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
    }
}

// Redirige de vuelta al carrito
header('Location: ../../views/user/cart.php');
exit;
?>