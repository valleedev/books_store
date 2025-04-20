<?php
session_start();
require_once('../../../db.php');

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'empty') {
        unset($_SESSION['cart']);
    } elseif (isset($_POST['index'])) {
        $index = (int)$_POST['index'];

        if (isset($_SESSION['cart'][$index])) {
            $product_id = $_SESSION['cart'][$index]['id'];

            $query = "SELECT stock FROM productos WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $stock = $product['stock'];

                if ($action === 'increase') {
                    if ($_SESSION['cart'][$index]['quantity'] < $stock) {
                        $_SESSION['cart'][$index]['quantity']++;
                    } else {
                        $_SESSION['error_message'] = "No hay suficiente stock disponible para este producto.";
                    }
                } elseif ($action === 'decrease') {
                    if ($_SESSION['cart'][$index]['quantity'] > 1) {
                        $_SESSION['cart'][$index]['quantity']--;
                    }
                } elseif ($action === 'delete') {
                    unset($_SESSION['cart'][$index]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                }
            } else {
                $_SESSION['error_message'] = "El producto no existe en la base de datos.";
            }
        }
    }
}

header('Location: ../../views/user/cart.php');
exit;
?>