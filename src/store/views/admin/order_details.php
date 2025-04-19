<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'admin') {
    header('Location: ../../views/main.php');
    exit();
}

// Obtener el ID del pedido de la URL
$pedido_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($pedido_id <= 0) {
    header('Location: categories.php');
    exit();
}

// Obtener información del pedido
$sql = "SELECT p.id, p.coste, p.fecha, p.estado, p.direccion, p.provincia, p.fecha, p.localidad, u.nombre, u.apellidos
         FROM pedidos p 
         JOIN usuarios u ON p.usuario_id = u.id 
         WHERE p.id = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $pedido_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pedido = mysqli_fetch_assoc($result);

if (!$pedido) {
    header('Location: products.php');
    exit();
}

// Obtener los productos del pedido
$sql_productos = "SELECT l.stock, dp.coste, l.nombre, l.imagen
                 FROM pedidos dp
                 JOIN productos l ON dp.id = l.id
                 WHERE dp.id = ?";

$stmt_prod = mysqli_prepare($conexion, $sql_productos);
mysqli_stmt_bind_param($stmt_prod, "i", $pedido_id);
mysqli_stmt_execute($stmt_prod);
$result_prod = mysqli_stmt_get_result($stmt_prod);
$productos = mysqli_fetch_all($result_prod, MYSQLI_ASSOC);

// Procesar cambio de estado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_estado'])) {
    $nuevo_estado = $_POST['nuevo_estado'];
    $sql_update = "UPDATE pedidos SET estado = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "si", $nuevo_estado, $pedido_id);
    mysqli_stmt_execute($stmt_update);

    // Refrescar la página para mostrar el estado actualizado
    header("Location: order_details.php?id=$pedido_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Detalle del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
</head>

<body>
    <?php include '../../includes/navbar.php' ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../../includes/aside.php' ?>

            <!-- Contenido principal -->
            <div class="col-md-10 main-content p-4 animate__animated animate__fadeIn animate__faster">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white text-center animate__animated animate__fadeInDown animate__faster">
                        <h3>Detalle del Pedido</h3>
                    </div>
                    <div class="card-body ">
                        <!-- Cambiar estado del pedido -->
                        <div class="mb-4">
                            <h5>Cambiar estado del pedido</h5>
                            <form method="post" class="row align-items-end">
                                <div class="col-md-9">
                                    <select name="nuevo_estado" class="form-select">
                                        <?php
                                        $estados = ['Pendiente', 'En proceso', 'Enviado', 'Entregado'];
                                        foreach ($estados as $estado):
                                        ?>
                                            <option value="<?= $estado ?>" <?= $pedido['estado'] == $estado ? 'selected' : '' ?>>
                                                <?= $estado ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-light border">Cambiar estado</button>
                                </div>
                            </form>
                        </div>

                        <!-- Dirección de envío -->
                        <div class="mb-4">
                            <h5>Dirección de envío</h5>
                            <div class="ms-3">
                                <p class="mb-1"><strong>Dirección:</strong> <?= htmlspecialchars($pedido['direccion']) ?></p>
                                <p class="mb-1"><strong>Provincia:</strong> <?= htmlspecialchars($pedido['provincia']) ?></p>
                                <p class="mb-1"><strong>Departamento:</strong> <?= htmlspecialchars($pedido['localidad']) ?></p>
                            </div>
                        </div>

                        <!-- Datos del pedido -->
                        <div class="mb-4">
                            <h5>Datos del pedido</h5>
                            <div class="ms-3">
                                <p class="mb-1"><strong>Número de pedido:</strong> <?= $pedido['id'] ?></p>
                                <p class="mb-1"><strong>Total a pagar:</strong> $<?= number_format($pedido['coste'], 0, ',', '.') ?></p>
                                <p class="mb-1"><strong>Productos:</strong></p>

                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 100px"></th>
                                                <th>Nombre</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productos as $producto): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php if (!empty($producto['imagen'])): ?>
                                                            <img src="<?= IMAGES . $producto['imagen'] ?>" alt="Foto producto" class="img-thumbnail" style="max-height: 60px;">
                                                        <?php else: ?>
                                                            <div class="bg-light text-center p-2">Foto producto</div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                                                    <td>$ <?= number_format($producto['precio'], 0, ',', '.') ?></td>
                                                    <td>Stock: <?= $producto['stock'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <a href="<?= PRODUCTS ?>dashboard.php" class="btn btn-secondary">Volver a la lista de pedidos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php' ?>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script personalizado -->
    <script src="<?= SCRIPTS ?>dashboard.js"></script>
</body>

</html>