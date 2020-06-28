$(document).ready(function() {
  $('#chkConArchivoRespuesta').on('change',function(){
    if($(this).prop('checked')){
      $('#divFrmRespuestaSinArchivo').attr('style','display: none;');
      $('#btnSubEditarRespuestaSinArchivo').attr('style','display: none;');
      $('#btnSubEditarRespuestaConArchivo').show();
      $('#divFrmRespuestaConArchivo').show();
    }else{
      $('#divFrmRespuestaConArchivo').attr('style','display: none;');
      $('#btnSubEditarRespuestaConArchivo').attr('style','display: none;');
      $('#btnSubEditarRespuestaSinArchivo').show();
      $('#divFrmRespuestaSinArchivo').show();
    }
  });

  $('#preobservacionConArchivo').on('change',function(){
    $('#preobservacionSinArchivo').val($(this).val());
  });

  $('#preobservacionSinArchivo').on('change',function(){
    $('#preobservacionConArchivo').val($(this).val());
  });
});

/*function fxEditarRespuesta(id_res) {
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
}*/
