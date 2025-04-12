<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

// mensajes 

// Obtener las categorías desde la base de datos
$query = "SELECT id, nombre FROM categorias";
$categories = [];
try {
    $stmt = $conexion->query($query);
    $categories = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener las categorías: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Gestión de Categorías</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="<?= STYLE ?>categories.css">
</head>
<body>
    <!-- Header -->
    <?php include '../../includes/navbar.php'; ?>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../../includes/aside.php'; ?>

            <!-- Main Content Area -->
            <div class="col-md-9 main-content">
                <h2 class="text-center mb-4">Gestión de Categorías</h2>

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    Crear Nueva Categoría
                </button>

                <table class="table">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%">NOMBRES</th>
                            <th width="30%"></th>
                            <th width="30%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['id']) ?></td>
                                    <td><?= htmlspecialchars($category['nombre']) ?></td>
                                    <td>
                                        <!-- Botón Editar -->
                                        <button class="btn btn-edit w-100" data-bs-toggle="modal" data-bs-target="#editCategoryModal" 
                                            data-id="<?= $category['id'] ?>" 
                                            data-nombre="<?= htmlspecialchars($category['nombre']) ?>">
                                            Editar
                                        </button>
                                    </td>
                                    <td>
                                        <!-- Botón Eliminar -->
                                        <form method="POST" action="/books_store/src/store/bussines_logic/categories/delete_categories.php" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                            <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                            <button type="submit" class="btn btn-delete w-100">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay categorías disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal for Creating a New Category -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Crear Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCategoryForm" method="POST" action="../../bussines_logic/categories/create_categories.php">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing a Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="/books_store/src/store/bussines_logic/categories/edit_categories.php" method="POST">

                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="editCategoryName" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pasar datos al modal de edición
        const editCategoryModal = document.getElementById('editCategoryModal');
        editCategoryModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');

            const editCategoryId = document.getElementById('editCategoryId');
            const editCategoryName = document.getElementById('editCategoryName');

            editCategoryId.value = id;
            editCategoryName.value = nombre;
        });
    </script>
</body>
</html>