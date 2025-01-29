<?php
session_start();  // Iniciar sesión al principio del archivo

// Incluir el controlador
require_once 'Controllers/IndexController.php';

// Procesar la acción de login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['action'])) {
    $indexController = new IndexController();
    $indexController->login();  // Llamar al método login para procesar el formulario
}

// Procesar la acción de registro (singUp)
if (isset($_SESSION['message'])) {
    echo '<div class="' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);  // Limpiar el mensaje después de mostrarlo
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
<div class="wrapper">
    <div class="card-switch">
        <label class="switch">
            <input type="checkbox" class="toggle">
            <span class="slider"></span>
            <span class="card-side"></span>
            <div class="flip-card__inner">
                <div class="flip-card__front">
                    <div class="title">Log in</div>
                    <form class="flip-card__form" method="POST">
                        <input class="flip-card__input" name="nombreUsuario" placeholder="Nombre Usuario" type="text">
                        <input class="flip-card__input" name="contraseña" placeholder="Contraseña" type="password">
                        <button class="flip-card__btn" type="submit">Entrar</button>
                    </form>
                </div>
                <div class="flip-card__back">
                    <div class="title">Sign up</div>
                    <form class="flip-card__form" id="formSignUp" action="controllers/indexController.php?action=signUp" method="POST">
                        <input class="flip-card__input" placeholder="Nombre" name="nnombre" type="text" required>
                        <input class="flip-card__input" name="nnombreUsuario" placeholder="Nombre usuario" type="text" required>
                        <input class="flip-card__input" name="ncontraseña" placeholder="Contraseña" type="password" required>
                        <button class="flip-card__btn" type="submit">Registrarse</button>
                    </form>

                </div>
            </div>
        </label>
    </div>
</div>

<!-- Div para el mensaje de éxito o error -->
<div class="mensaje">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="<?php echo $_SESSION['message_type']; ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php unset($_SESSION['message_type']); ?>
    <?php endif; ?>
</div>
<script src="Assets/motor.js"></script>
</body>
</html>
