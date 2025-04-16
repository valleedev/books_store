<div class="col-md-2 sidebar d-flex flex-column sticky-top" style="height: 100vh; z-index: 999;">
    <?php if (!isset($_SESSION['user'])): ?>
        <!-- Alerta de Bootstrap -->
        <div class="alert alert-warning m-3" role="alert">
            Debes iniciar sesión para acceder a esta sección.
        </div>
    <?php else: ?>
        <div class="user-section d-flex flex-column flex-grow-1">
            <h2 class="text-start p-2"><?= htmlspecialchars($_SESSION['user']['name']) ?></h2>
            <ul class="nav flex-column px-2 flex-grow-1 d-flex">
                <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                    <!-- Opciones para el administrador -->
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
                            Gestionar Categorías
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= CATEGORIES ?>dashboard.php">
                            Gestionar Pedidos
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Opciones para usuarios normales -->
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
                        <a class="icon-link icon-link-hover text-dark text-decoration-none" href="<?= USER ?>see_orders.php">
                            Mis Pedidos
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>