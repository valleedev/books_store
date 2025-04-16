<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../../db.php'; // Ruta corregida
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que el campo 'categoryName' esté presente y no esté vacío
    if (isset($_POST['categoryName']) && !empty(trim($_POST['categoryName']))) {

        $categoryName = trim($_POST['categoryName']);

        // Preparar la consulta SQL para insertar la nueva categoría
        $query = "INSERT INTO categorias (nombre) VALUES (?)"; // Cambiado 'name' a 'nombre'
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            // Vincular el parámetro y ejecutar la consulta
            $stmt->bind_param('s', $categoryName);

            if ($stmt->execute()) {
                // Redirigir de vuelta a la página de categorías con un mensaje de éxito
                header('Location: ../../views/admin/categories.php?success=1');
                exit();
            } else {
                // Redirigir con un mensaje de error si la inserción falla
                header('Location: ../../views/admin/categories.php?error=1');
                exit();
            }

            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si la preparación de la consulta falla
            header('Location: ../../views/admin/categories.php?error=2');
            exit();
        }
    } else {
        // Redirigir con un mensaje de error si el campo está vacío
        header('Location: ../../views/admin/categories.php?error=3');
        exit();
    }
} else {
    // Si no es una solicitud POST, redirigir a la página de categorías
    header('Location: ../../views/admin/categories.php');
    exit();
}