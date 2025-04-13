<?php

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, apellidos, email, password FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $usuario = $result->fetch_assoc();

        // Verificar la contraseña
        if ($password === $usuario['password']) { // Puedes usar password_verify si las contraseñas están hasheadas
            // Crear la sesión con los datos del usuario
            $_SESSION['user'] = [
                'id' => $usuario['id'],
                'name' => $usuario['nombre'],
                'lastname' => $usuario['apellidos'],
                'email' => $usuario['email']
            ];

            // Redirigir al dashboard o página principal
            header("Location: ../../views/admin/dashboard.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "El usuario no existe.";
    }
}
?>
