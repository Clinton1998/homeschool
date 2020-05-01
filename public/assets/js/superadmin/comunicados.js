$(document).ready(function () {
    $('input[name="opt_destino_comunicado"]').on('change', function () {
        if ($(this).val() == 'TODO') {
            $('#btnEnviarComunicado').find('span').text('docentes y alumnos');
        } else if ($(this).val() == 'DOCE') {
            $('#btnEnviarComunicado').find('span').text('docentes');
        } else {
            $('#btnEnviarComunicado').find('span').text('alumnos');
        }
    });
});

