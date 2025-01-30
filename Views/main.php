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
    <title>Inicio - Foro</title>
    <link rel="stylesheet" href="../Assets/styles.css">
</head>
<body>
    <nav>
    <h1>Bienvenido, <?php echo $nombreUsuario; ?></h1>
    <form action="../Controllers/logout.php" method="post">
    <button id="cerrarSesion" type="submit">Cerrar sesión</button>
    </form>
    </nav>
    <div id="main-content">
        <h2>Elige un tema</h2>        
        <table id="tablaForo">
            <thead id="foroHeader">
                <tr>

                </tr>
            </thead>
            <tbody id="foroBody">
                <tr>

                </tr>
            </tbody>
        </table>
        <button class="Btn" id="openFormBtn">
            <div class="sign">+</div>
            <div class="text">Añadir</div>
        </button>   
        
        <div id="formPopup" class="form-popup" style="display: none;">
            <div class="form-container">
                <span class="closeBtn">&times;</span>
                <form action="../Controllers/ForoController.php" method="POST">
                    <label for="tema">Tema:</label>
                    <input type="text" id="tema" name="tema" required>
                    <button id="btnAñadirTema" type="submit" class="save">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</form>
<script src="../Assets/motor.js"></script>
</body>
</html>
