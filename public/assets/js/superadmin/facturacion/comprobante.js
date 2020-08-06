$(function() {
    $('#chkComprobanteParaAlumno').on('change', function() {
        $('.col-comprobante-para-alumno').find('input').val('');
        if ($(this).prop('checked')) {
            $('.col-comprobante-para-alumno').show();
        } else {
            $('.col-comprobante-para-alumno').attr('style', 'display: none;');
        }
        $(this).val('');
    });

    $('#inpDniAlumnoParaComprobante').on('change', function() {
        var dni = $(this).val().trim();
        if (dni.length == 8) {
            fxConsultaAlumnoPorDni(dni);
        }
    });

    $('#inpNombreAlumnoParaComprobante').autocomplete({
        source: "/super/facturacion/comprobante/alumnosparacomprobante",
        minLength: 3,
        select: function(event, ui) {
            var item = ui.item;
            if (item != null) {
                $('#inpDniAlumnoParaComprobante').val(item.dni_alumno);
                $('#inpDniRuc').val(item.dni_repre1);
                $('#inpNombreCliente').val(item.nombre_repre1);
                $('#inpDireccion').val(item.direccion_repre1);
                if (item.ubigeo_repre1 == null || item.ubigeo_repre1 == '') {
                    $('#inpUbigeo').val($('#inpUbigeoDefault').val());
                } else {
                    $('#inpUbigeo').val(item.ubigeo_repre1);
                }
                $('#inpEmail').val(item.email_repre1);
                $('#inpTelefono').val(item.telefono_repre1);
            }
        }
    });
    $('#inpDniRuc').on('change', function() {
        fxConsultaPorRucDni($(this).val());
    });
    $('#btnCancelarEmision').on('click', function() {
        location.reload();
    });
    $('#btnGuardarComprobante').on('click', function() {
        let correcto = true;

        let msg_required = 'El campo es requerido.';
        let msg_not_number = 'El campo debe ser numérico';
        let msg_dni = 'DNI debe ser de 8 dígitos';

        let chkAlumno = $('#chkComprobanteParaAlumno');
        let inpDniRuc = $('#inpDniRuc');
        let inpNombreCliente = $('#inpNombreCliente');
        let inpDireccion = $('#inpDireccion');
        let inpObservaciones = $('#inpObservaciones');

        //validacion de cabecera
        if (chkAlumno.prop('checked')) {
            let inpDniAlumnoParaComprobante = $('#inpDniAlumnoParaComprobante');
            let inpNombreAlumnoParaComprobante = $('#inpNombreAlumnoParaComprobante');

            if (inpDniAlumnoParaComprobante.val().trim().length == 0) {
                $('#spnAlertDniAlumno').find('strong').text(msg_required);
                $('#spnAlertDniAlumno').show();
                inpDniAlumnoParaComprobante.removeClass('is-valid').addClass('is-invalid');
                correcto = false;
            } else {
                if (isNaN(inpDniAlumnoParaComprobante.val().trim())) {
                    $('#spnAlertDniAlumno').find('strong').text(msg_not_number);
                    $('#spnAlertDniAlumno').show();
                    inpDniAlumnoParaComprobante.removeClass('is-valid').addClass('is-invalid');
                    correcto = false;
                } else {
                    if (inpDniAlumnoParaComprobante.val().trim().length !== 8) {
                        $('#spnAlertDniAlumno').find('strong').text(msg_dni);
                        $('#spnAlertDniAlumno').show();
                        inpDniAlumnoParaComprobante.removeClass('is-valid').addClass('is-invalid');
                        correcto = false;
                    } else {
                        $('#spnAlertDniAlumno').find('strong').text('No es alumno(a)');
                        $('#spnAlertDniAlumno').attr('style', 'display: none;');
                        inpDniAlumnoParaComprobante.removeClass('is-invalid').addClass('is-valid');
                    }
                }
            }

            if (inpNombreAlumnoParaComprobante.val().trim().length == 0) {
                inpNombreAlumnoParaComprobante.siblings("span").find('strong').text(msg_required);
                inpNombreAlumnoParaComprobante.removeClass('is-valid').addClass('is-invalid');
                correcto = false;
            } else {
                inpNombreAlumnoParaComprobante.removeClass('is-invalid').addClass('is-valid');
            }
        }
        if (inpDniRuc.val().trim().length == 0) {
            inpDniRuc.siblings("span").find('strong').text(msg_required);
            inpDniRuc.removeClass('is-valid').addClass('is-invalid');
            correcto = false;
        } else {
            if (isNaN(inpDniRuc.val().trim())) {
                inpDniRuc.siblings("span").find('strong').text(msg_not_number);
                inpDniRuc.removeClass('is-valid').addClass('is-invalid');
                correcto = false;
            } else {
                inpDniRuc.removeClass('is-invalid').addClass('is-valid');
            }
        }

        if (inpNombreCliente.val().trim().length == 0) {
            inpNombreCliente.siblings("span").find('strong').text(msg_required);
            inpNombreCliente.removeClass('is-valid').addClass('is-invalid');
            correcto = false;
        } else {
            inpNombreCliente.removeClass('is-invalid').addClass('is-valid');
        }

        if (inpDireccion.val().trim().length == 0) {
            inpDireccion.siblings("span").find('strong').text(msg_required);
            inpDireccion.removeClass('is-valid').addClass('is-invalid');
            correcto = false;
        } else {
            inpDireccion.removeClass('is-invalid').addClass('is-valid');
        }

        if (inpObservaciones.val().trim().length == 0) {
            inpObservaciones.siblings("span").find('strong').text(msg_required);
            inpObservaciones.removeClass('is-valid').addClass('is-invalid');
            correcto = false;
        } else {
            inpObservaciones.removeClass('is-invalid').addClass('is-valid');
        }

        if (correcto) {
            //validacion de items(detalle)
            let tabProductos = $('#tabProductos');

            if (tabProductos.find('tbody').find('tr').length == 0) {
                $('#alertTabProductos').text('Debes agregar al menos un item');
                $('#alertTabProductos').show();
                correcto = false;
                console.log('Entra al primer if');
            } else {
                $('#tabProductos tbody tr').each(function(el) {
                    if ($(this).hasClass('item-no-disponible')) {
                        $(this).attr('style', 'border: 2px solid #f44336');
                        correcto = false;
                    } else {
                        $(this).removeAttr('style');
                    }
                });
                if (correcto == false) {
                    $('#alertTabProductos').text('Falta llenar fila(s)');
                    $('#alertTabProductos').show();
                    console.log('Entra al segundo if');
                } else {
                    $('#alertTabProductos').text('Debes agregar al menos un item');
                    $('#alertTabProductos').attr('style', 'display: none;');
                    console.log('Entra el else');
                }
            }
        }
        if (correcto) {
            fxGuardarComprobante();
        } else {
            alert('Hay errores de validacion, revisa por favor');
        }
    });
    $('#inpDateFechaEmision').on('change', function() {
        //verificamos si el valor actual es vacio
        var valor = $(this).val();
        if (!(valor == '' || valor == null)) {
            $('#spnFechaEmisionComprobante').find('i.text-fecha-emision').text(valor);
        }
        $('#spnFechaEmisionComprobante').find('i.input-fecha-emision').attr('style', 'display: none;');
        $('#spnFechaEmisionComprobante').find('i.text-fecha-emision').show();
        $('#iconEditEmision').show();
    });

    $("#selFiltroCodigoCom1").select2({
        ajax: {
            url: function(params) {
                return '/super/facturacion/comprobante/productos/' + params.term + '/codigo';
            },
            dataType: 'json',
            delay: 250,
            processResults: function(data, params) {
                if (data.correcto) {
                    return {
                        results: data.productos
                    };
                } else {
                    alert('Ocurrió un error. Intentalo nuevamente');
                }
            }
        },
        placeholder: 'Buscar por código',
        minimumInputLength: 1
    });

    $("#selFiltroCodigoCom1").on('change', function() {
        var select = $(this);
        var codigo = select.val();
        var filaProducto = select.parent().parent();
        if (codigo != '') {
            filaProducto.find('.campo-variable-com').attr('disabled', 'true');
            $.ajax({
                type: 'POST',
                url: '/super/facturacion/comprobante/producto',
                data: {
                    id_producto_servicio: codigo
                },
                error: function(error) {
                    alert('Ocurrió un error');
                    console.error(error);
                }
            }).done(function(data) {
                if (data.correcto) {
                    var producto = data.producto;
                    $.each(filaProducto, function(parm) {
                        var tds = $(this).find('td');
                        var cantidad = parseInt((tds.filter(':eq(4)').find('input').val() != '') ? tds.filter(':eq(4)').find('input').val() : 0);

                        var precio = parseFloat(producto.n_precio_con_igv);
                        var valorVentaUnitario = parseFloat(producto.n_precio_sin_igv);

                        tds.filter(':eq(2)').find('select').html('<option value="' + producto.id_producto_servicio + '">' + producto.c_nombre + '</option>');
                        tds.filter(':eq(2)').find('input').val('');
                        tds.filter(':eq(2)').find('a').attr('style', 'display: inline;');
                        tds.filter(':eq(3)').text(producto.c_unidad);
                        tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 6));
                        //verificamos que tipo de tributo se aplica al producto
                        var impuesto = 0;
                        var totalItem = 0;
                        if (producto.tributo.c_codigo_sunat.toUpperCase() == 'IGV') {
                            var porcentaje = parseInt(producto.tributo.n_porcentaje);
                            impuesto = valorVentaUnitario * (porcentaje / 100);
                            totalItem = (cantidad * valorVentaUnitario) * (1 + (porcentaje / 100));
                        } else {
                            impuesto = 0;
                            totalItem = cantidad * valorVentaUnitario;
                        }
                        tds.filter(':eq(6)').text(redondea(impuesto, 2));
                        tds.filter(':eq(7)').find('input').val(redondea(precio, 2));
                        tds.filter(':eq(8)').find('input').val(redondea(totalItem, 2));
                        tds.filter(':eq(9)').find('select').val(producto.tributo.c_codigo_sunat);
                    });
                    fxCalcularTotales();
                    //muestro los campos ocultos
                    filaProducto.find('.campo-variable-com').removeAttr('disabled');
                    filaProducto.find('.campo-variable-com').show();
                    filaProducto.removeClass('item-no-disponible').addClass('item-disponible');
                    filaProducto.removeAttr('style');
                    if ($('#tabProductos tbody').find('tr.item-no-disponible').length > 0) {
                        $('#alertTabProductos').show();
                    } else {
                        $('#alertTabProductos').attr('style', 'display: none;');
                    }
                } else {
                    alert('Algo salió mal. Elige de nuevo');
                }
            });
        }
    });

    $("#selFiltroNombreCom1").select2({
        ajax: {
            url: function(params) {
                return '/super/facturacion/comprobante/productos/' + params.term + '/nombre';
            },
            dataType: 'json',
            delay: 250,
            processResults: function(data, params) {
                if (data.correcto) {
                    return {
                        results: data.productos
                    };
                } else {
                    alert('Ocurrió un error. Intentalo nuevamente');
                }
            }
        },
        placeholder: 'Buscar por nombre',
        minimumInputLength: 1
    });

    $("#selFiltroNombreCom1").on('change', function() {
        var select = $(this);
        var codigo = select.val();
        var filaProducto = select.parent().parent();
        if (codigo != '') {
            filaProducto.find('.campo-variable-com').attr('disabled', 'true');
            $.ajax({
                type: 'POST',
                url: '/super/facturacion/comprobante/producto',
                data: {
                    id_producto_servicio: codigo
                },
                error: function(error) {
                    alert('Ocurrió un error');
                    console.error(error);
                }
            }).done(function(data) {
                if (data.correcto) {
                    var producto = data.producto;
                    $.each(filaProducto, function(parm) {
                        var tds = $(this).find('td');
                        var cantidad = parseInt((tds.filter(':eq(4)').find('input').val() != '') ? tds.filter(':eq(4)').find('input').val() : 0);

                        var precio = parseFloat(producto.n_precio_con_igv);
                        var valorVentaUnitario = parseFloat(producto.n_precio_sin_igv);

                        tds.filter(':eq(1)').find('select').html('<option value="' + producto.id_producto_servicio + '">' + producto.c_codigo + '</option>');
                        tds.filter(':eq(2)').find('input').val('');
                        tds.filter(':eq(2)').find('a').attr('style', 'display: inline;');

                        tds.filter(':eq(3)').text(producto.c_unidad);
                        tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 6));
                        //verificamos que tipo de tributo se aplica al producto
                        var impuesto = 0;
                        var totalItem = 0;
                        if (producto.tributo.c_codigo_sunat.toUpperCase() == 'IGV') {
                            var porcentaje = parseInt(producto.tributo.n_porcentaje);
                            impuesto = valorVentaUnitario * (porcentaje / 100);
                            totalItem = (cantidad * valorVentaUnitario) * (1 + (porcentaje / 100));
                        } else {
                            impuesto = 0;
                            totalItem = cantidad * valorVentaUnitario;
                        }
                        tds.filter(':eq(6)').text(redondea(impuesto, 2));
                        tds.filter(':eq(7)').find('input').val(redondea(precio, 2));
                        tds.filter(':eq(8)').find('input').val(redondea(totalItem, 2));
                        tds.filter(':eq(9)').find('select').val(producto.tributo.c_codigo_sunat);
                    });
                    fxCalcularTotales();
                    //muestro los campos ocultos
                    filaProducto.find('.campo-variable-com').removeAttr('disabled');
                    filaProducto.find('.campo-variable-com').show();

                    filaProducto.removeClass('item-no-disponible').addClass('item-disponible');
                    filaProducto.removeAttr('style');
                    if ($('#tabProductos tbody').find('tr.item-no-disponible').length > 0) {
                        $('#alertTabProductos').show();
                    } else {
                        $('#alertTabProductos').attr('style', 'display: none;');
                    }
                } else {
                    alert('Algo salió mal. Elige de nuevo');
                }
            });
        }
    });

    $('#btnAgregarProductoOServicio').on('click', function() {
        var datos_adicionales_calculo = $('#inpDatosAdicionalesCalculo').val() != '' ? 1 : 0;
        var tributos = $('#selTributos').html();
        var numfila = parseInt($('#inpNumFilaProducto').val());
        numfila++;
        $('#inpNumFilaProducto').val(numfila);
        var fila = parseInt($('#inpCodUniqueFilaProducto').val());
        fila++;
        $('#inpCodUniqueFilaProducto').val(fila);
        var htmlfila = '<tr class="item-no-disponible">';
        htmlfila += '<td>' + numfila + '</td>';
        htmlfila += '<td><select id="selFiltroCodigoCom' + fila + '" style="width: 100%;" class="campo-variable-com"></select></td>';
        htmlfila += '<td><input type="hidden" id="inpInfAdi' + fila + '" value=""><select type="text" id="selFiltroNombreCom' + fila + '" style="width: 100%;" class="campo-variable-com"></select><a href="#" onclick="fxInformacionAdicional(' + fila + ',event);" style="display: none;"><span class="badge badge-secondary" id="bdgInfAdi' + fila + '">Agregar información adicional</span></a></td>';
        htmlfila += '<td></td>';
        htmlfila += '<td><input type="number" class="form-control form-control-sm campo-variable-com calc-cantidad" value="1" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td>';
        if (datos_adicionales_calculo == 1) {
            htmlfila += '<td><input type="text" class="form-control form-control calc-valor-unitario campo-variable-com" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td><td class="td-impuesto"></td>';
        } else {
            htmlfila += '<td style="display: none;"><input type="text" class="form-control form-control campo-variable-com calc-valor-unitario" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td><td style="display: none;" class="td-impuesto"></td>';
        }
        htmlfila += '<td><input type="text" class="form-control form-control-sm campo-variable-com calc-precio" value="0.00" style="display: none;" onchange="fxCalcularValorUnitarioDeProducto(event);"></td>';
        htmlfila += '<td><input type="text" class="form-control form-control-sm campo-variable-com calc-total" value="0.00" style="display:  none;" onchange="fxCalcularNuevoValorProducto(event);"></td>';
        htmlfila += '<td><select class="form-control form-control-sm campo-variable-com calc-tributo" style="display: none;" onchange="fxActualizarValorDeProducto(event);">' + tributos + '</select></td>';
        htmlfila += '<td><button type="button" class="btn btn-danger btn-sm" onclick="fxQuitarProducto(event);">X</button></td>'
        htmlfila += '</tr>';
        $('#tabProductos tbody').append(htmlfila);

        $("#selFiltroCodigoCom" + fila).select2({
            ajax: {
                url: function(params) {
                    return '/super/facturacion/comprobante/productos/' + params.term + '/codigo';
                },
                dataType: 'json',
                delay: 250,
                processResults: function(data, params) {
                    if (data.correcto) {
                        return {
                            results: data.productos
                        };
                    } else {
                        alert('Ocurrió un error. Intentalo nuevamente');
                    }
                }
            },
            placeholder: 'Buscar por código',
            minimumInputLength: 1
        });

        $("#selFiltroCodigoCom" + fila).on('change', function() {
            var select = $(this);
            var codigo = select.val();
            var filaProducto = select.parent().parent();
            if (codigo != '') {
                filaProducto.find('.campo-variable-com').attr('disabled', 'true');
                $.ajax({
                    type: 'POST',
                    url: '/super/facturacion/comprobante/producto',
                    data: {
                        id_producto_servicio: codigo
                    },
                    error: function(error) {
                        alert('Ocurrió un error');
                        console.error(error);
                    }
                }).done(function(data) {
                    if (data.correcto) {
                        var producto = data.producto;
                        $.each(filaProducto, function(parm) {
                            var tds = $(this).find('td');
                            var cantidad = parseInt((tds.filter(':eq(4)').find('input').val() != '') ? tds.filter(':eq(4)').find('input').val() : 0);

                            var precio = parseFloat(producto.n_precio_con_igv);
                            var valorVentaUnitario = parseFloat(producto.n_precio_sin_igv);

                            tds.filter(':eq(2)').find('select').html('<option value="' + producto.id_producto_servicio + '">' + producto.c_nombre + '</option>');
                            tds.filter(':eq(2)').find('input').val('');
                            tds.filter(':eq(2)').find('a').attr('style', 'display: inline;');
                            tds.filter(':eq(3)').text(producto.c_unidad);
                            tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 6));
                            //verificamos que tipo de tributo se aplica al producto
                            var impuesto = 0;
                            var totalItem = 0;
                            if (producto.tributo.c_codigo_sunat.toUpperCase() == 'IGV') {
                                var porcentaje = parseInt(producto.tributo.n_porcentaje);
                                impuesto = valorVentaUnitario * (porcentaje / 100);
                                totalItem = (cantidad * valorVentaUnitario) * (1 + (porcentaje / 100));
                            } else {
                                impuesto = 0;
                                totalItem = cantidad * valorVentaUnitario;
                            }
                            tds.filter(':eq(6)').text(redondea(impuesto, 2));
                            tds.filter(':eq(7)').find('input').val(redondea(precio, 2));
                            tds.filter(':eq(8)').find('input').val(redondea(totalItem, 2));
                            tds.filter(':eq(9)').find('select').val(producto.tributo.c_codigo_sunat);
                        });
                        fxCalcularTotales();
                        //muestro los campos ocultos
                        filaProducto.find('.campo-variable-com').removeAttr('disabled');
                        filaProducto.find('.campo-variable-com').show();


                        filaProducto.removeClass('item-no-disponible').addClass('item-disponible');
                        filaProducto.removeAttr('style');
                        if ($('#tabProductos tbody').find('tr.item-no-disponible').length > 0) {
                            $('#alertTabProductos').show();
                        } else {
                            $('#alertTabProductos').attr('style', 'display: none;');
                        }
                    } else {
                        alert('Algo salió mal. Elige de nuevo');
                    }
                });
            }
        });

        $("#selFiltroNombreCom" + fila).select2({
            ajax: {
                url: function(params) {
                    return '/super/facturacion/comprobante/productos/' + params.term + '/nombre';
                },
                dataType: 'json',
                delay: 250,
                processResults: function(data, params) {
                    if (data.correcto) {
                        return {
                            results: data.productos
                        };
                    } else {
                        alert('Ocurrió un error. Intentalo nuevamente');
                    }
                }
            },
            placeholder: 'Buscar por nombre',
            minimumInputLength: 1
        });

        $("#selFiltroNombreCom" + fila).on('change', function() {
            var select = $(this);
            var codigo = select.val();
            var filaProducto = select.parent().parent();
            if (codigo != '') {
                filaProducto.find('.campo-variable-com').attr('disabled', 'true');
                $.ajax({
                    type: 'POST',
                    url: '/super/facturacion/comprobante/producto',
                    data: {
                        id_producto_servicio: codigo
                    },
                    error: function(error) {
                        alert('Ocurrió un error');
                        console.error(error);
                    }
                }).done(function(data) {
                    if (data.correcto) {
                        var producto = data.producto;
                        $.each(filaProducto, function(parm) {
                            var tds = $(this).find('td');
                            var cantidad = parseInt((tds.filter(':eq(4)').find('input').val() != '') ? tds.filter(':eq(4)').find('input').val() : 0);

                            var precio = parseFloat(producto.n_precio_con_igv);
                            var valorVentaUnitario = parseFloat(producto.n_precio_sin_igv);

                            tds.filter(':eq(1)').find('select').html('<option value="' + producto.id_producto_servicio + '">' + producto.c_codigo + '</option>');
                            tds.filter(':eq(2)').find('input').val('');
                            tds.filter(':eq(2)').find('a').attr('style', 'display: inline;');
                            tds.filter(':eq(3)').text(producto.c_unidad);
                            tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 6));
                            //verificamos que tipo de tributo se aplica al producto
                            var impuesto = 0;
                            var totalItem = 0;
                            if (producto.tributo.c_codigo_sunat.toUpperCase() == 'IGV') {
                                var porcentaje = parseInt(producto.tributo.n_porcentaje);
                                impuesto = valorVentaUnitario * (porcentaje / 100);
                                totalItem = (cantidad * valorVentaUnitario) * (1 + (porcentaje / 100));
                            } else {
                                impuesto = 0;
                                totalItem = cantidad * valorVentaUnitario;
                            }
                            tds.filter(':eq(6)').text(redondea(impuesto, 2));
                            tds.filter(':eq(7)').find('input').val(redondea(precio, 2));
                            tds.filter(':eq(8)').find('input').val(redondea(totalItem, 2));
                            tds.filter(':eq(9)').find('select').val(producto.tributo.c_codigo_sunat);
                        });
                        fxCalcularTotales();
                        //muestro los campos ocultos
                        filaProducto.find('.campo-variable-com').removeAttr('disabled');
                        filaProducto.find('.campo-variable-com').show();
                        filaProducto.removeClass('item-no-disponible').addClass('item-disponible');
                        filaProducto.removeAttr('style');
                        if ($('#tabProductos tbody').find('tr.item-no-disponible').length > 0) {
                            $('#alertTabProductos').show();
                        } else {
                            $('#alertTabProductos').attr('style', 'display: none;');
                        }
                    } else {
                        alert('Algo salió mal. Elige de nuevo');
                    }
                });
            }
        });

    });
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function(ul, items) {
            var that = this,
                currentCategory = "";
            $.each(items, function(index, item) {
                var li;
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/posiblesclientes',
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if (data.correcto) {
            $("#inpNombreCliente").catcomplete({
                delay: 0,
                source: data.posibles_clientes,
                select: function(event, ui) {
                    var item = ui.item;
                    if (item != null) {
                        $('#inpDniRuc').val(item.dni);
                        $('#inpDireccion').val(item.direccion);
                        $('#inpUbigeo').val(item.ubigeo);
                        $('#inpEmail').val(item.email);
                        $('#inpTelefono').val(item.telefono);
                    }
                }
            });
        } else {
            alert('Algo salió mal. Recarga la página');
        }
    });

    //descuento global
    $('#mdlAgregarDescuentoGlobal').on('shown.bs.modal', function() {
        $('#inpDescuentoGlobal').removeClass('is-invalid');
        $('#divInvalidDescuento').attr('style', 'display: none;');
        $('#btnListoDescuentoGlobal').show();
        $('#inpDescuentoGlobal').focus();
    });
    $('#btnDescuentoGlobal').on('click', function() {
        //alert('Abrimos el modal de calculo de descuento');
        fxCalcularTotales();
        $('#mdlAgregarDescuentoGlobal').modal('show');
    });

    $('#btnListoDescuentoGlobal').on('click', function() {
        //primero verificamos si el descuento global no supera al subtotal global
        var inpTotalGlobal = $('#inpTotalGlobal');
        var totalGlobal = parseFloat(inpTotalGlobal.val() != '' ? inpTotalGlobal.val() : 0);
        var inpDescuentoGlobal = $('#inpDescuentoGlobal');
        var descuentoGlobal = parseFloat(inpDescuentoGlobal.val() != '' ? inpDescuentoGlobal.val() : 0);
        if (descuentoGlobal <= totalGlobal) {
            $('#spnDescuentoComprobante').text(inpDescuentoGlobal.val());
        }
        fxCalcularTotales();
        $('#mdlAgregarDescuentoGlobal').modal('hide');
    });
    $('#inpDescuentoGlobal').on('change', function() {
        //calculamos el nuevo total, considerando el descuento
        var inpTotalGlobal = $('#inpTotalGlobal');
        var totalGlobal = parseFloat(inpTotalGlobal.val() != '' ? inpTotalGlobal.val() : 0);
        var inpDescuentoGlobal = $('#inpDescuentoGlobal');
        var descuentoGlobal = parseFloat(inpDescuentoGlobal.val() != '' ? inpDescuentoGlobal.val() : 0);

        //verificamos que el descuento sea menor o igual a total global
        if (descuentoGlobal <= totalGlobal) {
            var totalConDescuento = totalGlobal - descuentoGlobal;
            $('#inpDescuentoGlobal').val(redondea(descuentoGlobal, 2));
            $('#inpTotalConDescuentoGlobal').val(redondea(totalConDescuento, 2));
            $('#inpDescuentoGlobal').removeClass('is-invalid');
            $('#divInvalidDescuento').attr('style', 'display: none;');
            $('#btnListoDescuentoGlobal').show();
        } else {
            $('#inpDescuentoGlobal').addClass('is-invalid');
            $('#divInvalidDescuento').show();
            $('#btnListoDescuentoGlobal').attr('style', 'display: none;');
        }
    });

    //al momento de registrar
    $('#chkModoCodigo').on('change', function() {
        if ($(this).prop('checked')) {
            $('#inpCodigoProducto').val('');
            $('#inpCodigoProducto').attr('readonly', 'true');
        } else {
            $('#inpCodigoProducto').val('');
            $('#inpCodigoProducto').removeAttr('readonly');
        }
    });

    //al momento de registrar
    $('#selTributoProducto').on('change', function() {
        if ($(this).val().trim() != '') {
            var tributo = $(this).find('option:selected').text().toUpperCase();
            if (tributo == 'EXONERADO' || tributo == 'INAFECTO') {
                $('#inpPrecioProductoSinIgv').val('0.000000');
                $('#inpPrecioProductoConIgv').val('0.00');
                $('#inpPrecioProductoSinIgv').attr('readonly', 'true');
            } else if (tributo == 'IGV') {
                $('#inpPrecioProductoSinIgv').val('0.000000');
                $('#inpPrecioProductoConIgv').val('0.00');
                $('#inpPrecioProductoSinIgv').removeAttr('readonly');
            }
        }
    });

    //al momento de registrar
    $('#inpPrecioProductoSinIgv').on('change', function() {
        //verificamos que el tributo seleccionado sea diferente a inafecto y exonerado
        if ($('#selTributoProducto').val() != '') {
            var tributo = $('#selTributoProducto').find('option:selected').text().toUpperCase();
            if (tributo == 'IGV') {
                var porcentajeIgv = parseInt($('#inpPorcentajeIgv').val());
                var importeSinIgv = parseFloat($(this).val() != '' ? $(this).val() : 0);
                var impuesto = importeSinIgv * (porcentajeIgv / 100);
                var importeTotal = importeSinIgv + impuesto;
                $(this).val(redondea(importeSinIgv, 2));
                $('#inpPrecioProductoConIgv').val(redondea(importeTotal, 2));
            }
        }
    });
    $('#inpPrecioProductoConIgv').on('change', function() {
        //verificamos que exista un tributo seleccionado
        if ($('#selTributoProducto').val() != '') {
            var tributo = $('#selTributoProducto').find('option:selected').text().toUpperCase();
            if (tributo == 'IGV') {
                var porcentajeIgv = parseInt($('#inpPorcentajeIgv').val());
                var importeTotal = parseFloat($(this).val() != '' ? $(this).val() : 0);
                var importeSinIgv = importeTotal / (1 + (porcentajeIgv / 100));
                var impuesto = importeSinIgv * (porcentajeIgv / 100);
                //la suma debe ser correcta
                importeTotal = importeSinIgv + impuesto;
                $('#inpPrecioProductoSinIgv').val(redondea(importeSinIgv, 6));
                $(this).val(redondea(importeTotal, 2));
            } else {
                //debe ser inafecto o exonerado
                var importeTotal = parseFloat($(this).val() != '' ? $(this).val() : 0);
                var importeSinIgv = importeTotal;
                $('#inpPrecioProductoSinIgv').val(redondea(importeSinIgv, 6));
                $(this).val(redondea(importeTotal, 2));
            }
        }
    });

    $('#btnGuardarInfAdi').on('click', function() {
        var codFila = $('#inpCodFilaItem').val();
        var infAdi = $('#inpInformacionAdicional').val();
        $('#inpInfAdi' + codFila).val(infAdi);
        var newValue = $('#inpInfAdi' + codFila).val().trim();
        if (newValue.length == 0) {
            $('#bdgInfAdi' + codFila).text('Agregar información adicional');
        } else {
            $('#bdgInfAdi' + codFila).text('Editar información adicional');
        }
        $('#mdlInformacionAdicional').modal('hide');
    });
});

