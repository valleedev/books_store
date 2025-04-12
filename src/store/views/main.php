<?php
session_start(); // Asegúrate de iniciar la sesión al principio del archivo
require_once __DIR__ . '/../../router.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../bussines_logic/login/login.php';


// Función para agregar productos al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_image = $_POST['product_image'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = 1;

    // Inicializa el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verifica si el producto ya está en el carrito
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += 1; // Incrementa la cantidad
            $found = true;
            break;
        }
    }

    // Si no está en el carrito, agrégalo
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'image' => $product_image,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity,
        ];
    }

    // Mensaje de éxito
    $_SESSION['message'] = "Producto agregado al carrito correctamente.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener el ID de la categoría desde la URL (si está presente)
$categoria_id = isset($_GET['categoria_id']) && is_numeric($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : null;
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
                <?php
                // Mostrar mensaje de éxito si existe
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }
                ?>
                <div class="product-grid">
                    <?php
                    if ($categoria_id) {
                        $query = "SELECT id, nombre, precio, imagen, oferta FROM productos WHERE categoria_id = $categoria_id ORDER BY id DESC";
                    } else {
                        $query = "SELECT id, nombre, precio, imagen, oferta FROM productos ORDER BY id DESC";
                    }
                    $result = mysqli_query($conexion, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($producto = mysqli_fetch_assoc($result)) {
                            $precio_final = $producto['precio'];
                            if ($producto['oferta'] > 0) {
                                $precio_final = $producto['precio'] * (1 - ($producto['oferta'] / 100));
                            }

                            // Verificar si el producto ya está en el carrito
                            $in_cart = false;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $item) {
                                    if ($item['id'] == $producto['id']) {
                                        $in_cart = true;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <a class="product-card" href='user/see_product.php?id=<?= $producto['id'] ?>'>
                                <?php if (!empty($producto['imagen'])): ?>
                                <?php echo "<td><img src='" . IMAGES . "uploads/products/" . $producto['imagen'] . "' alt='Imagen del producto' style='max-width:200px; max-height: 200px;'></td>" ?>
                                <?php else: ?>
                                    <div class="no-image">Sin imagen</div>
                                <?php endif; ?>
                                <div class="product-title"><?= $producto['nombre'] ?></div>
                                <div class="product-price">$ <?= number_format($precio_final, 0, ',', '.') ?></div>
                                <?php if ($producto['oferta'] > 0): ?>
                                    <div class="product-discount">Descuento: <?= $producto['oferta'] ?>%</div>
                                <?php endif; ?>

                                <?php if (!$in_cart): ?>
                                <!-- Mostrar botón "Agregar al carrito" si no está en el carrito -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="add_to_cart" value="1">
                                    <input type="hidden" name="product_id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="product_image" value="<?= $producto['imagen'] ?>">
                                    <input type="hidden" name="product_name" value="<?= $producto['nombre'] ?>">
                                    <input type="hidden" name="product_price" value="<?= $precio_final ?>">
                                    <button type="submit" class="buy-button">Agregar al carrito</button>
                                </form>
                                <?php else: ?>
                                <!-- Mostrar mensaje si ya está en el carrito -->
                                <div class="in-cart-message">Ya en el carrito</div>
                                <?php endif; ?>
                            </a>
                            <?php
                        }
                    } else {
                        echo '<p class="no-products">No hay productos disponibles.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pedidoModalLabel">Iniciar Sesion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alerta alerta-error">
                                <?= $mensaje; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST"">
                    <div class=" mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php
    include '../includes/footer.php';
    ?>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>