<?php
require_once __DIR__ . '/../Db/ConDb.php';

class ForoModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conex1::con1();
    }

    public function obtenerPublicaciones() {
        try {
            $sql = "SELECT p.id AS Id, p.titulo AS Título, p.contenido AS Contenido, p.fecha_creacion AS Creación, u.nombre_usuario AS Autor,
                    (SELECT COUNT(*) FROM respuestas r WHERE r.publicacion_id = p.id) AS Respuestas
                    FROM publicaciones p
                    LEFT JOIN usuarios u ON p.autor_id = u.id
                    ORDER BY p.fecha_creacion DESC;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $publicaciones = [];
            $columnas = [];

            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }

            while ($row = $resultado->fetch_assoc()) {
                $publicaciones[] = $row;
            }

            return ['columnas' => $columnas, 'datos' => $publicaciones];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function obtenerPublicacionPorId($id) {
        try {
            $sql = "SELECT p.id, p.titulo, p.contenido, p.fecha_creacion, u.nombre_usuario AS autor
                    FROM publicaciones p
                    LEFT JOIN usuarios u ON p.autor_id = u.id
                    WHERE p.id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            if ($resultado->num_rows === 0) {
                return null;
            }
    
            return $resultado->fetch_assoc();
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    
    public function insertarTema($tema, $descripcion, $usuarioId) {
        $sql = "INSERT INTO publicaciones (titulo, contenido, autor_id) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssi", $tema, $descripcion, $usuarioId);
        $resultado = $stmt->execute();

        $stmt->close();
        return $resultado;
    }
}

?>