function fxInformacionAdicional(codFila, e) {
    e.preventDefault();
    var inpInfAdi = $('#inpInfAdi' + codFila);
    $('#inpCodFilaItem').val(codFila);
    $('#inpInformacionAdicional').val(inpInfAdi.val());
    $('#mdlInformacionAdicional').modal('show');
}


function fxGuardarComprobante() {
    var comprobante = {
        fecha: $('#spnFechaEmisionComprobante').find('i.text-fecha-emision').text(),
        id_serie: $('#inpIdSerieParaComprobante').val(),
        numero: parseInt($('#spnNumeroParaSerie').text()),
        is_for_alumno: ($('#chkComprobanteParaAlumno').prop('checked')) ? 1 : 0,
        id_alumno: ($('#chkComprobanteParaAlumno').val() != '' && $('#chkComprobanteParaAlumno').prop('checked')) ? $('#chkComprobanteParaAlumno').val() : null,
        id_tipo_documento: $('#inpIdTipoDocumentoParaComprobante').val(),
        id_moneda: $('#inpIdMonedaParaComprobante').val(),
        nombre_receptor: $('#inpNombreCliente').val(),
        numero_documento_identidad: $('#inpDniRuc').val(),
        direccion_receptor: $('#inpDireccion').val(),
        ubigeo_receptor: $('#inpUbigeo').val(),
        email_receptor: $('#inpEmail').val(),
        telefono_receptor: $('#inpTelefono').val(),
        observaciones: $('#inpObservaciones').val(),
        id_tipo_impresion: $('#inpIdTipoImpresionParaComprobante').val(),
        total_operacion_gravada: $('#spnTotalOpGravada').text(),
        total_operacion_exonerada: $('#spnTotalOpExonerada').text(),
        total_operacion_inafecta: $('#spnTotalOpInafecta').text(),
        total_operacion_gratuita: $('#spnTotalOpGratuita').text(),
        total_descuento: $('#spnDescuentoComprobante').text(),
        total_igv: $('#spnTotalIgv').text(),
        total: $('#spnTotalConDescuentoComprobante').text(),
        items: []
    };
    //compprobamos si el comprobante es para un alumno(a)
    if (comprobante.is_for_alumno == 1) {
        comprobante.dni_alumno = $('#inpDniAlumnoParaComprobante').val().trim();
        comprobante.nombre_alumno = $('#inpNombreAlumnoParaComprobante').val().trim();
    }
    //agregamos los items del comprobante
    $('#tabProductos tbody tr.item-disponible').each(function(el) {
        let tds = $(this).find('td');
        let valor_unitario = parseFloat(tds.filter(':eq(5)').find('input').val());
        let cantidad = parseInt(tds.filter(':eq(4)').find('input').val());
        let total_base = valor_unitario * cantidad;
        let item = {
            id_producto: tds.filter(':eq(1)').find('select').val(),
            inf_adi: tds.filter(':eq(2)').find('input').val(),
            tributo: tds.filter(':eq(9)').find('select').val(),
            cantidad: tds.filter(':eq(4)').find('input').val(),
            valor_unitario: tds.filter(':eq(5)').find('input').val(),
            precio_unitario: tds.filter(':eq(7)').find('input').val(),
            total_base: total_base,
            total_igv: tds.filter(':eq(6)').text(),
            total_detalle: tds.filter(':eq(8)').find('input').val()
        };
        comprobante.items.push(item);
    });
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/agregar',
        data: comprobante,
        beforeSend: function(xhr) {
            $('#loadMsgLoading').show();
            $('#responseAfterLoad').attr('style', 'display: none;');
            $('#mdlLoading').find('.modal-footer').attr('style', 'display: none;');
            $('#mdlLoading').modal('show');
        },
        error: function(error) {
            if (error.status == 422) {
                var data = error.responseJSON;
                let inpDniAlumnoParaComprobante = $('#inpDniAlumnoParaComprobante');
                let inpNombreAlumnoParaComprobante = $('#inpNombreAlumnoParaComprobante');
                let inpDniRuc = $('#inpDniRuc');
                let inpNombreCliente = $('#inpNombreCliente');
                let inpDireccion = $('#inpDireccion');
                let inpObservaciones = $('#inpObservaciones');

                if (data.errors.hasOwnProperty('dni_alumno')) {
                    $('#spnAlertDniAlumno').find('strong').text(data.errors.dni_alumno[0]);
                    $('#spnAlertDniAlumno').show();
                    inpDniAlumnoParaComprobante.removeClass('is-valid').addClass('is-invalid');
                } else {
                    $('#spnAlertDniAlumno').find('strong').text('No es alumno(a)');
                    $('#spnAlertDniAlumno').attr('style', 'display: none;');
                    inpDniAlumnoParaComprobante.removeClass('is-invalid').addClass('is-valid');
                }
                if (data.errors.hasOwnProperty('nombre_alumno')) {
                    inpNombreAlumnoParaComprobante.siblings("span").find('strong').text(data.errors.nombre_alumno[0]);
                    inpNombreAlumnoParaComprobante.removeClass('is-valid').addClass('is-invalid');
                } else {
                    inpNombreAlumnoParaComprobante.removeClass('is-invalid').addClass('is-valid');
                }
                if (data.errors.hasOwnProperty('numero_documento_identidad')) {
                    inpDniRuc.siblings("span").find('strong').text(data.errors.numero_documento_identidad[0]);
                    inpDniRuc.removeClass('is-valid').addClass('is-invalid');
                } else {
                    inpDniRuc.removeClass('is-invalid').addClass('is-valid');
                }
                if (data.errors.hasOwnProperty('nombre_receptor')) {
                    inpNombreCliente.siblings("span").find('strong').text(data.errors.nombre_receptor[0]);
                    inpNombreCliente.removeClass('is-valid').addClass('is-invalid');
                } else {
                    inpNombreCliente.removeClass('is-invalid').addClass('is-valid');
                }

                if (data.errors.hasOwnProperty('direccion_receptor')) {
                    inpDireccion.siblings("span").find('strong').text(data.errors.direccion_receptor[0]);
                    inpDireccion.removeClass('is-valid').addClass('is-invalid');
                } else {
                    inpDireccion.removeClass('is-invalid').addClass('is-valid');
                }

                if (data.errors.hasOwnProperty('observaciones')) {
                    inpObservaciones.siblings("span").find('strong').text(data.errors.observaciones[0]);
                    inpObservaciones.removeClass('is-valid').addClass('is-invalid');
                } else {
                    inpObservaciones.removeClass('is-invalid').addClass('is-valid');
                }

                if (data.errors.hasOwnProperty('items')) {
                    $('#alertTabProductos').text('Debes agregar al menos un item');
                    $('#alertTabProductos').show();
                } else {
                    $('#alertTabProductos').attr('style', 'display: none;');
                }
            } else {
                alert('Ocurrió un error');
                console.error(error);
            }
            $('#loadMsgLoading').attr('style', 'display: none;');
            $('#responseAfterLoad').attr('style', 'display: none;');
            $('#mdlLoading').find('.modal-footer').attr('style', 'display: none;');
            $('#mdlLoading').modal('hide');
        }
    }).done(function(data) {
        console.log('Los datos devueltos son: ');
        console.log(data);
        if (data.correcto) {
            $('#loadMsgLoading').attr('style', 'display: none;');
            $('#responseAfterLoad').html('<h2 class="text-info text-center">Comprobante guardado</h2>');
            $('#responseAfterLoad').show();
            $('#mdlLoading').find('.modal-footer').show();
        }
    });
}

