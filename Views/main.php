<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario']; // Obtiene el nombre del usuario desde la sesión
} else {
    // Si no está autenticado, puedes redirigirlo al login o mostrar un mensaje
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $nombreUsuario; ?></h1>
    <form action="../Controllers/logout.php" method="post">
    <button id="cerrarSesion" type="submit">Cerrar sesión</button>
</form>
</body>
</html>
