$(document).ready(function() {
    Ladda.bind('button[type=submit]', { timeout: 5000 });

    $('#btnBuscarPorDNI').on('click', function() {
        fxConsultaDni(this);
    });
    $('#frmActualizarContraAlumno').submit(function(evt) {
        evt.preventDefault();
        fxCambiarContrasena();
    });
    $('#frmActualizacionRepresentanteAlumno').submit(function(evt) {
        evt.preventDefault();
        fxActualizarRepresentante();
    });
    $('#btnSubirFotoAlumno').on('click', function() {
        if ($('#fotoalumno').val() != '') {
            $('#divProgressFotoAlumno').show();
        }
    });
    $('#selDepartamento').select2({
        placeholder: "Seleccione departamento",
        allowClear: true
    });
    $('#selProvincia').select2({
        placeholder: "Seleccione provincia",
        allowClear: true
    });
    $('#selDistrito').select2({
        placeholder: "Seleccione distrito",
        allowClear: true
    });
    $('#selDepartamentoRepre1').select2({
        placeholder: "Seleccione departamento",
        allowClear: true
    });
    $('#selProvinciaRepre1').select2({
        placeholder: "Seleccione provincia",
        allowClear: true
    });
    $('#selDistritoRepre1').select2({
        placeholder: "Seleccione distrito",
        allowClear: true
    });
    $('#selDepartamentoRepre2').select2({
        placeholder: "Seleccione departamento",
        allowClear: true
    });
    $('#selProvinciaRepre2').select2({
        placeholder: "Seleccione provincia",
        allowClear: true
    });
    $('#selDistritoRepre2').select2({
        placeholder: "Seleccione distrito",
        allowClear: true
    });

    $('#selDepartamento').on('change',function(){
        let value = $(this).val().trim();
        if(value.length!=0){
          fxProvincias(value,'#selProvincia','#selDistrito');
        }
    });
    $('#selProvincia').on('change',function(){
        let dep = $('#selDepartamento').val().trim();
        let pro = $(this).val().trim();
        if(dep.length!=0 && pro.length!=0){
          fxDistritos(dep,pro,'#selDistrito');
        }
    });

    $('#selDepartamentoRepre1').on('change',function(){
        let value = $(this).val().trim();
        if(value.length!=0){
          fxProvincias(value,'#selProvinciaRepre1','#selDistritoRepre1');
        }
    });
    $('#selProvinciaRepre1').on('change',function(){
        let dep = $('#selDepartamentoRepre1').val().trim();
        let pro = $(this).val().trim();
        if(dep.length!=0 && pro.length!=0){
          fxDistritos(dep,pro,'#selDistritoRepre1');
        }
    });

    $('#selDepartamentoRepre2').on('change',function(){
        let value = $(this).val().trim();
        if(value.length!=0){
          fxProvincias(value,'#selProvinciaRepre2','#selDistritoRepre2');
        }
    });
    $('#selProvinciaRepre2').on('change',function(){
        let dep = $('#selDepartamentoRepre2').val().trim();
        let pro = $(this).val().trim();
        if(dep.length!=0 && pro.length!=0){
          fxDistritos(dep,pro,'#selDistritoRepre2');
        }
    });
});

function fxProvincias(dep,target,clear){
  let selProvincia = $(target);
  let selClear = $(clear);
  selProvincia.attr('disabled','true');
  selClear.attr('disabled','true');
  $.ajax({
    type: 'GET',
    url: '/provincias/'+dep,
    error: function(error){
      alert('Ocurrió un error');
      console.error(error);
      selProvincia.removeAttr('disabled');
      selClear.removeAttr('disabled');
    }
  }).done(function(data){
      let htmlProvincias = `<option></option>`;
      data.forEach(function(provincia,index){
          htmlProvincias += `<option value="${provincia.c_provincia}">${provincia.c_nombre}</option>`;
      });
      selProvincia.html(htmlProvincias);
      selClear.html('<option></option>');
      selProvincia.removeAttr('disabled');
      selClear.removeAttr('disabled');
  });
}

function fxDistritos(dep,pro,target){
  let selDistrito = $(target);
  selDistrito.attr('disabled','true');
  $.ajax({
    type: 'GET',
    url: '/distritos/'+dep+'/'+pro,
    error: function(error){
      alert('Ocurrió un error');
      console.error(error);
      selDistrito.removeAttr('disabled');
    }
  }).done(function(data){
      let htmlDistritos = `<option></option>`;
      data.forEach(function(distrito,index){
          htmlDistritos += `<option value="${distrito.id_ubigeo}">${distrito.c_nombre}</option>`;
      });
      selDistrito.html(htmlDistritos);
      selDistrito.removeAttr('disabled');
  });
}

function fxConsultaDni(obj) {
    var l = Ladda.create(obj);
    l.start();
    $.ajax({
        type: 'POST',
        url: '/dni/buscar',
        data: {
            dni: $('#dni').val()
        },
        dataType: 'JSON',
        error: function(error) {
            alert('No hay resultados');
            console.error(error);
            l.stop();
        }
    }).done(function(data) {
        $('#nombre').val(data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno);
        l.stop();
    });
}

/*REVIEW*/
function fxCambiarContrasena() {
    var datos = {
        id_alumno: $('#infid_alumno').val(),
        contrasena: $('#inpContra').val(),
        repite_contrasena: $('#inpContraRepet').val()
    };
    $.ajax({
        type: 'POST',
        url: '/super/alumno/cambiarcontrasena',
        data: datos,
        error: function(error) {
            console.error(error);
        }
    }).done(function(data) {
        if (data.correcto) {
            location.reload();
        }
    });
}

function fxActualizarRepresentante() {
    var datos = {
        id_alumno: $('#id_alumno_repre').val(),
        dni_repre1: $('#dni_repre1').val(),
        nombre_repre1: $('#nombre_repre1').val(),
        nacionalidad_repre1: $('#nacionalidad_repre1').val(),
        sexo_repre1: $('#sexo_repre1').val(),
        telefono_repre1: $('#telefono_repre1').val(),
        correo_repre1: $('#correo_repre1').val(),
        direccion_repre1: $('#direccion_repre1').val(),
        ubigeo_repre1: $('#selDistritoRepre1').val(),
        vinculo_repre1: $('#vinculo_repre1').val(),
        dni_repre2: $('#dni_repre2').val(),
        nombre_repre2: $('#nombre_repre2').val(),
        nacionalidad_repre2: $('#nacionalidad_repre2').val(),
        sexo_repre2: $('#sexo_repre2').val(),
        telefono_repre2: $('#telefono_repre2').val(),
        correo_repre2: $('#correo_repre2').val(),
        direccion_repre2: $('#direccion_repre2').val(),
        ubigeo_repre2: $('#selDistritoRepre2').val(),
        vinculo_repre2: $('#vinculo_repre2').val(),
    };
    $.ajax({
        type: 'POST',
        url: '/super/alumno/actualizarrepresentante',
        data: datos,
        error: function(error) {
            alert('Ocurrió un error. Por favor completa todos los campos');
            console.error(error);
        }
    }).done(function(data) {
        if (data.correcto) {
            location.reload();
        }
    });
}
