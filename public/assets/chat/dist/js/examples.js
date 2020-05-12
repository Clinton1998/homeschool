$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.layout .content .sidebar-group .sidebar .list-group-item', function() {
        if (jQuery.browser.mobile) {
            $(this).closest('.sidebar-group').removeClass('mobile-open');
        }
    });

    $('#btnCrearGrupo').on('click', function() {
        fxCrearNuevoGrupo();
    });
});

function fxCrearNuevoGrupo() {
    $.ajax({
        type: 'POST',
        url: '/chat/group/crear',
        data: {
            name: $('#group_name').val(),
            users: [280, 278]
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        console.log('Los datos devueltos son: ');
        console.log(data);
    });
}