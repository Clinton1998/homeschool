$(document).ready(function () {
    Ladda.bind('button[type=submit]', {
        timeout: 5000
    });
    new SlimSelect({
        select: '#optgroups'
    });

    new SlimSelect({
        select: '#nombrecategoria',
        placeholder: 'Elige categoria'
    });

    $('#nombre').on('change', function () {
        $('#spanNombreNuevaCategoria').text($(this).val());
    });
});

function fxAplicarCategoria(id) {
    var l = Ladda.create(document.getElementById('btnAplicarCategoria' + id));
    l.start();
    $('#btnAplicarCategoria' + id).attr('disabled', 'true');

    $.ajax({
        type: 'POST',
        url: '/super/categorias/aplicar',
        data: {
            id_categoria: id
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        $('#id_categoria').val(data.id_categoria);
        $('#actnombre').val(data.c_nombre);
        $('#actnivel_academico').val(data.c_nivel_academico);
        $('#mdlEditarCategoria').modal('show');
        l.stop();
    });
}


function fxConfirmacionEliminarCategoria(id_categoria) {
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
        fxEliminarCategoria(id_categoria);
    }, function (dismiss) {});

}

function fxEliminarCategoria(id) {

    $('#btnConfirmacionEliminarCategoria' + id).attr('disabled', 'true');
    $.ajax({
        type: 'POST',
        url: '/super/categorias/eliminar',
        data: {
            id_categoria: id
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

function fxQuitarCategoriaDeSeccion(id_seccion, id) {
    var l = Ladda.create(document.getElementById('btnConfirmacionQuitarCategoriaDeSeccion' + id));
    l.start();
    $('#btnConfirmacionQuitarCategoriaDeSeccion' + id).attr('disabled', 'true');
    $.ajax({
        type: 'POST',
        url: '/super/categorias/quitarcategoria',
        data: {
            id_seccion: id_seccion,
            id_categoria: id
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        if (data.correcto) {
            location.reload();
            /*$('#btnConfirmacionQuitarCategoriaDeSeccion'+id).parent().remove();
            $("[data-toggle='tooltip']").tooltip('hide');*/
        }
    });
}

function fxAplicarSeccion(id) {
    var l = Ladda.create(document.getElementById('btnAgregarCategoriaASeccion' + id));
    l.start();

    $.ajax({
        type: 'POST',
        url: '/super/categorias/aplicarseccion',
        data: {
            id_seccion: id
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        //slimCategorias.destroy();
        $('#id_seccion').val(data.seccion.id_seccion);
        $('#spanNombreSeccion').text(data.seccion.c_nombre);
        var htmlCategorias = '<option data-placeholder="true"></option>';
        data.categoria_no_utilizados.forEach(function (elemento, indice) {
            htmlCategorias += '<option value="' + elemento.id_categoria + '">' + elemento.c_nombre + ' - ' + elemento.c_nivel_academico + '</option>'
        });
        $('#nombrecategoria').html(htmlCategorias);
        $('#mdlAgregarCategoriaASeccion').modal('show');
        l.stop();
    });

}
