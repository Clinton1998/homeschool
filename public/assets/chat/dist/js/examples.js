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

    new SlimSelect({
        select: '#optusuarios'
    });
});

function fxCrearNuevoGrupo() {
    $('#btnCrearGrupo').attr('disabled', 'true');
    var data = {
        name: $('#group_name').val(),
        users: $('#optusuarios').val()
    };
    $.ajax({
        type: 'POST',
        url: '/chat/group/crear',
        data: data,
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
            $('#btnCrearGrupo').removeAttr('disabled');
        }
    }).done(function(data) {
        if (data.correcto) {
            location.reload();
        }
    });
}