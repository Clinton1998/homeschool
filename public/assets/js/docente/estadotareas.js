$(document).ready(function () {
    Ladda.bind('button[type=submit]', {
        timeout: 5000
    });
    //alert('Todo es correcto');
});

/*function Contadores() {
    // Badges de las pestañas
    document.querySelector(".badge-enviadas").innerHTML = document.getElementById("tareas-enviadas").childElementCount;
    document.querySelector(".badge-calificadas").innerHTML = document.getElementById("tareas-calificadas").childElementCount;
    document.querySelector(".badge-pendientes").innerHTML = document.getElementById("tareas-pendientes").childElementCount;
    // Badges de alumnos que enviaron y que no enviaron la tarea
    document.querySelector(".badge-alumnos-que-enviaron").innerHTML = document.getElementById("alumnos-que-enviaron").childElementCount;
    document.querySelector(".badge-alumnos-que-no-enviaron").innerHTML = document.getElementById("alumnos-que-no-enviaron").childElementCount;
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
        if (data.correcto) {
            $('#spanCategoria').text(data.tarea.categoria.c_nombre);
            $('#nombreTarea').text(data.tarea.c_titulo);
            $('#observacionTarea').text(data.tarea.c_observacion);
            var htmlAlumnosEnviaron = '';
            var htmlAlumnosNoEnviaron = '';
            var countEnviaron = 0;
            var countNoEnviaron = 0;
            data.tarea.alumnos_asignados.forEach(function (alumno, indice) {
                if (alumno.pivot.id_respuesta == null) {
                    htmlAlumnosNoEnviaron += '<li class="tarea-pendiente-alumno list-group-item">' + alumno.c_nombre + '</li>';
                    countNoEnviaron++;
                } else {
                    if (alumno.pivot.c_estado == 'ACAL') {
                        htmlAlumnosEnviaron += '<li class="tarea-pendiente-alumno list-group-item">';
                        htmlAlumnosEnviaron += alumno.c_nombre;
                        htmlAlumnosEnviaron += '<span class="btn-revisar badge badge-light" style="margin: auto 5px;" onclick="">Revisado</span>';
                        htmlAlumnosEnviaron += '<a href="#" class="badge badge-warning" onclick="fxAplicarRespuesta(' + alumno.pivot.id_alumno_docente_tarea + ');">';
                        htmlAlumnosEnviaron += '<svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg>';
                        htmlAlumnosEnviaron += '</a></li>';
                    } else {
                        htmlAlumnosEnviaron += '<li class="tarea-pendiente-alumno list-group-item" onclick="fxAplicarRespuesta(' + alumno.pivot.id_alumno_docente_tarea + ');">';
                        htmlAlumnosEnviaron += alumno.c_nombre;
                        htmlAlumnosEnviaron += '<a href="#" class="badge badge-success" style="margin-left: 5px;">';
                        htmlAlumnosEnviaron += 'Revisar';
                        htmlAlumnosEnviaron += '</a></li>';
                    }
                    countEnviaron++;
                }
            });
            $('#badgeEnviaron').text(countEnviaron);
            $('#badgeNoEnviaron').text(countNoEnviaron);
            $('#alumnos-que-enviaron').html(htmlAlumnosEnviaron);
            $('#alumnos-que-no-enviaron').html(htmlAlumnosNoEnviaron);
            $('#spinnerInfoTarea').attr('style', 'display: none;');
            $('#divInfoTarea').show();
        } else {
            location.reload();
        }
    });
}

function fxAplicarRespuesta(id_pue) {

    $.ajax({
        type: 'POST',
        url: '/docente/tarea/respuesta',
        data: {
            id_puente: id_pue
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            $('#id_puente').val(data.puente.id_alumno_docente_tarea);
            $('#respuestaObservacion').text(data.respuesta.c_observacion);
            $('#txtCalificacion').val(data.respuesta.c_calificacion);
            $('#txtComentario').val(data.respuesta.c_comentario_calificacion);
            $('#modal-tarea-pendiente-revisar').modal('show');
        } else {
            location.reload();
        }
    });
}

function fxConfirmarRevision(e) {
    $(e.target).attr('disabled', 'true');
    swal({
        title: '¿Estas seguro?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
        fxCalificarTareaDeAlumno();
    }, function (dismiss) {
        $(e.target).removeAttr('disabled');
    });
}

function fxCalificarTareaDeAlumno() {
    $('#frmCalificarTareaDeAlumno').submit();
}

function fxInfoTarea(id_tar) {
    $.ajax({
        type: 'POST',
        url: '/docente/tarea/aplicar_info',
        data: {
            id_tarea: id_tar
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            $('#infCategoria').text(data.tarea.categoria.c_nombre);
            $('#infTitulo').text(data.tarea.c_titulo);
            $('#infDescripcion').text(data.tarea.c_observacion);
            $('#infGrupo').find('p').text(data.seccion_asignada.c_nombre + ' - ' + data.seccion_asignada.grado.c_nombre + ' ' + data.seccion_asignada.grado.c_nivel_academico);
            $('#infFechaEnvio').find('p').text(data.tarea.created_at);
            $('#infFechaEntrega').find('p').text(data.tarea.t_fecha_hora_entrega);
            $('#modal-tarea-enviada-detalle').modal('show');
        } else {
            location.reload();
        }
    });
}
