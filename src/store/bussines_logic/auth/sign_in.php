<?php
require_once __DIR__ . '/../../router.php';
require_once __DIR__ . '/../../db.php';

$message = ''; // Variable para almacenar el mensaje

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['name']);
    $apellidos = trim($_POST['lastname']);
    $correo = trim($_POST['email']);
    $contrasena = $_POST['password'];

    // Verificar si el email ya está registrado
    $check_email = "SELECT id FROM usuarios WHERE email = '$correo'";
    $result = mysqli_query($conexion, $check_email);

    if (mysqli_num_rows($result) > 0) {
        $message = "Error: El correo ya está registrado.";
    } else {
        $contrasena_segura = password_hash($contrasena, PASSWORD_BCRYPT);
        $query = "INSERT INTO usuarios (nombre, apellidos, email, password) 
                  VALUES ('$nombre', '$apellidos', '$correo', '$contrasena_segura')";

        if (mysqli_query($conexion, $query)) {
            $message = "Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            $message = "Error: No se pudo completar el registro.";
        }
    }
}
?>