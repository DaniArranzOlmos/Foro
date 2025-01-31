// Assets/motor.js
document.addEventListener('DOMContentLoaded', function() {
    cargarPublicaciones();

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

        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });

        datos.forEach(fila => {
            const tr = document.createElement('tr');
            columnas.forEach(columna => {
                const td = document.createElement('td');
                td.textContent = fila[columna];
                tr.appendChild(td);
            });
            tablaBody.appendChild(tr);
        });
    }

    function añadirTema() {
        const form = document.querySelector('form');
        const btnAñadirTema = document.getElementById('btnAñadirTema');
        
        btnAñadirTema.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que se recargue la página si el botón está dentro de un formulario
        
            const tema = document.getElementById('tema').value;
            const descripcion = document.getElementById('descripcion').value;
        
            const formData = new FormData();
            formData.append('tema', tema);
            formData.append('descripcion', descripcion);
            formData.append('action', 'add'); // Añadir la acción aquí
        
            fetch('../Controllers/ForoController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.getElementById('mensaje');
                const formPopup = document.getElementById('formPopup');
        
                if (data.status === 'exito') {
                    mensajeDiv.style.backgroundColor = '#4CAF50';
                    mensajeDiv.textContent = 'Tema añadido con éxito.';
        
                    // Redirigir a la misma página después de añadir el tema
                    setTimeout(() => {
                        window.location.href = 'main.php';
                    }, 2000);
                } else {
                    mensajeDiv.style.backgroundColor = '#f44336';
                    mensajeDiv.textContent = 'Error al añadir el tema.';
                }
        
                mensajeDiv.style.display = 'block';
        
                form.reset();
                formPopup.style.display = 'none';
        
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                const mensajeDiv = document.getElementById('mensaje');
                mensajeDiv.style.backgroundColor = '#f44336';
                mensajeDiv.textContent = 'Error al procesar la solicitud.';
                mensajeDiv.style.display = 'block';
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            });
        });
    }
    
    
    
});