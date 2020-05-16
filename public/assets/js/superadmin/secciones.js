$(document).ready(function() {
    Ladda.bind('button[type=submit]', {
        timeout: 5000
    });
});

function fxAlumnosDeSeccion(seccion, e) {
    e.preventDefault();
    $('#spinnerInfoAlumnos').show();
    $('#divAlumnos').attr('style', 'display: none;');
    $('#alumnos_seccion').modal('show');
    fxConsultarAlumnosDeSeccion(seccion);
}

function fxConsultarAlumnosDeSeccion(seccion) {
    $.ajax({
        type: 'POST',
        url: '/super/gradoseccion/alumnos',
        data: {
            id_seccion: seccion
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if (data.correcto) {
            var htmlAlumnos = ``;

            data.alumnos.forEach(function(alumno, indice) {
                htmlAlumnos += `
                <div class="card_list">
                        <div class="card_list_fotografia">`;
                var srcFoto = '';
                if (alumno.c_foto == null) {
                    if (alumno.c_sexo.toUpperCase() == 'M') {
                        srcFoto = '../assets/images/usuario/studentman.png';
                    } else {
                        srcFoto = '../assets/images/usuario/studentwoman.png';
                    }
                } else {
                    srcFoto = '../super/alumno/foto/' + alumno.c_foto;
                }

                htmlAlumnos += `<img class="card_list_fotografia_img" src="${srcFoto}" alt="${alumno.c_nombre}">`;
                htmlAlumnos += `</div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>${alumno.c_nombre}</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: ${alumno.c_dni}</p>
                                </div>
                            </div>
    
                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: ${(alumno.c_telefono_representante1?alumno.c_telefono_representante1:alumno.c_telefono_representante2)}</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>${alumno.c_correo}</p>
                                </div>
                            </div>
    
                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Apoderado:&nbsp;</strong>
                                        <p class="hs_capitalize">${(alumno.c_nombre_representante1?alumno.c_nombre_representante1:alumno.c_nombre_representante2)}&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_telefono">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Telf.:&nbsp;</strong>
                                        <p>${(alumno.c_telefono_representante1?alumno.c_telefono_representante1:alumno.c_telefono_representante2)}&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="/super/alumno/${alumno.id_alumno}" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });

            if (data.alumnos.length > 0) {
                $('#divAlumnos').html(htmlAlumnos);
            } else {
                $('#divAlumnos').html('<h3>No hay alumnos</h3>');
            }
            $('#spinnerInfoAlumnos').attr('style', 'display: none;');
            $('#divAlumnos').show();

        } else {
            alert('Joder paso algo!!');
        }
    });
}

function fxDocentesDeSeccion(seccion, e) {
    e.preventDefault();
    $('#spinnerInfoDocentes').show();
    $('#divDocentes').attr('style', 'display: none;');
    $('#docentes_seccion').modal('show');
    fxConsultarDocentesDeSeccion(seccion);
}

function fxConsultarDocentesDeSeccion(seccion) {
    $.ajax({
        type: 'POST',
        url: '/super/gradoseccion/docentes',
        data: {
            id_seccion: seccion
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if (data.correcto) {
            var htmlDocentes = ``;
            data.docentes.forEach(function(docente, indice) {
                htmlDocentes += `<div class="card_list">
                    <div class="card_list_fotografia">`;
                var srcFoto = '';
                if (docente.c_foto == null) {
                    if (docente.c_sexo.toUpperCase() == 'M') {
                        srcFoto = '../assets/images/usuario/teacherman.png';
                    } else {
                        srcFoto = '../assets/images/usuario/teacherwoman.png';
                    }
                } else {
                    srcFoto = '../super/docente/foto/' + docente.c_foto;
                }

                htmlDocentes += `<img class="card_list_fotografia_img" src="${srcFoto}" alt="${docente.c_nombre}">`;
                htmlDocentes += `</div>
                    <div class="card_list_datos">
                        <div class="card_list_basico">
                            <div class="card_list_nombre">
                                <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>${docente.c_nombre}</strong>
                            </div>
                            <div class="card_list_dni">
                                <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: ${docente.c_dni}</p>
                            </div>
                        </div>

                        <div class="card_list_contacto">
                            <div class="card_list_telefono">
                                <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: ${docente.c_telefono}</strong>
                            </div>
                            <div class="card_list_correo">
                                <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>${docente.c_correo}</p>
                            </div>
                        </div>

                        <div class="card_list_representante">
                            <div class="card_list_representante_nombre">
                                <small class="card_list_representante_nombre_block">
                                    <strong>Especialidad:&nbsp;</strong>
                                    <p class="hs_capitalize">${docente.c_especialidad}&nbsp;</p>
                                </small>
                            </div>
                            <div class="card_list_representante_link">
                                <a href="/super/docente/${docente.id_docente}" class="card_list_representante_link_more">Más información&nbsp;</a>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            if (data.docentes.length > 0) {
                $('#divDocentes').html(htmlDocentes);
            } else {
                $('#divDocentes').html('<h3>No hay docentes</h3>');
            }
            $('#spinnerInfoDocentes').attr('style', 'display: none;');
            $('#divDocentes').show();

        } else {
            alert('Joder paso algo!!');
        }
    });
}

function fxAplicarGrado(id_grado) {
    var l = Ladda.create(document.getElementById('btnAgregarSeccion' + id_grado));
    l.start();
    $('#btnAgregarSeccion' + id_grado).attr('disabled', 'true');
    $.ajax({
        type: 'POST',
        url: '/super/grados/aplicar',
        data: {
            id_grado: id_grado
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
            l.top();
        }
    }).done(function(data) {
        $('#id_grado').val(data.id_grado);
        $('#spanNombreGrado').text(data.c_nombre);
        $('#spanNivelGrado').text(data.c_nivel_academico);
        $('#mdlAgregarSeccion').modal('show');
        l.stop();
    });
}

function fxEditarSeccion(id_seccion) {
    $('#rowEdicionSeccion' + id_seccion).show();
    $('#rowNormalSeccion' + id_seccion).hide();
    $('#actnombre' + id_seccion).focus();
}

function fxCancelarEdicion(id_seccion) {
    $('#rowEdicionSeccion' + id_seccion).hide();
    $('#rowNormalSeccion' + id_seccion).show();
}

function fxConfirmacionEliminarSeccion(id_seccion) {
    swal({
        title: '¿Estas seguro?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí, elimínalo!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        fxEliminarSeccion(id_seccion);
    }, function(dismiss) {});

}

function fxEliminarSeccion(id) {
    $('#btnConfirmacionEliminarSeccion' + id).attr('disabled', 'true');
    $.ajax({
        type: 'POST',
        url: '/super/gradoseccion/eliminar',
        data: {
            id_seccion: id
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if (data.correcto) {
            location.reload();
        }
    });
}

function fxActualizarSeccion(id) {
    var l = Ladda.create(document.getElementById('btnActualizarSeccion' + id));
    l.start();
    $('#btnActualizarSeccion' + id).attr('disabled', 'true');

    $.ajax({
        type: 'POST',
        url: '/super/gradoseccion/aplicar',
        data: {
            id_seccion: id
        },
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function(data) {
        $('#id_seccion').val(data.id_seccion);
        $('#actnombre').val(data.c_nombre);
        $('#hs_MODAL-2').modal('show');
        l.stop();
    });
}