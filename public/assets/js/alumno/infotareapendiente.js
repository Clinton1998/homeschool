$(document).ready(function() {
    $('#btnPresentarTarea').on('click', function() {
        if ($('#preobservacion').val().trim() != '' && $('#prearchivo').val() != '') {
            $('#divProgressArchivoRespuesta').attr('style', 'height: 40px;display: block;');
        } else {
            $('#divProgressArchivoRespuesta').attr('style', 'height: 40px;display: none;');
        }
    });
});

function fxResponder(id_tar) {
    $('#btnResponderTarea').attr('disabled', 'true');
    $('#preid_tarea').val(id_tar);
    $('#mdlPresentarTarea').modal('show');
    $('#btnResponderTarea').removeAttr('disabled');
}