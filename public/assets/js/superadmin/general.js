
$(document).ready(function(){
    $('#tools-container').hide();
    $('#tools-icon').show();

    MostrarHerramientas();

    $('.boton_eliminar').hide();
    $('#quiero_cancelar').hide();
    $('#quiero_eliminar').show();

    $('#textBuscar').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');

        $('.tools-item').hide();

        $('.tools-item').filter(function () {
            return rex.test($(this).text());
        }).show();
    });

    $('#logo_fisico').hide();
    $('#logo_link').show();

    //generaciond de comprobante

    $('.input-necesario').on('change',function(){
        if($('#selNecesarioSerie').val().trim()!='' && $('#selNecesarioMoneda').val().trim()!='' && $('#selNecesarioTipoImpresion').val().trim()!=''){
            $('#btnSiguienteBasicoParaComprobante').show();
        }else{
            $('#btnSiguienteBasicoParaComprobante').attr('style','display: none;');
        }
    });

    $('#mdlElegirTipoComprobante').on('show.bs.modal',function(){
        $('#mdlElegirAlumnoParaComprobante').modal('hide');
        $('#mdlElegirClienteParaAlumno').modal('hide');
    });
    $('#mdlElegirAlumnoParaComprobante').on('show.bs.modal',function(){
        $('#mdlElegirTipoComprobante').modal('hide');
        $('#mdlElegirClienteParaAlumno').modal('hide');
    });
    $('#mdlElegirClienteParaAlumno').on('show.bs.modal',function(){
        $('#mdlElegirAlumnoParaComprobante').modal('hide');
        $('#mdlElegirTipoComprobante').modal('hide');
    });
});

$('#tools-icon').click(function(){
    $('#tools-container').fadeIn();
    $('#tools-icon').hide();
});

$('.tools-nav-min').click(function(){
    $('#tools-container').fadeOut();
    $('#tools-icon').fadeIn();
});

//Agregar herramienta
$("#frm-tools").on("submit", function(e){
    e.preventDefault();
    var f = $(this);

    nombre = $("#nombre").val();
    file = $("#logo_fisico").val();
    link = $("#logo_link").val();
    url = $("#link").val();

    modal = $('#MODAL-TOOLS');

    if (nombre == '') {
        Swal.fire({
            position: 'center',
            icon: 'info',
            text: 'Su nueva herramienta, necesita un título',
            showConfirmButton: true,
            confirmButtonColor: '#3498db'
        });
    } else {
        if (url == '') {
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'Necesita escribir o copiar el enlace de la herramienta',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });
        } else {
            var formData = new FormData(document.getElementById("frm-tools"));
            formData.append("dato", "valor");

            $.ajax({
                url: "/herramienta/agregar",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    /* $("#box_files"+id_modulo).load(" #box_files"+id_modulo); */

                    modal.modal('hide');

                    $("#nombre").val('');
                    $("#logo_fisico").val('');
                    $("#logo_link").val('');
                    $("#link").val('');

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Su nueva herramienta fue configurada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    MostrarHerramientas();
                    console.log(data);
                },
                error: function(){
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        text: 'Su herramienta no pudo ser configurada, vuelva a intentarlo',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    }
});

//Validar tamaño de archivo
$(document).on('change', 'input[type="file"]', function(){
    var file_name = this.files[0].name;
    var file_size = this.files[0].size;

    //5MB
    if (file_size > 5000000) {

        Swal.fire({
            position: 'center',
            icon: 'info',
            text: 'El archivo no debe superar los 5MB',
            showConfirmButton: true,
            confirmButtonColor: '#3498db'
        });

        this.value = '';
        this.files[0].name = '';
    } else {
        var archivo = this.value;
        var extensiones = archivo.substring(archivo.lastIndexOf("."));

        if(extensiones != ".jpg" && extensiones != ".jpeg" && extensiones != ".png" && extensiones != ".gif")
        {
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'Archivo no válido, intente con otro archivo',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });

            this.value = '';
            this.files[0].name = '';
        }
    }
});

