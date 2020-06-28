$(document).ready(function () {
    new SlimSelect({
        select: '#cbGradoSeccionSinArchivo',
        placeholder: 'Elige seccion',
        onChange: (info) => {
            //selSeccionConArchivo.selected(info.value);
            fxActualizarDatosSegunSeccion(info.value);
        }
    });

    new SlimSelect({
        select: '#cbGradoSeccionConArchivo',
        placeholder: 'Elige seccion',
        onChange: (info) => {
            //selSeccionSinArchivo.selected(info.value);
            fxActualizarDatosSegunSeccion(info.value,true);
        }
    });

    $('#chkConArchivoNuevaTarea').on('change',function(){
        if($(this).prop('checked')){
            $('#divFrmTareaSinArchivo').attr('style','display: none;');
            $('#btnSubmitAsignarTareaSinArchivo').attr('style','display: none;');
            $('#btnSubmitAsignarTareaConArchivo').show();
            $('#divAlumnosDeSeccionSinArchivo').attr('style','display: none;');
            $('#divAlumnosDeSeccionConArchivo').show();
            $('#divFrmTareaConArchivo').show();
        }else{
            $('#divFrmTareaConArchivo').attr('style','display: none;');
            $('#btnSubmitAsignarTareaConArchivo').attr('style','display: none;');
            $('#btnSubmitAsignarTareaSinArchivo').show();
            $('#divAlumnosDeSeccionConArchivo').attr('style','display: none;')
            $('#divAlumnosDeSeccionSinArchivo').show();
            $('#divFrmTareaSinArchivo').show();
        }
    });

    $('#txtTituloConArchivo').on('change',function(){
      $('#txtTituloSinArchivo').val($(this).val());
    });
    $('#txtTituloSinArchivo').on('change',function(){
      $('#txtTituloConArchivo').val($(this).val());
    });

    $('#txtDescripcionConArchivo').on('change',function(){
      $('#txtDescripcionSinArchivo').val($(this).val());
    });

    $('#txtDescripcionSinArchivo').on('change',function(){
      $('#txtDescripcionConArchivo').val($(this).val());
    });
});