function fxActualizarValorDeProducto(e) {
    var valor = $(e.target).val().trim();
    if (valor != '') {
        var fila = $(e.target).parent().parent();
        fila.find('input.calc-valor-unitario').trigger('change');
    }
}


function fxMostrarCampoFecha(e) {
    e.preventDefault();
    var fecha_emision = $('#spnFechaEmisionComprobante').find('i.text-fecha-emision').text();
    $('#inpDateFechaEmision').val(fecha_emision);
    $('#spnFechaEmisionComprobante').find('i.text-fecha-emision').attr('style', 'display: none;');
    $('#iconEditEmision').attr('style', 'display: none;');
    $('#spnFechaEmisionComprobante').find('i.input-fecha-emision').show();
}

//para calculo de totales(global)
function fxCalcularTotales() {
    var sumaGravada = 0;
    var sumaExonerada = 0;
    var sumaInafecta = 0;
    var sumaGratuita = 0;
    var totalIgv = 0;
    var total = 0;

    var filas = $('#tabProductos tbody').find('tr');
    $.each(filas, function(param) {
        var tds = $(this).find('td');
        var tributo = tds.filter(':eq(9)').find('select.calc-tributo').val().toUpperCase();
        var inpValorUnitario = tds.filter(':eq(5)').find('input.calc-valor-unitario');
        var inpCantidad = tds.filter(':eq(4)').find('input.calc-cantidad');

        var valorUnitario = parseFloat(inpValorUnitario.val() != '' ? inpValorUnitario.val() : 0);
        var cantidad = parseInt(inpCantidad.val() != '' ? inpCantidad.val() : 0);

        if (tributo == 'IGV') {
            sumaGravada += (valorUnitario * cantidad);
        } else if (tributo == 'EXO') {
            sumaExonerada += (valorUnitario * cantidad);
        } else if (tributo == 'INA') {
            sumaInafecta += (valorUnitario * cantidad);
        }
    });
    var porcentaje = parseInt($('#inpPorcentajeIgv').val());
    totalIgv = (sumaGravada * (porcentaje / 100));
    total = (sumaGravada + sumaExonerada + sumaInafecta + sumaGratuita + totalIgv);

    $('#spnTotalOpGravada').text(redondea(sumaGravada, 2));
    $('#spnTotalOpExonerada').text(redondea(sumaExonerada, 2));
    $('#spnTotalOpInafecta').text(redondea(sumaInafecta, 2));
    $('#spnTotalOpGratuita').text(redondea(sumaGratuita, 2));
    $('#spnTotalIgv').text(redondea(totalIgv, 2));
    $('#spnTotalGlobal').text(redondea(total, 2));

    var spnDescuento = $('#spnDescuentoComprobante');
    var descuentoGlobal = parseFloat(spnDescuento.text() != '' ? spnDescuento.text() : 0);
    var totalConDescuento = total - descuentoGlobal;

    spnDescuento.text(redondea(descuentoGlobal, 2));
    $('#spnTotalConDescuentoComprobante').text(redondea(totalConDescuento, 2));

    //Los totales tambien almacenamos en el modal de descuento global
    $('#inpTotalGlobal').val(redondea(total, 2));
    $('#inpDescuentoGlobal').val(redondea(descuentoGlobal, 2));
    $('#inpTotalConDescuentoGlobal').val(redondea(totalConDescuento, 2));
}

