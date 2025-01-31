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

    

    public function añadirTema() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tema = $_POST['tema'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $usuarioId = $_SESSION['usuario_id'] ?? null;  // Obtiene el id del usuario desde la sesión
    
            if (empty($tema) || empty($descripcion) || !$usuarioId) {
                echo json_encode(['status' => 'error', 'message' => 'Faltan datos o sesión inválida.']);
                exit();
            }
    
            // Instanciar el modelo para insertar el tema
            $foroModel = new ForoModel();
            $resultado = $foroModel->insertarTema($tema, $descripcion, $usuarioId);
    
            // Devolver respuesta en formato JSON
            if ($resultado) {
                echo json_encode(['status' => 'exito']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar el tema']);
            }
            exit();
        }
    }

    public function manejarAcciones() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'add':
                        $this->añadirTema(); // Llama a la acción de añadir tema
                        break;
                    case 'update':
                       /* $this->actualizarTema(); */// Llama a la acción de actualizar tema
                        break;
                    case 'delete':
                     //   $this->eliminarTema(); // Llama a la acción de eliminar tema
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
    
}

// Manejo de solicitudes AJAX
if (isset($_GET['accion']) && $_GET['accion'] === 'obtenerPublicaciones') {
    $controller = new ForoController();
    $controller->obtenerPublicaciones();
}

?>
