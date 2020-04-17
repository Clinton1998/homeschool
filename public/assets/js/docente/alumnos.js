
function fxAplicarAlumno(id_alm){

    $.ajax({
        type: 'POST',
        url: '/docente/alumno/aplicar',
        data: {
            id_alumno: id_alm
        },
        error: function(error){
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function(data){
        console.log('Los datos devueltos son: ');
        console.log(data);
        if(data.correcto){
            var srcFoto = '';
            if (data.alumno.c_foto == null) {
                if (data.alumno.c_sexo.toUpperCase() == 'M') {
                    srcFoto = '../assets/images/usuario/teacherman.png';
                } else {
                    srcFoto = '../assets/images/usuario/teacherwoman.png';
                }
            } else {
                srcFoto = '../super/docente/foto/' + data.alumno.c_foto;
            }
            $('#fotoAlumno').attr('src',srcFoto);
            $('#nombreAlumno').text(data.alumno.c_nombre);
            $('#correoAlumno').text(data.alumno.c_correo);
            $('#nombreRepresentante1').text(data.alumno.c_nombre_representante1);
            $('#telefono1').text(data.alumno.c_telefono_representante1);
            $('#nombreRepresentante2').text(data.alumno.c_nombre_representante2);
            $('#telefono2').text(data.alumno.c_telefono_representante2);
            $('#modal-datos-alumno').modal('show');
        }else{
            location.reload();
        }
    });
    
    
}