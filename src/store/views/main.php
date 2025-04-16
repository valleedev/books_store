<?php
session_start();
require_once __DIR__ . '/../../router.php';
require_once __DIR__ . '/../../db.php';

// Agregar productos al carrito
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
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$query = "SELECT id, nombre FROM categorias";
$result = mysqli_query($conexion, $query);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

</head>

<body>
    <?php
    include '../includes/navbar.php';
    ?>



    <div class="container-fluid">



        <div class="row">
            <!-- Aside -->
            <?php
            include '../includes/aside.php';
            ?>


            <!-- Contenido Principal -->

            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>


            <div class="col-md-10">

                <nav class="navbar navbar-expand-lg bg-light rounded mb-4 sticky-top">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategorias" aria-controls="navbarCategorias" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-center" id="navbarCategorias">
                            <ul class="navbar-nav nav-underline">
                                <li class="nav-item">
                                    <a class="nav-link <?= is_null($categoria_id) ? 'active' : '' ?>" href="main.php">Todos</a>
                                </li>
                                <?php
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($categoria = mysqli_fetch_assoc($result)) {
                                        $active_class = ($categoria_id === (int)$categoria['id']) ? 'active' : '';
                                        echo '<li class="nav-item">';
                                        echo '<a class="nav-link ' . $active_class . '" href="main.php?categoria_id=' . $categoria['id'] . '">' . htmlspecialchars($categoria['nombre']) . '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                    echo '<li class="nav-item"><a class="nav-link disabled" href="#">Sin categorías</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <h2 class="text-center pb-3">Nuestros Libros</h2>

                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }
                ?>

                <div class="row g-4 p-4">
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
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <article class="card h-100">
                                    <a href='user/see_product.php?id=<?= $producto['id'] ?>' class="text-decoration-none text-dark">
                                        <?php if (!empty($producto['imagen'])): ?>
                                            <img src="<?= IMAGES ?>uploads/products/<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen del producto" style="max-height: 200px; object-fit: contain;">
                                        <?php else: ?>
                                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">Sin imagen</div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                                            <p class="card-text fw-bold">$ <?= number_format($precio_final, 0, ',', '.') ?></p>
                                            <?php if ($producto['oferta'] > 0): ?>
                                                <p class="text-danger small mb-2">Descuento: <?= $producto['oferta'] ?>%</p>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                    <div class="card-footer bg-white border-0 text-center">
                                        <?php if (!$in_cart): ?>
                                            <form method="POST">
                                                <input type="hidden" name="add_to_cart" value="1">
                                                <input type="hidden" name="product_id" value="<?= $producto['id'] ?>">
                                                <input type="hidden" name="product_image" value="<?= $producto['imagen'] ?>">
                                                <input type="hidden" name="product_name" value="<?= $producto['nombre'] ?>">
                                                <input type="hidden" name="product_price" value="<?= $precio_final ?>">
                                                <button type="submit" class="btn btn-primary btn-sm">Agregar al carrito</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="badge text-bg-success">Ya en el carrito</span>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p class="text-muted">No hay productos disponibles.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include '../includes/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>