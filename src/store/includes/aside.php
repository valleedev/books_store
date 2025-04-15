<div class="col-md-2 sidebar border d-flex flex-column sticky-top" style="top: 57px; height: 85vh; z-index: 999;">
    <?php if (!isset($_SESSION['user'])): ?>
        <!-- Mostrar botones de Ingresar y Registrarse si no hay sesión -->
        <div class="guest-section d-flex flex-column align-items-center justify-content-center">
            <a href="<?= USER ?>login.php" class="btn btn-primary mb-2 w-75">Ingresar</a>
            <a href="<?= USER ?>register.php" class="btn btn-secondary w-75">Registrarse</a>
        </div>
        <!-- Mostrar opciones adicionales --> 
        <hr>
        <div class="guest-options mt-3">
            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= USER ?>see_orders.php">
                        Mis pedidos
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= PRODUCTS ?>products.php">
                        Gestionar pedidos
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= PRODUCTS ?>categories.php">
                        Gestionar categorías
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <!-- Mostrar contenido actual si hay sesión -->
        <div class="cart-summary mb-3 w-100">
            <h2 class="text-start p-2">Carrito</h2>
            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= MAIN ?>main.php">
                        Productos
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= USER ?>cart.php">
                        Ver Carrito
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="#">
                        Total productos
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>

        <div class="user-section d-flex flex-column flex-grow-1">
            <h2 class="text-start p-2"><?= $_SESSION['user']['name'] ?></h2>
            <ul class="nav flex-column px-2 flex-grow-1 d-flex">
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= PRODUCTS ?>products.php">
                        Gestionar productos
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= CATEGORIES ?>categories.php">
                        Gestionar Categorias
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="#">
                        Mis pedidos
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item mt-auto">
                    <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= USER ?>logout.php">
                        Cerrar Sesión
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>