//tipo de comprobante boleta o factura
function fxElegirTipoComprobante(t){
    $('.select-tipo .bg-primary-super').removeClass('card-necesario-activo')
    if(t.toUpperCase()=='F'){
        $('#cardTipoFactura').addClass('card-necesario-activo');
    }else{
        $('#cardTipoBoleta').addClass('card-necesario-activo');
    }
    $('#spinnerBasicoNecesario').show();
    $('#divBasicoNecesario').attr('style','display: none;');
    $('#btnSiguienteBasicoParaComprobante').attr('style','display: none;');
    $.ajax({
        type:'POST',
        url: '/super/facturacion/comprobante/basiconecesario',
        data: {
            tipo: t
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            var htmlSeries = '<option value="">--Seleccione--</option>';
            var htmlMonedas = '<option value="">--Seleccione--</option>';
            var htmlTiposImpresion = '<option value="">--Seleccione--</option>';
            data.series.forEach(function(serie,indice){
                if(serie.b_principal==1){
                    htmlSeries += '<option value="'+serie.id_serie+'" selected>'+serie.c_serie+'</option>';
                }else{
                    htmlSeries += '<option value="'+serie.id_serie+'">'+serie.c_serie+'</option>';
                }
            });
            data.monedas.forEach(function(moneda,indice){
                if(moneda.b_principal==1){
                    htmlMonedas += '<option value="'+moneda.id_moneda+'" selected>'+moneda.c_nombre+'</option>';
                }else{
                    htmlMonedas += '<option value="'+moneda.id_moneda+'">'+moneda.c_nombre+'</option>';
                }
            });
            data.tipos_de_impresion.forEach(function(tipo,indice){
                htmlTiposImpresion += '<option value="'+tipo+'">'+tipo+'</option>';
            });
            $('#selNecesarioSerie').html(htmlSeries);
            $('#selNecesarioMoneda').html(htmlMonedas);
            $('#selNecesarioTipoImpresion').html(htmlTiposImpresion);
            if($('#selNecesarioSerie').val().trim()!='' && $('#selNecesarioMoneda').val().trim()!='' && $('#selNecesarioTipoImpresion').val().trim()!=''){
                //Mostramos el boton de enviar formulario
                $('#btnSiguienteBasicoParaComprobante').show();
            }else{
                $('#btnSiguienteBasicoParaComprobante').attr('style','display: none;');
            }
            $('#spinnerBasicoNecesario').attr('style','display: none;');
            $('#divBasicoNecesario').show();
        }else{
            alert('Algo salió mal. Recarga la página');
        }
    });
}

function fxElegirAlumno(respuesta){
    $('.select-alumno .bg-primary-super').removeClass('card-necesario-activo')
    if(respuesta.toUpperCase()=='SI'){
        $('#cardSiEsParaAlumno').addClass('card-necesario-activo');
        $('#spinnerBasicoNecesarioParaAlumno').show();
        $('#divBasicoNecesarioParaAlumno').attr('style','display:none;');
        $.ajax({
            type: 'POST',
            url: '/super/facturacion/comprobante/alumnos',
            error: function(error){
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function(data){
            if(data.correcto) {
                var htmlAlumnos = '';
                var filaAlumno = 1;
                data.grados.forEach(function (grado, i_grado) {
                    grado.secciones.forEach(function(seccion,i_seccion){
                        seccion.alumnos.forEach(function(alumno,i_alumno){
                            htmlAlumnos += '<tr>';
                            htmlAlumnos += '<td>'+filaAlumno+'</td>';
                            htmlAlumnos += '<td>'+alumno.c_dni+'</td>';
                            htmlAlumnos += '<td>'+alumno.c_nombre+'</td>';
                            htmlAlumnos += '<td>'+grado.c_nombre+'-'+seccion.c_nombre+'-'+grado.c_nivel_academico+'</td>';
                            htmlAlumnos += '<td><button type="button" class="btn btn-success btn-sm" id="btnSeleccionarAlumno'+alumno.id_alumno+'" onclick="fxSeleccionarAlumno('+alumno.id_alumno+');">Elegir</button></td>';
                            htmlAlumnos += '</tr>';
                            filaAlumno++;
                        });
                    });
                });
                $('#tabAlumnosParaComprobante tbody').html(htmlAlumnos);
                $('#tabAlumnosParaComprobante').DataTable({
                    destroy: true
                });
                $('#spinnerBasicoNecesarioParaAlumno').attr('style','display: none;');
                $('#divBasicoNecesarioParaAlumno').show();
            }else{
                alert('Ocurrió un error. Recarga la página');
            }

        });
    }else{
        //enviarmos el formulario,sin datos del alumno
        $('#cardNoEsParaAlumno').addClass('card-necesario-activo');
        $('#inpNecesarioIdAlumno').val('');
        $('#inpNecesarioTipoDatoClienteParaAlumno').val('');
        $('#frmNecesarioParaComprobante').submit();
    }
}

function fxSeleccionarAlumno(alumno){
    $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
    $('#btnSeleccionarAlumno'+alumno).attr('disabled','true');
    $('#divElegirCliente').attr('style','display: none;');
    $('#spinnerClienteNecesarioParaAlumno').show();
    $('#mdlElegirClienteParaAlumno').modal('show');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/alumno',
        data: {
            id_alumno: alumno
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
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
            $('#cardClienteAlumno span').text('DNI: '+dni_alumno+' Apellidos y nombres: '+nombre_alumno);
            $('#cardClienteAlumno').on('click',function(){
                $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                $(this).addClass('card-necesario-activo');
                fxClienteSeleccionado('alumno');
            });
            if(dni_repre1!='' && dni_repre1!=null && nombre_repre1!='' && nombre_repre1!=null){
                $('#cardClienteRepresentante1 span').text('DNI: '+dni_repre1+' Nombre: '+nombre_repre1);
                $('#cardClienteRepresentante1').on('click',function(){
                    $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                    $(this).addClass('card-necesario-activo');
                    fxClienteSeleccionado('representante1');
                });
                $('#cardClienteRepresentante1').parent().show();
            }else{
                $('#cardClienteRepresentante1').parent().hide();
            }
            if(dni_repre2!='' && dni_repre2!=null && nombre_repre2!='' && nombre_repre2!=null){
                $('#cardClienteRepresentante2 span').text('DNI: '+dni_repre2+' Nombre: '+nombre_repre2);
                $('#cardClienteRepresentante2').on('click',function(){
                    $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                    $(this).addClass('card-necesario-activo');
                    fxClienteSeleccionado('representante2');
                });
                $('#cardClienteRepresentante2').parent().show();
            }else{
                $('#cardClienteRepresentante2').parent().hide();
            }

            $('#cardClientePersonalizado').on('click',function(){
                $('.select-cliente .bg-primary-super').removeClass('card-necesario-activo')
                $(this).addClass('card-necesario-activo');
                //enviamos el formulario
                $('#inpNecesarioTipoDatoClienteParaAlumno').val('personalizado');
                $('#frmNecesarioParaComprobante').submit();
            });
            $('#btnSeleccionarAlumno'+alumno).removeAttr('disabled');
            $('#divElegirCliente').show();
            $('#spinnerClienteNecesarioParaAlumno').attr('style','display: none;');
        }else{
            alert('Algo salió mal. Recarga la página');
        }
    });
}
function fxClienteSeleccionado(tipo){
    $('#inpNecesarioTipoDatoClienteParaAlumno').val(tipo);
    $('#frmNecesarioParaComprobante').submit();
}


