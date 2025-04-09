<?php
require_once __DIR__ . '/../../router.php';
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
                    <div class="product-card">
                        <div class="product-title">Camiseta Azul</div>
                        <div class="product-price">$ 20.000</div>
                        <button class="buy-button">Agregar al carrito</button>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-title">Camiseta Azul</div>
                        <div class="product-price">$ 20.000</div>
                        <button class="buy-button">Agregar al carrito</button>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-title">Camiseta Azul</div>
                        <div class="product-price">$ 20.000</div>
                        <button class="buy-button">Agregar al carrito</button>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-title">Camiseta Azul</div>
                        <div class="product-price">$ 20.000</div>
                        <button class="buy-button">Agregar al carrito</button>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-title">Camiseta Azul</div>
                        <div class="product-price">$ 20.000</div>
                        <button class="buy-button">Agregar al carrito</button>
                    </div>
                    
                    <div class="product-card">
                        <div class="product-title">Camiseta Azul</div>
                        <div class="product-price">$ 20.000</div>
                        <button class="buy-button">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            include '../includes/footer.php';
        ?>
    </div>
</body>
</html>