$(document).ready(function () {
    $('.a-info-docente').click(function (evt) {
        evt.preventDefault();
        fxAplicarDocente($(this).find('input').val());
    });

    $('#button-addon2').on('click', function () {
        fxBuscarDocente();
    });

    $('#inpBuscarNombreDocente').on('keypress', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            fxBuscarDocente();
        }
    });
});

function fxAplicarDocente(id_doc) {
    $('#spinnerInfoDocente').show();
    $('#divInfoDocente').attr('style', 'display: none;');
    $.ajax({
        type: 'POST',
        url: '/docente/docente/aplicar',
        data: {
            id_docente: id_doc
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            var srcFoto = '';
            if (data.docente.c_foto == null) {
                if (data.docente.c_sexo.toUpperCase() == 'M') {
                    srcFoto = '../assets/images/usuario/teacherman.png';
                } else {
                    srcFoto = '../assets/images/usuario/teacherwoman.png';
                }
            } else {
                srcFoto = '../super/docente/foto/' + data.docente.c_foto;
            }
            $('#imgInfoDocente').attr('src', srcFoto);
            $('#infoNombreDocente').text(data.docente.c_nombre.toLowerCase());
            $('#infoEspecilidadDocente').text(data.docente.c_especialidad.toLowerCase());
            $('#infoCorreoDocente').text(data.docente.c_correo);
            $('#infoTelefonoDocente').text(data.docente.c_telefono);
        } else {
            location.reload();
        }
        $('#spinnerInfoDocente').attr('style', 'display: none;');
        $('#divInfoDocente').show();
    });

}


function fxBuscarDocente() {
    $('#spinnerBuscadorDocente').show();
    $('#listDocentes').attr('style', 'display: none;');
    var l = Ladda.create(document.getElementById('button-addon2'));
    l.start();

    $.ajax({
        type: 'POST',
        url: '/docente/docente/buscar',
        data: {
            nombre: $('#inpBuscarNombreDocente').val()
        },
        error: function (error) {
            alert('Ocurrío un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        var htmlDocentes = '';
        data.docentes.forEach(function (elemento, indice) {
            htmlDocentes += '<li class="list-group-item tarea-pendiente-alumno">';
            htmlDocentes += '<a href="#" class="a-info-docente" data-toggle="modal" data-target="#modal-datos-docente" style="display: block; padding: 12px 20px;">';
            htmlDocentes += '<input type="hidden" value="' + elemento.id_docente + '">';
            if (elemento.c_foto == null) {
                if (elemento.c_sexo.toUpperCase() == 'M') {
                    htmlDocentes += '<img class="foto-perfil" src="../assets/images/usuario/teacherman.png" alt="Foto del docente">';
                } else {
                    htmlDocentes += '<img class="foto-perfil" src="../assets/images/usuario/teacherwoman.png" alt="Foto del docente">';
                }
            } else {
                htmlDocentes += '<img class="foto-perfil" src="../super/docente/foto/' + elemento.c_foto + '" alt="Foto del docente">';
            }
            htmlDocentes += elemento.c_nombre;
            htmlDocentes += '</a></li>';
        });
        $('#listDocentes').html(htmlDocentes);
        $('.a-info-docente').click(function (evt) {
            evt.preventDefault();
            fxAplicarDocente($(this).find('input').val());
        });

        l.stop();
        $('#spinnerBuscadorDocente').attr('style', 'display: none;');
        $('#listDocentes').show();
    });
}
