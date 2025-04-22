<?php
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pedido_id = $_POST['pedido_id'];
    $nuevo_estado = $_POST['estado'];

    $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nuevo_estado, $pedido_id);
    mysqli_stmt_execute($stmt);
}

header("Location: dashboard.php");
exit();
?>
