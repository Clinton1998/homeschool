$(document).ready(function() {
    $('#frmNuevoProducto').on('keyup keypress',function(e){
        var keyCode = e.keyCode || e.which;
        if(keyCode==13){
            e.preventDefault();
            return false;
        }
    });
    //al momento de registrar
    $('#selTributoProducto').on('change',function(){
        if($(this).val().trim()!=''){
            var tributo = $(this).find('option:selected').text().toUpperCase();
            if(tributo=='EXONERADO' || tributo=='INAFECTO'){
                $('#inpPrecioProductoSinIgv').val('0.00000000');
                $('#inpPrecioProductoConIgv').val('0.00');
                $('#inpPrecioProductoSinIgv').attr('readonly','true');
            }else if(tributo=='IGV'){
                $('#inpPrecioProductoSinIgv').val('0.00000000');
                $('#inpPrecioProductoConIgv').val('0.00');
                $('#inpPrecioProductoSinIgv').removeAttr('readonly');
            }
        }
    });

    //al momento de actualizar
    $('#selTributo').on('change',function(){
        if($(this).val().trim()!=''){
            var tributo = $(this).find('option:selected').text().toUpperCase();
            if(tributo=='EXONERADO' || tributo=='INAFECTO'){
                $('#inpPrecioSinIgv').val('0.00000000');
                $('#inpPrecioConIgv').val('0.00');
                $('#inpPrecioSinIgv').attr('readonly','true');
            }else if(tributo=='IGV'){
                $('#inpPrecioSinIgv').val('0.00000000');
                $('#inpPrecioConIgv').val('0.00');
                $('#inpPrecioSinIgv').removeAttr('readonly');
            }
        }
    });
    //al momento de registrar
    $('#inpPrecioProductoSinIgv').on('change',function(){
        //verificamos que el tributo seleccionado sea diferente a inafecto y exonerado
        if($('#selTributoProducto').val()!=''){
            var tributo = $('#selTributoProducto').find('option:selected').text().toUpperCase();
            if(tributo=='IGV'){
                var importeSinIgv = parseFloat($(this).val()!=''?$(this).val():0);
                var impuesto = importeSinIgv*0.18;
                var importeTotal = importeSinIgv+impuesto;
                $(this).val(redondea(importeSinIgv,8));
                $('#inpPrecioProductoConIgv').val(redondea(importeTotal,2));
            }
        }
    });
    $('#inpPrecioProductoConIgv').on('change',function(){
        //verificamos que exista un tributo seleccionado
        if($('#selTributoProducto').val()!=''){
            var tributo = $('#selTributoProducto').find('option:selected').text().toUpperCase();
            if(tributo=='IGV'){
                var importeTotal = parseFloat($(this).val()!=''?$(this).val():0);
                var importeSinIgv = importeTotal/1.18;
                var impuesto = importeSinIgv*0.18;
                //la suma debe ser correcta
                importeTotal = importeSinIgv+impuesto;
                $('#inpPrecioProductoSinIgv').val(redondea(importeSinIgv,8));
                $(this).val(redondea(importeTotal,2));
            }else {
                //debe ser inafecto o exonerado
                var importeTotal = parseFloat($(this).val()!=''?$(this).val():0);
                var importeSinIgv = importeTotal;
                $('#inpPrecioProductoSinIgv').val(redondea(importeSinIgv,8));
                $(this).val(redondea(importeTotal,2));
            }
        }
    });
    //al momento de actualizar
    $('#inpPrecioSinIgv').on('change',function(){
        //verificamos que el tributo seleccionado sea diferente a inafecto y exonerado
        if($('#selTributo').val()!=''){
            var tributo = $('#selTributo').find('option:selected').text().toUpperCase();
            if(tributo=='IGV'){
                var importeSinIgv = parseFloat($(this).val()!=''?$(this).val():0);
                var impuesto = importeSinIgv*0.18;
                var importeTotal = importeSinIgv+impuesto;
                $(this).val(redondea(importeSinIgv,2));
                $('#inpPrecioConIgv').val(redondea(importeTotal,8));
            }
        }
    });
    $('#inpPrecioConIgv').on('change',function(){
        //verificamos que exista un tributo seleccionado
        if($('#selTributo').val()!=''){
            var tributo = $('#selTributo').find('option:selected').text().toUpperCase();
            if(tributo=='IGV'){
                var importeTotal = parseFloat($(this).val()!=''?$(this).val():0);
                var importeSinIgv = importeTotal/1.18;
                var impuesto = importeSinIgv*0.18;
                //la suma debe ser correcta
                importeTotal = importeSinIgv+impuesto;
                $('#inpPrecioSinIgv').val(redondea(importeSinIgv,8));
                $(this).val(redondea(importeTotal,2));
            }else {
                //debe ser inafecto o exonerado
                var importeTotal = parseFloat($(this).val()!=''?$(this).val():0);
                var importeSinIgv = importeTotal;
                $('#inpPrecioSinIgv').val(redondea(importeSinIgv,8));
                $(this).val(redondea(importeTotal,2));
            }
        }
    });
    $('#tabProductos').DataTable({
        destroy: true
    });
    $('#selFiltroTipo').on('change',function(){
        fxFiltroTipo($(this).val());
    });
    $('#selFiltroUnidad').on('change',function(){
        fxFiltroUnidad($(this).val());
    });

    $('#btnVerProductosEliminados').on('click',function(){
        fxProductosEliminados();
    });

    $('#inpFiltroNombreCodigo').on('change',function(){
        fxBusquedaPorNombreCodigo($(this).val().trim());
    });
    //al momento de registrar
    $('#chkModoCodigo').on('change',function(){
        if($(this).prop('checked')){
            $('#inpCodigoProducto').val('');
            $('#inpCodigoProducto').attr('readonly','true');
        }else{
            $('#inpCodigoProducto').val('');
            $('#inpCodigoProducto').removeAttr('readonly');
        }
    });

    //al momento de actualizar
    $('#chkModoCodigoEditar').on('change',function(){
        if($(this).prop('checked')){
            $('#inpCodigo').val('');
            $('#inpCodigo').attr('readonly','true');
        }else{
            $('#inpCodigo').removeAttr('readonly');
        }
    });
});

