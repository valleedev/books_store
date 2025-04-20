<?php
require_once __DIR__ . '/../../../db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['categoryName']) && !empty(trim($_POST['categoryName']))) {

        $categoryName = trim($_POST['categoryName']);

        $query = "INSERT INTO categorias (nombre) VALUES (?)";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $categoryName);

            if ($stmt->execute()) {
                header('Location: ../../views/admin/categories.php?success=1');
                exit();
            } else {
                header('Location: ../../views/admin/categories.php?error=1');
                exit();
            }

            $stmt->close();
        } else {
            header('Location: ../../views/admin/categories.php?error=2');
            exit();
        }
    } else {
        header('Location: ../../views/admin/categories.php?error=3');
        exit();
    }
} else {
    header('Location: ../../views/admin/categories.php');
    exit();
}