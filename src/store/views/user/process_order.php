<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Verificar si hay productos en el carrito
if (empty($cart)) {
    header("Location: cart.php?error=empty_cart");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y limpiar los datos del formulario
    $provincia = mysqli_real_escape_string($conexion, $_POST['provincia']);
    $localidad = mysqli_real_escape_string($conexion, $_POST['localidad']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $prefijo = mysqli_real_escape_string($conexion, $_POST['prefijo']);
    $contacto = mysqli_real_escape_string($conexion, $_POST['contacto']);
    $coste = mysqli_real_escape_string($conexion, $_POST['coste']);
    
    // Concatenar prefijo y número de contacto para almacenarlo en la base de datos si es necesario
    $telefono_completo = $prefijo . $contacto;
    
    // Obtener el ID del usuario si existe sesión
    if (!isset($_SESSION['user'])) {
        // Redirigir si no hay sesión activa
        header("Location: login.php?error=not_logged_in");
        exit();
    }
    
    $usuario_id = $_SESSION['user']['id'];
    
    // Fecha y hora actual para el pedido
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    
    // Estado inicial del pedido
    $estado = 'Pendiente';
    
    // Insertar datos en la tabla de pedidos
    $sql = "INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) 
            VALUES ('$usuario_id', '$provincia', '$localidad', '$direccion', '$coste', '$estado', '$fecha', '$hora')";
    
    if (mysqli_query($conexion, $sql)) {
        // Obtener el ID del pedido recién insertado
        $pedido_id = mysqli_insert_id($conexion);
        
        // Guardar los productos del carrito en la tabla lineas_pedidos
        foreach ($cart as $producto) {
            $producto_id = mysqli_real_escape_string($conexion, $producto['id']);
            $unidades = mysqli_real_escape_string($conexion, $producto['quantity']);
            $precio = mysqli_real_escape_string($conexion, $producto['price']);
            
            $sql_linea = "INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) 
                         VALUES ('$pedido_id', '$producto_id', '$unidades')";
            
            mysqli_query($conexion, $sql_linea);
        }
        
        // Guardar el pedido en la sesión para mostrarlo en la confirmación
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
        
        // Vaciar el carrito después de completar el pedido
        $_SESSION['cart'] = [];
        
        // Redirigir a una página de confirmación
        header("Location: order_confirmation.php");
        exit();
    } else {
        echo "Error al guardar el pedido: " . mysqli_error($conexion);
    }
} else {
    // Si se accede directamente a este archivo sin usar el formulario
    header("Location: cart.php");
    exit();
}
?>