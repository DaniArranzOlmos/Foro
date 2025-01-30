<?php
require_once __DIR__ . '/../Db/ConDb.php';

class ForoModel {

    private $conexion;

    public function __construct() {
        $this->conexion = Conex1::con1(); // Uso correcto de la clase de conexión
    }

    public function obtenerPublicaciones() {
        try {
            $sql = "SELECT p.id, p.titulo, p.contenido, p.fecha_creacion, u.nombre_usuario AS autor
                    FROM publicaciones p
                    JOIN usuarios u ON p.autor_id = u.id
                    ORDER BY p.fecha_creacion DESC";

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

    public function insertarPublicacion($titulo, $contenido, $autor_id) {
        try {
            $sql = "INSERT INTO publicaciones (titulo, contenido, autor_id) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssi", $titulo, $contenido, $autor_id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
