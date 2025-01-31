<?php
session_start();
require_once __DIR__ . '/../Models/ForoModel.php';
require_once __DIR__ . '/../Models/RespuestaModel.php';

class RespuestaController {

    public function obtenerPublicacionYRespuestas($publicacionId) {
        $foroModel = new ForoModel();
        $publicacion = $foroModel->obtenerPublicacionPorId($publicacionId);
        $respuestas = $foroModel->obtenerRespuestas($publicacionId);

        if ($publicacion === null) {
            echo json_encode(['status' => 'error', 'message' => 'No se encontró la publicación.']);
            exit();
        }

        return ['publicacion' => $publicacion, 'respuestas' => $respuestas];
    }

    public function añadirRespuesta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contenido = $_POST['contenido'] ?? '';
            $publicacionId = $_POST['publicacion_id'] ?? '';
            $autorId = $_POST['autor_id'] ?? null;  // Obtener el ID del usuario desde la sesión
    
            if (empty($contenido) || empty($publicacionId) || !$autorId) {
                echo json_encode(['status' => 'error', 'message' => 'Faltan datos o sesión inválida.']);
                exit();
            }
    
            $respuestaModel = new RespuestaModel();
            $resultado = $respuestaModel->insertarRespuesta($contenido, $publicacionId, $autorId);
    
            echo json_encode([
                'status' => $resultado ? 'exito' : 'error',
                'message' => $resultado ? 'Respuesta añadida con éxito.' : 'Error al insertar la respuesta',
                'autor' => $_SESSION['usuario'] // Nombre del usuario para mostrar en la respuesta
            ]);
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RespuestaController();
    $controller->añadirRespuesta();
}
?>
