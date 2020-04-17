$(document).ready(function(){
    Ladda.bind('button[type=submit]', {timeout: 3000});
    //eventos para botones
    $('#btnBuscarPorRuc').on('click',function(){
        fxConsultaRuc(this);
    });

    $('#btnBuscarPorDni').on('click',function(){
        fxConsultaDni(this);
    });
});

function fxConsultaRuc(obj){
    var l = Ladda.create(obj);
	l.start();
    $.ajax({
        type: 'GET',
        url: 'https://dniruc.apisperu.com/api/v1/ruc/'+$('#ruc').val()+'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function(data){
        $('#razonsocial').val(data.razonSocial);
        l.stop();
    });
}

function fxConsultaDni(obj){
    var l = Ladda.create(obj);
	l.start();
    $.ajax({
        type: 'GET',
        url: 'https://dniruc.apisperu.com/api/v1/dni/'+$('#dni').val()+'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function(data){
        $('#nombre').val(data.nombres+' '+data.apellidoPaterno+' '+data.apellidoMaterno);
        l.stop();
    });
}