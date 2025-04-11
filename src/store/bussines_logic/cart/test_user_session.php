<?php
session_start(); // Inicia la sesión

// Datos ficticios del usuario
$_SESSION['user'] = [
    'id' => 1,
    'name' => 'Juan Pérez',
    'email' => 'juan.perez@example.com',
    'role' => 'admin', // Puede ser 'admin' o 'customer'
];

// Mensaje de confirmación
echo "Sesión de usuario creada con éxito.";
?>