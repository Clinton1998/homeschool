$(document).ready(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#btnActualizarClaveLicencia').on('click',fxActualizarClaveLicencia);
});

function fxActualizarClaveLicencia(){
  $('#mdlActualizarClave').modal('hide');
  $.ajax({
    type: 'POST',
    url: '/licencia/clave/actualizar',
    data: {
      token: $('#inpTokenLicencia').val(),
      clave: $('#inpNuevaClaveLicencia').val()
    },
    error: function(error){
      alert('Ocurrió un error');
      console.error(error);
      location.reload();
    }
  }).done(function(data){
    if(data.correcto){
      toastr.success('Clave de licencia actualizada');
      $('#frmLogin').submit();
    }else{
      location.reload();
    }
  });
}
