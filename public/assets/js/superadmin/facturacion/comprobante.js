
$( function() {
    $('#inpDniRuc').on('change',function(){
        fxConsultaPorRucDni($(this).val());
    });

    $("#selFiltroCodigoCom1").select2({
        ajax: {
            url: function(params){
                return '/super/facturacion/comprobante/productos/'+params.term+'/codigo';
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data, params) {
                if(data.correcto){
                    return {
                        results: data.productos
                    };
                }else{
                    alert('Ocurrió un error. Intentalo nuevamente');
                }
            }
        },
        placeholder: 'Buscar por código',
        minimumInputLength: 1
    });

    $("#selFiltroCodigoCom1").on('change',function(){
        var select = $(this);
        var codigo = select.val();
        var filaProducto = select.parent().parent();
        if(codigo!=''){
            filaProducto.find('.campo-variable-com').attr('disabled','true');
            $.ajax({
                type: 'POST',
                url: '/super/facturacion/comprobante/producto',
                data: {
                    id_producto_servicio: codigo
                },
                error: function(error){
                    alert('Ocurrió un error');
                    console.error(error);
                }
            }).done(function(data){
                if(data.correcto){
                    var producto = data.producto;
                    $.each(filaProducto,function(parm){
                        var tds = $(this).find('td');
                        var cantidad = parseInt((tds.filter(':eq(4)').find('input').val()!='')?tds.filter(':eq(4)').find('input').val():0);

                        var precio = parseFloat(producto.n_precio_con_igv);
                        var total = cantidad*precio;
                        tds.filter(':eq(2)').find('select').html('<option value="'+producto.id_producto_servicio+'">'+producto.c_nombre+'</option>');
                        tds.filter(':eq(3)').text(producto.c_unidad);
                        tds.filter(':eq(5)').find('input').val(redondea(precio,2));
                        tds.filter(':eq(6)').find('input').val(redondea(total,2));
                        tds.filter(':eq(7)').find('select').val(producto.id_tributo);

                    });
                    fxCalcularTotales();
                    //muestro los campos ocultos
                    filaProducto.find('.campo-variable-com').removeAttr('disabled');
                    filaProducto.find('.campo-variable-com').show();
                }else{
                    alert('Algo salió mal. Elige de nuevo');
                }
            });
        }else{
            alert('No hacemos niguna peticion');
        }
    });

    $("#selFiltroNombreCom1").select2({
        ajax: {
            url: function(params){
                return '/super/facturacion/comprobante/productos/'+params.term+'/nombre';
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data, params) {
                if(data.correcto){
                    return {
                        results: data.productos
                    };
                }else{
                    alert('Ocurrió un error. Intentalo nuevamente');
                }
            }
        },
        placeholder: 'Buscar por nombre',
        minimumInputLength: 1
    });

    $("#selFiltroNombreCom1").on('change',function(){
        var select = $(this);
        var codigo = select.val();
        var filaProducto = select.parent().parent();
        if(codigo!=''){
            filaProducto.find('.campo-variable-com').attr('disabled','true');
            $.ajax({
                type: 'POST',
                url: '/super/facturacion/comprobante/producto',
                data: {
                    id_producto_servicio: codigo
                },
                error: function(error){
                    alert('Ocurrió un error');
                    console.error(error);
                }
            }).done(function(data){
                if(data.correcto){
                    var producto = data.producto;
                    $.each(filaProducto,function(parm){
                        var tds = $(this).find('td');
                        var cantidad = parseInt((tds.filter(':eq(4)').find('input').val()!='')?tds.filter(':eq(4)').find('input').val():0);

                        var precio = parseFloat(producto.n_precio_con_igv);
                        var total = cantidad*precio;
                        tds.filter(':eq(1)').find('select').html('<option value="'+producto.id_producto_servicio+'">'+producto.c_codigo+'</option>');
                        tds.filter(':eq(3)').text(producto.c_unidad);
                        tds.filter(':eq(5)').find('input').val(redondea(precio,2));
                        tds.filter(':eq(6)').find('input').val(redondea(total,2));
                        tds.filter(':eq(7)').find('select').val(producto.id_tributo);
                    });
                    fxCalcularTotales();
                    //muestro los campos ocultos
                    filaProducto.find('.campo-variable-com').removeAttr('disabled');
                    filaProducto.find('.campo-variable-com').show();
                }else{
                    alert('Algo salió mal. Elige de nuevo');
                }
            });
        }else{
            alert('No hacemos niguna peticion');
        }
    });



    $('#btnAgregarProductoOServicio').on('click',function(){
        var tributos = $('#selTributos').html();
        var fila = parseInt($('#inpNumFilaProducto').val());
        fila++;
        $('#inpNumFilaProducto').val(fila);
        var numfila = fila;
        var htmlfila = '<tr>';
        htmlfila += '<td>'+numfila+'</td>';
        htmlfila += '<td><select id="selFiltroCodigoCom'+fila+'" style="width: 100%;" class="campo-variable-com"></select></td>';
        htmlfila += '<td><select type="text" id="selFiltroNombreCom'+fila+'" style="width: 100%;" class="campo-variable-com"></select></td>';
        htmlfila += '<td></td>';
        htmlfila += '<td><input type="number" class="form-control form-control-sm campo-variable-com calc-cantidad" value="1" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td>';
        htmlfila += '<td><input type="text" class="form-control form-control-sm campo-variable-com calc-precio" value="0.00" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td>';
        htmlfila += '<td><input type="text" class="form-control form-control-sm campo-variable-com calc-total" value="0.00" style="display:  none;" onchange="fxCalcularPrecioDeProducto(event);"></td>';
        htmlfila += '<td><select class="form-control form-control-sm campo-variable-com" style="display: none;">'+tributos+'</select></td>';
        htmlfila += '<td><button type="button" class="btn btn-danger btn-sm" onclick="fxQuitarProducto(event);">X</button></td>'
        htmlfila += '</tr>';
        $('#tabProductos tbody').append(htmlfila);

        $("#selFiltroCodigoCom"+fila).select2({
            ajax: {
                url: function(params){
                    return '/super/facturacion/comprobante/productos/'+params.term+'/codigo';
                },
                dataType: 'json',
                delay: 250,
                processResults: function (data, params) {
                    if(data.correcto){
                        return {
                            results: data.productos
                        };
                    }else{
                        alert('Ocurrió un error. Intentalo nuevamente');
                    }
                }
            },
            placeholder: 'Buscar por código',
            minimumInputLength: 1
        });

        $("#selFiltroCodigoCom"+fila).on('change',function(){
            var select = $(this);
            var codigo = select.val();
            var filaProducto = select.parent().parent();
            if(codigo!=''){
                filaProducto.find('.campo-variable-com').attr('disabled','true');
                $.ajax({
                    type: 'POST',
                    url: '/super/facturacion/comprobante/producto',
                    data: {
                        id_producto_servicio: codigo
                    },
                    error: function(error){
                        alert('Ocurrió un error');
                        console.error(error);
                    }
                }).done(function(data){
                    if(data.correcto){
                        var producto = data.producto;
                        $.each(filaProducto,function(parm){
                            var tds = $(this).find('td');
                            var cantidad = parseInt((tds.filter(':eq(4)').find('input').val()!='')?tds.filter(':eq(4)').find('input').val():0);

                            var precio = parseFloat(producto.n_precio_con_igv);
                            var total = cantidad*precio;
                            tds.filter(':eq(2)').find('select').html('<option value="'+producto.id_producto_servicio+'">'+producto.c_nombre+'</option>');
                            tds.filter(':eq(3)').text(producto.c_unidad);
                            tds.filter(':eq(5)').find('input').val(redondea(precio,2));
                            tds.filter(':eq(6)').find('input').val(redondea(total,2));
                            tds.filter(':eq(7)').find('select').val(producto.id_tributo);
                        });
                        fxCalcularTotales();
                        //muestro los campos ocultos
                        filaProducto.find('.campo-variable-com').removeAttr('disabled');
                        filaProducto.find('.campo-variable-com').show();
                    }else{
                        alert('Algo salió mal. Elige de nuevo');
                    }
                });
            }else{
                alert('No hacemos niguna peticion');
            }
        });

        $("#selFiltroNombreCom"+fila).select2({
            ajax: {
                url: function(params){
                    return '/super/facturacion/comprobante/productos/'+params.term+'/nombre';
                },
                dataType: 'json',
                delay: 250,
                processResults: function (data, params) {
                    if(data.correcto){
                        return {
                            results: data.productos
                        };
                    }else{
                        alert('Ocurrió un error. Intentalo nuevamente');
                    }
                }
            },
            placeholder: 'Buscar por nombre',
            minimumInputLength: 1
        });

        $("#selFiltroNombreCom"+fila).on('change',function(){
            var select = $(this);
            var codigo = select.val();
            var filaProducto = select.parent().parent();
            if(codigo!=''){
                filaProducto.find('.campo-variable-com').attr('disabled','true');
                $.ajax({
                    type: 'POST',
                    url: '/super/facturacion/comprobante/producto',
                    data: {
                        id_producto_servicio: codigo
                    },
                    error: function(error){
                        alert('Ocurrió un error');
                        console.error(error);
                    }
                }).done(function(data){
                    if(data.correcto){
                        var producto = data.producto;
                        $.each(filaProducto,function(parm){
                            var tds = $(this).find('td');
                            var cantidad = parseInt((tds.filter(':eq(4)').find('input').val()!='')?tds.filter(':eq(4)').find('input').val():0);

                            var precio = parseFloat(producto.n_precio_con_igv);
                            var total = cantidad*precio;
                            tds.filter(':eq(1)').find('select').html('<option value="'+producto.id_producto_servicio+'">'+producto.c_codigo+'</option>');
                            tds.filter(':eq(3)').text(producto.c_unidad);
                            tds.filter(':eq(5)').find('input').val(redondea(precio,2));
                            tds.filter(':eq(6)').find('input').val(redondea(total,2));
                            tds.filter(':eq(7)').find('select').val(producto.id_tributo);
                        });
                        fxCalcularTotales();
                        //muestro los campos ocultos
                        filaProducto.find('.campo-variable-com').removeAttr('disabled');
                        filaProducto.find('.campo-variable-com').show();
                    }else{
                        alert('Algo salió mal. Elige de nuevo');
                    }
                });
            }else{
                alert('No hacemos niguna peticion');
            }
        });

    });
    $.widget( "custom.catcomplete", $.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
        },
        _renderMenu: function( ul, items ) {
            var that = this,
                currentCategory = "";
            $.each( items, function( index, item ) {
                var li;
                if ( item.category != currentCategory ) {
                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                li = that._renderItemData( ul, item );
                if ( item.category ) {
                    li.attr( "aria-label", item.category + " : " + item.label );
                }
            });
        }
    });
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/comprobante/posiblesclientes',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
            if(data.correcto){
                $( "#inpNombreCliente" ).catcomplete({
                    delay: 0,
                    source: data.posibles_clientes
                });
            }else{
                alert('Algo salió mal. Recarga la página');
            }
    });
} );