function fxCalcularTotalPorProducto(e) {
    var filaProducto = $(e.target).parent().parent();

    var inputCantidad = filaProducto.find('input.calc-cantidad');
    var cantidad = parseInt((inputCantidad.val() != '') ? inputCantidad.val() : 0);

    var inpValorUnitario = filaProducto.find('input.calc-valor-unitario');
    var valorUnitario = parseFloat((inpValorUnitario.val() != '') ? inpValorUnitario.val() : 0);

    var impuestoUnitario = 0;
    var precioVentaUnitario = 0;
    var totalItem = 0;
    var selTributoUnitario = filaProducto.find('select.calc-tributo');
    //impuesto tipo IGV
    if (selTributoUnitario.val() == 'IGV') {
        var porcentajeIgv = parseInt($('#inpPorcentajeIgv').val());
        impuestoUnitario = valorUnitario * (porcentajeIgv / 100);
        precioVentaUnitario = valorUnitario * (1 + (porcentajeIgv / 100));
        totalItem = (valorUnitario * cantidad) * (1 + (porcentajeIgv / 100));
    } else {
        impuestoUnitario = 0;
        precioVentaUnitario = valorUnitario;
        totalItem = valorUnitario * cantidad;
    }
    inpValorUnitario.val(redondea(valorUnitario, 6));
    filaProducto.find('.td-impuesto').text(redondea(impuestoUnitario, 2));
    filaProducto.find('input.calc-precio').val(redondea(precioVentaUnitario, 2));
    filaProducto.find('input.calc-total').val(redondea(totalItem, 2));

    //calculos totales globales
    fxCalcularTotales();
}
//si cambiamos el precio se obtiene un nuevo valor, y con eso se calcula los nuevos total
function fxCalcularValorUnitarioDeProducto(e) {
    var filaProducto = $(e.target).parent().parent();

    var inpPrecioVentaUnitario = filaProducto.find('input.calc-precio');
    var precioVentaUnitario = parseFloat(inpPrecioVentaUnitario.val() != '' ? inpPrecioVentaUnitario.val() : 0);

    var selTributoUnitario = filaProducto.find('select.calc-tributo');
    var valorUnitario = 0;
    var impuestoUnitario = 0;
    if (selTributoUnitario.val() == 'IGV') {
        var porcentajeIgv = parseInt($('#inpPorcentajeIgv').val());
        valorUnitario = precioVentaUnitario / (1 + (porcentajeIgv / 100));
        impuestoUnitario = valorUnitario * (porcentajeIgv / 100);
    } else {
        valorUnitario = precioVentaUnitario;
        impuestoUnitario = 0;
    }
    filaProducto.find('input.calc-valor-unitario').val(redondea(valorUnitario, 6));
    filaProducto.find('.td-impuesto').text(redondea(impuestoUnitario, 2));
    filaProducto.find('input.calc-valor-unitario').trigger('change');
}
//para calcular el nuevo valor del producto apartir del total item
function fxCalcularNuevoValorProducto(e) {
    var filaProducto = $(e.target).parent().parent();
    var inpTotalItem = filaProducto.find('input.calc-total');
    var inpCantidad = filaProducto.find('input.calc-cantidad');
    var selTributo = filaProducto.find('select.calc-tributo');
    var totalItem = parseFloat((inpTotalItem.val() != '' ? inpTotalItem.val() : 0));
    var cantidad = parseInt(inpCantidad.val() != '' ? inpCantidad.val() : 0);

    var valorUnitario = 0;
    //verificamos si hay impuesto
    if (selTributo.val() == 'IGV') {
        var porcentaje = parseInt($('#inpPorcentajeIgv').val());
        valorUnitario = totalItem / ((1 + (porcentaje / 100)) * cantidad);
    } else {
        valorUnitario = totalItem / cantidad;
    }
    filaProducto.find('input.calc-valor-unitario').val(redondea(valorUnitario, 6));
    filaProducto.find('input.calc-valor-unitario').trigger('change');
}

