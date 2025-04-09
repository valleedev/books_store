<?php
require_once __DIR__ . '/../../../router.php';

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
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo-container">
                <div class="logo">
                    <img src="<?= IMAGES ?>logo-librarium.jpg" alt="Librarium Logo">
                </div>
                <h1 class="brand-name">LIBRARIUM</h1>
            </div>
        </div>
    </header>
    
    <!-- Navigation Menu -->
    <nav class="nav-menu">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoría 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoría 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoría 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoría 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoría 5</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-1 sidebar">
                <div class="cart-summary mb-5 w-100">
                    <h2>Carrito</h2>
                    <p>- Productos 165</p>
                    <p>- Total 150.00.00</p>
                    <p>- Ver Carrito</p>
                </div>
                
                <div class="user-section">
                    <h2>Isaac Cardona</h2>
                    <p>- Gestionar productos</p>
                    <p>- Gestionar categorías</p>
                    <p>- Gestionar pedidos</p>
                    <p>- Mis pedidos</p>
                    <p>- Cerrar sesión</p>
                </div>
            </div> 
            
            <!-- Main Content -->
            <div class="col-md-9 main-content">
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
                
                <!-- Product 1 -->
                <div class="row product-row">
                    <div class="col-md-2">
                        <div class="product-image">
                            <p>Foto producto</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>Nombre_producto</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p>$ 20.000</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p>Num Cantidad</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <button class="btn btn-eliminar">ELIMINAR</button>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="row product-row">
                    <div class="col-md-2">
                        <div class="product-image">
                            <p>Foto producto</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>Nombre_producto</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p>$ 20.000</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p>Num cantidad</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <button class="btn btn-eliminar">ELIMINAR</button>
                    </div>
                </div>
                
                <!-- Cart Actions -->
                <div class="row cart-actions">
                    <div class="col-md-4">
                        <button class="btn btn-vaciar">VACIAR CARRITO</button>
                    </div>
                    <div class="col-md-4 text-center">
                        <h5>Precio Total {Total}</h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-pedido">HACER PEDIDO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">Desarrollado por Grupo n° 2 | SENA CDITI 2025</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>