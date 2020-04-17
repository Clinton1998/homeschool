$(document).ready(function(){
    Ladda.bind('button[type=submit]', {timeout: 5000});
});

function fxAplicarGrado(id_grado){
    var l = Ladda.create(document.getElementById('btnAplicarGrado'+id_grado));
    l.start();
    
    $('#btnAplicarGrado'+id_grado).attr('disabled','true');
    $.ajax({
        type: 'POST',
        url:'/super/grados/aplicar',
        data: {
            id_grado: id_grado
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
            l.top();
        }
    }).done(function(data){
        $('#actidgrado').val(data.id_grado);
        $('#actnombre').val(data.c_nombre);
        $('#actnivel_academico').val(data.c_nivel_academico);
        $('#mdlActualizarGrado').modal('show');
        l.stop();
    });
}

function fxConfirmacionEliminarGrado(id_grado){
    swal({
        title: '¿Estas seguro?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí, elimínalo!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
        fxEliminarGrado(id_grado);
    }, function (dismiss) {
    });

}

function fxEliminarGrado(id){
    $('#btnConfirmacionEliminarGrado'+id).attr('disabled','true');
    $.ajax({
        type: 'POST',
        url: '/super/grados/eliminar',
        data: {
            id_grado: id
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            location.reload();
        }
    });
}