function fxActualizarDatosSegunSeccion(id_sec,con_archivo = false) {
    if(con_archivo){
        $('#divRadioAlumnoConArchivo').find('input').attr('disabled', 'true');
        $('#selCategoriaConArchivo').attr('disabled','true');
    }else{
        $('#divRadioAlumnoSinArchivo').find('input').attr('disabled', 'true');
        $('#selCategoriaSinArchivo').attr('disabled', 'true');
    }
    $.ajax({
        type: 'POST',
        url: '/docente/docente/alumnoscategorias',
        data: {
            id_docente: (con_archivo==false)?$('#id_docente_sin_archivo').val():$('#id_docente_con_archivo').val(),
            id_seccion: id_sec
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            htmlAlumnosSinArchivo = '';
            htmlAlumnosConArchivo = '';
            data.alumnos.forEach(function (alumno, indice) {
              if(con_archivo){
                  htmlAlumnosConArchivo += '<div class="check-alumnos form-check">';
                  htmlAlumnosConArchivo += '<input class="form-check-input" type="checkbox" value="' + alumno.id_alumno + '" id="chkAlumnoConArchivo' + alumno.id_alumno + '" name="alumnos[]" form="qq-form">';
                  htmlAlumnosConArchivo += '<label class="hs_capitalize form-check-label" for="chkAlumnoConArchivo' + alumno.id_alumno + '">';
                  htmlAlumnosConArchivo += alumno.c_nombre.toLowerCase();
                  htmlAlumnosConArchivo += '</label></div>';
              }else{
                  htmlAlumnosSinArchivo += '<div class="check-alumnos form-check">';
                  htmlAlumnosSinArchivo += '<input class="form-check-input" type="checkbox" value="' + alumno.id_alumno + '" id="chkAlumnoSinArchivo' + alumno.id_alumno + '" name="alumnos[]" form="frmAsignarTarea">';
                  htmlAlumnosSinArchivo += '<label class="hs_capitalize form-check-label" for="chkAlumnoSinArchivo' + alumno.id_alumno + '">';
                  htmlAlumnosSinArchivo += alumno.c_nombre.toLowerCase();
                  htmlAlumnosSinArchivo += '</label></div>';
              }
            });

            if (data.alumnos.length == 0) {
                toastr.error("No tienes ningun alumno en la sección");
                if(con_archivo){
                  $('#selCategoriaConArchivo').attr('disabled','true');
                  $('#txtFechaEntregaConArchivo').attr('disabled','true');
                  $('#txtHoraEntregaConArchivo').attr('disabled','true');
                  $('#txtMinutoEntregaConArchivo').attr('disabled','true');
                  $('#btnSubmitAsignarTareaConArchivo').attr('disabled','true');
                }else{
                  $('#selCategoriaSinArchivo').attr('disabled', 'true');
                  $('#txtFechaEntregaSinArchivo').attr('disabled', 'true');
                  $('#txtHoraEntregaSinArchivo').attr('disabled', 'true');
                  $('#txtMinutoEntregaSinArchivo').attr('disabled', 'true');
                  $('#btnSubmitAsignarTareaSinArchivo').attr('disabled', 'true');
                }
            }
            if(con_archivo){
                $('#divAlumnosDeSeccionConArchivo').html(htmlAlumnosConArchivo);
            }else{
                $('#divAlumnosDeSeccionSinArchivo').html(htmlAlumnosSinArchivo);
            }
            htmlCategorias = '<option value=""></option>';
            data.categorias.forEach(function (categoria, indice) {
                htmlCategorias += '<option value="' + categoria.curso.id_categoria + '">' + categoria.curso.c_nombre.charAt(0).toUpperCase() + categoria.curso.c_nombre.slice(1).toLowerCase() + '</option>';
            });
            if(con_archivo){
                $('#selCategoriaConArchivo').html(htmlCategorias);
            }else{
                $('#selCategoriaSinArchivo').html(htmlCategorias);
            }
            if (data.categorias.length == 0) {
              if(con_archivo){
                $('#alertNoHayCategoriasConArchivo').show();
                $('#selCategoriaConArchivo').attr('disabled','true');
                $('#txtFechaEntregaConArchivo').attr('disabled','true');
                $('#txtHoraEntregaConArchivo').attr('disabled','true');
                $('#txtMinutoEntregaConArchivo').attr('disabled','true');
                $('#btnSubmitAsignarTareaConArchivo').attr('disabled','true');
              }else{
                $('#alertNoHayCategoriasSinArchivo').show();
                $('#selCategoriaSinArchivo').attr('disabled', 'true');
                $('#txtFechaEntregaSinArchivo').attr('disabled', 'true');
                $('#txtHoraEntregaSinArchivo').attr('disabled', 'true');
                $('#txtMinutoEntregaSinArchivo').attr('disabled', 'true');
                $('#btnSubmitAsignarTareaSinArchivo').attr('disabled', 'true');
              }
            } else {
              if(con_archivo){
                $('#alertNoHayCategoriasConArchivo').attr('style','display: none;');
                $('#selCategoriaConArchivo').removeAttr('disabled');
                $('#txtFechaEntregaConArchivo').removeAttr('disabled');
                $('#txtHoraEntregaConArchivo').removeAttr('disabled');
                $('#txtMinutoEntregaConArchivo').removeAttr('disabled');
                $('#btnSubmitAsignarTareaConArchivo').removeAttr('disabled');
              }else{
                $('#alertNoHayCategoriasSinArchivo').attr('style', 'display:none;');
                $('#selCategoriaSinArchivo').removeAttr('disabled');
                $('#txtFechaEntregaSinArchivo').removeAttr('disabled');
                $('#txtHoraEntregaSinArchivo').removeAttr('disabled');
                $('#txtMinutoEntregaSinArchivo').removeAttr('disabled');
                $('#btnSubmitAsignarTareaSinArchivo').removeAttr('disabled');
              }
            }
            if(con_archivo){
              $('#divRadioAlumnoConArchivo').find('input').removeAttr('disabled');
            }else{
              $('#divRadioAlumnoSinArchivo').find('input').removeAttr('disabled');
            }
        } else {
            location.reload();
        }
    });
}
