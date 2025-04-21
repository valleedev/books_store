<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';
session_start();

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LIBRARIUM - Gestión de Categorías</title>
    
    <!-- Estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= STYLE ?>index.css" />
    <link rel="stylesheet" href="<?= STYLE ?>categories.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>
<body>
    
    <?php include '../../includes/navbar.php'; ?>

    <main class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/aside.php'; ?>

            <section class="col-md-10 main-content">
                <header class="text-center mb-4 animate__animated animate__fadeInDown animate__faster">
                    <h1>Gestión de Categorías</h1>
                </header>

                <div class="mb-3">
                    <button type="button" class="btn btn-create animate__animated animate__fadeIn animate__faster" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        Crear Nueva Categoría
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered animate__animated animate__fadeIn animate__faster">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="10%">ID</th>
                                <th scope="col" width="50%">Nombre</th>
                                <th scope="col" width="20%">Editar</th>
                                <th scope="col" width="20%">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($category['id']) ?></td>
                                        <td><?= htmlspecialchars($category['nombre']) ?></td>
                                        <td>
                                            <button 
                                                class="btn btn-warning text-white w-100" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCategoryModal" 
                                                data-id="<?= $category['id'] ?>" 
                                                data-nombre="<?= htmlspecialchars($category['nombre']) ?>">
                                                Editar
                                            </button>
                                        </td>
                                        <td>
                                            <form method="POST" action="/books_store/src/store/bussines_logic/categories/delete_categories.php" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                                <input type="hidden" name="id" value="<?= $category['id'] ?>" />
                                                <button type="submit" class="btn btn-danger text-white w-100">Eliminar</button>
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
            </section>
        </div>
    </main>

    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <header class="modal-header">
                    <h2 class="modal-title fs-5" id="createCategoryModalLabel">Crear Nueva Categoría</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </header>
                <div class="modal-body">
                    <form method="POST" action="../../bussines_logic/categories/create_categories.php" id="createCategoryForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <header class="modal-header">
                    <h2 class="modal-title fs-5" id="editCategoryModalLabel">Editar Categoría</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </header>
                <div class="modal-body">
                    <form method="POST" action="/books_store/src/store/bussines_logic/categories/edit_categories.php">
                        <input type="hidden" id="editCategoryId" name="id" />
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="editCategoryName" name="nombre" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const editCategoryModal = document.getElementById('editCategoryModal');
        editCategoryModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');

            const inputId = editCategoryModal.querySelector('#editCategoryId');
            const inputNombre = editCategoryModal.querySelector('#editCategoryName');

            inputId.value = id;
            inputNombre.value = nombre;
        });
    </script>
    
</body>
</html>
