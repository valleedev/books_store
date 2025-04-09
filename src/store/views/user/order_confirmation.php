<?php
require_once __DIR__ . '/../../../router.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Confirmación de Pedido</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STYLE ?>order_confirmation.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo-container">
                <div class="logo">
                    <img src="/placeholder.svg?height=40&width=40" alt="Librarium Logo">
                </div>
                <h1 class="brand-name">LIBRARIUM</h1>
            </div>
        </div>
    </header>
    
    <!-- Navegación -->
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
            
            
            <!-- Contenido principal -->
            <div class="col-md-9 main-content">
                <h1>Tu pedido se ha confirmado</h1>
                
                <div class="order-details">
                    <p>Tu pedido ha sido guardado con éxito, una vez que realices la transferencia bancaria a la cuenta 7382947289239ADD con precio total del pedido, será procesado y enviado.</p>
                    
                    <h3>Datos del pedido</h3>
                    <p>Número de pedido: 2</p>
                    <p>Total a pagar: $24.000.00</p>
                    <p>Productos:</p>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 20%"></th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="product-image">
                                        Foto producto
                                    </div>
                                </td>
                                <td>Nombre_producto</td>
                                <td>$ 20.000</td>
                                <td>Num Cantidad</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="product-image">
                                        Foto producto
                                    </div>
                                </td>
                                <td>Nombre_producto</td>
                                <td>$ 20.000</td>
                                <td>Num cantidad</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <p class="mb-0">Desarrollado por Grupo n° 2 | SENA CDITI 2025</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>