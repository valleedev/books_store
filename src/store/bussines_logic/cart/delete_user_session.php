<?php
session_start(); // Inicia la sesión

// Elimina la sesión del usuario
unset($_SESSION['user']);

// Mensaje de confirmación
echo "Sesión de usuario eliminada con éxito.";
?>