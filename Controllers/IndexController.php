<?php
require_once __DIR__ . '/../Db/ConDb.php';  // Ruta correcta al archivo de conexión

class IndexController {

    public function login() {
        // Comprobar si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario
            $nombreUsuario = $_POST['nombreUsuario'];  
            $contraseña = $_POST['contraseña']; 
    
            // Llamar a la función de conexión
            $conn = Conex1::con1(); 
    
            // Consultar la base de datos para verificar el usuario
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombreUsuario); // Usamos 'nombre_usuario' según tu base de datos
            $stmt->execute();
            $resultado = $stmt->get_result();
    
            // Si el usuario existe
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
    
                // Verificar la contraseña hasheada
                if (password_verify($contraseña, $row['contraseña'])) {
                    // Login exitoso, guardar la sesión y redirigir
                    $_SESSION['usuario'] = $nombreUsuario;
                    header('Location: Views/main.php');  // Redirige al inicio o a la página principal
                    exit();
                } else {
                    // Contraseña incorrecta
                    $_SESSION['error'] = 'Contraseña incorrecta';  
                    header('Location: index.php');  // Redirige al login
                    exit();
                }
            } else {
                // Usuario no encontrado
                $_SESSION['error'] = 'Usuario no encontrado';  
                header('Location: index.php');  // Redirige al login
                exit();
            }
        }
    }
    

    public function signUp() {
        // Verificar si los datos fueron enviados por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger los datos del formulario
            $nombre = $_POST['nnombre'];
            $nombreUsuario = $_POST['nnombreUsuario'];
            $contraseña = $_POST['ncontraseña'];

            // Validar que los campos no estén vacíos
            if (empty($nombre) || empty($nombreUsuario) || empty($contraseña)) {
                $_SESSION['message'] = 'Todos los campos son obligatorios.';
                $_SESSION['message_type'] = 'error';
                header('Location: ../index.php'); // Redirigir al formulario con mensaje de error
                exit();
            }

            // Conectar a la base de datos
            $conn = Conex1::con1();  // Llamamos a la función de conexión a la base de datos

            // Verificar si el nombre de usuario ya existe
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $_SESSION['message'] = 'El nombre de usuario ya está registrado.';
                $_SESSION['message_type'] = 'error';
                header('Location: ../index.php'); // Redirigir con mensaje de error
                exit();
            }

            // Cifrar la contraseña antes de almacenarla
            $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (nombre, nombre_usuario, contraseña) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $nombreUsuario, $contraseñaCifrada);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Usuario registrado con éxito. Ahora puedes iniciar sesión.';
                $_SESSION['message_type'] = 'success';
                header('Location: ../index.php');  // Redirigir a la página principal o login
                exit();
            } else {
                $_SESSION['message'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                $_SESSION['message_type'] = 'error';
                header('Location: ../index.php'); // Redirigir con mensaje de error
                exit();
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
