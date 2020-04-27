$(document).ready(function () {
    Ladda.bind('button[type=submit]', { timeout: 10000 });
    new SlimSelect({
        select: '#optsecciones'
    });
    new SlimSelect({
        select: '#optcategorias'
    });
    $('#btnBuscarPorDNI').on('click', function () {
        fxConsultaDni(this);
    });

    $("#frmAgregarSeccionADocente").submit(function (evt) {
        evt.preventDefault();
        fxAgregarSeccion();
    });

    $("#frmAgregarCategoriaADocente").submit(function (evt) {
        evt.preventDefault();
        fxAgregarCategoria();
    });

    $('#frmActulizarContraDocente').submit(function (evt) {
        evt.preventDefault();
        fxCambiarContrasena();
    });

    //alert('Todo es correcto');
});

function fxConsultaDni(obj) {
    var l = Ladda.create(obj);
    l.start();
    $.ajax({
        type: 'POST',
        url: '/dni/buscar',
        data: {
            dni: $('#dni').val()
        },
        dataType: 'JSON',
        error: function (error) {
            alert('No hay resultados');
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

function fxQuitarCategoriaDeDocente(id_doc, id_cat) {
    var l = Ladda.create(document.getElementById('btnQuitarCategoriaDeDocente' + id_cat));
    l.start();

    $.ajax({
        type: 'POST',
        url: '/super/docente/quitarcategoria',
        data: {
            id_docente: id_doc,
            id_categoria: id_cat
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        if (data.correcto) {
            $('#cardCategoria' + id_cat).remove();
        }
        l.stop();
    });
}

function fxMostrarSeccionesAAgregar(id_doc, nom_doc) {
    $('#sec_id_docente').val(id_doc);
    $('#mdlAgregarCategoriaASeccion').modal('show');
}

function fxMostrarCategoriasAAgregar(id_doc, nom_doc) {
    $('#cat_id_docente').val(id_doc);
    $('#mdlAgregarCategoriaADocente').modal('show');
}
function fxAgregarSeccion() {
    $.ajax({
        type: 'POST',
        url: '/super/docente/agregarseccion',
        data: {
            id_docente: $('#sec_id_docente').val(),
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

function fxAgregarCategoria() {
    $.ajax({
        type: 'POST',
        url: '/super/docente/agregarcategoria',
        data: {
            id_docente: $('#cat_id_docente').val(),
            optcategorias: $('#optcategorias').val()
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
    var datos = {
        id_docente: $('#infid_docente').val(),
        contrasena: $('#inpContra').val(),
        repite_contrasena: $('#inpContraRepet').val()
    };
    $.ajax({
        type: 'POST',
        url: '/super/docente/cambiarcontrasena',
        data: datos,
        error: function (error) {
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            location.reload();
        }
    });
}