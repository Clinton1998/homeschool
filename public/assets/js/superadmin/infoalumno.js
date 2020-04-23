$(document).ready(function () {
    Ladda.bind('button[type=submit]', { timeout: 10000 });

    $('#btnBuscarPorDNI').on('click', function () {
        fxConsultaDni(this);
    });


    $('#frmActualizarContraAlumno').submit(function (evt) {
        evt.preventDefault();
        fxCambiarContrasena();
    });

    $('#frmActualizacionRepresentanteAlumno').submit(function (evt) {
        evt.preventDefault();
        fxActualizarRepresentante();
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

/*REVIEW*/
function fxCambiarContrasena() {
    var datos = {
        id_alumno: $('#infid_alumno').val(),
        contrasena: $('#inpContra').val(),
        repite_contrasena: $('#inpContraRepet').val()
    };
    $.ajax({
        type: 'POST',
        url: '/super/alumno/cambiarcontrasena',
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

function fxActualizarRepresentante() {
    /*
            $alumno->c_dni_representante1 = $request->input('dni_repre1');
            $alumno->c_nombre_representante1 = $request->input('nombre_repre1');
            $alumno->c_nacionalidad_representante1 = $request->input('nacionalidad_repre1');
            $alumno->c_sexo_representante1 = $request->input('sexo_repre1');
            $alumno->c_telefono_representante1 = $request->input('telefono_repre1');
            $alumno->c_correo_representante1 = $request->input('correo_repre1');
            $alumno->c_direccion_representante1 = $request->input('direccion_repre1');
            $alumno->c_vinculo_representante1 = $request->input('vinculo_repre1');
    */
    var datos = {
        id_alumno: $('#id_alumno_repre').val(),
        dni_repre1: $('#dni_repre1').val(),
        nombre_repre1: $('#nombre_repre1').val(),
        nacionalidad_repre1: $('#nacionalidad_repre1').val(),
        sexo_repre1: $('#sexo_repre1').val(),
        telefono_repre1: $('#telefono_repre1').val(),
        correo_repre1: $('#correo_repre1').val(),
        direccion_repre1: $('#direccion_repre1').val(),
        vinculo_repre1: $('#vinculo_repre1').val(),
        dni_repre2: $('#dni_repre2').val(),
        nombre_repre2: $('#nombre_repre2').val(),
        nacionalidad_repre2: $('#nacionalidad_repre2').val(),
        sexo_repre2: $('#sexo_repre2').val(),
        telefono_repre2: $('#telefono_repre2').val(),
        correo_repre2: $('#correo_repre2').val(),
        direccion_repre2: $('#direccion_repre2').val(),
        vinculo_repre2: $('#vinculo_repre2').val(),
    };

    $.ajax({
        type: 'POST',
        url: '/super/alumno/actualizarrepresentante',
        data: datos,
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