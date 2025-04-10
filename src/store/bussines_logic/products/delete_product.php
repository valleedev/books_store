<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query_img = "SELECT imagen FROM productos WHERE id = ?";
    $stmt_img = $conexion->prepare($query_img);
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $stmt_img->bind_result($imagen);
    $stmt_img->fetch();
    $stmt_img->close();

    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

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

<script>
    function eliminarProducto(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'products.php?action=delete&id=' + id;
            }
        });
    }
</script>