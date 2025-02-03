<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once '../Controllers/PerfilController.php';

$perfilController = new PerfilController();
$temas = $perfilController->obtenerTemasUsuario($_SESSION['usuario_id']);

$nombreUsuario = $_SESSION['usuario'];  // Obtener el nombre del usuario desde la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
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
        <h2>Mis Temas</h2>
        <table id="tablaForo">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($temas['error'])): ?>
                    <tr>
                        <td colspan="3"><?php echo $temas['error']; ?></td>
                    </tr>
                <?php elseif (!empty($temas)): ?>
                    <?php foreach ($temas as $tema): ?>
                        <tr class="fila-clicable">
                            <td><?php echo htmlspecialchars($tema['titulo']); ?></td>
                            <td><?php echo $tema['fecha_creacion']; ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="tema_id" value="<?php echo $tema['id']; ?>">
                                    <input type="hidden" name="action" value="eliminar">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No has creado ningún tema aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botón Volver al inicio -->
        <div class="volver-inicio" style="margin-top: 30px; text-align: center;">
            <a href="main.php" class="Btn">
                Volver al inicio
            </a>
        </div>

    </div>

    <script src="Assets/respuesta.js"></script>
</body>
</html>
