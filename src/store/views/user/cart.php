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
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
</head>
<body>
    <?php
    include '../../includes/navbar.php'
    ?>
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
                        <!-- Button to trigger modal -->
                        <button class="btn btn-pedido" data-bs-toggle="modal" data-bs-target="#pedidoModal">HACER PEDIDO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pedidoModalLabel">Hacer Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesar_pedido.php" method="POST">
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                        </div>
                        <div class="mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" required>
                        </div>
                        <div class="mb-3">
                            <label for="contacto" class="form-label">Nro de Contacto</label>
                            <div class="input-group">
                                <select class="form-select" id="prefijo" name="prefijo" required>
                                    <option value="+57" selected>+57 (Colombia)</option>
                                    <option value="+1">+1 (EE.UU.)</option>
                                    <option value="+44">+44 (Reino Unido)</option>
                                    <option value="+34">+34 (España)</option>
                                    <option value="+52">+52 (México)</option>
                                    <!-- Agrega más prefijos según sea necesario -->
                                </select>
                                <input type="number" class="form-control" id="contacto" name="contacto" placeholder="Número de contacto" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                    </form>
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