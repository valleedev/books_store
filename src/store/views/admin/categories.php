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
</head>
<body>
    
    <!-- Encabezado -->
    <?php include '../../includes/navbar.php'; ?>

    <main class="container-fluid">
        <div class="row">
            
            <!-- Barra lateral -->
            <?php include '../../includes/aside.php'; ?>

            <!-- Sección principal -->
            <section class="col-md-10 main-content">
                <header class="text-center mb-4">
                    <h1>Gestión de Categorías</h1>
                </header>

                <!-- Botón para crear nueva categoría -->
                <div class="mb-3">
                    <button type="button" class="btn btn-create" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        Crear Nueva Categoría
                    </button>
                </div>

                <!-- Tabla de categorías -->
                <div class="table-responsive">
                    <table class="table">
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
                                                class="btn btn-edit text-white w-100" 
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
                                                <button type="submit" class="btn btn-delete text-white w-100">Eliminar</button>
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

    <!-- Modal: Crear nueva categoría -->
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

    <!-- Modal: Editar categoría -->
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

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
