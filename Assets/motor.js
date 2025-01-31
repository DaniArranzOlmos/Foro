document.addEventListener('DOMContentLoaded', function() {
    cargarPublicaciones();
    añadirTema(); // Llamamos a la función aquí para registrar el evento correctamente

    document.getElementById('openFormBtn').addEventListener('click', function() {
        document.getElementById('formPopup').style.display = 'block';
    });

    document.querySelector('.closeBtn').addEventListener('click', function() {
        document.getElementById('formPopup').style.display = 'none';
    });

    function cargarPublicaciones() {
        fetch('../Controllers/ForoController.php?accion=obtenerPublicaciones')
            .then(response => response.json())
            .then(data => {
                if (data.columnas && data.datos) {
                    crearTablaForo(data.columnas, data.datos);
                }
            })
            .catch(error => console.error('Error al cargar publicaciones:', error));
    }

    function crearTablaForo(columnas, datos) {
        const tablaHead = document.getElementById('foroHeader');
        const tablaBody = document.getElementById('foroBody');
        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';
    
        // Crear las cabeceras de la tabla
        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });

        // Crear las filas con los datos
        console.log(datos);  // Verifica que el array tiene los datos correctamente.
        datos.forEach(fila => {
            const tr = document.createElement('tr');
            tr.classList.add('fila-clicable'); // Agregar la clase para el cursor
            console.log(fila);
            // Asegúrate de que todos los datos están siendo asignados correctamente
            tr.dataset.id = fila.Id;
            tr.dataset.titulo = fila.Título;
            tr.dataset.contenido = fila.Contenido;
            tr.dataset.autor = fila.Autor;  
            console.log("Dataset asignado:", tr.dataset);
            columnas.forEach(columna => {
                const td = document.createElement('td');
                td.textContent = fila[columna];
                tr.appendChild(td);
            });

            // Agregar evento para redirigir a respuesta.php con el ID
            tr.addEventListener('click', function() {
                const publicacionId = this.dataset.id; // Capturar ID desde el atributo 'data-id'
                console.log(publicacionId);  // Verifica el valor del ID antes de redirigir
                if (publicacionId) {
                    window.location.href = `respuesta.php?id=${publicacionId}`;
                } else {
                    console.log("ID de publicación no encontrado.");
                }
            });

            tablaBody.appendChild(tr);
        });
    }
    
    function añadirTema() {
        document.getElementById('btnAñadirTema').addEventListener('click', function(event) {
            event.preventDefault(); 

            const tema = document.getElementById('tema').value;
            const descripcion = document.getElementById('descripcion').value;
            const autor_id = document.querySelector('input[name="autor_id"]').value; 

            const formData = new FormData();
            formData.append('tema', tema);
            formData.append('descripcion', descripcion);
            formData.append('autor_id', autor_id);
            formData.append('action', 'add');

            fetch('../Controllers/ForoController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.getElementById('mensaje');
                const formPopup = document.getElementById('formPopup');

                mensajeDiv.textContent = data.message;
                mensajeDiv.style.backgroundColor = data.status === 'exito' ? '#4CAF50' : '#f44336';
                mensajeDiv.style.display = 'block';

                if (data.status === 'exito') {
                    cargarPublicaciones(); // Recargar publicaciones después de añadir
                }

                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);

                formPopup.style.display = 'none';
            })
            .catch(error => console.error('Error al añadir tema:', error));
        });
    }

    gestionarRespuestas(); // Llamamos a gestionarRespuestas() para manejar la respuesta sin redirección

    document.getElementById('openRespuestaFormBtn').addEventListener('click', function() {
        document.getElementById('formPopupRespuesta').style.display = 'block';
    });

    document.querySelector('.closeBtn').addEventListener('click', function() {
        document.getElementById('formPopupRespuesta').style.display = 'none';
    });

    gestionarRespuestas(); // Llamamos a gestionarRespuestas() para manejar la respuesta sin redirección

    function gestionarRespuestas() {
        document.getElementById('btnAñadirRespuesta').addEventListener('click', function(event) {
            event.preventDefault(); // Evitar la redirección del formulario al enviarlo

            const contenido = document.getElementById('contenido').value;
            const publicacionId = document.getElementById('publicacion_id').value;
            const autorId = document.getElementById('autor_id').value;

            if (!contenido) {
                alert("El contenido no puede estar vacío.");
                return;
            }

            const formData = new FormData();
            formData.append('contenido', contenido);
            formData.append('publicacion_id', publicacionId);
            formData.append('autor_id', autorId);
            formData.append('action', 'add_respuesta'); // Acción para indicar que se trata de una respuesta

            fetch('../Controllers/RespuestaController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.createElement('div');
                mensajeDiv.classList.add('mensaje');
                const respuestasDiv = document.getElementById('respuestas');

                if (data.status === 'exito') {
                    // Crear y mostrar la nueva respuesta en el div de respuestas
                    const nuevaRespuesta = document.createElement('div');
                    nuevaRespuesta.classList.add('respuesta');
                    nuevaRespuesta.innerHTML = ` 
                        <p><strong>${data.autor}</strong>: ${contenido}</p>
                        <p><small>Justo ahora</small></p>
                    `;
                    respuestasDiv.appendChild(nuevaRespuesta);
                } else {
                    // Mostrar mensaje de error
                    mensajeDiv.textContent = data.message;
                    mensajeDiv.style.backgroundColor = '#f44336'; // Rojo para errores
                }

                // Mostrar mensaje de éxito o error
                respuestasDiv.prepend(mensajeDiv);

                // Limpiar el formulario
                document.getElementById('contenido').value = '';

                // Ocultar el mensaje después de 5 segundos
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                console.error('Error al enviar la respuesta:', error);
            });
        });
    }
    

    // Llamar a la función gestionarRespuestas() al cargar la página
    gestionarRespuestas();

});
