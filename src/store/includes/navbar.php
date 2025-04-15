<?php
require_once __DIR__ . '/../../db.php';
?>

<nav class="navbar header">
    <div class="container-fluid">
        <a class="navbar-brand d-flex" href="<?= VIEWS ?>main.php">
            <img src="<?= IMAGES ?>bookLogo.jpeg" alt="Logo" width="50" height="50" class="d-inline-block rounded-circle">
            <h1 class="brand-name">LIBRARIUM</h1>
        </a>
        <?php if (!isset($_SESSION['user'])): ?>
            <div class="d-flex">
                <a href="<?= VIEWS ?>register.php" class="btn btn-secondary mx-2">Registrarse</a>
                <a href="<?= VIEWS ?>login.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pedidoModal">Iniciar Sesión</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
