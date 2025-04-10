<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['edit_product'])) {
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $offer = trim($_POST['offer']);
    $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

    $image = '';
    $upload_successful = true;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = __DIR__ . '/../../../../public/images/products/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $unique_name = uniqid() . '_' . $file_name;
        $target_file = $upload_dir . $unique_name;

        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($file_ext, $allowed_exts)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        } else if ($_FILES['image']['size'] > 2000000) {
            $upload_successful = false;
            $_SESSION['error_message'] = "El archivo es demasiado grande. Máximo 2MB.";
        } else if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Hubo un error al subir el archivo.";
        } else {
            $image = $unique_name;
        }
    }

    if (!empty($category) && !empty($name) && !empty($description) && !empty($price) && !empty($stock) && !empty($offer) && $upload_successful) {
        $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issdiiss", $category, $name, $description, $price, $stock, $offer, $date, $image);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Producto creado correctamente.";
            header("Location: products.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Error al guardar en la base de datos: " . $stmt->error;
            header("Location: products.php");
            exit;
        }
    } else if (!$upload_successful) {
        // El mensaje de error ya está establecido
        header("Location: products.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
        header("Location: products.php");
        exit;
    }
}
?>


<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '<?= $_SESSION['success_message'] ?>',
            confirmButtonText: 'Aceptar',
            allowOutsideClick: false,
            heightAuto: false,
            confirmButtonColor: '#28a745',
            customClass: {
                popup: 'small-alert',
                confirmButton: 'green-button'
            }
        });
    </script>
<?php
    unset($_SESSION['success_message']);
endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= $_SESSION['error_message'] ?>',
            confirmButtonText: 'Intentar de nuevo',
            allowOutsideClick: false,
            heightAuto: false,
            customClass: {
                popup: 'small-alert',
                confirmButton: 'green-button'
            }
        });
    </script>
<?php
    unset($_SESSION['error_message']);
endif; ?>