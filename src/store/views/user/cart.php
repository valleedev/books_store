<?php
require_once __DIR__ . '/../../../router.php';

session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Carrito de Compras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?= STYLE ?>cart.css">
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
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <h1>Carrito de Compras</h1>
                
                <!-- Column Headers -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Nombre</h5>
                    </div>
                    <div class="col-md-2 text-center">
                        <h5>Precio</h5>
                    </div>
                    <div class="col-md-2 text-center">
                        <h5>Cantidad</h5>
                    </div>
                    <div class="col-md-2 text-center">
                        <!-- Empty for alignment -->
                    </div>
                </div>
                
                <!-- Products -->
                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $index => $product): ?>
                        <div class="row product-row">
                            <div class="col-md-2">
                                <div class="product-image">
                                <?php echo "<td><img src='" . IMAGES . "uploads/products/" . $product['image'] . "' alt='Imagen del producto' style='max-width:150px; max-height: 150px;'></td>" ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p><?= htmlspecialchars($product['name']) ?></p>
                            </div>
                            <div class="col-md-2 text-center">
                                <p>$ <?= number_format($product['price'], 0, ',', '.') ?></p>
                            </div>
                            <div class="col-md-2 text-center">
                                <!-- Botón para disminuir cantidad -->
                                <form action="../../bussines_logic/cart/update_cart.php" method="POST" class="d-inline">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary">-</button>
                                </form>
                                <span><?= htmlspecialchars($product['quantity']) ?></span>
                                <!-- Botón para aumentar cantidad -->
                                <form action="../../bussines_logic/cart/update_cart.php" method="POST" class="d-inline">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-secondary">+</button>
                                </form>
                            </div>
                            <div class="col-md-2 text-center">
                                <form action="../../bussines_logic/cart/update_cart.php" method="POST" class="d-inline">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger">ELIMINAR</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>No hay productos en el carrito.</p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Cart Actions -->
                <div class="row cart-actions">
                    <div class="col-md-4">
                        <form action="../../bussines_logic/cart/update_cart.php" method="POST">
                            <button type="submit" name="action" value="empty" class="btn btn-vaciar btn-danger">VACIAR CARRITO</button>
                        </form>
                    </div>
                    <div class="col-md-4 text-center">
                        <h5>
                            Precio Total: 
                            $ <?= number_format(array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $cart)), 0, ',', '.') ?>
                        </h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <!-- Button to trigger modal -->
                        <button class="btn btn-pedido" data-bs-toggle="modal" data-bs-target="#pedidoModal">HACER PEDIDO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pedidoModalLabel">Hacer Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesar_pedido.php" method="POST">
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                        </div>
                        <div class="mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" required>
                        </div>
                        <div class="mb-3">
                            <label for="contacto" class="form-label">Nro de Contacto</label>
                            <div class="input-group">
                                <select class="form-select" id="prefijo" name="prefijo" required>
                                    <option value="+57" selected>+57 (Colombia)</option>
                                    <option value="+1">+1 (EE.UU.)</option>
                                    <option value="+44">+44 (Reino Unido)</option>
                                    <option value="+34">+34 (España)</option>
                                    <option value="+52">+52 (México)</option>
                                    <!-- Agrega más prefijos según sea necesario -->
                                </select>
                                <input type="number" class="form-control" id="contacto" name="contacto" placeholder="Número de contacto" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                    </form>
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