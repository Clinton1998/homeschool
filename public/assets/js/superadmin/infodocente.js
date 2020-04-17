$(document).ready(function () {
    Ladda.bind('button[type=submit]', { timeout: 10000 });
    new SlimSelect({
        select: '#optsecciones'
    });
    $('#btnBuscarPorDNI').on('click', function () {
        fxConsultaDni(this);
    });

    $("#frmAgregarSeccionADocente").submit(function (evt) {
        evt.preventDefault();
        fxAgregarSeccion();
    });

   $('#frmActulizarContraDocente').submit(function(evt){
        evt.preventDefault();
        fxCambiarContrasena();
   });

    //alert('Todo es correcto');
});

function fxConsultaDni(obj) {
    var l = Ladda.create(obj);
    l.start();
    $.ajax({
        type: 'GET',
        url: 'https://dniruc.apisperu.com/api/v1/dni/' + $('#dni').val() + '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8',
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        $('#nombre').val(data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno);
        l.stop();
    });
}

function fxQuitarSeccionDeDocente(id_doc, id_sec) {
    var l = Ladda.create(document.getElementById('btnQuitarSeccionDeDocente' + id_sec));
    l.start();

    $.ajax({
        type: 'POST',
        url: '/super/docente/quitarseccion',
        data: {
            id_docente: id_doc,
            id_seccion: id_sec
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        if (data.correcto) {
            $('#cardSeccion' + id_sec).remove();
        }
        l.stop();
    });
}

function fxMostrarSeccionesAAgregar(id_doc, nom_doc) {
    $('#id_docente').val(id_doc);
    $('#spanNombreDocente').text(nom_doc);
    $('#mdlAgregarCategoriaASeccion').modal('show');
}


function fxAgregarSeccion() {
    $.ajax({
        type: 'POST',
        url: '/super/docente/agregarseccion',
        data: {
            id_docente: $('#id_docente').val(),
            optsecciones: $('#optsecciones').val()
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            location.reload();
        }
    });
}
/*REVIEW*/
function fxCambiarContrasena() {
    var datos  = {
        id_docente: $('#infid_docente').val(),
        contrasena:$('#inpContra').val(),
        repite_contrasena: $('#inpContraRepet').val()
    };
    $.ajax({
        type: 'POST',
        url:'/super/docente/cambiarcontrasena',
        data: datos,
        error: function(error){
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            location.reload();
        }
    });
}