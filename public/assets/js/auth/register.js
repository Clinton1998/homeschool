$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //Ladda.bind('button[type=submit]', { timeout: 3000 });
    //eventos para botones
    $('#btnBuscarPorRuc').on('click', function () {
        fxConsultaRuc(this);
    });

    $('#btnBuscarPorDni').on('click', function () {
        fxConsultaDni(this);
    });
    $('#dni').on('keypress', function () {
        limpiarDatos();
    });
    $('#dni').on('change', function () {
        limpiarDatos();
    });
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "20000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
});

function limpiarDatos() {
    $('#nombre').val('');
    $('#email').val('');
    $('#password').val('');
    $('#password-confirm').val('');

    $('#nombre').attr('readonly', 'true');
    $('#email').attr('readonly', 'true');
    $('#password').attr('disabled','true');
    $('#password-confirm').attr('disabled','true');
}

function fxConsultaRuc(obj) {
    var l = Ladda.create(obj);
    l.start();

    $.ajax({
        type: 'POST',
        url: '/ruc/buscar',
        data: {
            ruc: $('#ruc').val()
        },
        dataType: 'JSON',
        error: function (error) {
            toastr.error('No hay resultados');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        $('#razonsocial').val(data.razonSocial);
        l.stop();
    });
}

function fxConsultaDni(obj) {
    limpiarDatos();
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
            toastr.error('No hay resultados');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        //proceso para generar un usuario segun dni del representante
        var apiconsulta = data;
        $.ajax({
            type: 'POST',
            url: '/register/generarusuario',
            data: {
                dni: $('#dni').val()
            },
            error: function (error) {
                toastr.error('Ups! algo salió mal. Intenta nuevamente');
                console.error(error);
            }
        }).done(function (repsonse) {
            console.log('Los datos devueltos son: ');
            console.log(repsonse);
            $('#nombre').val(apiconsulta.nombres + ' ' + apiconsulta.apellidoPaterno + ' ' + apiconsulta.apellidoMaterno);
            $('#email').val(repsonse.usuario_generado);
            $('#password').removeAttr('disabled');
            $('#password-confirm').removeAttr('disabled');
            l.stop();
        });
    });
}