<?php
require_once __DIR__ . '/../../../router.php';
require_once '../../../db.php';
require_once '../../bussines_logic/products/create_product.php';
require_once '../../bussines_logic/products/delete_product.php';
require_once '../../bussines_logic/products/update_product.php';

session_start();

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="<?= STYLE ?>products.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <title>LIBRARIUM - Gestión de Productos</title>
</head>

<body>

    <?php
    include '../../includes/navbar.php';
    ?>

    <div class="container-fluid">
        <div class="row">

            <?php
            include '../../includes/aside.php';
            ?>

            <div class="col-md-10 main-content">
                <h1 class="text-center animate__animated animate__fadeInDown animate__faster">Gestión de Productos</h1>

                <div class="mb-3">
                    <button type="button" class="btn btn-create animate__animated animate__fadeIn animate__faster" data-bs-toggle="modal" data-bs-target="#createModal">
                        Crear Producto
                    </button>
                </div>

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
                                            <img id="current_image" src="/public/images/uploads/products/<?= $row['imagen'] ?>" alt="Imagen actual" style="max-width: 100px; max-height: 100px;">
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

                <table class="table table-bordered align-middle text-center animate__animated animate__fadeIn animate__faster">
                    <thead class="table">
                        <tr class="table-light">
                            <th scope="col" width="10%">Imagen</th>
                            <th scope="col" width="20%">Nombre</th>
                            <th scope="col" width="20%">Precio</th>
                            <th scope="col" width="10%">Oferta</th>
                            <th scope="col" width="10%">Stock</th>
                            <th scope="col" width="20%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $query = "SELECT * FROM productos ORDER BY id DESC";
                        $result = mysqli_query($conexion, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td><img src='" . IMAGES . "uploads/products/" . $row['imagen'] . "' alt='Imagen del producto' class='img-fluid rounded' style='max-width: 80px;'></td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>" . $row['precio'] . "</td>";
                                echo "<td>" . $row['oferta'] . "</td>";
                                echo "<td>" . $row['stock'] . "</td>";
                                echo "<td class='d-flex justify-content-center align-items-center gap-2 h-100'>
                                        <button class='btn btn-warning text-white' onclick='editarProducto(" . $row['id'] . ")'>Editar</button>
                                        <button class='btn btn-danger text-white' onclick='eliminarProducto(" . $row['id'] . ")'>Eliminar</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No hay productos registrados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    include '../../includes/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="/public/scripts/modal.js"></script>

</body>

</html>