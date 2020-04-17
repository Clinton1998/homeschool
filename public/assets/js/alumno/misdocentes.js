$(document).ready(function(){
    $('#button-addon2').on('click',function(){
        fxBuscarMiDocente();
    });

    $('#inpBuscarNombreDocente').on('keypress', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            fxBuscarMiDocente();
        }
    });
});

function fxBuscarMiDocente(){
    $('#spinnerBuscadorDocente').show();
    $('#rowMisDocentes').attr('style','display: none;');
    var l = Ladda.create(document.getElementById('button-addon2'));
    l.start();

    /*$.ajax({
        type: 'POST'
    })*/
}