function fxQuitarProducto(e) {
    $(e.target).parent().parent().remove();
    //orden del numero de filas
    if ($('#tabProductos tbody').find('tr').length > 0) {
        var f = 1;
        $('#tabProductos tbody').find('tr').each(function(indice, elemento) {
            $(elemento).find('td:first-child').text(f);
            f++;
        });
        $('#inpNumFilaProducto').val($('#tabProductos tbody').find('tr').length);
    } else {
        $('#inpNumFilaProducto').val(0);
    }
    fxCalcularTotales();
}

function fxConsultaPorRucDni(documento) {
    var doc = documento.trim();
    var longitud = doc.length;
    //verificamos si es RUC o DNI
    if (longitud == 8 && $('#inpSoloRuc').val() == 'no') {
        //busqueda por DNI
        fxConsultaPorDni(doc);
    } else if (longitud == 11) {
        //busqueda por RUC
        fxConsultaPorRuc(doc);
    }
}

function fxConsultaPorRuc(r) {
    $('#inpDniRuc').attr('readonly', 'true');
    $.ajax({
        type: 'POST',
        url: '/ruc/buscar',
        data: {
            ruc: r
        },
        dataType: 'JSON',
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if (data.success) {
            $('#inpNombreCliente').val(data.nombre_o_razon_social);
            $('#inpDireccion').val(data.direccion_completa);
            if (data.ubigeo == '-' || data.ubigeo == '') {
                $('#inpUbigeo').val($('#inpUbigeoDefault').val());
            } else {
                $('#inpUbigeo').val(data.ubigeo);
            }
            $('#inpEmail').val('');
            $('#inpTelefono').val('');
        }
    });
    $('#inpDniRuc').removeAttr('readonly');
}