//para calculo de totales(global)
function fxCalcularTotales(){
    //primero hallamos el subtotal
    var suma = 0;
    var filas = $('#tabProductos tbody').find('tr');
    $.each(filas,function(parm){
        var tds = $(this).find('td');
        //obtenemos el total del producto
        var inputTotal = tds.filter(':eq(6)').find('input.calc-total');
        var total = parseFloat((inputTotal.val()!='')?inputTotal.val():0);
        suma += total;
    });

    var subTotalGlobal = suma;
    var importeGlobal = suma/1.18;
    var igvGlobal = importeGlobal*0.18;

    $('#spnImporteComprobante').text(redondea(importeGlobal,2));
    $('#spnIgvComprobante').text(redondea(igvGlobal,2));
    $('#spnSubTotalComprobante').text(redondea(subTotalGlobal,2));

    var spnDescuento = $('#spanDescuentoComprobante');
    var descuentoGlobal = parseFloat((spnDescuento.text()!='')?spnDescuento.text():0);
    var totalGlobal = subTotalGlobal-descuentoGlobal;

    spnDescuento.text(redondea(descuentoGlobal,2));
    $('#spanTotalComprobante').text(redondea(totalGlobal,2));
}

function fxCalcularTotalPorProducto(e){
    var filaProducto = $(e.target).parent().parent();

    var inputCantidad = filaProducto.find('input.calc-cantidad');
    var cantidad = parseInt((inputCantidad.val()!='')?inputCantidad.val():0);
    var inputPrecio = filaProducto.find('input.calc-precio');
    var precio = parseFloat((inputPrecio.val()!='')?inputPrecio.val():0);
    var total = cantidad*precio;

    filaProducto.find('input.calc-precio').val(redondea(precio,2));
    filaProducto.find('input.calc-total').val(redondea(total,2));

    fxCalcularTotales();
}
//para calcular el nuevo precio del producto, apartir del total del producto
function fxCalcularPrecioDeProducto(e){
    var filaProducto = $(e.target).parent().parent();
    var inputCantidad = filaProducto.find('input.calc-cantidad');
    var cantidad = parseInt((inputCantidad.val()!='')?inputCantidad.val():0);
    var inputTotal = filaProducto.find('input.calc-total');
    var total = parseFloat((inputTotal.val()!='')?inputTotal.val():0);
    //hallamos el nuevo precio unitario del producto
    var precio = total/cantidad;
    //Mostramos las cantidades calculadas
    filaProducto.find('input.calc-precio').val(redondea(precio,2));
    filaProducto.find('input.calc-total').val(redondea(total,2));

    fxCalcularTotales();
}
function fxQuitarProducto(e){
    $(e.target).parent().parent().remove();
    //orden del numero de filas
    if($('#tabProductos tbody').find('tr').length>0){
        var f = 1;
        $('#tabProductos tbody').find('tr').each(function(indice,elemento){
            $(elemento).find('td:first-child').text(f);
            f++;
        });
        $('#inpNumFilaProducto').val($('#tabProductos tbody').find('tr').length);
    }else{
        $('#inpNumFilaProducto').val(0);
    }
}

