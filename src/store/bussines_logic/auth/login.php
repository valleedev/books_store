<?php
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT id, nombre, apellidos, email, password, rol FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);

        if (password_verify($password, $usuario['password'])) { 
            $_SESSION['user'] = [
                'id' => $usuario['id'],
                'name' => $usuario['nombre'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol']
            ];
        
            $_SESSION['bienvenida'] = "¡Bienvenido, " . $usuario['nombre'] . "!";
        
            if ($usuario['rol'] === 'admin') {
                header("Location: ../../views/admin/dashboard.php");
            } else {
                header("Location: ../../views/main.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Contraseña incorrecta.";
            header("Location: ../../views/main.php?login_error=1");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "El usuario no existe.";
        header("Location: ../../views/main.php?login_error=1");
        exit();
    }
}
?>