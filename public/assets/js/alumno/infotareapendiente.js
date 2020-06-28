$(document).ready(function(){
  $('#chkConArchivoRespuesta').on('change',function(){
    if($(this).prop('checked')){
      $('#divFrmRespuestaSinArchivo').attr('style','display: none;');
      $('#btnPresentarTareaSinArchivo').attr('style','display: none;');
      $('#btnPresentarTareaConArchivo').show();
      $('#divFrmRespuestaConArchivo').show();
    }else{
      $('#divFrmRespuestaConArchivo').attr('style','display: none;');
      $('#btnPresentarTareaConArchivo').attr('style','display: none;');
      $('#btnPresentarTareaSinArchivo').show();
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
