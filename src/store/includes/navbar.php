<?php
require_once __DIR__ . '/../../db.php';

$query = "SELECT id, nombre FROM categorias";
$result = mysqli_query($conexion, $query);

// Obtener el ID de la categoría seleccionada desde la URL
$categoria_id = isset($_GET['categoria_id']) && is_numeric($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : null;
?>

<nav class="navbar header">
    <div class="container-fluid">
        <a class="navbar-brand d-flex" href="<?= VIEWS ?>main.php">
            <img src="<?= IMAGES ?>bookLogo.jpeg" alt="Logo" width="50" height="50" class="d-inline-block rounded-circle">
            <h1 class="brand-name">LIBRARIUM</h1>
        </a>
    </div>
</nav>

<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" style="z-index: 999;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav nav-underline">
                <!-- Enlace para "Todos" -->
                <li class="nav-item">
                    <a class="nav-link <?= is_null($categoria_id) ? 'active' : '' ?>" href="main.php">Todos</a>
                </li>
                <?php
                // Enlaces dinámicos para las categorías
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($categoria = mysqli_fetch_assoc($result)) {
                        $active_class = ($categoria_id === (int)$categoria['id']) ? 'active' : '';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link ' . $active_class . '" href="main.php?categoria_id=' . $categoria['id'] . '">' . htmlspecialchars($categoria['nombre']) . '</a>';
                        echo '</li>';
                    }
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="#">Sin categorías</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
