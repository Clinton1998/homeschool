$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Ladda.bind('button[type=submit]', { timeout: 3000 });
    //eventos para botones
    $('#btnBuscarPorRuc').on('click', function () {
        fxConsultaRuc(this);
    });

    $('#btnBuscarPorDni').on('click', function () {
        fxConsultaDni(this);
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

function fxConsultaRuc(obj) {
    var l = Ladda.create(obj);
    l.start();
    //proceso para verificar si haz pagado por usar la plataforma
    $.ajax({
        type: 'POST',
        url: '/verificaractivo',
        data: {
            ruc: $('#ruc').val()
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.permitido) {
            $.ajax({
                type: 'GET',
                url: 'https://dniruc.apisperu.com/api/v1/ruc/' + $('#ruc').val() + '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8',
                error: function (error) {
                    alert('Ocurrió un error');
                    console.error(error);
                    l.stop();
                }
            }).done(function (data) {
                $('#razonsocial').val(data.razonSocial);
                l.stop();
            });
        } else {
            toastr.info('Para poder usar el RUC en esta plataforma, comunicate con el gerente de la empresa Innova Sistemas Integrales, Puedes llamar al +51 930 274 447');
            l.stop();
        }
    });

}

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