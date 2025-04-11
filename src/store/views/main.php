<?php
require_once __DIR__ . '/../../router.php';
require_once __DIR__ . '/../../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main - Book Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>main.css">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

</head>
<body>
    <?php 
        include '../includes/navbar.php';
    ?>
    <div class="container-m">    
        <div class="main-content">
            <?php
                include '../includes/aside.php';
            ?>
            <?php if (!empty($message)): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
                <button type="button" class="btn btn-create" data-bs-toggle="modal" data-bs-target="#createModal">
                    Crear Producto
                </button>
                <!-- Modal de Creación -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="createModalLabel">Crear Producto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="sign_in.php" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                                    </div>                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo electronico</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Crear</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            <div class="products">
                <h2>Nuestros Productos</h2>
                
                <div class="product-grid">
                    <?php
                    $query = "SELECT id, nombre, precio, imagen, oferta FROM productos ORDER BY id DESC";
                    $result = mysqli_query($conexion, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($producto = mysqli_fetch_assoc($result)) {
                            $precio_final = $producto['precio'];
                            if ($producto['oferta'] > 0) {
                                $precio_final = $producto['precio'] * (1 - ($producto['oferta'] / 100));
                            }
                            ?>
                            <div class="product-card">
                                <?php if (!empty($producto['imagen'])): ?>
                                <img src="/public/uploads/productos/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" class="product-image">
                                <?php else: ?>
                                <div class="no-image">Sin imagen</div>
                                <?php endif; ?>
                                <div class="product-title"><?= $producto['nombre'] ?></div>
                                <div class="product-price">$ <?= number_format($precio_final, 0, ',', '.') ?></div>
                                <?php if ($producto['oferta'] > 0): ?>
                                <div class="product-discount">Descuento: <?= $producto['oferta'] ?>%</div>
                                <?php endif; ?>
                                <button class="buy-button" onclick="agregarAlCarrito(<?= $producto['id'] ?>)">Agregar al carrito</button>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="no-products">No hay productos disponibles.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php 
            include '../includes/footer.php';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>