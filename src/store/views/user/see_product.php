<?php
require_once __DIR__ . '/../../../router.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link rel="stylesheet" href="<?= STYLE ?>see_product.css">
    <!-- Estilos personalizados -->
    <style>
    </style>
</head>
<body>
    <!-- Header -->
    <?php
    include '../../includes/navbar.php'
    ?>
    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php
            include '../../includes/aside.php'
        ?>
        <!-- Content -->
        <main class="content">
            <h1 class="product-title">Ver Producto</h1>

            <div class="product-container">
                <div class="product-image">
                    <!-- Aquí iría la imagen del producto -->
                    <!-- <img src="ruta-de-la-imagen.jpg" alt="Nombre del producto"> -->
                    <span class="product-image-placeholder">Foto producto</span>
                </div>

                <div class="product-info">
                    <div class="product-header">
                        <div class="product-category">Categoria</div>
                        <div class="product-price-title">Precio</div>
                    </div>
                    
                    <p class="product-description">
                        es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años.
                    </p>

                    <div class="product-stock">
                        Stock: {No}
                    </div>

                    <div class="product-actions">
                        <button class="btn-primary">COMPRAR</button>
                        <button class="btn-secondary">VER OTROS PRODUCTOS</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php
    include '../../includes/footer.php'
    ?>
</body>
</html>