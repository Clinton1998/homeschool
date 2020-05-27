$(document).ready(function(){
    //alert('Documento listo');
    $('#selTipoDocumentoSerie').on('change',function(){
        fxAplicarTipoDocumento($(this).val(),'registrar');
    });

    //establecemos el evento al select
    $('#selTipoDocumento').on('change',function(){
        fxAplicarTipoDocumento($(this).val(),'actualizar');
    });


    $('#btnVerSeriesEliminados').on('click',function(){
        fxSeriesEliminados();
    });

    $('#tabSeries').DataTable({
        destroy: true
    });
});
function fxConfirmacionEstablecerDefecto(serie,e){
    e.preventDefault();
    swal({
        title: '¿Estas seguro?',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Sí, establecer!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        fxEstablecerPorDefecto(serie);
    }, function(dismiss) {});
}

function fxEstablecerPorDefecto(serie){
    $('#btnEstablecerADefecto'+serie).attr('disabled','true');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/serie/estableceraprincipal',
        data: {
            id_serie: serie
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            location.reload();
        }else{
            alert('Algo salió mal. Recarga la página');
        }
    });

}
function fxConfirmacionRestaurarSerie(serie){
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
        fxRestaurarSerie(serie);
    }, function(dismiss) {});
}
function fxRestaurarSerie(serie){
    $('#btnRestaurarSerie'+serie).attr('disabled','true');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/serie/restaurar',
        data: {
            id_serie: serie
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

function fxSeriesEliminados(){
    $('#spinnerSeriesEliminados').show();
    $('#divTabla').attr('style','display: none;');
    $('#mdlSeriesEliminados').modal('show');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/serie/eliminados',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        if(data.correcto){
            var f = 1;
            $.each(data.series,function(){
                var id_serie = this.id_serie;
                this.numeroFila = f;
                var documento_afectacion = (this.c_documento_afectacion)?(this.c_documento_afectacion.toUpperCase()):'';
                if(documento_afectacion=='F'){
                        this.c_documento_afectacion = 'Factura';
                }else if(documento_afectacion=='B'){
                        this.c_documento_afectacion = 'Boleta';
                }
                this.restaurar = '<button type="button" class="btn btn-success btn-sm" id="btnRestaurarSerie'+id_serie+'" onclick="fxConfirmacionRestaurarSerie('+id_serie+');">Restaurar</button>';
                f++;
            });
            $('#tabEliminados').DataTable({
                data: data.series,
                columns: [
                    {data:'numeroFila'},
                    {data:'tipo_documento.c_nombre'},
                    {data:'c_documento_afectacion'},
                    {data:'c_serie'},
                    {data:'restaurar'},
                ],
                destroy: true
            });

            //mostramos los datos
            $('#spinnerSeriesEliminados').attr('style','display: none;');
            $('#divTabla').show();
        }else{
            alert('Algo salio mal');
        }
    });
}