function fxBusquedaPorNombreCodigo(nombreCodigo){
    $.ajax({
        type: 'POST',
        url:'/super/facturacion/producto/busqueda/nombrecodigo',
        data: {
            nombre_codigo: nombreCodigo
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data) {
        if(data.correcto){
            var f = 1;
            $.each(data.productos,function(){
                var id_producto = this.id_producto_servicio;
                this.numeroFila = f;
                this.acciones = '<a href="#" class="badge badge-warning" id="btnAplicarProducto'+id_producto+'" onclick="fxAplicarProducto('+id_producto+',event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a> ';
                this.acciones += '<a href="#" class="badge badge-danger" id="btnConfirmacionEliminarProducto'+id_producto+'" onclick="fxConfirmacionEliminarProducto('+id_producto+');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>'
                f++;
            });
            $('#tabProductos').DataTable({
                data: data.productos,
                columns: [
                    {data:'numeroFila'},
                    {data:'c_codigo'},
                    {data:'c_tipo'},
                    {data:'c_nombre'},
                    {data:'c_unidad'},
                    {data:'c_unidad_sunat'},
                    {data:'n_precio_sin_igv'},
                    {data:'n_precio_con_igv'},
                    {data:'tributo.c_nombre'},
                    {data:'acciones'},
                ],
                destroy: true
            });
        }else{
            alert('Algo salió mal');
        }
    });
}

function fxProductosEliminados(){
    $('#spinnerProductosEliminados').show();
    $('#divTabla').attr('style','display: none;');
    $('#mdlProductosEliminados').modal('show');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/producto/eliminados',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            var f = 1;
            $.each(data.productos,function(){
                var id_producto = this.id_producto_servicio;
                this.numeroFila = f;
                this.restaurar = '<button type="button" class="btn btn-success btn-sm" id="btnRestaurarProducto'+id_producto+'" onclick="fxConfirmacionRestaurarProducto('+id_producto+');">Restaurar</button>';
                f++;
            });
            $('#tabEliminados').DataTable({
                data: data.productos,
                columns: [
                    {data:'numeroFila'},
                    {data:'c_codigo'},
                    {data:'c_tipo'},
                    {data:'c_nombre'},
                    {data:'restaurar'},
                ],
                destroy: true
            });

            //mostramos los datos
            $('#spinnerProductosEliminados').attr('style','display: none;');
            $('#divTabla').show();
        }else{
            alert('Algo salio mal');
        }
    });
}
function fxRestaurarProducto(producto){
    $('#btnRestaurarProducto'+producto).attr('disabled','true');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/producto/restaurar',
        data: {
            id_producto: producto
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.restaurado){
            location.reload();
        }else{
            alert('Algo salió mal...');
        }
    });
}
function fxFiltroUnidad(unidad){
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/producto/filtrounidad',
        data: {
            nombre_unidad: unidad
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            var f = 1;
            $.each(data.productos,function(){
                var id_producto = this.id_producto_servicio;
                this.numeroFila = f;
                this.acciones = '<a href="#" class="badge badge-warning" id="btnAplicarProducto'+id_producto+'" onclick="fxAplicarProducto('+id_producto+',event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a> ';
                this.acciones += '<a href="#" class="badge badge-danger" id="btnConfirmacionEliminarProducto'+id_producto+'" onclick="fxConfirmacionEliminarProducto('+id_producto+');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>'
                f++;
            });
            $('#tabProductos').DataTable({
                data: data.productos,
                columns: [
                    {data:'numeroFila'},
                    {data:'c_codigo'},
                    {data:'c_tipo'},
                    {data:'c_nombre'},
                    {data:'c_unidad'},
                    {data:'c_unidad_sunat'},
                    {data:'n_precio_sin_igv'},
                    {data:'n_precio_con_igv'},
                    {data:'tributo.c_nombre'},
                    {data:'acciones'},
                ],
                destroy: true
            });
        }else{
            alert('Algo salio mal');
        }
    });
}
function fxFiltroTipo(tipo){
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/producto/filtrotipo',
        data: {
            tipo: tipo
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            var f = 1;
            $.each(data.productos,function(){
                var id_producto = this.id_producto_servicio;
                this.numeroFila = f;
                this.acciones = '<a href="#" class="badge badge-warning" id="btnAplicarProducto'+id_producto+'" onclick="fxAplicarProducto('+id_producto+',event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a> ';
                this.acciones += '<a href="#" class="badge badge-danger" id="btnConfirmacionEliminarProducto'+id_producto+'" onclick="fxConfirmacionEliminarProducto('+id_producto+');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>'
                f++;
            });
            $('#tabProductos').DataTable({
                data: data.productos,
                columns: [
                    {data:'numeroFila'},
                    {data:'c_codigo'},
                    {data:'c_tipo'},
                    {data:'c_nombre'},
                    {data:'c_unidad'},
                    {data:'c_unidad_sunat'},
                    {data:'n_precio_sin_igv'},
                    {data:'n_precio_con_igv'},
                    {data:'tributo.c_nombre'},
                    {data:'acciones'},
                ],
                destroy: true
            });

        }else{
            alert('Joder! Algo salió mal');
        }
    });
}

