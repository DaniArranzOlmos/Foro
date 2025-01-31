<?php
require_once __DIR__ . '/../Db/ConDb.php';

class RespuestaModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conex1::con1();
    }

    public function obtenerRespuestas($publicacionId) {
        try {
            $sql = "SELECT r.contenido, r.fecha_creacion, u.nombre_usuario AS autor
                    FROM respuestas r
                    LEFT JOIN usuarios u ON r.autor_id = u.id
                    WHERE r.publicacion_id = ?
                    ORDER BY r.fecha_creacion ASC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $publicacionId);
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            $respuestas = [];
            while ($row = $resultado->fetch_assoc()) {
                $respuestas[] = $row;
            }
    
            return $respuestas;
        } catch (Exception $e) {
            return false;
        }
    }

    public function insertarRespuesta($contenido, $publicacionId, $autorId) {
        $sql = "INSERT INTO respuestas (contenido, publicacion_id, autor_id) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sii", $contenido, $publicacionId, $autorId);
        $resultado = $stmt->execute();
    
        $stmt->close();
        return $resultado;
    }
}
?>