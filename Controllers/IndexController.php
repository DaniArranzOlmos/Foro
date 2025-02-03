<?php

require_once __DIR__ . '/../Db/ConDb.php';  // Ruta correcta al archivo de conexión

class IndexController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
            $nombreUsuario = $_POST['nombreUsuario'];  
            $contraseña = $_POST['contraseña']; 
            $conn = Conex1::con1(); 
    
            // Validar que los campos no estén vacíos
            if (empty($nombreUsuario) || empty($contraseña)) {
                $_SESSION['error'] = 'Debes completar todos los campos.';
                return;  // No redirigir, para mostrar el error en la misma página
            }
    
            // Consultar la base de datos
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            if ($resultado->num_rows > 0) {
                // Recorremos los resultados (en este caso sólo habrá uno)
                while ($row = $resultado->fetch_assoc()) {
                    // Verificar la contraseña
                    if (password_verify($contraseña, $row['contraseña'])) {
                        // Guardamos el nombre de usuario y el id en la sesión
                        $_SESSION['usuario'] = $nombreUsuario;
                        $_SESSION['usuario_id'] = $row['id'];  // Aquí se toma el id del usuario
    
                        // Redirigir a la página principal
                        header('Location: Views/main.php');
                        exit();
                    } else {
                        // Contraseña incorrecta
                        $_SESSION['error'] = 'Contraseña incorrecta.';
                    }
                }
            } else {
                // Usuario no encontrado
                $_SESSION['error'] = 'El usuario no existe.';
            }
        }
    }
    
    

    public function signUp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'signUp') {
            $nombre = $_POST['nnombre'];
            $nombreUsuario = $_POST['nnombreUsuario'];
            $contraseña = $_POST['ncontraseña'];
    
            // Verificar si los campos están vacíos
            if (empty($nombre) || empty($nombreUsuario) || empty($contraseña)) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                return;  // No redirigir, para mostrar el error en la misma página
            }
    
            // Validar el nombre de usuario
            if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-_\.]{9,29}$/', $nombreUsuario)) {
                $_SESSION['error'] = 'El nombre de usuario debe tener entre 10 y 30 caracteres y no puede comenzar con un número.';
                return;
            }
    
            // Validar la contraseña
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{5,20}$/', $contraseña)) {
                $_SESSION['error'] = 'La contraseña debe tener entre 5 y 20 caracteres, incluyendo al menos una mayúscula y un número.';
                return;
            }
    
            $conn = Conex1::con1();
    
            // Verificar si el usuario ya existe
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            if ($resultado->num_rows > 0) {
                $_SESSION['error'] = 'El nombre de usuario ya está registrado.';
            } else {
                // Cifrar la contraseña
                $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
    
                // Intentar insertar el usuario
                $sql = "INSERT INTO usuarios (nombre, nombre_usuario, contraseña) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $nombre, $nombreUsuario, $contraseñaCifrada);
    
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Usuario registrado con éxito.';
                } else {
                    $_SESSION['error'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                }
            }
        }
    }
    

    public function verificarSesion() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit();
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'signUp') {
    $controller = new IndexController();
    $controller->signUp();
}
?>
