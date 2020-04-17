$(document).ready(function () {
    Ladda.bind('button[type=submit]', {timeout: 5000});
});

function fxAplicarGrado(id_grado) {
    var l = Ladda.create(document.getElementById('btnAgregarSeccion'+id_grado));
    l.start();
    $('#btnAgregarSeccion'+id_grado).attr('disabled','true');
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
        $('#id_grado').val(data.id_grado);
        $('#spanNombreGrado').text(data.c_nombre);
        $('#spanNivelGrado').text(data.c_nivel_academico);
        $('#mdlAgregarSeccion').modal('show');
        l.stop();
    });
}

function fxEditarSeccion(id_seccion){
    $('#rowEdicionSeccion'+id_seccion).show();
    $('#rowNormalSeccion'+id_seccion).hide();
    $('#actnombre'+id_seccion).focus();
}

function fxCancelarEdicion(id_seccion){
    $('#rowEdicionSeccion'+id_seccion).hide();
    $('#rowNormalSeccion'+id_seccion).show();
}

function fxConfirmacionEliminarSeccion(id_seccion){
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
        fxEliminarSeccion(id_seccion);
    }, function (dismiss) {
    });

}

function fxEliminarSeccion(id){
    $('#btnConfirmacionEliminarSeccion'+id).attr('disabled','true');
    $.ajax({
        type: 'POST',
        url: '/super/secciones/eliminar',
        data: {
            id_seccion: id
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

function fxActualizarSeccion(id){
    $('#btnActualizarSeccion'+id).attr('disabled','true');
    var l = Ladda.create(document.getElementById('btnActualizarSeccion'+id));
    l.start();

    $.ajax({
        type:'POST',
        url:'/super/secciones/actualizar',
        data: {
            id_seccion: id,
            nombre: $('#actnombre'+id).val()
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function(data){
        if(data.correcto){
            l.stop();
            $('#actnombre'+id).val(data.nombre);
            $('#spanNombreNormal'+id).text(data.nombre);
            $('#rowEdicionSeccion'+id).hide();
            $('#rowNormalSeccion'+id).show();
        }
    });
}