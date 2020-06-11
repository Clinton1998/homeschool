$(document).ready(function(){
    $('#tabPreferencias').DataTable();
    $('#selTipoDocumentoPreferencia').on('change',function(){
        if($(this).val()!=''){
            fxDatosParaPreferenciaSegunTipoDocumento($(this).val());
        }
    });
});

function fxDatosParaPreferenciaSegunTipoDocumento(tipo_documento){
        $('#spinnerNecesarioParaPreferencia').show();
        $('#divNecesarioParaPreferencia').attr('style','display: none;');
        $.ajax({
            type: 'POST',
            url:'/super/facturacion/preferencia/seriesytipoimpresiones',
            data: {
                id_tipo_documento: tipo_documento
            },
            error: function(error){
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function(data){
            console.log('Los datitos devueltos son: ');
            console.log(data);
            if(data.correcto){
                var htmlSeries = '<option value="">--Seleccione--</option>';
                var htmlTiposImpresion = '<option value="">--Seleccione--</option>';
                data.series.forEach(function(serie,indice){
                    if(serie.b_principal==1){
                        htmlSeries += '<option value="'+serie.id_serie+'" selected>'+serie.c_serie+'</option>;'
                    }else{
                        htmlSeries += '<option value="'+serie.id_serie+'">'+serie.c_serie+'</option>;'
                    }
                });
                data.tipos_de_impresion.forEach(function(tipo,indice){
                    htmlTiposImpresion += '<option value="'+tipo.id_tipo_impresion+'">'+tipo.c_nombre+'</option>';
                });
                $('#selSeriePreferencia').html(htmlSeries);
                $('#selTipoImpresionPreferencia').html(htmlTiposImpresion);
                $('#spinnerNecesarioParaPreferencia').attr('style','display: none;');
                $('#divNecesarioParaPreferencia').show();
            }else{
                alert('Algo salió mal. Recarga la página');
            }
        });
}

function fxAplicarPreferencia(preferencia,e){
    e.preventDefault();
    $('#divNecesarioParaPreferenciaEdi').attr('style','display: none;');
    $('#spinnerNecesarioParaPreferenciaEdi').show();
    $('#mdlEditarPreferencia').modal('show');
        $.ajax({
            type:'POST',
            url:'/super/facturacion/preferencia/aplicar',
            data: {
                id_preferencia: preferencia
            },
            error: function(error){
                alert('Ocurrío un error');
                console.error(error);
            }
        }).done(function(data){
            if(data.correcto){
                var preferencia = data.preferencia;
                $('#inpIdPreferencia').val(preferencia.id_preferencia);
                $('#selTipoDocumentoPreferenciaEdi').html('<option value="'+preferencia.tipo_documento.id_tipo_documento+'">'+preferencia.tipo_documento.c_nombre+'</option>');
                var htmlSeries = '<option value="">--Seleccione--</option>';
                var htmlTiposImpresion = '<option value="">--Seleccione--</option>';
                data.series.forEach(function(serie,indice){
                    if(serie.id_serie==preferencia.id_serie){
                        htmlSeries += '<option value="'+serie.id_serie+'" selected>'+serie.c_serie+'</option>';
                    }else{
                        htmlSeries += '<option value="'+serie.id_serie+'">'+serie.c_serie+'</option>';
                    }
                });
                data.tipos_de_impresion.forEach(function(tipo,indice){
                    if(tipo.id_tipo_impresion==preferencia.id_tipo_impresion){
                        htmlTiposImpresion += '<option value="'+tipo.id_tipo_impresion+'" selected>'+tipo.c_nombre+'</option>';
                    }else{
                        htmlTiposImpresion += '<option value="'+tipo.id_tipo_impresion+'">'+tipo.c_nombre+'</option>';
                    }
                });
                if(preferencia.b_datos_adicionales_calculo==1){
                    $('#chkDatosAdicionalesNO').prop('checked',false);
                    $('#chkDatosAdicionalesSI').prop('checked',true);
                }else{
                    $('#chkDatosAdicionalesSI').prop('checked',false);
                    $('#chkDatosAdicionalesNO').prop('checked',true);
                }
                if(preferencia.c_modo_emision.toUpperCase()=='DET'){
                    $('#chkModoEmisionDir').prop('checked',false);
                    $('#chkModoEmisionDet').prop('checked',true);
                }else{
                    $('#chkModoEmisionDet').prop('checked',false);
                    $('#chkModoEmisionDir').prop('checked',true);
                }
                $('#selSeriePreferenciaEdi').html(htmlSeries);
                $('#selTipoImpresionPreferenciaEdi').html(htmlTiposImpresion);
                //mostramos los datos
                $('#spinnerNecesarioParaPreferenciaEdi').attr('style','display: none;');
                $('#divNecesarioParaPreferenciaEdi').show();
            }else{
                location.reload();
            }
        });
}

function fxConfirmacionEliminarPreferencia(preferencia,e){
    e.preventDefault();
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
        fxEliminarPreferencia(preferencia);
    }, function(dismiss) {});
}

function fxEliminarPreferencia(preferencia){
    $.ajax({
        type: 'POST',
        url: '/super/facturacion/preferencia/eliminar',
        data: {
            id_preferencia: preferencia
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
