<?php
require_once __DIR__ . '/../../../router.php';
session_start()
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
    <link rel="stylesheet" href="<?= STYLE ?>dashboard.css">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
</head>
<body> 
    <?php
    include '../../includes/navbar.php'
    ?>
    <!-- Contenido principal -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include '../../includes/aside.php'
            ?>
            <!-- Contenido principal -->
            <div class="col-md-10 main-content p-4">
                <h2 class="text-center mb-5">GESTIONAR PEDIDOS</h2>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nro Pedido</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="selectable-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                            <tr class="selectable-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                            <tr class="selectable-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                            <tr class="selectable-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../../includes/footer.php'
    ?>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script personalizado -->
    <script src="<?= SCRIPTS ?>dashboard.js"></script>
</body>
</html>