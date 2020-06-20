$(document).ready(function() {
    $('#chkConArchivoComunicado').on('change',function(){
        if($(this).prop('checked')){
            $('#divFrmSinArchivo').attr('style','display: none;')
            $('#btnEnviarComunicadoSinArchivo').attr('style','display: none;');
            $('#btnEnviarComunicadoConArchivo').show();
            $('#divFrmConArchivo').show();
        }else{
            $('#divFrmConArchivo').attr('style','display: none;');
            $('#btnEnviarComunicadoConArchivo').attr('style','display: none;');
            $('#btnEnviarComunicadoSinArchivo').show();
            $('#divFrmSinArchivo').show();
        }
    });

    $('input[name="opt_destino_comunicado_con_archivo"]').on('change', function() {
        if ($(this).val() == 'TODO') {
            $('#btnEnviarComunicadoConArchivo').find('span').text('docentes y alumnos');
            $('#btnEnviarComunicadoSinArchivo').find('span').text('docentes y alumnos');
            $('#radioTodoSinArchivo').prop('checked',true);
        } else if ($(this).val() == 'DOCE') {
            $('#btnEnviarComunicadoConArchivo').find('span').text('docentes');
            $('#btnEnviarComunicadoSinArchivo').find('span').text('docentes');
            $('#radioDocenteSinArchivo').prop('checked',true);
        } else {
            $('#btnEnviarComunicadoConArchivo').find('span').text('alumnos');
            $('#btnEnviarComunicadoSinArchivo').find('span').text('alumnos');
            $('#radioAlumnoSinArchivo').prop('checked',true);
        }
    });

    $('input[name="opt_destino_comunicado_sin_archivo"]').on('change', function() {
        if ($(this).val() == 'TODO') {
            $('#btnEnviarComunicadoSinArchivo').find('span').text('docentes y alumnos');
            $('#btnEnviarComunicadoConArchivo').find('span').text('docentes y alumnos');
            $('#radioTodoConArchivo').prop('checked',true);
        } else if ($(this).val() == 'DOCE') {
            $('#btnEnviarComunicadoSinArchivo').find('span').text('docentes');
            $('#btnEnviarComunicadoConArchivo').find('span').text('docentes');
            $('#radioDocenteConArchivo').prop('checked',true);
        } else {
            $('#btnEnviarComunicadoSinArchivo').find('span').text('alumnos');
            $('#btnEnviarComunicadoConArchivo').find('span').text('alumnos');
            $('#radioAlumnoConArchivo').prop('checked',true);
        }
    });

    $('#titulo_comunicado_con_archivo').on('change',function(){
        $('#titulo_comunicado_sin_archivo').val($(this).val());
    });
    $('#titulo_comunicado_sin_archivo').on('change',function(){
        $('#titulo_comunicado_con_archivo').val($(this).val());
    });
    $('#descripcion_comunicado_con_archivo').on('change',function(){
        $('#descripcion_comunicado_sin_archivo').val($(this).val());
    });
    $('#descripcion_comunicado_sin_archivo').on('change',function(){
        $('#descripcion_comunicado_con_archivo').val($(this).val());
    });
});