//Optener herramientas
function MostrarHerramientas(){
    $.ajax({
        url: "/herramienta/listar",
        type: "GET",
        /* data: {id_tarea: id}, */
        success:function(data){
            console.log(data)

            Comentarios = '';

            if (data.herramientas.length > 0) {
                data.herramientas.forEach(function (herramienta, indice){
                    Comentarios += '<div class="tools-item" data-toggle="tooltip" data-placement="top" title="'+ herramienta.c_link +'">';
                    Comentarios += '<div class="text-right tools-delete-box"><a href="#" class="badge badge-danger boton_eliminar" onclick="EliminarHerramienta('+ herramienta.id_herramienta +')">x</a></div>';
                    Comentarios += '<a class="tools-link" id="tool_link_'+ herramienta.id_herramienta +'" href="'+ herramienta.c_link +'" target="_blank">';
                    /* Comentarios +='<input type="hidden" id="tool_'+ herramienta.id_herramienta +'" name="tool_'+ herramienta.id_herramienta +'" value="">'; */
                    if (herramienta.c_logo_fisico == null && herramienta.c_logo_link == null) {
                        Comentarios += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="/assets/images/briefcase.png" alt="Tool">';
                    } else if (herramienta.c_logo_fisico == null){
                        Comentarios += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="'+ herramienta.c_logo_link +'" alt="Tool">';
                    } else {
                        Comentarios += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="' + '/herramienta/logo/' + herramienta.c_logo_fisico + '" alt="Tool">';
                    }
                    Comentarios += '<small id="tool_name_'+ herramienta.id_herramienta +'" class="tools-name">'+ herramienta.c_nombre +'</small>';
                    Comentarios += '</a>';
                    Comentarios += '</div>';
                })
            };

            $('#tools-list').html(Comentarios);
        },
        error: function(){
            alert('Error al leer los comentarios');
        }
    })
};

//Eliminar herramienta
function EliminarHerramienta(id){
    Swal.fire({
        text: "¿Quiere eliminar esta herramienta?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ffffff',
        cancelButtonColor: '#e74c3c',
        confirmButtonText: 'Si, eliminar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/herramienta/eliminar',
                type: 'POST',
                data: {
                    id_herramienta: id
                },
                success:function(data){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Herramienta eliminada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    MostrarHerramientas();
                    $('#quiero_cancelar').hide();
                    $('#quiero_eliminar').show();
                },
                error: function(){
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        text: 'Problemas al intentar eliminar la herramienta, vuelva a intentarlo',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#quiero_cancelar').hide();
                    $('#quiero_eliminar').show();
                }
            })
        }
    })
}

function MostrarEliminar(){
    $('.boton_eliminar').show();
    $('#quiero_cancelar').show();
    $('#quiero_eliminar').hide();
}

function CancelarEliminar(){
    $('.boton_eliminar').hide();
    $('#quiero_cancelar').hide();
    $('#quiero_eliminar').show();
}

$('#file-pc').click(function(){
    $('#logo_fisico').show();
    $('#logo_link').hide();
});

$('#file-web').click(function(){
    $('#logo_fisico').hide();
    $('#logo_link').show();
});

