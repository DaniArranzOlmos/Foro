<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario']; // Obtiene el nombre del usuario desde la sesión
    $usuarioId = $_SESSION['usuario_id']; // Obtenemos el ID del usuario desde la sesión
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
                <!-- Aquí van tus cabeceras -->
                </tr>
            </thead>
            <tbody id="foroBody">
                <tr>
                <!-- Aquí se llenarán las publicaciones -->
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
                <form method="POST">
                    <label for="tema">Tema:</label>
                    <input type="text" id="tema" name="tema" required>

                    <label for="descripcion">Descripcion:</label>
                    <input type="text" id="descripcion" name="descripcion" required>

                    <!-- Añadimos un campo oculto con el ID del usuario -->
                    <input type="hidden" name="autor_id" value="<?php echo $usuarioId; ?>">

                    <input type="hidden" name="action" value="add">

                    <button id="btnAñadirTema" type="submit" class="save">Guardar</button>
                </form>
            </div>
        </div>
        <div id="mensaje" class="mensaje" style="display: none;"></div>
    </div>
<script src="../Assets/motor.js"></script>
</body>
</html>
