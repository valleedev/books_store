<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que el campo 'id' esté presente y no esté vacío
    if (isset($_POST['id']) && !empty(trim($_POST['id']))) {

        $id = intval($_POST['id']);

        // Preparar la consulta SQL para eliminar la categoría
        $query = "DELETE FROM categorias WHERE id = ?";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            // Vincular el parámetro y ejecutar la consulta
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                // Redirigir de vuelta a la página de categorías con un mensaje de éxito
                header('Location: ../../views/admin/categories.php?success=delete');
                exit();
            } else {
                // Redirigir con un mensaje de error si la eliminación falla
                header('Location: ../../views/admin/categories.php?error=delete');
                exit();
            }

            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si la preparación de la consulta falla
            header('Location: ../../views/admin/categories.php?error=prepare');
            exit();
        }
    } else {
        // Redirigir con un mensaje de error si el campo está vacío
        header('Location: ../../views/admin/categories.php?error=invalid');
        exit();
    }
} else {
    // Si no es una solicitud POST, redirigir a la página de categorías
    header('Location: ../../views/admin/categories.php');
    exit();
}
?>