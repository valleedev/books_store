<?php
session_start();
require_once('../../../db.php');

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'empty') {
        // Vaciar el carrito
        unset($_SESSION['cart']);
    } elseif (isset($_POST['index'])) {
        $index = (int)$_POST['index'];

        if (isset($_SESSION['cart'][$index])) {
            $product_id = $_SESSION['cart'][$index]['id'];

            // Consulta a la base de datos para obtener el stock actual
            $query = "SELECT stock FROM productos WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $stock = $product['stock'];

                if ($action === 'increase') {
                    // Verificar si hay suficiente stock antes de aumentar la cantidad
                    if ($_SESSION['cart'][$index]['quantity'] < $stock) {
                        $_SESSION['cart'][$index]['quantity']++;
                    } else {
                        $_SESSION['error_message'] = "No hay suficiente stock disponible para este producto.";
                    }
                } elseif ($action === 'decrease') {
                    // Disminuir la cantidad, pero no permitir que sea menor a 1
                    if ($_SESSION['cart'][$index]['quantity'] > 1) {
                        $_SESSION['cart'][$index]['quantity']--;
                    }
                } elseif ($action === 'delete') {
                    // Eliminar el producto del carrito
                    unset($_SESSION['cart'][$index]);
                    // Reindexar el array para evitar problemas con índices desordenados
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                }
            } else {
                $_SESSION['error_message'] = "El producto no existe en la base de datos.";
            }
        }
    }
}

// Redirige de vuelta al carrito
header('Location: ../../views/user/cart.php');
exit;
?>