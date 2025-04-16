<?php
session_start(); 

// Eliminar todas las variables de sesión
session_unset();

session_destroy();

// Redirigir al usuario a la página principal
header("Location: ../../views/main.php");
exit();
?>