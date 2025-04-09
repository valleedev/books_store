<?php
require_once __DIR__ . '/../../../router.php';
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
    <?php
    include '../../includes/navbar.php'
    ?>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include '../../includes/aside.php'
            ?>

            <!-- Main Content Area -->
            <div class="col-md-9 main-content">
                <h2 class="text-center mb-4">Gestión de Catergorías</h2>
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
                        <tr>
                            <td>1</td>
                            <td>Pantalones</td>
                            <td><button class="btn btn-edit w-100">Editar</button></td>
                            <td><button class="btn btn-delete w-100">Eliminar</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Camisas</td>
                            <td><button class="btn btn-edit w-100">Editar</button></td>
                            <td><button class="btn btn-delete w-100">Eliminar</button></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Medias</td>
                            <td><button class="btn btn-edit w-100">Editar</button></td>
                            <td><button class="btn btn-delete w-100">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    include '../../includes/footer.php'
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>