function fxConsultaPorRucDni(documento){
    var doc = documento.trim();
    var longitud = doc.length;
    //verificamos si es RUC o DNI
    if(longitud==8 && $('#inpSoloRuc').val()=='no'){
        //busqueda por DNI
        fxConsultaPorDni(doc);
    }else if(longitud==11){
        //busqueda por RUC
        fxConsultaPorRuc(doc);
    }else{
        alert('No hacemos la consulta');
    }
}

function fxConsultaPorRuc(r){
    $('#inpDniRuc').attr('readonly','true');
    $.ajax({
        type: 'POST',
        url: '/ruc/buscar',
        data: {
            ruc: r
        },
        dataType:'JSON',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.success){
            $('#inpNombreCliente').val(data.nombre_o_razon_social);
            $('#inpDniRuc').removeAttr('readonly');
        }else{
            alert('Algo salió mal. Recarga la página');
        }
    });
}
function fxConsultaPorDni(d){
    $('#inpDniRuc').attr('readonly','true');
    $.ajax({
        type: 'POST',
        url: '/dni/buscar',
        data: {
            dni: d
        },
        dataType:'JSON',
        error: function(error){
            alert('Ocurrió un error');
            console.err(error);
        }
    }).done(function(data){
        if(data.success){
            $('#inpNombreCliente').val(data.result.Apellidos+' '+data.result.Nombres);
            $('#inpDniRuc').removeAttr('readonly');
        }else{
            alert('Algo salió mal. Recarga la página');
        }
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
