$(document).ready(function() {
    //Ladda.bind('button[type=submit]', { timeout: 20000 });
    new SlimSelect({
        select: '#cbGradoSeccion',
        placeholder: 'Elige seccion',
        onChange: (info) => {
            fxActualizarDatosSegunSeccion(info.value);
        }
    });

    /*$('#frmAsignarTarea').on('submit', function() {
        alert('Envio de datos al servidor');
    });*/

    $('#btnSubmitAsignarTarea').on('click', function() {
        if ($('#txtTitulo').val() != '' && $('#selCategoria').val() != '' && $('#txtFechaEntrega').val() != '' && $('#cbGradoSeccion').val() != '' && $('#txtArchivo').val() != '') {
            $('#divProgressArchivoAsignacion').attr('style', 'height: 40px;display: block;');
        } else {
            $('#divProgressArchivoAsignacion').attr('style', 'height: 40px;display: none;');
        }
    });
});

function fxActualizarDatosSegunSeccion(id_sec) {
    $('#divRadioAlumno').find('input').attr('disabled', 'true');
    $('#selCategoria').attr('disabled', 'true');
    $.ajax({
        type: 'POST',
        url: '/docente/docente/alumnoscategorias',
        data: {
            id_docente: $('#id_docente').val(),
            id_seccion: id_sec
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        console.log(data);
        if (data.correcto) {
            htmlAlumnos = '';
            data.alumnos.forEach(function(alumno, indice) {
                htmlAlumnos += '<div class="check-alumnos form-check">';
                htmlAlumnos += '<input class="form-check-input" type="checkbox" value="' + alumno.id_alumno + '" id="chkAlumno' + alumno.id_alumno + '" name="alumnos[]" form="frmAsignarTarea">';
                htmlAlumnos += '<label class="form-check-label" for="chkAlumno' + alumno.id_alumno + '">';
                htmlAlumnos += alumno.c_nombre;
                htmlAlumnos += '</label></div>';
            });

            if (data.alumnos.length == 0) {
                toastr.error("No tienes ningun alumno en la sección");
                $('#selCategoria').attr('disabled', 'true');
                $('#txtFechaEntrega').attr('disabled', 'true');
                $('#txtHoraEntrega').attr('disabled', 'true');
                $('#txtMinutoEntrega').attr('disabled', 'true');
                $('#btnSubmitAsignarTarea').attr('disabled', 'true');
            }
            $('#divAlumnosDeSeccion').html(htmlAlumnos);
            htmlCategorias = '<option value=""></option>';
            data.categorias.forEach(function(categoria, indice) {
                htmlCategorias += '<option value="' + categoria.curso.id_categoria + '">' + categoria.curso.c_nombre + '</option>';
            });
            $('#selCategoria').html(htmlCategorias);

            if (data.categorias.length == 0) {
                $('#alertNoHayCategorias').show();
                $('#selCategoria').attr('disabled', 'true');
                $('#txtFechaEntrega').attr('disabled', 'true');
                $('#txtHoraEntrega').attr('disabled', 'true');
                $('#txtMinutoEntrega').attr('disabled', 'true');
                $('#btnSubmitAsignarTarea').attr('disabled', 'true');
            } else {
                $('#alertNoHayCategorias').attr('style', 'display:none;');
                $('#selCategoria').removeAttr('disabled');
                $('#txtFechaEntrega').removeAttr('disabled');
                $('#txtHoraEntrega').removeAttr('disabled');
                $('#txtMinutoEntrega').removeAttr('disabled');
                $('#btnSubmitAsignarTarea').removeAttr('disabled');
            }
            $('#divRadioAlumno').find('input').removeAttr('disabled');
            //$('#selCategoria').removeAttr('disabled');
        } else {
            location.reload();
        }
    });
}
