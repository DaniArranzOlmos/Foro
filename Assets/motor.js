// Assets/motor.js
document.addEventListener('DOMContentLoaded', function() {
    cargarPublicaciones();

    document.getElementById('openFormBtn').addEventListener('click', function() {
        document.getElementById('formPopup').style.display = 'block';
    });

    document.querySelector('.closeBtn').addEventListener('click', function() {
        document.getElementById('formPopup').style.display = 'none';
    });
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
