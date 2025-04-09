<?php
require_once __DIR__ . '/../../../router.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Gestión de Categorías</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header, .footer {
            background-color: #4a7a7c;
            color: white;
            padding: 15px 0;
        }
        .logo {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .logo img {
            width: 30px;
            height: 30px;
        }
        .nav-menu {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .sidebar {
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - 170px);
            padding: 20px 15px;
        }
        .sidebar-section {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        .sidebar-section:last-child {
            border-bottom: none;
        }
        .sidebar-menu {
            list-style: none;
            padding-left: 10px;
        }
        .sidebar-menu li {
            margin-bottom: 5px;
            cursor: pointer;
        }
        .sidebar-menu li:hover {
            color: #4a7a7c;
        }
        .main-content {
            padding: 20px;
        }
        .btn-edit {
            background-color: #b8e0e6;
            border-color: #b8e0e6;
            color: #000;
        }
        .btn-delete {
            background-color: #f5c6cb;
            border-color: #f5c6cb;
            color: #000;
        }
        .table th {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container d-flex align-items-center">
            <div class="logo">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Captura%20de%20pantalla%202025-04-09%20084805-1in9vR6bsMx0LEI5k45pSu4bj8MIkK.png" alt="Logo">
            </div>
            <h1 class="mb-0">LIBRARIUM</h1>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="nav-menu">
        <div class="container">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoria 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoria 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoria 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoria 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categoria 5</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="sidebar-section">
                    <h5>Carrito</h5>
                    <ul class="sidebar-menu">
                        <li>• Productos 165</li>
                        <li>• Total 150.00.00</li>
                        <li>• Ver Carrito</li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h5>Isaac Cardona</h5>
                    <ul class="sidebar-menu">
                        <li>• Gestionar productos</li>
                        <li>• Gestionar categorías</li>
                        <li>• Gestionar pedidos</li>
                        <li>• Mis pedidos</li>
                        <li>• Cerrar sesión</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9 main-content">
                <h2 class="text-center mb-4">Gestión de Catergorías</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%">NOMBRES</th>
                            <th width="30%"></th>
                            <th width="30%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pantalones</td>
                            <td><button class="btn btn-edit w-100">Editar</button></td>
                            <td><button class="btn btn-delete w-100">Eliminar</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Camisas</td>
                            <td><button class="btn btn-edit w-100">Editar</button></td>
                            <td><button class="btn btn-delete w-100">Eliminar</button></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Medias</td>
                            <td><button class="btn btn-edit w-100">Editar</button></td>
                            <td><button class="btn btn-delete w-100">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p class="mb-0">Desarrollado por Grupo nº 2 | SENA CDITI 2025</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>