function fxAplicarProducto(producto,e){
    e.preventDefault();
    $('#divFrmProducto').attr('style','display: none;');
    $('#spinnerEditarProducto').show();
    $('#mdlEditarProducto').modal('show'),
    $.ajax({
        type:'POST',
        url:'/super/facturacion/producto/aplicar',
        data: {
            id_producto: producto
        },
        error: function(error){
            alert('Ocurrío un error');
            console.error(error);
        }
    }).done(function(data){
        console.log('el productito es: ');
        console.log(data);
        if(data.correcto){
            var producto = data.producto;
            $('#inpIdProducto').val(producto.id_producto_servicio);
            if(producto.c_tipo.toLowerCase()=='producto'){
                //producto
                $('#optTipoProducto').prop('checked',true);
            }else{
                //servicio
                $('#optTipoServicio').prop('checked',true);
            }
            $('#inpCodigo').val(producto.c_codigo);
            $('#inpNombre').val(producto.c_nombre);
            if(producto.c_tipo_codigo.toUpperCase()=='GENERADO'){
                //generado automaticamente
                $('#chkModoCodigoEditar').prop('checked',true);
                $('#inpCodigo').attr('readonly','true');
            }else{
                //manual
                $('#chkModoCodigoEditar').prop('checked',false);
                $('#inpCodigo').removeAttr('readonly');
            }
            $('#selTributo').val(producto.id_tributo);
            $('#inpUnidad').val(producto.c_unidad);
            $('#inpUnidadSunat').val(producto.c_unidad_sunat);
            $('#inpPrecioSinIgv').val(producto.n_precio_sin_igv);
            $('#inpPrecioConIgv').val(producto.n_precio_con_igv);
            var codigo_sunat = producto.tributo.c_codigo_sunat.toUpperCase();
            if(codigo_sunat=='EXO' || codigo_sunat=='INA'){
                $('#inpPrecioSinIgv').attr('readonly','true');
            }else{
                $('#inpPrecioSinIgv').removeAttr('readonly');
            }
            //mostramos los datos
            $('#spinnerEditarProducto').attr('style','display: none;');
            $('#divFrmProducto').show();
        }else{
            location.reload();
        }
    });
}
function fxConfirmacionRestaurarProducto(producto){
    swal({
        title: '¿Estas seguro?',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí, restaurar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        fxRestaurarProducto(producto);
    }, function(dismiss) {});
}

function fxConfirmacionEliminarProducto(producto,e){

    swal({
        title: '¿Estas seguro?',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí, elimínalo!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        fxEliminarProducto(producto);
    }, function(dismiss) {});
}

function fxEliminarProducto(producto){
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/producto/eliminar',
        data: {
            id_producto: producto
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.eliminado){
            location.reload();
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
