$(document).ready(function () {
    $('.input-necesario').on('change', function () {
        if ($('#selNecesarioSerie').val().trim() != '' && $('#selNecesarioMoneda').val().trim() != '' && $('#selNecesarioTipoImpresion').val().trim() != '') {
            $('#btnSiguienteBasicoParaComprobante').show();
        } else {
            $('#btnSiguienteBasicoParaComprobante').attr('style', 'display: none;');
        }
    });

    $('#mdlElegirTipoComprobante').on('show.bs.modal', function () {
        $('#mdlElegirAlumnoParaComprobante').modal('hide');
        $('#mdlElegirClienteParaAlumno').modal('hide');
    });
    $('#mdlElegirAlumnoParaComprobante').on('show.bs.modal', function () {
        $('#mdlElegirTipoComprobante').modal('hide');
        $('#mdlElegirClienteParaAlumno').modal('hide');
    });
    $('#mdlElegirClienteParaAlumno').on('show.bs.modal', function () {
        $('#mdlElegirAlumnoParaComprobante').modal('hide');
        $('#mdlElegirTipoComprobante').modal('hide');
    });
});

//tipo de comprobante boleta o factura
function fxElegirTipoComprobante(t,e) {
    e.preventDefault();
    $('#spinnerBasicoNecesario').show();
    $('#divBasicoNecesario').attr('style', 'display: none;');
    $('#mdlElegirTipoComprobante').modal('show');
    $('#btnSiguienteBasicoParaComprobante').attr('style', 'display: none;');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/basiconecesario',
        data: {
            tipo: t
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {

        console.log('Los datitos devueltos son: ');
        console.log(data);
        if (data.correcto) {
            var htmlSeries = '<option value="">--Seleccione--</option>';
            var htmlMonedas = '<option value="">--Seleccione--</option>';
            var htmlTiposImpresion = '<option value="">--Seleccione--</option>';
            data.series.forEach(function (serie, indice) {
                if(data.preferencia==null){
                    if (serie.b_principal == 1) {
                        htmlSeries += '<option value="' + serie.id_serie + '" selected>' + serie.c_serie + '</option>';
                    } else {
                        htmlSeries += '<option value="' + serie.id_serie + '">' + serie.c_serie + '</option>';
                    }
                }else{
                    //elegimos la preferencia guardada
                    if(serie.id_serie==data.preferencia.id_serie){
                        htmlSeries += '<option value="' + serie.id_serie + '" selected>' + serie.c_serie + '</option>';
                    }else{
                        htmlSeries += '<option value="' + serie.id_serie + '">' + serie.c_serie + '</option>';
                    }
                }
            });
            data.monedas.forEach(function (moneda, indice) {
                if (moneda.b_principal == 1) {
                    htmlMonedas += '<option value="' + moneda.id_moneda + '" selected>' + moneda.c_nombre + '</option>';
                } else {
                    htmlMonedas += '<option value="' + moneda.id_moneda + '">' + moneda.c_nombre + '</option>';
                }
            });
            data.tipos_de_impresion.forEach(function (tipo, indice) {
                if(data.preferencia==null){
                    htmlTiposImpresion += '<option value="' + tipo.id_tipo_impresion + '">' + tipo.c_nombre + '</option>';
                }else{
                    if(tipo.id_tipo_impresion==data.preferencia.id_tipo_impresion){
                        htmlTiposImpresion += '<option value="' + tipo.id_tipo_impresion + '" selected>' + tipo.c_nombre + '</option>';
                    }else{
                        htmlTiposImpresion += '<option value="' + tipo.id_tipo_impresion + '">' + tipo.c_nombre + '</option>';
                    }
                }
            });
            $('#selNecesarioSerie').html(htmlSeries);
            $('#selNecesarioMoneda').html(htmlMonedas);
            $('#selNecesarioTipoImpresion').html(htmlTiposImpresion);
            if(data.preferencia!=null){
                if(data.preferencia.b_datos_adicionales_calculo==1){
                    //activamos el checkbox
                    $('#chkDatosAdicionalesCalculo').prop('checked',true);
                }else{
                    $('#chkDatosAdicionalesCalculo').prop('checked',false);
                }
            }else{
                $('#chkDatosAdicionalesCalculo').prop('checked',false);
            }
            if ($('#selNecesarioSerie').val().trim() != '' && $('#selNecesarioMoneda').val().trim() != '' && $('#selNecesarioTipoImpresion').val().trim() != '') {
                //Mostramos el boton de enviar formulario
                $('#btnSiguienteBasicoParaComprobante').show();
            } else {
                $('#btnSiguienteBasicoParaComprobante').attr('style', 'display: none;');
            }
            $('#spinnerBasicoNecesario').attr('style', 'display: none;');
            $('#divBasicoNecesario').show();
        } else {
            alert('Algo salió mal. Recarga la página');
        }
    });
}