function fxConsultaPorDni(d) {
    $('#inpDniRuc').attr('readonly', 'true');
    $.ajax({
        type: 'POST',
        url: '/dni/buscar',
        data: {
            dni: d
        },
        dataType: 'JSON',
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if (data.success) {
            $('#inpNombreCliente').val(data.result.Apellidos + ' ' + data.result.Nombres);
            $('#inpDireccion').val('SIN INFORMACIÓN');
            $('#inpUbigeo').val($('#inpUbigeoDefault').val());
            $('#inpEmail').val('');
            $('#inpTelefono').val('');
        }
    });
    $('#inpDniRuc').removeAttr('readonly');
}

function fxConsultaAlumnoPorDni(d) {
    $('#spnAlertDniAlumno').attr('style', 'display: none;');
    $('#inpDniAlumnoParaComprobante').removeClass('is-invalid is-valid');
    $('#inpDniAlumnoParaComprobante').attr('readonly', 'true');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/alumnopordni',
        data: {
            dni: d
        },
        dataType: 'JSON',
        error: function(error) {
            alert('Ocurrió un error');
            console.err(error);
            $('#inpDniAlumnoParaComprobante').removeAttr('readonly');
        }
    }).done(function(data) {
        if (data.encontrado) {
            $('#chkComprobanteParaAlumno').val(data.alumno.id_alumno);
            $('#inpNombreAlumnoParaComprobante').val(data.alumno.c_nombre);
            //datos del primer representante
            $('#inpDniRuc').val(data.alumno.c_dni_representante1);
            $('#inpNombreCliente').val(data.alumno.c_nombre_representante1);
            $('#inpDireccion').val(data.alumno.c_direccion_representante1);
            $('#inpUbigeo').val(data.alumno.c_ubigeo_representante1);
            $('#inpEmail').val(data.alumno.c_correo_representante1);
            $('#inpTelefono').val(data.alumno.c_telefono_representante1);
        } else {
            $('#chkComprobanteParaAlumno').val('');
            $('#inpNombreAlumnoParaComprobante').val('');
            $('#spnAlertDniAlumno').show();
            $('#inpDniAlumnoParaComprobante').addClass('is-invalid');
        }
        $('#inpDniAlumnoParaComprobante').removeAttr('readonly');
    });
}


function redondea(sVal, nDec) {
    var n = parseFloat(sVal);
    var s = "0.00";
    if (!isNaN(n)) {
        n = Math.round(n * Math.pow(10, nDec)) / Math.pow(10, nDec);
        s = String(n);
        s += (s.indexOf(".") == -1 ? "." : "") + String(Math.pow(10, nDec)).substr(1);
        s = s.substr(0, s.indexOf(".") + nDec + 1);
    }
    return s;
}