<?php
require_once __DIR__ . '/../Models/ForoModel.php'; 

class ForoController {

    public function obtenerPublicaciones() {
        $foroModel = new ForoModel();
        $publicaciones = $foroModel->obtenerPublicaciones();

        // Asegurar que la respuesta es JSON válido
        header('Content-Type: application/json');
        echo json_encode([
            'columnas' => $publicaciones['columnas'] ?? [],
            'datos' => $publicaciones['datos'] ?? []
        ]);
        exit();
    }

    public function crearPublicacion() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $contenido = $_POST['contenido'] ?? '';
            $autor_id = $_SESSION['usuario_id'] ?? null;

            if (empty($titulo) || empty($contenido) || !$autor_id) {
                header('Location: ../Views/main.php?mensaje=error');
                exit();
            }

            $foroModel = new ForoModel();
            $resultado = $foroModel->insertarPublicacion($titulo, $contenido, $autor_id);

            if ($resultado) {
                header('Location: ../Views/main.php?mensaje=exito');
            } else {
                header('Location: ../Views/main.php?mensaje=error');
            }
            exit();
        }
    }
}

// Manejo de solicitudes AJAX
if (isset($_GET['accion']) && $_GET['accion'] === 'obtenerPublicaciones') {
    $controller = new ForoController();
    $controller->obtenerPublicaciones();
}
?>
