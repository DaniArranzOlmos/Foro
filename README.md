# Foro MVC en PHP

Este proyecto es una aplicación de foro basada en el patrón Modelo-Vista-Controlador (MVC). Permite a los usuarios registrarse, iniciar sesión, crear publicaciones y responder a ellas. Se utilizan tecnologías como PHP, HTML, CSS, JavaScript y MySQL para construir una aplicación organizada y funcional.

## Tecnologías utilizadas

- **PHP**: Manejo de la lógica de negocio y conexión con la base de datos.
- **HTML**: Estructura y presentación de las vistas.
- **CSS**: Estilos y diseño visual de la aplicación.
- **JavaScript**: Dinámica en el lado del cliente y mejora de la experiencia del usuario.
- **MySQL**: Almacenamiento, consulta y manipulación de datos en la base de datos.

## Estructura del Proyecto

La estructura del proyecto sigue el patrón MVC, dividiéndose en tres capas principales:

- **Modelo**: Contiene las clases y funciones necesarias para interactuar con la base de datos. Aquí se definen las consultas SQL y la lógica de acceso a datos.
- **Vista**: Contiene las plantillas HTML y CSS que muestran la interfaz al usuario. También incluye JavaScript para la interacción con el usuario en el lado del cliente.
- **Controlador**: Gestiona las solicitudes del usuario, llama a los modelos para obtener datos y selecciona las vistas adecuadas para mostrarlos.

## Funcionalidades

Este proyecto incluye las siguientes funcionalidades:

1. **Registro e inicio de sesión**: Los usuarios pueden registrarse y autenticarse en la aplicación.
2. **Creación de publicaciones**: Los usuarios pueden crear nuevos temas en el foro.
3. **Visualización de publicaciones**: Se listan todas las publicaciones junto con la cantidad de respuestas.
4. **Visualización de detalles**: Se muestra el contenido de una publicación junto con todas sus respuestas.
5. **Añadir respuestas**: Los usuarios pueden responder a una publicación.
6. **Gestión de perfil**: Cada usuario puede ver y eliminar sus publicaciones desde su perfil.

## Requisitos Previos

Para ejecutar este proyecto en tu máquina local, necesitarás:

- Un servidor local como XAMPP o WAMP.
- Un navegador web actualizado.
- Un editor de código como VS Code o Sublime Text.

## Instalación

1. Clona el repositorio o descarga el código fuente.
   ```sh
   git clone https://github.com/tu_usuario/foro-mvc.git
