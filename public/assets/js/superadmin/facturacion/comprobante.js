/*$(document).ready(function(){

});*/

$( function() {
    $('#inpDniRuc').on('change',function(){
        fxConsultaPorRucDni($(this).val());
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
            console.log('Los posibles clientes son: ');
            console.log(data);
            if(data.correcto){
                $( "#inpNombreCliente" ).catcomplete({
                    delay: 0,
                    source: data.posibles_clientes
                });
            }else{
                alert('Algo salió mal. Recarga la página');
            }
    });
    /*var data = [
        { label: "anders", category: "" },
        { label: "andreas", category: "" },
        { label: "antal", category: "" },
        { label: "annhhx10", category: "Products" },
        { label: "annk K12", category: "Products" },
        { label: "annttop C13", category: "Products" },
        { label: "anders andersson", category: "People" },
        { label: "andreas andersson", category: "People" },
        { label: "andreas johnson", category: "People" }
    ];

    $( "#search" ).catcomplete({
        delay: 0,
        source: data
    });*/
} );

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
