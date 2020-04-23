$(document).ready(function () {
    Ladda.bind('button[type=submit]', { timeout: 20000 });
    $('#btnBuscarPorDNI').on('click', function () {
        fxConsultaDni(this);
    });

});
function fxConsultaDni(obj) {
    var l = Ladda.create(obj);
    l.start();
    $.ajax({
        type: 'POST',
        url: '/dni/buscar',
        data: {
            dni: $('#inpActDniRepresentante').val()
        },
        dataType: 'JSON',
        error: function (error) {
            toastr.error('No hay resultados');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        $('#inpActNombreRepresentante').val(data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno);
        l.stop();
    });
}