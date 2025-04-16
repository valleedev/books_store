<?php
require_once __DIR__ . '/../../../db.php';
session_start();
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT id, nombre, apellidos, email, password, rol FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);

        if (password_verify($password, $usuario['password'])) { 
            $_SESSION['user'] = [
                'name' => $usuario['nombre'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol']
            ];

            // Redirección según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: ../../views/admin/dashboard.php");
            } else {
                header("Location: ../../views/main.php");
            }
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "El usuario no existe.";
    }
}
echo $mensaje
?>
