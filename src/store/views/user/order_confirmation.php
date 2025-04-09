<?php
require_once __DIR__ . '/../../../router.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Confirmación de Pedido</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>order_confirmation.css">
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
            <div class="col-md-9 main-content">
                <h1>Tu pedido se ha confirmado</h1>
                
                <div class="order-details">
                    <p>Tu pedido ha sido guardado con éxito, una vez que realices la transferencia bancaria a la cuenta 7382947289239ADD con precio total del pedido, será procesado y enviado.</p>
                    
                    <h3>Datos del pedido</h3>
                    <p>Número de pedido: 2</p>
                    <p>Total a pagar: $24.000.00</p>
                    <p>Productos:</p>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 20%"></th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="product-image">
                                        Foto producto
                                    </div>
                                </td>
                                <td>Nombre_producto</td>
                                <td>$ 20.000</td>
                                <td>Num Cantidad</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-image">
                                        Foto producto
                                    </div>
                                </td>
                                <td>Nombre_producto</td>
                                <td>$ 20.000</td>
                                <td>Num cantidad</td>
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
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>