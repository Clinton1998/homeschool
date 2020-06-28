$(document).ready(function () {
    Ladda.bind('button[type=submit]', { timeout: 20000 });
});

function fxAplicarRespuesta(id_pue,e) {
    e.preventDefault();
    $('#divRespuestaTarea').attr('style','display: none;');
    $('#spinnerRespuestaDeTarea').show();
    $('#modal-tarea-pendiente-revisar').modal('show');
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
        if(data.correcto){
          $('#respuestaObservacion').text(data.respuesta.c_observacion);
          if(data.respuesta.c_url_archivo==null){
            $('#divArchivosRespuesta').text('No hay archivos adjuntos');
          }else{
            var htmlArchivos = '<span class="d-block"><a href="/alumno/tarea/respuestaarchivo/'+data.puente.id_tarea+'/'+data.respuesta.id_respuesta+'/'+data.respuesta.c_url_archivo+'" class="text-primary" cdownload="' + data.respuesta.c_url_archivo + '">Descargar Archivo ' + data.respuesta.c_url_archivo + '</a></span>';
            $.each(data.respuesta.archivos,function(index,archivo){
                htmlArchivos += '<span class="d-block"><a href="/alumno/tarea/respuestaarchivo/'+data.puente.id_tarea+'/'+data.respuesta.id_respuesta+'/'+archivo.c_url_archivo+'" class="text-primary" cdownload="'+archivo.c_url_archivo+'">Descargar Archivo '+archivo.c_url_archivo+'</a></span>'
            });
            $('#divArchivosRespuesta').html(htmlArchivos);
          }
          $('#spinnerRespuestaDeTarea').attr('style','display: none;');
          $('#divRespuestaTarea').show();
        }else{
          location.reload();
        }
    });
}
