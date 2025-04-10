<?php
require_once __DIR__ . '/../../../router.php';
require_once '../../../db.php';
require_once '../../bussines_logic/products/create_product.php';

session_start();

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Manejo de eliminación de producto
/* if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
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
} */

// Manejo de la actualización de producto
if (isset($_POST['edit_product'])) {
    $id = $_POST['edit_id'];
    $category = trim($_POST['edit_category']);
    $name = trim($_POST['edit_name']);
    $description = trim($_POST['edit_description']);
    $price = trim($_POST['edit_price']);
    $stock = trim($_POST['edit_stock']);
    $offer = trim($_POST['edit_offer']);
    $date = isset($_POST['edit_date']) ? $_POST['edit_date'] : date('Y-m-d');
    
    // Verificamos si se ha subido una nueva imagen
    $image_updated = false;
    $upload_successful = true;
    
    if(isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
        $upload_dir = __DIR__ . '/../../../../public/uploads/productos/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = basename($_FILES['edit_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $unique_name = uniqid() . '_' . $file_name;
        $target_file = $upload_dir . $unique_name;
        
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
        if(!in_array($file_ext, $allowed_exts)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        }
        
        else if($_FILES['edit_image']['size'] > 2000000) {
            $upload_successful = false;
            $_SESSION['error_message'] = "El archivo es demasiado grande. Máximo 2MB.";
        }
        
        else if(!move_uploaded_file($_FILES['edit_image']['tmp_name'], $target_file)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Hubo un error al subir el archivo.";
        }
        
        else {
            $image_updated = true;
            $new_image = $unique_name;
            
            // Obtenemos la imagen antigua para eliminarla
            $query_old_img = "SELECT imagen FROM productos WHERE id = ?";
            $stmt_old_img = $conexion->prepare($query_old_img);
            $stmt_old_img->bind_param("i", $id);
            $stmt_old_img->execute();
            $stmt_old_img->bind_result($old_image);
            $stmt_old_img->fetch();
            $stmt_old_img->close();
            
            // Eliminamos la imagen antigua
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
        // El mensaje de error ya está establecido
    } else {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
    }
    
    if (isset($_SESSION['error_message'])) {
        header("Location: products.php");
        exit;
    }
}

// Manejo del formulario de creación de producto
/* if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['edit_product'])) {
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $offer = trim($_POST['offer']);
    $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
    
    $image = '';
    $upload_successful = true;

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = __DIR__ . '/../../../../public/uploads/productos/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $unique_name = uniqid() . '_' . $file_name;
        $target_file = $upload_dir . $unique_name;
        
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
        if(!in_array($file_ext, $allowed_exts)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        }
        
        else if($_FILES['image']['size'] > 2000000) {
            $upload_successful = false;
            $_SESSION['error_message'] = "El archivo es demasiado grande. Máximo 2MB.";
        }
        
        else if(!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $upload_successful = false;
            $_SESSION['error_message'] = "Hubo un error al subir el archivo.";
        }
        
        else {
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
} */

// Obtener categorías para los selectores
$query_categorias = "SELECT id, nombre FROM categorias ORDER BY nombre";
$result_categorias = mysqli_query($conexion, $query_categorias);
$categorias = [];
if ($result_categorias && mysqli_num_rows($result_categorias) > 0) {
    while ($row = mysqli_fetch_assoc($result_categorias)) {
        $categorias[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Gestión de Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="<?= STYLE ?>products.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<body>
    <!-- Header -->
    <?php
    include '../../includes/navbar.php';
    ?>    

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include '../../includes/aside.php';
            ?>

            <!-- Main Content Area -->
            <div class="col-md-10 main-content">
                <h2 class="text-center mb-4">Gestión de Productos</h2>

                <button type="button" class="btn btn-create" data-bs-toggle="modal" data-bs-target="#createModal">
                    Crear Producto
                </button>

                <!-- Modal de Creación -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createModalLabel">Crear Producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="category" class="form-label">Categoría del Producto</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción del Producto</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Precio del Producto</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock del Producto</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>

                            <div class="mb-3">
                                <label for="offer" class="form-label">Oferta del Producto (%)</label>
                                <input type="number" class="form-control" id="offer" name="offer" min="0" max="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha del Producto</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF. Tamaño máximo: 2MB</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                
                <!-- Modal de Edición -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Editar Producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" id="editForm">
                        <div class="modal-body">
                            <input type="hidden" name="edit_product" value="1">
                            <input type="hidden" name="edit_id" id="edit_id">
                            
                            <div class="mb-3">
                                <label for="edit_category" class="form-label">Categoría del Producto</label>
                                <select class="form-select" id="edit_category" name="edit_category" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Descripción del Producto</label>
                                <textarea class="form-control" id="edit_description" name="edit_description" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Precio del Producto</label>
                                <input type="number" class="form-control" id="edit_price" name="edit_price" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_stock" class="form-label">Stock del Producto</label>
                                <input type="number" class="form-control" id="edit_stock" name="edit_stock" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_offer" class="form-label">Oferta del Producto (%)</label>
                                <input type="number" class="form-control" id="edit_offer" name="edit_offer" min="0" max="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_date" class="form-label">Fecha del Producto</label>
                                <input type="date" class="form-control" id="edit_date" name="edit_date">
                            </div>

                            <div class="mb-3">
                                <label for="edit_image" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="edit_image" name="edit_image" accept="image/*">
                                <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF. Tamaño máximo: 2MB</small>
                                <div id="current_image_container" class="mt-2">
                                    <p>Imagen actual:</p>
                                    <img id="current_image" src="" alt="Imagen actual" style="max-width: 100px; max-height: 100px;">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="40%">NOMBRE</th>
                            <th width="20%">STOCK</th>
                            <th width="30%">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta para obtener los productos
                        $query = "SELECT id, nombre, stock FROM productos ORDER BY id DESC";
                        $result = mysqli_query($conexion, $query);
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>" . $row['stock'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-edit' onclick='editarProducto(" . $row['id'] . ")'>Editar</button>
                                        <button class='btn btn-delete' onclick='eliminarProducto(" . $row['id'] . ")'>Eliminar</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No hay productos registrados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    include '../../includes/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="/public/scripts/modal.js"></script>
    
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
        
        function editarProducto(id) {
            // Realizar una petición AJAX para obtener los datos del producto
            fetch('get_product.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    // Rellenar el formulario con los datos
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_category').value = data.categoria_id;
                    document.getElementById('edit_name').value = data.nombre;
                    document.getElementById('edit_description').value = data.descripcion;
                    document.getElementById('edit_price').value = data.precio;
                    document.getElementById('edit_stock').value = data.stock;
                    document.getElementById('edit_offer').value = data.oferta;
                    document.getElementById('edit_date').value = data.fecha;
                    
                    // Mostrar la imagen actual si existe
                    if (data.imagen) {
                        document.getElementById('current_image').src = '/public/uploads/productos/' + data.imagen;
                        document.getElementById('current_image_container').style.display = 'block';
                    } else {
                        document.getElementById('current_image_container').style.display = 'none';
                    }
                    
                    // Abrir el modal
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
</body>
</html>