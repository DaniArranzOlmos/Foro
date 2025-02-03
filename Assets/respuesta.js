document.addEventListener("DOMContentLoaded", function () {
    const btnAñadirRespuesta = document.getElementById("btnAñadirRespuesta");

    if (btnAñadirRespuesta) {
        btnAñadirRespuesta.addEventListener("click", function (event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma tradicional

            const contenido = document.getElementById("contenido").value.trim();
            const publicacion_id = document.getElementById("publicacion_id").value;
            const autor_id = document.getElementById("autor_id").value;

            if (!contenido) {
                alert("El contenido no puede estar vacío.");
                return;
            }

            fetch("../Controllers/RespuestaController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({ contenido, publicacion_id, autor_id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "exito") {
                    alert(data.message);
                    location.reload();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error en la solicitud:", error));
        });
    }
});
