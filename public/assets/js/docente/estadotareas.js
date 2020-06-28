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
            $('#spanCategoria').attr('style','text:white; background-color: '+data.tarea.categoria.c_nivel_academico);
            $('#nombreTarea').text(data.tarea.c_titulo);
            $('#observacionTarea').text(data.tarea.c_observacion);
            if (data.tarea.c_url_archivo == null) {
                $('#archivoTarea').text('');
            } else {
                var htmlArchivos = '<span class="d-block"><a href="/docente/tarea/archivo/'+data.tarea.id_tarea+'/'+data.tarea.c_url_archivo+'" class="text-primary" cdownload="'+data.tarea.c_url_archivo+'">Descargar Archivo '+data.tarea.c_url_archivo+'</a></span>';
                $.each(data.tarea.archivos,function(index,archivo){
                    htmlArchivos += '<span class="d-block"><a href="/docente/tarea/archivo/'+data.tarea.id_tarea+'/'+archivo.c_url_archivo+'" class="text-primary" cdownload="'+archivo.c_url_archivo+'">Descargar Archivo '+archivo.c_url_archivo+'</a></span>';
                });
                $('#archivoTarea').html(htmlArchivos);
            }
            var htmlAlumnosEnviaron = '';
            var htmlAlumnosEnvFueraDeTiempo = '';
            var htmlAlumnosNoEnviaron = '';
            var countEnviaronATiempo = 0;
            var countEnviaronFueraDePlazo = 0;
            var countNoEnviaron = 0;
            data.tarea.alumnos_asignados.forEach(function (alumno, indice) {
                if (alumno.pivot.id_respuesta == null) {
                    //los que nunca enviaron
                    htmlAlumnosNoEnviaron += '<li class="tarea-pendiente-alumno list-group-item">' + alumno.c_nombre + '</li>';
                    countNoEnviaron++;
                } else {
                    if (alumno.pivot.updated_at >= data.tarea.t_fecha_hora_entrega) {
                        //los que enviaron fuera del plazo
                        if (alumno.pivot.c_estado == 'ACAL') {
                            htmlAlumnosEnvFueraDeTiempo += '<li class="tarea-pendiente-alumno list-group-item">';
                            htmlAlumnosEnvFueraDeTiempo += alumno.c_nombre;
                            htmlAlumnosEnvFueraDeTiempo += '<span class="btn-revisar badge badge-light p-2" style="margin: auto 5px;" onclick="">Revisado</span>';
                            htmlAlumnosEnvFueraDeTiempo += '<a href="#" class="badge badge-warning p-2" onclick="fxAplicarRespuesta(' + alumno.pivot.id_alumno_docente_tarea + ',event);">';
                            htmlAlumnosEnvFueraDeTiempo += '<svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg>';
                            htmlAlumnosEnvFueraDeTiempo += '</a></li>';
                        } else {
                            htmlAlumnosEnvFueraDeTiempo += '<li class="tarea-pendiente-alumno list-group-item" onclick="fxAplicarRespuesta(' + alumno.pivot.id_alumno_docente_tarea + ',event);">';
                            htmlAlumnosEnvFueraDeTiempo += alumno.c_nombre;
                            htmlAlumnosEnvFueraDeTiempo += '<a href="#" class="badge badge-success p-2" style="margin-left: 5px;">';
                            htmlAlumnosEnvFueraDeTiempo += 'Revisar';
                            htmlAlumnosEnvFueraDeTiempo += '</a></li>';
                        }
                        countEnviaronFueraDePlazo++;
                    } else {
                        //los que enviaron a tiempo
                        if (alumno.pivot.c_estado == 'ACAL') {
                            htmlAlumnosEnviaron += '<li class="tarea-pendiente-alumno list-group-item">';
                            htmlAlumnosEnviaron += alumno.c_nombre;
                            htmlAlumnosEnviaron += '<span class="btn-revisar badge badge-light p-2" style="margin: auto 5px;" onclick="">Revisado</span>';
                            htmlAlumnosEnviaron += '<a href="#" class="badge badge-warning p-2" onclick="fxAplicarRespuesta(' + alumno.pivot.id_alumno_docente_tarea + ',event);">';
                            htmlAlumnosEnviaron += '<svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg>';
                            htmlAlumnosEnviaron += '</a></li>';
                        } else {
                            htmlAlumnosEnviaron += '<li class="tarea-pendiente-alumno list-group-item" onclick="fxAplicarRespuesta(' + alumno.pivot.id_alumno_docente_tarea + ',event);">';
                            htmlAlumnosEnviaron += alumno.c_nombre;
                            htmlAlumnosEnviaron += '<a href="#" class="badge badge-success p-2" style="margin-left: 5px;">';
                            htmlAlumnosEnviaron += 'Revisar';
                            htmlAlumnosEnviaron += '</a></li>';
                        }
                        countEnviaronATiempo++;
                    }
                }
            });
            $('#badgeEnviaron').text(countEnviaronATiempo);
            $('#badgeFueraDePlazo').text(countEnviaronFueraDePlazo);
            $('#badgeNoEnviaron').text(countNoEnviaron);
            $('#alumnos-que-enviaron').html(htmlAlumnosEnviaron);
            $('#alumnos-que-enviaron-fuera-de-plazo').html(htmlAlumnosEnvFueraDeTiempo);
            $('#alumnos-que-no-enviaron').html(htmlAlumnosNoEnviaron);
            $('#spinnerInfoTarea').attr('style', 'display: none;');
            $('#divInfoTarea').show();
        } else {
            location.reload();
        }
    });
}

function fxAplicarRespuesta(id_pue,e) {
    e.preventDefault();
    $('#divFrmTareaPendiente').attr('style','display: none;');
    $('#spinnerInfoTareaPendiente').show();
    $('#modal-tarea-pendiente-revisar').modal('show');
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
            if (data.respuesta.c_url_archivo == null) {
                $('#divRespuestaArchivos').text('No hay archivos adjuntos');
            } else {
              var htmlArchivos = '<span class="d-block"><a href="/alumno/tarea/respuestaarchivo/'+data.puente.id_tarea+'/'+data.respuesta.id_respuesta+'/'+data.respuesta.c_url_archivo+'" class="text-primary" cdownload="'+data.respuesta.c_url_archivo+'">Descargar Archivo '+data.respuesta.c_url_archivo+'</a></span>';
              $.each(data.respuesta.archivos,function(index,archivo){
                htmlArchivos += '<span class="d-block"><a href="/alumno/tarea/respuestaarchivo/'+data.puente.id_tarea+'/'+data.respuesta.id_respuesta+'/'+archivo.c_url_archivo+'" class="text-primary" cdownload="'+archivo.c_url_archivo+'">Descargar Archivo '+archivo.c_url_archivo+'</a></span>';
              });
              $('#divRespuestaArchivos').html(htmlArchivos);
            }
            $('#txtCalificacion').val(data.respuesta.c_calificacion);
            $('#txtComentario').val(data.respuesta.c_comentario_calificacion);
            $('#spinnerInfoTareaPendiente').attr('style','display: none;');
            $('#divFrmTareaPendiente').show();
        } else {
            location.reload();
        }
    });
}

function fxConfirmarRevision(e) {
    $(e.target).attr('disabled', 'true');
    swal({
        title: '¿Estas seguro?',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {
        $('#frmCalificarTareaDeAlumno').submit();
    }, function (dismiss) {
        $(e.target).removeAttr('disabled');
    });
}
