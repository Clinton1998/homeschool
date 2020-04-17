$(document).ready(function () {
    //alert('Documento listo');
});

/*function MostrarPanel(){
    document.getElementById("panel-pendientes-detalle").style.display="block";
}*/

function CerrarPanel() {
    document.getElementById("panel-pendientes-detalle").style.display = "none";
}

function fxAplicarTarea(id_tar) {
    $('#panel-pendientes-detalle').show();
    $('#spinnerInfoTarea').show();
    $('#divInfoTarea').attr('style', 'display: none;');
    $.ajax({
        type: 'POST',
        url: '/docente/tarea/aplicar',
        data: {
            id_tarea: id_tar
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.log(error);
        }
    }).done(function (data) {
        console.log('Los datos devueltos son: ');
        console.log(data);
        if (data.correcto) {
            $('#spanCategoria').text(data.tarea.categoria.c_nombre);
            $('#nombreTarea').text(data.tarea.c_titulo);
            $('#observacionTarea').text(data.tarea.c_observacion);

            var htmlAlumnosEnviaron = '';
            var htmlAlumnosNoEnviaron = '';

            var countEnviaron = 0;
            var countNoEnviaron = 0;
            var countRevisados = 0;

            data.tarea.alumnos_asignados.forEach(function (alumno, indice) {
                if (alumno.pivot.id_respuesta == null) {
                    htmlAlumnosNoEnviaron += '<li class="list-group-item">' + alumno.c_nombre + '</li>';
                    countNoEnviaron++;
                } else {
                    if (alumno.pivot.c_estado == 'ACAL') {
                        htmlAlumnosEnviaron += '<li class="tarea-pendiente-alumno list-group-item">';
                        htmlAlumnosEnviaron += alumno.c_nombre;
                        htmlAlumnosEnviaron += '<span class="btn-revisar badge badge-light m-2">Revisado</span></li>';
                        countRevisados++;
                    } else {
                        htmlAlumnosEnviaron += '<li class="tarea-pendiente-alumno list-group-item" onclick="fxAplicarRespuesta('+alumno.pivot.id_alumno_docente_tarea+');">';
                        htmlAlumnosEnviaron += alumno.c_nombre;
                        htmlAlumnosEnviaron += '<span class="btn-revisar badge badge-success m-2">Revisar</span></li>';
                    }
                    countEnviaron++;
                }
            });
            $('#spnNRevisados').text(countRevisados);
            $('#spnNTotales').text(countEnviaron);
            $('#badgeEnviaron').text(countEnviaron);
            $('#badgeNoEnviaron').text(countNoEnviaron);
            $('#listEnviaron').html(htmlAlumnosEnviaron);
            $('#ListNoEnviaron').html(htmlAlumnosNoEnviaron);
            $('#spinnerInfoTarea').attr('style', 'display: none;');
            $('#divInfoTarea').show();
        } else {
            location.reload();
        }
    });
}

function fxAplicarRespuesta(id_pue){
    alert('El id puente es: '+id_pue);

    $.ajax({
        type: 'POST',
        url: '/docente/tarea/respuesta',
        data: {
            id_puente: id_pue
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        console.log('Los datos devueltos son: ');
        console.log(data);
    });
}