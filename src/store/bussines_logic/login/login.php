<?php

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT id, nombre, apellidos, email, password, rol FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);

        // Verificación de contraseña (idealmente deberías usar password_hash en la BD y password_verify aquí)
        if ($password === $usuario['password']) { 
            $_SESSION['usuario'] = [
                'email' => $usuario['email'],
                'rol' => $usuario['rol']
            ];

            // Redirección según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: main.php");
            }
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "El usuario no existe.";
    }
}
?>
