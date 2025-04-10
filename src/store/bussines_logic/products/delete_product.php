<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Primero obtenemos la información de la imagen
    $query_img = "SELECT imagen FROM productos WHERE id = ?";
    $stmt_img = $conexion->prepare($query_img);
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $stmt_img->bind_result($imagen);
    $stmt_img->fetch();
    $stmt_img->close();
    
    // Eliminamos el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Si hay imagen, la eliminamos del servidor
        if (!empty($imagen)) {
            $ruta_imagen = __DIR__ . '/../../../../public/uploads/productos/' . $imagen;
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }
        
        $_SESSION['success_message'] = "Producto eliminado correctamente.";
    } else {
        $_SESSION['error_message'] = "Error al eliminar el producto: " . $stmt->error;
    }
    
    header("Location: products.php");
    exit;
}

?>