<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los campos 'id' y 'nombre' estén presentes y no estén vacíos
    if (isset($_POST['id'], $_POST['nombre']) && !empty(trim($_POST['id'])) && !empty(trim($_POST['nombre']))) {

        $id = intval($_POST['id']);
        $nombre = trim($_POST['nombre']);

        // Preparar la consulta SQL para actualizar la categoría
        $query = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('si', $nombre, $id);

            if ($stmt->execute()) {
                // Redirigir de vuelta a la página de categorías con un mensaje de éxito
                header('Location: ../../views/admin/categories.php?success=edit');
                exit();
            } else {
                // Redirigir con un mensaje de error si la actualización falla
                header('Location: ../../views/admin/categories.php?error=edit');
                exit();
            }

            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si la preparación de la consulta falla
            header('Location: ../../views/admin/categories.php?error=prepare');
            exit();
        }
    } else {
        // Redirigir con un mensaje de error si los campos están vacíos
        header('Location: ../../views/admin/categories.php?error=invalid');
        exit();
    }
} else {
    // Si no es una solicitud POST, redirigir a la página de categorías
    header('Location: ../../views/admin/categories.php');
    exit();
}
?>