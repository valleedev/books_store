<?php
session_start(); 

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cerrando sesión...</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
</style>

<body>

<script>
  Swal.fire({
    icon: 'success',
    title: 'Sesión cerrada',
    text: 'Has cerrado sesión correctamente.',
    confirmButtonText: 'OK'
  }).then(() => {
    // Redirige cuando el usuario presiona "OK"
    window.location.href = '../../views/main.php';
  });
</script>

</body>
</html>
