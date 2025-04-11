<?php
require_once __DIR__ . '/../../../router.php';
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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php
            include '../../includes/aside.php'
            ?>
            <!-- Contenido principal -->
            <div class="col-md-10 orders-main-content p-4">
                <h2 class="text-center mb-5">TODOS LOS PEDIDOS</h2>
                
                <div class="table-responsive orders-table-container">
                    <table class="table table-bordered orders-table">
                        <thead>
                            <tr>
                                <th>Nro Pedido</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                            <tr class="order-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                            <tr class="order-row">
                                <td>1</td>
                                <td>$ 40.000.00</td>
                                <td>2025-02-05</td>
                                <td>Pendiente</td>
                            </tr>
                            <tr class="order-row">
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


</body>
</html>