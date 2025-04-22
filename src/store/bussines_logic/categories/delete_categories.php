<?php
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && !empty(trim($_POST['id']))) {

        $id = intval($_POST['id']);

        $query = "DELETE FROM categorias WHERE id = ?";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                header('Location: ../../views/admin/categories.php?success=delete');
                exit();
            } else {
                header('Location: ../../views/admin/categories.php?error=delete');
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