<?php
session_start();
require_once __DIR__ . '/../Models/ForoModel.php';

class ForoController {
    
    public function obtenerPublicaciones() {
        $foroModel = new ForoModel();
        $publicaciones = $foroModel->obtenerPublicaciones();

        header('Content-Type: application/json');
        echo json_encode([
            'columnas' => $publicaciones['columnas'] ?? [],
            'datos' => $publicaciones['datos'] ?? []
        ]);
        exit();
    }

    public function añadirTema() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tema = $_POST['tema'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $usuarioId = $_SESSION['usuario_id'] ?? null;  

            if (empty($tema) || empty($descripcion) || !$usuarioId) {
                echo json_encode(['status' => 'error', 'message' => 'Faltan datos o sesión inválida.']);
                exit();
            }

            $foroModel = new ForoModel();
            $resultado = $foroModel->insertarTema($tema, $descripcion, $usuarioId);

            echo json_encode([
                'status' => $resultado ? 'exito' : 'error',
                'message' => $resultado ? 'Tema añadido con éxito.' : 'Error al insertar el tema'
            ]);
            exit();
        }
    }

    public function manejarAcciones() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add':
                    $this->añadirTema();
                    break;
                default:
                    echo json_encode(['status' => 'error', 'message' => 'Acción no reconocida']);
                    break;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Acción no proporcionada']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] === 'obtenerPublicaciones') {
    $controller = new ForoController();
    $controller->obtenerPublicaciones();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ForoController();
    $controller->manejarAcciones();
}
?>
