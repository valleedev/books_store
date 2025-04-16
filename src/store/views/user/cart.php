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
            <div class="col-md-10">
                <section class="mb-5">
                    <h2 class="text-center py-4">Carrito de Compras</h2>

                    <!-- Encabezados de columnas -->
                    <div class="row mb-4 border py-2 bg-light fw-bold text-center">
                        <div class="col-md-2">Imagen</div>
                        <div class="col-md-4 text-start">Nombre</div>
                        <div class="col-md-2">Precio</div>
                        <div class="col-md-2">Cantidad</div>
                        <div class="col-md-2">Acciones</div>
                    </div>

                    <!-- Productos -->
                    <?php if (!empty($cart)): ?>
                        <?php foreach ($cart as $index => $product): ?>
                            <div class="row align-items-center py-3 border-bottom">
                                <div class="col-md-2 text-center">
                                    <img src="<?= IMAGES . "uploads/products/" . htmlspecialchars($product['image']) ?>" alt="Imagen del producto" class="img-fluid" style="max-height: 100px;">
                                </div>

                                <div class="col-md-4">
                                    <p class="mb-0"><?= htmlspecialchars($product['name']) ?></p>
                                </div>

                                <div class="col-md-2 text-center">
                                    <p class="mb-0">$ <?= number_format($product['price'], 0, ',', '.') ?></p>
                                </div>

                                <div class="col-md-2 text-center">
                                    <form action="../../bussines_logic/cart/update_cart.php" method="POST" class="d-inline">
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary">-</button>
                                    </form>
                                    <span class="mx-2"><?= htmlspecialchars($product['quantity']) ?></span>
                                    <form action="../../bussines_logic/cart/update_cart.php" method="POST" class="d-inline">
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-secondary">+</button>
                                    </form>
                                </div>

                                <div class="col-md-2 text-center">
                                    <form action="../../bussines_logic/cart/update_cart.php" method="POST">
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger">ELIMINAR</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="row py-4">
                            <div class="col-12 text-center">
                                <p class="text-muted">No hay productos en el carrito.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Acciones del carrito -->
                    <div class="row border-top pt-4 mt-4">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <form action="../../bussines_logic/cart/update_cart.php" method="POST">
                                <button type="submit" name="action" value="empty" class="btn btn-outline-danger">VACIAR CARRITO</button>
                            </form>
                        </div>

                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pedidoModal">HACER PEDIDO</button>
                        </div>

                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <h5 class="mb-0 text-center">
                                Precio Total: $ <?= number_format(array_sum(array_map(fn($p) => $p['price'] * $p['quantity'], $cart)), 0, ',', '.') ?>
                            </h5>
                        </div>
                    </div>
                </section>
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