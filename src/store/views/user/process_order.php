<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    header("Location: cart.php?error=empty_cart");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provincia = mysqli_real_escape_string($conexion, $_POST['provincia']);
    $localidad = mysqli_real_escape_string($conexion, $_POST['localidad']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $prefijo = mysqli_real_escape_string($conexion, $_POST['prefijo']);
    $contacto = mysqli_real_escape_string($conexion, $_POST['contacto']);
    $coste = mysqli_real_escape_string($conexion, $_POST['coste']);
    
    $telefono_completo = $prefijo . $contacto;
    
    if (!isset($_SESSION['user'])) {
        header("Location: login.php?error=not_logged_in");
        exit();
    }
    
    $usuario_id = $_SESSION['user']['id'];
    
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    
    $estado = 'Pendiente';
    
    $sql = "INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) 
            VALUES ('$usuario_id', '$provincia', '$localidad', '$direccion', '$coste', '$estado', '$fecha', '$hora')";
    
    if (mysqli_query($conexion, $sql)) {
        $pedido_id = mysqli_insert_id($conexion);
        
        foreach ($cart as $producto) {
            $producto_id = mysqli_real_escape_string($conexion, $producto['id']);
            $unidades = mysqli_real_escape_string($conexion, $producto['quantity']);
            $precio = mysqli_real_escape_string($conexion, $producto['price']);
            
            if (isset($producto_id)) {
                $sql = "SELECT id, nombre, descripcion, precio, stock, imagen, categoria_id 
                        FROM productos 
                        WHERE id = ?";
                
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $producto_id);
                $stmt->execute();
                $result = $stmt->get_result();
            
                if ($result->num_rows > 0) {
                    $prod = $result->fetch_assoc();
                } else {
                    echo "Producto no encontrado.";
                }
            
                $stmt->close();
                $image_prod = $prod['imagen'];
                $nombre_prod = $prod['nombre'];
                $precio_prod = $prod['precio'];
                $stock_prod = $prod['stock'];
            }

            $sql_linea = "INSERT INTO lineas_pedido (pedido_id, unidades, imagen_prod, nombre_prod, precio_prod, stock_prod) 
                         VALUES ('$pedido_id', '$unidades', '$image_prod', '$nombre_prod', '$precio_prod', '$stock_prod')";
            
            mysqli_query($conexion, $sql_linea);
        }
        
        $_SESSION['pedido'] = [
            'id' => $pedido_id,
            'provincia' => $provincia,
            'localidad' => $localidad,
            'direccion' => $direccion,
            'telefono' => $telefono_completo,
            'coste' => $coste,
            'fecha' => $fecha,
            'hora' => $hora,
            'productos' => $cart
        ];
        
        $_SESSION['cart'] = [];
        
        header("Location: order_confirmation.php");
        exit();
    } else {
        echo "Error al guardar el pedido: " . mysqli_error($conexion);
    }
} else {
    header("Location: cart.php");
    exit();
}
?>