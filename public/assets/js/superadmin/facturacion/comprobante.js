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
        //proceso de validacion
        fxGuardarComprobante();
    });

    /*$('#btnPrevisualizarComrpobante').on('click', function () {
        fxPrevisualizarComprobante();
    });*/
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
                        tds.filter(':eq(3)').text(producto.c_unidad);
                        tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 8));
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
                        tds.filter(':eq(3)').text(producto.c_unidad);
                        tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 8));
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
                } else {
                    alert('Algo salió mal. Elige de nuevo');
                }
            });
        }
    });

    $('#btnAgregarProductoOServicio').on('click', function() {
        var datos_adicionales_calculo = $('#inpDatosAdicionalesCalculo').val() != '' ? 1 : 0;
        var tributos = $('#selTributos').html();
        var fila = parseInt($('#inpNumFilaProducto').val());
        fila++;
        $('#inpNumFilaProducto').val(fila);
        var numfila = fila;
        var htmlfila = '<tr>';
        htmlfila += '<td>' + numfila + '</td>';
        htmlfila += '<td><select id="selFiltroCodigoCom' + fila + '" style="width: 100%;" class="campo-variable-com"></select></td>';
        htmlfila += '<td><select type="text" id="selFiltroNombreCom' + fila + '" style="width: 100%;" class="campo-variable-com"></select></td>';
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
                            tds.filter(':eq(3)').text(producto.c_unidad);
                            tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 8));
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
                            tds.filter(':eq(3)').text(producto.c_unidad);
                            tds.filter(':eq(5)').find('input.calc-valor-unitario').val(redondea(valorVentaUnitario, 8));
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
                change: function(event, ui) {
                    var item = ui.item;
                    if (item != null) {
                        //obtengo el dni y direccion
                        var dni = item.dni;
                        var direccion = item.direccion;
                        $('#inpDniRuc').val(dni);
                        $('#inpDireccion').val(direccion);
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
                $('#inpPrecioProductoSinIgv').val('0.00');
                $('#inpPrecioProductoConIgv').val('0.00');
                $('#inpPrecioProductoSinIgv').attr('readonly', 'true');
            } else if (tributo == 'IGV') {
                $('#inpPrecioProductoSinIgv').val('0.00');
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
                var importeSinIgv = parseFloat($(this).val() != '' ? $(this).val() : 0);
                var impuesto = importeSinIgv * 0.18;
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
                var importeTotal = parseFloat($(this).val() != '' ? $(this).val() : 0);
                var importeSinIgv = importeTotal / 1.18;
                var impuesto = importeSinIgv * 0.18;
                //la suma debe ser correcta
                importeTotal = importeSinIgv + impuesto;
                $('#inpPrecioProductoSinIgv').val(redondea(importeSinIgv, 2));
                $(this).val(redondea(importeTotal, 2));
            } else {
                //debe ser inafecto o exonerado
                var importeTotal = parseFloat($(this).val() != '' ? $(this).val() : 0);
                var importeSinIgv = importeTotal;
                $('#inpPrecioProductoSinIgv').val(redondea(importeSinIgv, 2));
                $(this).val(redondea(importeTotal, 2));
            }
        }
    });
});


function fxGuardarComprobante() {
    var comprobante = {
        fecha: $('#spnFechaEmisionComprobante').find('i.text-fecha-emision').text(),
        id_serie: $('#inpIdSerieParaComprobante').val(),
        id_alumno: ($('#chkComprobanteParaAlumno').val() != '') ? $('#chkComprobanteParaAlumno').val() : null,
        id_tipo_documento: $('#inpIdTipoDocumentoParaComprobante').val(),
        id_moneda: $('#inpIdMonedaParaComprobante').val(),
        nombre_receptor: $('#inpNombreCliente').val(),
        numero_documento_identidad: $('#inpDniRuc').val(),
        direccion_receptor: $('#inpDireccion').val(),
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
    //agregamos los items del comprobante
    $('#tabProductos tbody tr').each(function(el) {
        let tds = $(this).find('td');
        let valor_unitario = parseFloat(tds.filter(':eq(5)').find('input').val());
        let cantidad = parseInt(tds.filter(':eq(4)').find('input').val());
        let total_base = valor_unitario * cantidad;
        let item = {
            id_producto: tds.filter(':eq(1)').find('select').val(),
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
    console.log('Los datos a enviar son: ');
    console.log(comprobante);

    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/agregar',
        data: comprobante,
        error: function(error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        console.log('Los datos devueltos son: ');
        console.log(data);
        if (data.correcto) {
            alert('Comprobante guardado');
            location.reload();
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
            $('#inpDireccion').val(data.direccion);
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
            console.err(error);
        }
    }).done(function(data) {
        if (data.success) {
            $('#inpNombreCliente').val(data.result.Apellidos + ' ' + data.result.Nombres);
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