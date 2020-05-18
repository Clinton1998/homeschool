$(document).ready(function() {
    $('#btnSubEditarRespuesta').on('click', function() {
        if ($('#preobservacion').val().trim() != '' && $('#prearchivo').val() != '') {
            $('#divProgressArchivoRespuesta').attr('style', 'height: 40px;display: block;');
        } else {
            $('#divProgressArchivoRespuesta').attr('style', 'height: 40px;display: none;');
        }
    });
});

function fxEditarRespuesta(id_res) {
    $('#btnEditarRespuesta').attr('disabled', 'true');
    $.ajax({
        type: 'POST',
        url: '/alumno/tarea/respuesta',
        data: {
            id_respuesta: id_res
        },
        error: function(error) {
            alert('Ocurrió un  error');
            console.error(error);
        }
    }).done(function(data) {
        $('#preid_respuesta').val(data.id_respuesta);
        $('#mdlPresentarTarea').modal('show');
        $('#btnEditarRespuesta').removeAttr('disabled');
    });
}