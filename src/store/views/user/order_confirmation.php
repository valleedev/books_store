<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

session_start();

if (!isset($_SESSION['pedido'])) {
    header("Location: cart.php");
    exit();
}

$pedido = $_SESSION['pedido'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Confirmación de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" href="<?= STYLE ?>order_confirmation.css">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
</head>
<body>
    <?php
    include '../../includes/navbar.php'
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            include '../../includes/aside.php'
            ?>
            
            <div class="col-md-9 main-content">
                <div class="card my-5">
                    <div class="card-header bg-success text-white animate__animated animate__fadeInDown animate__faster">
                        <h1 class="mb-0">¡Tu pedido se ha confirmado!</h1>
                    </div>
                    <div class="card-body animate__animated animate__fadeIn animate__faster">
                        <div class="order-details">
                            <div class="alert alert-info">
                                <p>Tu pedido ha sido guardado con éxito. Una vez que realices la transferencia bancaria a la cuenta <strong>7382947289239ADD</strong> con el precio total del pedido, será procesado y enviado.</p>
                            </div>
                            
                            <h3>Datos del pedido</h3>
                            <ul class="list-group mb-4">
                                <li class="list-group-item"><strong>Número de pedido:</strong> <?= $pedido['id'] ?></li>
                                <li class="list-group-item"><strong>Total a pagar:</strong> $<?= number_format($pedido['coste'], 0, ',', '.') ?></li>
                                <li class="list-group-item"><strong>Provincia:</strong> <?= htmlspecialchars($pedido['provincia']) ?></li>
                                <li class="list-group-item"><strong>Localidad:</strong> <?= htmlspecialchars($pedido['localidad']) ?></li>
                                <li class="list-group-item"><strong>Dirección:</strong> <?= htmlspecialchars($pedido['direccion']) ?></li>
                                <?php if (isset($pedido['telefono'])): ?>
                                <li class="list-group-item"><strong>Teléfono:</strong> <?= htmlspecialchars($pedido['telefono']) ?></li>
                                <?php endif; ?>
                                <li class="list-group-item"><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($pedido['fecha'])) ?> a las <?= $pedido['hora'] ?></li>
                            </ul>
                        </div>
                        
                        <h3>Productos:</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedido['productos'] as $producto): ?>
                                    <tr>
                                        <td>
                                            <div class="product-image">
                                                <img src="<?= IMAGES . "uploads/products/" . htmlspecialchars($producto['image']) ?>" alt="<?= htmlspecialchars($producto['name']) ?>" class="img-fluid" style="max-height: 80px;">
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($producto['name']) ?></td>
                                        <td>$ <?= number_format($producto['price'], 0, ',', '.') ?></td>
                                        <td><?= $producto['quantity'] ?></td>
                                        <td>$ <?= number_format($producto['price'] * $producto['quantity'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>$ <?= number_format($pedido['coste'], 0, ',', '.') ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="<?= VIEWS ?>main.php" class="btn btn-primary">Volver a la tienda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    include '../../includes/footer.php'
    ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>