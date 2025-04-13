<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php'; 
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    
    $query = "SELECT p.nombre, p.descripcion, p.precio, p.stock, p.imagen, c.nombre AS categoria 
              FROM productos p
              JOIN categorias c ON p.categoria_id = c.id
              WHERE p.id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        
        header("Location: ../../views/user/see_product.php");
        exit;
    }
} else {
    
    header("Location: ../../views/user/see_product.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_image = $_POST['product_image'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = 1;

    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += 1; 
            $found = true;
            break;
        }
    }

    
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'image' => $product_image,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity,
        ];
    }

    
    $_SESSION['message'] = "Producto agregado al carrito correctamente.";
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $product_id);
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
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../../includes/aside.php'; ?>

            <!-- Content -->
            <main class="col-md-10 w-75 mx-auto main-content p-4">
                <?php
                
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo $_SESSION['message'];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                    unset($_SESSION['message']); 
                }
                ?>
                <h1 class="text-center mb-5"><?= htmlspecialchars($product['nombre']) ?></h1>

                <div class="d-flex gap-4">
                    <div class="product-image d-flex justify-content-center">
                        <?php if (!empty($product['imagen'])): ?>
                            <?php echo "<img src='" . IMAGES . "uploads/products/" . $product['imagen'] . "' alt='Imagen del producto' class='img-fluid rounded'>  " ?>
                        <?php else: ?>
                            <span class="product-image-placeholder">Sin imagen</span>
                        <?php endif; ?>
                    </div>

                    <div class="product-info">
                        <div class="d-flex justify-content-between mb-3">
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
                            <?php
                            
                            $in_cart = false;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $item) {
                                    if ($item['id'] == $product_id) {
                                        $in_cart = true;
                                        break;
                                    }
                                }
                            }
                            ?>
                            
                            <?php if ($product['stock'] > 0): ?>
                                <?php if (!$in_cart): ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['nombre']) ?>">
                                        <input type="hidden" name="product_price" value="<?= $product['precio'] ?>">
                                        <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['imagen']) ?>">
                                        <input type="hidden" name="add_to_cart" value="1">
                                        <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-info rounded d-flex justify-content-center px-2">¡Ya en el carrito!</div>
                                <?php endif; ?>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Producto agotado</button>
                            <?php endif; ?>
                            <a href="../main.php" class="btn btn-secondary">Ver otros Productos</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</body>

</html>