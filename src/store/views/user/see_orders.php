<?php
require_once __DIR__ . '/../../../router.php';
require_once __DIR__ . '/../../../db.php';

session_start();

$result = null;

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];

    $sql = "SELECT id, coste, fecha, estado FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        echo "Error en la preparación de la consulta.";
        exit;
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIUM - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
    <link rel="stylesheet" href="<?= STYLE ?>dashboard.css">
    <link rel="stylesheet" href="<?= STYLE ?>index.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>
<body> 
    <?php include '../../includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include '../../includes/aside.php'; ?>

            <div class="col-md-10 orders-main-content p-4">
                <h2 class="text-center mb-5 animate__animated animate__fadeInDown animate__faster">Todos los Pedidos</h2>

                <div class="table-responsive orders-table-container animate__animated animate__fadeIn animate__faster">
                    <table class="table table-bordered orders-table">
                        <thead>
                            <tr>
                                <th>Nro Pedido</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr class="order-row">
                                        <td><?= $row['id'] ?></td>
                                        <td>$ <?= number_format($row['coste'], 2, ',', '.') ?></td>
                                        <td><?= $row['fecha'] ?></td>
                                        <td><?= $row['estado'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay pedidos disponibles.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>

</body>
</html>
