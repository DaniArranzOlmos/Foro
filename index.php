<?php
session_start();  // Iniciar sesión al principio del archivo

// Incluir el controlador
require_once 'Controllers/IndexController.php';

// Procesar la acción de login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $indexController = new IndexController();
    if ($_POST['action'] == 'login') {
        $indexController->login();  // Llamar al método login para procesar el formulario
    } elseif ($_POST['action'] == 'signUp') {
        $indexController->signUp();  // Llamar al método signUp para procesar el formulario
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro-Login</title>
    <link rel="stylesheet" href="Assets/styleIndex.css">
</head>
<body>
    <div class="grid-container">
        <div class="wrapper">
            <div class="card-switch">
                <label class="switch">
                    <input type="checkbox" class="toggle">
                    <span class="slider"></span>
                    <span class="card-side"></span>
                    <div class="flip-card__inner">
                        <!-- Formulario de Login -->
                        <div class="flip-card__front">
                            <div class="title">Log in</div>
                            <form class="flip-card__form" method="POST">
                                <input class="flip-card__input" name="nombreUsuario" placeholder="Nombre Usuario" type="text">
                                <input class="flip-card__input" name="contraseña" placeholder="Contraseña" type="password">
                                <input type="hidden" name="action" value="login">
                                <button class="flip-card__btn" type="submit">Entrar</button>
                            </form>
                        </div>
                        
                        <!-- Formulario de Sign up -->
                        <div class="flip-card__back">
                            <div class="title">Sign up</div>
                            <form class="flip-card__form" method="POST">
                                <input class="flip-card__input" placeholder="Nombre" name="nnombre" type="text" required>
                                <input class="flip-card__input" name="nnombreUsuario" placeholder="Nombre usuario" type="text" required>
                                <input class="flip-card__input" name="ncontraseña" placeholder="Contraseña" type="password" required>
                                <input type="hidden" name="action" value="signUp">
                                <button class="flip-card__btn" type="submit">Registrarse</button>
                            </form>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Mensaje de error o éxito -->
        <div id="mensajeError">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php elseif (isset($_SESSION['message'])): ?>
                <div class="success">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        </div>
    </div>

<script src="Assets/motor.js"></script>
</body>
</html>
