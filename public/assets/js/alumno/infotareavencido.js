
function fxResponder(id_tar) {
    $('#btnResponderTarea').attr('disabled', 'true');
    $('#preid_tarea').val(id_tar);
    $('#mdlPresentarTarea').modal('show');
    $('#btnResponderTarea').removeAttr('disabled');
}
