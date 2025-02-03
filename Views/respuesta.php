<?php
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];
$nombreUsuario = $_SESSION['usuario'];

// Obtener el ID de la publicación desde la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $publicacionId = $_GET['id'];
} else {
    echo "No se encontró el ID en la URL.";
    exit();
}

// Incluir los modelos necesarios
require_once __DIR__ . '/../Models/ForoModel.php';
require_once __DIR__ . '/../Models/RespuestaModel.php';

$foroModel = new ForoModel();
$respuestaModel = new RespuestaModel();

// Obtener la publicación
$publicacion = $foroModel->obtenerPublicacionPorId($publicacionId);

// Verificar que la publicación existe
if (!$publicacion) {
    echo "No se encontró la publicación.";
    exit();
}

// Obtener respuestas
$respuestas = $respuestaModel->obtenerRespuestas($publicacionId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $publicacion['titulo']; ?> - Respuestas</title>
    <link rel="stylesheet" href="../Assets/styles.css">
</head>
<body>
    <nav>
        <h1>Bienvenido, <?php echo $nombreUsuario; ?></h1>
        <form action="perfil.php" method="get">
            <button id="irPerfil" type="submit">Ir al Perfil</button>
        </form>
        <form action="../Controllers/logout.php" method="post">
            <button id="cerrarSesion" type="submit">Cerrar sesión</button>
        </form>
    </nav>

    <div id="main-content">
        <h2><?php echo htmlspecialchars($publicacion['titulo']); ?></h2>
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($publicacion['autor']); ?></p>
        <p><strong>Fecha de Creación:</strong> <?php echo htmlspecialchars($publicacion['fecha_creacion']); ?></p>
        <p><strong>Contenido:</strong> <?php echo nl2br(htmlspecialchars($publicacion['contenido'])); ?></p>

        <h3>Respuestas:</h3>
        <div id="respuestas" style="margin-top: 20px;">
            <?php foreach ($respuestas as $respuesta): ?>
                <div class="respuesta" style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <p><strong><?php echo htmlspecialchars($respuesta['autor']); ?>:</strong> <?php echo htmlspecialchars($respuesta['contenido']); ?></p>
                    <p><small><?php echo htmlspecialchars($respuesta['fecha_creacion']); ?></small></p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div id="formRespuesta" style="margin-top: 30px;">
            <textarea id="contenido" name="contenido" placeholder="Escribe tu respuesta..." required style="width: 100%; padding: 12px 15px; margin: 15px 0; border-radius: 8px; border: 1px solid #ddd; font-size: 14px;"></textarea>
            <input type="hidden" id="publicacion_id" value="<?php echo $publicacionId; ?>">
            <input type="hidden" id="autor_id" value="<?php echo $usuarioId; ?>">
            <button id="btnAñadirRespuesta" type="submit" class="Btn" style="width: 100%; padding: 12px 15px; font-size: 16px;">Añadir Respuesta</button>
        </div>

        <!-- Botón Volver al inicio -->
        <div class="volver-inicio" style="margin-top: 30px; text-align: center;">
            <a href="main.php" class="Btn" style="padding: 8px 15px; font-size: 14px; background-color: #f0f0f0; color: #333; text-decoration: none; border-radius: 8px; border: 1px solid #ddd; transition: background-color 0.3s ease;">
                Volver al inicio
            </a>
        </div>

    </div>

    <script src="../Assets/respuesta.js"></script>
</body>
</html>
