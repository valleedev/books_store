<?php

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    
    $sql = "SELECT id, nombre, apellidos, email, password FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);
        
        
         if ($password === $usuario['password']) { //password_verify($password, $usuario['password'])
            $_SESSION['usuario'] = [
     
                'email' => $usuario['email']
            ];
            header("Location: admin/dashboard.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "El usuario no existe.";
    }
}
?>
