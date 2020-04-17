$(document).ready(function(){
    Ladda.bind('button[type=submit]', {timeout: 20000});
    $('#btnBuscarPorDNI').on('click',function(){
        fxConsultaDni(this);
    }); 
      
});
function fxConsultaDni(obj){
    var l = Ladda.create(obj);
	l.start();
    $.ajax({
        type: 'GET',
        url: 'https://dniruc.apisperu.com/api/v1/dni/'+$('#inpActDniRepresentante').val()+'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNsaW50b250YXBpYWxhZ2FyQGdtYWlsLmNvbSJ9.wEBYhpOvFDf_EpdRbDIDi6Oh5wYNUyFXqWa-V28_nV8',
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function(data){
        $('#inpActNombreRepresentante').val(data.nombres+' '+data.apellidoPaterno+' '+data.apellidoMaterno);
        l.stop();
    });
}