function fxElegirAlumno(respuesta) {
    $('.select-alumno .bg-primary-super').removeClass('card-necesario-activo')
    if (respuesta.toUpperCase() == 'SI') {
        $('#cardSiEsParaAlumno').addClass('card-necesario-activo');
        $('#spinnerBasicoNecesarioParaAlumno').show();
        $('#divBasicoNecesarioParaAlumno').attr('style', 'display:none;');
        $.ajax({
            type: 'POST',
            url: '/super/facturacion/comprobante/alumnos',
            error: function (error) {
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function (data) {
            if (data.correcto) {
                var htmlAlumnos = '';
                var filaAlumno = 1;
                data.grados.forEach(function (grado, i_grado) {
                    grado.secciones.forEach(function (seccion, i_seccion) {
                        seccion.alumnos.forEach(function (alumno, i_alumno) {
                            htmlAlumnos += '<tr>';
                            htmlAlumnos += '<td>' + filaAlumno + '</td>';
                            htmlAlumnos += '<td>' + alumno.c_dni + '</td>';
                            htmlAlumnos += '<td>' + alumno.c_nombre + '</td>';
                            htmlAlumnos += '<td>' + grado.c_nombre + '-' + seccion.c_nombre + '-' + grado.c_nivel_academico + '</td>';
                            htmlAlumnos += '<td><button type="button" class="btn btn-success btn-sm" id="btnSeleccionarAlumno' + alumno.id_alumno + '" onclick="fxSeleccionarAlumno(' + alumno.id_alumno + ');">Elegir</button></td>';
                            htmlAlumnos += '</tr>';
                            filaAlumno++;
                        });
                    });
                });
                $('#tabAlumnosParaComprobante tbody').html(htmlAlumnos);
                $('#tabAlumnosParaComprobante').DataTable({
                    destroy: true
                });
                $('#spinnerBasicoNecesarioParaAlumno').attr('style', 'display: none;');
                $('#divBasicoNecesarioParaAlumno').show();
            } else {
                alert('Ocurrió un error. Recarga la página');
            }

        });
    } else {
        //enviarmos el formulario,sin datos del alumno
        $('#cardNoEsParaAlumno').addClass('card-necesario-activo');
        $('#inpNecesarioIdAlumno').val('');
        $('#inpNecesarioTipoDatoClienteParaAlumno').val('');
        $('#frmNecesarioParaComprobante').submit();
    }
}

function fxSeleccionarAlumno(alumno) {
    $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
    $('#btnSeleccionarAlumno' + alumno).attr('disabled', 'true');
    $('#divElegirCliente').attr('style', 'display: none;');
    $('#spinnerClienteNecesarioParaAlumno').show();
    $('#mdlElegirClienteParaAlumno').modal('show');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/alumno',
        data: {
            id_alumno: alumno
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            //seleccionamos al alumno para el comprobante
            $('#inpNecesarioIdAlumno').val(data.alumno.id_alumno);

            var dni_repre1 = data.alumno.c_dni_representante1;
            var nombre_repre1 = data.alumno.c_nombre_representante1;
            var dni_repre2 = data.alumno.c_dni_representante2;
            var nombre_repre2 = data.alumno.c_nombre_representante2;
            var dni_alumno = data.alumno.c_dni;
            var nombre_alumno = data.alumno.c_nombre;

            $('#cardClienteRepresentante1').off('click');
            $('#cardClienteRepresentante2').off('click');
            $('#cardClienteAlumno').off('click');
            $('#cardClientePersonalizado').off('click');
            $('#cardClienteAlumno span').text('DNI: ' + dni_alumno + ' Apellidos y nombres: ' + nombre_alumno);
            $('#cardClienteAlumno').on('click', function () {
                $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                $(this).addClass('card-necesario-activo');
                fxClienteSeleccionado('alumno');
            });
            if (dni_repre1 != '' && dni_repre1 != null && nombre_repre1 != '' && nombre_repre1 != null) {
                $('#cardClienteRepresentante1 span').text('DNI: ' + dni_repre1 + ' Nombre: ' + nombre_repre1);
                $('#cardClienteRepresentante1').on('click', function () {
                    $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                    $(this).addClass('card-necesario-activo');
                    fxClienteSeleccionado('representante1');
                });
                $('#cardClienteRepresentante1').parent().show();
            } else {
                $('#cardClienteRepresentante1').parent().hide();
            }
            if (dni_repre2 != '' && dni_repre2 != null && nombre_repre2 != '' && nombre_repre2 != null) {
                $('#cardClienteRepresentante2 span').text('DNI: ' + dni_repre2 + ' Nombre: ' + nombre_repre2);
                $('#cardClienteRepresentante2').on('click', function () {
                    $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                    $(this).addClass('card-necesario-activo');
                    fxClienteSeleccionado('representante2');
                });
                $('#cardClienteRepresentante2').parent().show();
            } else {
                $('#cardClienteRepresentante2').parent().hide();
            }

            $('#cardClientePersonalizado').on('click', function () {
                $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                $(this).addClass('card-necesario-activo');
                //enviamos el formulario
                $('#inpNecesarioTipoDatoClienteParaAlumno').val('personalizado');
                $('#frmNecesarioParaComprobante').submit();
            });
            $('#btnSeleccionarAlumno' + alumno).removeAttr('disabled');
            $('#divElegirCliente').show();
            $('#spinnerClienteNecesarioParaAlumno').attr('style', 'display: none;');
        } else {
            alert('Algo salió mal. Recarga la página');
        }
    });
}

function fxClienteSeleccionado(tipo) {
    $('#inpNecesarioTipoDatoClienteParaAlumno').val(tipo);
    $('#frmNecesarioParaComprobante').submit();
}
