<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'admin') {
    header('Location: ../../views/main.php');
    exit();
}

$sql = "SELECT p.id, p.coste, p.fecha, p.estado, u.nombre, u.apellidos 
        FROM pedidos p 
        JOIN usuarios u ON p.usuario_id = u.id 
        ORDER BY p.fecha DESC";

$result = mysqli_query($conexion, $sql);
$pedidos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">  
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <style>
        .selectable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .selectable-row:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body> 
    <?php
    include '../../includes/navbar.php'
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            include '../../includes/aside.php'
            ?>
            <div class="col-md-10 main-content p-4">
                <h1 class="text-center mb-5  animate__animated animate__fadeInDown animate__faster">Gestionar Pedidos</h1>
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered animate__animated animate__fadeIn">
                        <thead class="table-light">
                            <tr>
                                <th>Nro Pedido</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pedidos)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay pedidos disponibles</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr class="selectable-row" onclick="window.location='order_details.php?id=<?= $pedido['id'] ?>'">
                                        <td><?= $pedido['id'] ?></td>
                                        <td>$ <?= number_format($pedido['coste'], 2, ',', '.') ?></td>
                                        <td><?= date('Y-m-d', strtotime($pedido['fecha'])) ?></td>
                                        <td>
                                            <?php
                                            $estadoClase = '';
                                            switch ($pedido['estado']) {
                                                case 'Pendiente':
                                                    $estadoClase = 'text-warning';
                                                    break;
                                                case 'En proceso':
                                                    $estadoClase = 'text-primary';
                                                    break;
                                                case 'Enviado':
                                                    $estadoClase = 'text-info';
                                                    break;
                                                case 'Entregado':
                                                    $estadoClase = 'text-success';
                                                    break;
                                            }
                                            ?>
                                            <span class="<?= $estadoClase ?>"><?= $pedido['estado'] ?></span>
                                        </td>
                                        <td><?= $pedido['nombre'] . ' ' . $pedido['apellidos'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../../includes/footer.php'
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= SCRIPTS ?>dashboard.js"></script>
</body>
</html>