$(document).ready(function () {
    Ladda.bind('button[type=submit]', { timeout: 20000 });
});

function fxAplicarRespuesta(id_pue) {
    $.ajax({
        type: 'POST',
        url: '/docente/tarea/respuesta',
        data: {
            id_puente: id_pue
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            $('#respuestaObservacion').text(data.respuesta.c_observacion);
            if (data.respuesta.c_url_archivo == null) {
                $('#respuestaArchivo').text('No hay archivos adjuntos');
            } else {
                $('#respuestaArchivo').html('<a href="/alumno/tarea/respuestaarchivo/' + data.puente.id_tarea + '/' + data.respuesta.id_respuesta + '" class="text-primary" cdownload="' + data.respuesta.c_url_archivo + '">Descargar Archivo ' + data.respuesta.c_url_archivo + '</a>');
            }
            $('#modal-tarea-pendiente-revisar').modal('show');
        } else {
            location.reload();
        }
    });
}