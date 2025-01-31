<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];  // Obtener el ID del usuario desde la sesión
$nombreUsuario = $_SESSION['usuario']; // Nombre del usuario

// Obtener el ID de la publicación de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $publicacionId = $_GET['id'];
    echo "ID de la publicación recibido: " . $publicacionId;  // Imprimir el ID recibido
} else {
    echo "No se encontró el ID en la URL.";
    exit();
}

// Incluir el modelo para obtener la publicación y las respuestas
require_once __DIR__ . '/../Models/ForoModel.php';
require_once __DIR__ . '/../Models/RespuestaModel.php';

$foroModel = new ForoModel();
$respuestaModel = new RespuestaModel();

// Obtener la publicación con el ID
$publicacion = $foroModel->obtenerPublicacionPorId($publicacionId);

// Verificar que la publicación existe
if (!$publicacion) {
    echo "No se encontró la publicación.";
    exit();
}

// Agrupar los datos de la publicación en un array
$datosPublicacion = [
    'id' => $publicacionId,
    'titulo' => $publicacion['titulo'],
    'contenido' => $publicacion['contenido'],
    'fecha_creacion' => $publicacion['fecha_creacion'],
    'autor' => $publicacion['autor']  // Este campo ahora debería tener el nombre de usuario del autor
];

// Obtener respuestas
$respuestas = $respuestaModel->obtenerRespuestas($publicacionId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $datosPublicacion['titulo']; ?> - Respuestas</title>
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
        <h2><?php echo $datosPublicacion['titulo']; ?></h2>
        <p><strong>Autor:</strong> <?php echo $datosPublicacion['autor']; ?></p> <!-- Aquí se muestra el autor -->
        <p><strong>Fecha de Creación:</strong> <?php echo $datosPublicacion['fecha_creacion']; ?></p>
        <p><strong>Contenido:</strong> <?php echo $datosPublicacion['contenido']; ?></p>

        <h3>Respuestas:</h3>
        <div id="respuestas">
            <?php foreach ($respuestas as $respuesta): ?>
                <div class="respuesta">
                    <p><strong><?php echo $respuesta['autor']; ?>:</strong> <?php echo $respuesta['contenido']; ?></p>
                    <p><small><?php echo $respuesta['fecha_creacion']; ?></small></p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div id="formRespuesta" style="margin-top: 20px;">
            <textarea id="contenido" name="contenido" placeholder="Escribe tu respuesta..." required></textarea>
            <input type="hidden" id="publicacion_id" value="<?php echo $publicacionId; ?>">
            <input type="hidden" id="autor_id" value="<?php echo $usuarioId; ?>">
            <button id="btnAñadirRespuesta" class="save">Añadir Respuesta</button>
        </div>
    </div>

<script src="../Assets/motor.js"></script>
</body>
</html>
