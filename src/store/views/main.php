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
    
</body>
</html>