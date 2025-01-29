<?php
session_start();  // Iniciar sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio (index.php en la raíz de Foro)
header('Location: ../index.php');  // Regresar un nivel para llegar a la raíz de Foro
exit();
?>
