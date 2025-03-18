function administradorGaleria() {
    const url = "modulos/galeria/ADMIN_home.php";
    // Mostrar el indicador de carga
    $('#cargando').show();
    $.post(url)
        .then(response => {
            $('#contenedor_principal').html(response);
        })
        .catch(error => {
            console.error('Error al cargar la galería:', error);
            $('#contenedor_principal').html('<p>Error al cargar la galería. Por favor, inténtelo de nuevo más tarde.</p>');
        })
        .always(() => {
            // Ocultar el indicador de carga (se ejecuta siempre, tanto en éxito como en error)
            $('#cargando').hide();
        });
}

function modulo_galeria_ver_carpeta(carpeta) {
    const url = "modulos/galeria/ver_carpeta.php";
    const parametros = { carpeta: carpeta };

    $('#cargando').show();

    $.post(url, parametros)
        .then(response => {
            $('#contenedor_principal').html(response);

            // Inicializar Fancybox después de cargar el contenido
            Fancybox.bind("[data-fancybox='gallery']", {
                // Opciones de Fancybox (opcional)
                Thumbs: {
                    autoStart: true,
                },
            });
        })
        .catch(error => {
            console.error('Error al cargar la carpeta:', error);
            $('#contenedor_principal').html('<p>Error al cargar la carpeta. Por favor, inténtelo de nuevo más tarde.</p>');
        })
        .always(() => {
            $('#cargando').hide();
        });
}



async function administradorGaleria_crear_carpeta() {
    try {
        // Ocultar el modal
        $("#nuevacarpeta").modal("hide");

        // Obtener el formulario y crear un FormData
        const form = document.getElementById('addimgs');
        const formData = new FormData(form);

        // Deshabilitar el botón de envío para evitar múltiples envíos
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;



        // Enviar la solicitud AJAX
        const response = await $.ajax({
            url: "modulos/galeria/crear_carpeta.php",
            type: "POST",
            dataType: "json", // Cambia a "json" para manejar la respuesta JSON
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

        // Mostrar la respuesta del servidor
        if (response.status === 'success') {
            modulo_galeria_alerta('imagen_subida');
        } else if (response.type === 'existe') {
            modulo_galeria_alerta('existe'); // Alerta específica para carpeta existente
        } else {
            modulo_galeria_alerta('error'); // Alerta genérica para otros errores
        }
    } catch (error) {
        // Manejar errores de la solicitud
        console.error("Error en la solicitud:", error);
        modulo_galeria_alerta('error'); // Alerta genérica para errores de red o servidor
    } finally {
        // Habilitar el botón de envío nuevamente
        submitButton.disabled = false;

        // Ocultar el mensaje de carga
      
    }

}

function eliminarCarpeta(carpeta) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la carpeta y todas sus imágenes. ¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = "modulos/galeria/eliminar_carpeta.php";
            const parametros = { carpeta: carpeta };

            $.post(url, parametros)
                .then(response => {
                    if (response.status == 'success') {
                        Swal.fire('¡Eliminada!', 'La carpeta ha sido eliminada.', 'success');
                        administradorGaleria(); // Recargar la galería
                    } else {
                       modulo_galeria_alerta("carpeta_eliminada");

                    }
                })
                .catch(error => {
                    console.error('Error al eliminar la carpeta:', error);
                    Swal.fire('Error', 'No se pudo eliminar la carpeta.', 'error');
                });
        }
    });
}


function modulo_galeria_alerta(alerta) {
    if (alerta === "imagen_subida") {
        return Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Imagen(es) Subida(s) con Éxito',
            showConfirmButton: false,
            timer: 2000,
            backdrop: false
            }).then(() => {
            administradorGaleria(); // Recargar la galería después de la alerta
        });
    }

    if (alerta === "error") {
        return Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'Error',
            showConfirmButton: false,
            timer: 2000,
            backdrop: false
        });
    }

    if (alerta === "proceso_terminado") {
        return Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Proceso Terminado',
            showConfirmButton: false,
            timer: 2000,
            backdrop: false
        }).then(() => {
            administradorGaleria(); // Recargar la galería después de la alerta
        });
    }

    if (alerta === "existe") {
        return Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'Ya existe una Carpeta con ese Nombre',
            showConfirmButton: false,
            timer: 2000,
            backdrop: false
        });
    }

        if (alerta==="carpeta_eliminada") {
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'La Carpeta se Elimino  Correctamente',
            showConfirmButton: false,
            timer: 2000,
            backdrop: false
                }).then(() => {
            administradorGaleria(); // Recargar la galería después de la alerta
        });    }
}