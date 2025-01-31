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


    public function insertarTema($tema, $descripcion, $usuarioId) {
        $conn = Conex1::con1();
    
        $sql = "INSERT INTO publicaciones (titulo, contenido, autor_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        // Asociamos los valores a los parámetros de la consulta
        $stmt->bind_param("ssi", $tema, $descripcion, $usuarioId);
        $resultado = $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        return $resultado;  // Retorna verdadero si la inserción fue exitosa
    }
    
}
?>
