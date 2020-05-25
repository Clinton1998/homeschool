$(document).ready(function() {
    /*Ladda.bind('button[type=submit]', { timeout: 20000 });
    alert('Todo es correcto');*/
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
    /*$('#inpFiltroNombreCodigo').on('keypress',function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
            fxBusquedaPorNombreCodigo($(this).val().trim());
        }
    });*/
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
        console.log('Los datos devueltos son: ');
        console.log(data);

        if(data.correcto){
            var f = 1;
            $.each(data.productos,function(){
                var id_producto = this.id_producto_servicio;
                this.numeroFila = f;
                this.restaurar = '<button type="button" class="btn btn-success btn-sm" id="btnRestaurarProducto'+id_producto+'" onclick="fxRestaurarProducto('+id_producto+');">Restaurar</button>';
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
        console.log('Los datos devueltos son: ');
        console.log(data);
        data.correcto = true;
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
            //mostramos los datos
            $('#spinnerEditarProducto').attr('style','display: none;');
            $('#divFrmProducto').show();
        }else{
            location.reload();
        }
    });
}

function fxConfirmacionEliminarProducto(producto){
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
            alert('Joder! algo salió mal');
        }
    });
}
