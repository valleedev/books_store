<?php
require_once __DIR__ . '/../../../router.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Detalle del Pedido</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="<?= STYLE ?>order_details.css">
    <!-- Estilos personalizados -->
    <style>
    </style>
</head>
<body>
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
                <h2 class="text-center mb-4">Detalle del Pedido</h2>
                
                <!-- Order Status -->
                <div class="mb-4">
                    <h5>Cambiar estado del pedido</h5>
                    <div class="input-group mb-3">
                        <select class="form-select">
                            <option selected>Pendiente</option>
                            <option>En proceso</option>
                            <option>Enviado</option>
                            <option>Entregado</option>
                            <option>Cancelado</option>
                        </select>
                    </div>
                    <button class="btn change-status-btn">Cambiar estado</button>
                </div>
                
                <!-- Shipping Address -->
                <div class="mb-4">
                    <h5>Direccion de envío</h5>
                    <p><strong>Dirección:</strong></p>
                    <p><strong>Ciudad:</strong></p>
                    <p><strong>Departamento:</strong></p>
                    <p><strong>Teléfono:</strong></p>
                </div>
                
                <!-- Order Details -->
                <div class="mb-4">
                    <h5>Datos del pedido</h5>
                    <p><strong>Número de pedido:</strong> 2</p>
                    <p><strong>Total a pagar:</strong> $24.000</p>
                    <p><strong>Productos:</strong></p>
                    
                    <!-- Products Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="product-img">
                                        Foto producto
                                    </div>
                                </td>
                                <td>Camiseta Azul</td>
                                <td>$ 20.000</td>
                                <td>Stock:</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-img">
                                        Foto producto
                                    </div>
                                </td>
                                <td>Camiseta Azul</td>
                                <td>$ 20.000</td>
                                <td>Stock:</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php
    include '../../includes/footer.php'
    ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>