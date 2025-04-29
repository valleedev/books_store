<?php

if (isset($_POST['edit_product'])) {
    $id = $_POST['edit_id'];
    $category = trim($_POST['edit_category']);
    $name = trim($_POST['edit_name']);
    $description = trim($_POST['edit_description']);
    $price = trim($_POST['edit_price']);
    $stock = trim($_POST['edit_stock']);
    $offer = trim($_POST['edit_offer']);
    $date = isset($_POST['edit_date']) ? $_POST['edit_date'] : date('Y-m-d');

    $image_updated = false;
    $upload_successful = true;

    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
        $upload_dir = __DIR__ . '/../../../../public/uploads/productos/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['edit_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $unique_name = uniqid() . '_' . $file_name;
        $target_file = $upload_dir . $unique_name;

        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($file_ext, $allowed_exts)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        } else if ($_FILES['edit_image']['size'] > 2000000) {
            $upload_successful = false;
            $_SESSION['error_message'] = "El archivo es demasiado grande. Máximo 2MB.";
        } else if (!move_uploaded_file($_FILES['edit_image']['tmp_name'], $target_file)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Hubo un error al subir el archivo.";
        } else {
            $image_updated = true;
            $new_image = $unique_name;

            $query_old_img = "SELECT imagen FROM productos WHERE id = ?";
            $stmt_old_img = $conexion->prepare($query_old_img);
            $stmt_old_img->bind_param("i", $id);
            $stmt_old_img->execute();
            $stmt_old_img->bind_result($old_image);
            $stmt_old_img->fetch();
            $stmt_old_img->close();

            if (!empty($old_image)) {
                $ruta_imagen_antigua = $upload_dir . $old_image;
                if (file_exists($ruta_imagen_antigua)) {
                    unlink($ruta_imagen_antigua);
                }
            }
        }
    }

    if (!empty($category) && !empty($name) && !empty($description) && !empty($price) && !empty($stock) && $upload_successful) {
        if ($image_updated) {
            $sql = "UPDATE productos SET categoria_id = ?, nombre = ?, descripcion = ?, precio = ?, stock = ?, oferta = ?, fecha = ?, imagen = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("issdisssi", $category, $name, $description, $price, $stock, $offer, $date, $new_image, $id);
        } else {
            $sql = "UPDATE productos SET categoria_id = ?, nombre = ?, descripcion = ?, precio = ?, stock = ?, oferta = ?, fecha = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("issdissi", $category, $name, $description, $price, $stock, $offer, $date, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Producto actualizado correctamente.";
            header("Location: products.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Error al actualizar en la base de datos: " . $stmt->error;
        }
    } else if (!$upload_successful) {
    } else {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
    }

    if (isset($_SESSION['error_message'])) {
        header("Location: products.php");
        exit;
    }
}

?>

<script>
    function editarProducto(id) {

        fetch('get_product.php?id=' + id)
            .then(response => response.json())
            .then(data => {

                document.getElementById('edit_id').value = data.id;
                document.getElementById('edit_category').value = data.categoria_id;
                document.getElementById('edit_name').value = data.nombre;
                document.getElementById('edit_description').value = data.descripcion;
                document.getElementById('edit_price').value = data.precio;
                document.getElementById('edit_stock').value = data.stock;
                document.getElementById('edit_offer').value = data.oferta;
                document.getElementById('edit_date').value = data.fecha;


                if (data.imagen) {
                    document.getElementById('current_image').src = '/public/uploads/productos/' + data.imagen;

                    document.getElementById('current_image_container').style.display = 'none';
                } else {
                    document.getElementById('current_image_container').style.display = 'none';
                }


                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del producto',
                    confirmButtonText: 'Aceptar'
                });
            });
    }
</script>