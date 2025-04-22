<?php
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['nombre']) && !empty(trim($_POST['id'])) && !empty(trim($_POST['nombre']))) {

        $id = intval($_POST['id']);
        $nombre = trim($_POST['nombre']);

        $query = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('si', $nombre, $id);

            if ($stmt->execute()) {
                header('Location: ../../views/admin/categories.php?success=edit');
                exit();
            } else {
                header('Location: ../../views/admin/categories.php?error=edit');
                exit();
            }

            $stmt->close();
        } else {
            header('Location: ../../views/admin/categories.php?error=prepare');
            exit();
        }
    } else {
        header('Location: ../../views/admin/categories.php?error=invalid');
        exit();
    }
} else {
    header('Location: ../../views/admin/categories.php');
    exit();
}
?>