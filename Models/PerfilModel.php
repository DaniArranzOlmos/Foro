<?php
require_once __DIR__ . '/../Db/ConDb.php';

class PerfilModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conex1::con1();
    }

    public function obtenerTemasPorUsuario($usuario_id) {
        try {
            $sql = "SELECT id, titulo, fecha_creacion FROM publicaciones WHERE autor_id = ?";
            $stmt = $this->conexion->prepare($sql);
            
            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta SQL: " . $this->conexion->error);
            }

            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $temas = [];
            while ($row = $resultado->fetch_assoc()) {
                $temas[] = $row;
            }

            return $temas;
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function eliminarTema($tema_id, $usuario_id) {
        $sql = "DELETE FROM publicaciones WHERE id = ? AND usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            return 'Error al preparar la consulta SQL: ' . $this->conexion->error;
        }

        $stmt->bind_param("ii", $tema_id, $usuario_id);
        $resultado = $stmt->execute();
    
        $stmt->close();
        return $resultado;
    }
}
?>