function fxConfirmacionEliminarSerie(serie){
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
        fxEliminarSerie(serie);
    }, function(dismiss) {});
}
function fxEliminarSerie(serie){

    $.ajax({
        type: 'POST',
        url: '/super/facturacion/serie/eliminar',
        data: {
            id_serie: serie
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
function fxAplicarSerie(serie,e){
    e.preventDefault();
    //alert('Consultamos la serie');
    $('#spinnerEditarSerie').show();
    $('#divFrmEditarSerie').attr('style','display: none;');
    $('#mdlEditarSerie').modal('show');
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/serie/aplicar',
        data: {
            id_serie: serie
        },
        error: function(error){
            alert('Ocurió un error');
            console.error(error);
        }
    }).done(function(data){

        /*console.log('Los datos devueltos son:');
        console.log(data);*/

        if(data.correcto){
            $('#inpIdSerie').val(data.serie.id_serie);
            $('#selTipoDocumento').val(data.serie.id_tipo_documento);
            $('#inpSerieSerie').val(data.serie.c_serie);
            if(data.serie.c_documento_afectacion !=null && data.serie.tipo_documento.b_tipo==1){
                var afectado = `
            <label for="selDocumentoAfectacionSerie">Documento afectación</label>
            <select name="documento_afectacion_serie" id="selDocumentoAfectacionSerie" class="form-control" required>
                    <option value="">--Seleccione--</option>
                    <option value="B">BOLETA</option>
                    <option value="F">FACTURA</option>
            </select>
            <span class="invalid-feedback" role="alert">
                    <strong>
                    El campo documento afectacion es obligatorio
                    </strong>
            </span>
            `;
                $('#divDocumentoAfectacionEdicion').html(afectado);
                $('#selDocumentoAfectacionSerie').find('option[value="'+data.serie.c_documento_afectacion+'"]').attr('selected','true');
                $('#divDocumentoAfectacionEdicion').show();
            }else{
                $('#divDocumentoAfectacionEdicion').html('');
                $('#divDocumentoAfectacionEdicion').attr('style','display: none;');
            }
            $('#spinnerEditarSerie').attr('style','display: none;')
            $('#divFrmEditarSerie').show();

        }else{
            alert('No se encontró la serie. Actualize la página');
        }
    });
}

function fxAplicarTipoDocumento(tipo_documento,opcion){
    if(tipo_documento.trim()==''){
        if(opcion=='registrar'){
            $('#divDocumentoAfectacion').html('');
            $('#divDocumentoAfectacion').attr('style','display: none;');
        }else if(opcion=='actualizar'){
            $('#divDocumentoAfectacionEdicion').html('');
            $('#divDocumentoAfectacionEdicion').attr('style','display: none;');
        }
    }else{
        //console.log('Entro al else');
        //alert('Ejecutandose');
        $.ajax({
            type: 'POST',
            url: '/super/facturacion/serie/tipodocumento',
            data: {
                id_tipo_documento: tipo_documento
            },
            error: function(error){
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function(data){
            /*console.log('El tipo documento enviado es:  ');
            console.log(data);*/
            if(opcion=='registrar'){
                if(data.b_tipo==1){
                    //mostramos select de documento de afectacion
                    $('#divDocumentoAfectacion').html(`
                <label for="selDocumentoAfectacion">Documento afectación</label>
                <select name="documento_afectacion" id="selDocumentoAfectacion" class="form-control" required>
                    <option value="">--Seleccione--</option>
                    <option value="B">BOLETA</option>
                    <option value="F">FACTURA</option>
                </select>
                <span class="invalid-feedback" role="alert">
                    <strong>
                    El campo documento afectacion es obligatorio
                    </strong>
                </span>
            `);
                    $('#divDocumentoAfectacion').show();
                }else{
                    //quitamos select de documento de afectacion
                    $('#divDocumentoAfectacion').html('');
                    $('#divDocumentoAfectacion').attr('style','display: none;');
                }
            }else if(opcion=='actualizar'){
                if(data.b_tipo==1){
                    //mostramos select de documento de afectacion
                    $('#divDocumentoAfectacionEdicion').html(`
                <label for="selDocumentoAfectacionSerie">Documento afectación</label>
                <select name="documento_afectacion_serie" id="selDocumentoAfectacionSerie" class="form-control" required>
                    <option value="">--Seleccione--</option>
                    <option value="B">BOLETA</option>
                    <option value="F">FACTURA</option>
                </select>
                <span class="invalid-feedback" role="alert">
                    <strong>
                    El campo documento afectacion es obligatorio
                    </strong>
                </span>
            `);
                    $('#divDocumentoAfectacionEdicion').show();
                }else{
                    //quitamos select de documento de afectacion
                    $('#divDocumentoAfectacionEdicion').html('');
                    $('#divDocumentoAfectacionEdicion').attr('style','display: none;');
                }
            }
        });
    }
}
