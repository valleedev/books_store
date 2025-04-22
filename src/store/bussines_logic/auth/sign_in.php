<?php
require_once __DIR__ . '/../../../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'];
    $apellidos = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "Todos los campos son obligatorios.";
        header("Location: ../../views/main.php?register_error=1");
        exit();
    }
    
    $check_email = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['register_error'] = "El correo electrónico ya está registrado.";
        header("Location: ../../views/main.php?register_error=1");
        exit();
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rol) VALUES (?, ?, ?, ?, 'user')";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellidos, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        $user_id = mysqli_insert_id($conexion);
        
        $_SESSION['user'] = [
            'id' => $user_id,
            'name' => $nombre,
            'email' => $email,
            'rol' => 'user'
        ];
        
        $_SESSION['welcome_message'] = "¡Bienvenido a Librarium, $nombre!";
        
        header("Location: ../../views/main.php?welcome=1");
        exit();
    } else {
        $_SESSION['register_error'] = "Error al registrar usuario: " . mysqli_error($conexion);
        header("Location: ../../views/main.php?register_error=1");
        exit();
    }
}
?>