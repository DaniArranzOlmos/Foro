<?php
require_once '../Models/PerfilModel.php'; // Asegúrate de que la ruta sea correcta

class PerfilController {
    private $perfilModel;

    public function __construct() {
        $this->perfilModel = new PerfilModel();
    }

    // Obtener los temas creados por el usuario
    public function obtenerTemasUsuario($usuario_id) {
        $temas = $this->perfilModel->obtenerTemasPorUsuario($usuario_id);
        // Verificar si la respuesta es un array
        if (!is_array($temas)) {
            echo '<pre>';
            var_dump($temas);  // Para inspeccionar qué está devolviendo la función
            echo '</pre>';
        }
        return $temas;
    }
    

    // Eliminar un tema
    public function eliminarTema() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'eliminar') {
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['error'] = "Debes iniciar sesión.";
                header("Location: login.php");
                exit();
            }
    
            $tema_id = $_POST['tema_id'];
            $usuario_id = $_SESSION['usuario_id'];
    
            // Eliminar tema
            if ($this->perfilModel->eliminarTema($tema_id, $usuario_id)) {
                $_SESSION['message'] = "Tema eliminado con éxito.";
            } else {
                $_SESSION['error'] = "Error al eliminar el tema.";
            }
    
            // Redirigir al perfil después de la eliminación
            header("Location: perfil.php"); // Esto redirige a la página de perfil, no a login.php
            exit();
        }
    }
    
}

// Si la petición viene desde el formulario de eliminación, ejecutar la lógica del controlador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $perfilController = new PerfilController();
    $perfilController->eliminarTema();
}
?>
