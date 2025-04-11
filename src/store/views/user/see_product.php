<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php'; // Asegúrate de incluir la conexión a la base de datos
session_start();
// Verificar si el ID del producto está presente en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    // Consulta a la base de datos para obtener la información del producto
    $query = "SELECT p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria 
              FROM productos p
              JOIN categorias c ON p.categoria_id = c.id
              WHERE p.id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el producto existe
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        // Redirigir si el producto no existe
        header("Location: ../../views/user/products.php");
        exit;
    }
} else {
    // Redirigir si no se proporciona un ID válido
    header("Location: ../../views/user/products.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['nombre']) ?> - LIBRARIUM</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="<?= STYLE ?>see_product.css">
</head>
<body>
    <!-- Header -->
    <?php include '../../includes/navbar.php'; ?>
    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php include '../../includes/aside.php'; ?>
        <!-- Content -->
        <main class="content">
            <h1 class="product-title"><?= htmlspecialchars($product['nombre']) ?></h1>

            <div class="product-container">
                <div class="product-image">
                    <?php if (!empty($product['imagen'])): ?>
                        <img src="/public/images/uploads/products/<?= htmlspecialchars($product['imagen']) ?>" alt="<?= htmlspecialchars($product['nombre']) ?>" style="max-width: 300px; max-height: 300px;">
                    <?php else: ?>
                        <span class="product-image-placeholder">Sin imagen</span>
                    <?php endif; ?>
                </div>

                <div class="product-info">
                    <div class="product-header">
                        <div class="product-category">Categoría: <?= htmlspecialchars($product['categoria']) ?></div>
                        <div class="product-price-title">Precio: $<?= number_format($product['precio'], 0, ',', '.') ?></div>
                    </div>
                    
                    <p class="product-description">
                        <?= htmlspecialchars($product['descripcion']) ?>
                    </p>

                    <div class="product-stock">
                        Stock: <?= $product['stock'] > 0 ? $product['stock'] : 'Agotado' ?>
                    </div>

                    <div class="product-actions">
                        <?php if ($product['stock'] > 0): ?>
                            <form method="POST" action="../cart/add_to_cart.php">
                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['nombre']) ?>">
                                <input type="hidden" name="product_price" value="<?= $product['precio'] ?>">
                                <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['imagen']) ?>">
                                <button type="submit" class="btn btn-primary">COMPRAR</button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Producto agotado</button>
                        <?php endif; ?>
                        <a href="../main.php" class="btn btn-secondary">VER OTROS PRODUCTOS</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>
</body>
</html>