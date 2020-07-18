<head>
    <style>
        .tools,
        .tools-icon {
            position: fixed;
            bottom: 30px;
            right: 10px;
            width: 250px;
            z-index: 100;
            /* display: none; */
        }

        .tools-icon {
            background-color: lightgrey;
            /* color: #FFF; */
            font-size: 20px;
            width: 40px;
            height: 40px;
            padding: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            cursor: pointer;
        }

        .maletin {
            /* background-image: url(../../images/briefcase.png); */
            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
            width: 35px;
            height: 35px;
            display: block;
        }

        .tools-icon:hover {
            transform: scale(1.08);
        }

        .tools-container {
            height: 310px;
            border-radius: 8px;
            overflow: hidden;
        }

        .tools-header {
            background: var(--ps-color-secundario);
            color: #FFF;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 40px;
            padding: 15px;
        }

        .tools-nav-min {
            font-size: 25px;
            color: #FFF;
            font-weight: bolder;
            margin-bottom: 0;
        }

        .tools-nav-min:hover {
            color: #FFF;
        }

        .tools-nav {
            background-color: lightgrey;
            text-align: center;
        }

        .textBuscar {
            border: solid 1px lightgray;
            width: 100%;
            padding: 5px 12px;
            font-size: 10px;
            height: 30px;
        }

        .tools-list {
            background: #FFF;
            height: calc(100% - 110px);
            padding: 5px;
            border: solid 1px lightgrey;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            grid-template-rows: repeat(auto-fill, 60px);
            grid-gap: 5px;
            overflow-y: scroll;
        }

        .tools-delete-box {
            height: 0;
        }

        .tools-item {
            border: solid 1px #f1f2f6;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            text-align: center;
            padding: 0 3px;
            background: #f9f9f9;
        }

        .tools-item:hover {
            background-color: #f1f2f6;
        }

        .tools-link {
            /* border: solid 1px blue; */
            display: flex;
            flex-direction: column;
            margin-top: 3px;
        }

        .tools-img {
            /* border: solid 1px orange; */
            height: 35px;
            width: 35px;
            margin: auto;
        }

        .tools-name {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            word-wrap: break-word;
        }

        .tools-footer {
            background: #f9f9f9;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            border: solid 1px lightgrey;
        }

        .tools-nav-link {
            font-weight: bolder;
            font-size: 15px;
            margin-bottom: 0;
        }

        .hs_upload {
            height: 50px !important;
            border-style: dashed;
            text-align: center;
        }

        .tools-delete-box {
            z-index: 10000;
        }

        .boton_editar, .boton_eliminar {
            display: none;
        }

        @media screen and (max-width: 425px) {

            .tools,
            .tools-icon {
                bottom: 10px;
                z-index: 100;
            }
        }

        .my-alert-content{
            text-align: center;
            padding: 30px;
        }

        .icono-success{
            color: #A5DC86;
        }

        .icono-question{
            color: #87ADBD;
        }

        .icono-info{
            color: #3FC3EE;
        }

        .my-alert-footer{
            display: flex;
            justify-content: center
        }
    </style>
</head>

<div class="tools">
    <div id="tools-container" class="tools-container">
        <div class="tools-header">
            <div class="tools-title">
                <span>Mis herramientas</span>
            </div>
            <a class="tools-nav-min" href="#">-</a>
        </div>
        <div class="tools-nav">
            <input type="text" placeholder="Buscar tus herramientas" class="textBuscar" id="textBuscar">
        </div>
        <div class="tools-list" id="tools-list">

        </div>
        <div class="tools-footer">
            <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#MODAL-TOOLS">Agregar</a>
            <a  id="quiero_eliminar"  href="#" class="btn btn-sm" onclick="MostrarEliminar()">Mantenimiento</a>
            <a  id="quiero_cancelar"  href="#" class="btn btn-sm" onclick="CancelarEliminar()">Cancelar</a>
        </div>
    </div>
</div>

<div id="tools-icon" class="tools-icon">
    {{-- <div class="maletin">

    </div> --}}
    <i class="fas fa-th "></i>
</div>

<div class="modal fade" id="MODAL-TOOLS" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-tools-title">Herramienta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form enctype="multipart/form-data" id="frm-tools" name="frm-tools" method="POST" action="{{url('/herramienta/agregar')}}" novalidate>
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id_tool" id="id_tool" value="">
                <div class="formgroup">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <br>
                <div class="formgroup">
                    <label for="link">Enlace de la herramienta</label>
                    <input type="url" name="link" id="link" class="form-control" placeholder="https://www.mi-herramienta-online.com" required>
                </div>

                <br>
                <div class="formgroup">
                    <label for="">Imagen</label>
                </div>

                <div class="form-group" style="display: flex; flex-wrap: wrap; justify-content: space-between">
                    <label class="radio radio-light mr-1" id="file-web">
                        <input type="radio" name="radio" [value]="2" formControlName="radio" checked>
                        <span>Desde un enlace web</span>
                        <span class="checkmark"></span>
                    </label>

                    <label class="radio radio-light" id="file-pc">
                        <input type="radio" name="radio" [value]="1" formControlName="radio">
                        <span>Desde mi dispositivo</span>
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="formgroup">
                    <input type="file" name="logo_fisico" id="logo_fisico" class="form-control hs_upload">
                    <input type="url" name="logo_link" id="logo_link" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="LimpiarInputs()" >Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btn_guardar" form="frm-tools">Guardar</button>
                <button class="btn btn-primary" id="btn_actualizar">Actualizar</button>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="modal fade" id="MODAL-ALERT-SUCCESS" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
        <div class="my-alert-content">
            <div class="my-alert-header">
                <i class="icono-success far fa-check-circle fa-3x"></i>
                <i class="icono-info fas fa-info-circle fa-3x"></i>
                <i class="icono-question far fa-question-circle fa-3x"></i>
            </div>
            <div class="my-alert-body">
                <br>
                <h5 id="alert-text">
                    Mensaje de confirmación
                </h5>
                <br>
            </div>
            <div class="my-alert-footer">
                <a id="btn-si" class="btn btn-primary mr-4" href=">#">Si, eliminar</a>
                <a id="btn-cancelar" class="btn btn-danger" data-dismiss="modal" href="#">Cancelar</a>
                <a id="btn-entendido" class="btn btn-primary" data-dismiss="modal" href="#">Entendido</a>
            </div>
        </div>
    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
    $('#tools-container').hide();
    $('#tools-icon').show();

    MostrarHerramientas();

    $('.boton_editar').hide();
    $('.boton_eliminar').hide();
    $('#quiero_cancelar').hide();
    $('#quiero_eliminar').show();

    $('#textBuscar').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');

        $('.tools-item').hide();

        $('.tools-item').filter(function () {
            return rex.test($(this).text());
        }).show();
    });

    $('#logo_fisico').hide();
    $('#logo_link').show();

    $('#btn_actualizar').hide();
});

$('#tools-icon').click(function(){
    $('#tools-container').fadeIn();
    $('#tools-icon').hide();
});

$('.tools-nav-min').click(function(){
    $('#tools-container').fadeOut();
    $('#tools-icon').fadeIn();
});

//Agregar herramienta
$("#frm-tools").on("submit", function(e){
    e.preventDefault();
    var f = $('#frm-tools');

    nombre = $("#nombre").val();
    file = $("#logo_fisico").val();
    link = $("#logo_link").val();
    url = $("#link").val();

    modal = $('#MODAL-TOOLS');

    if (nombre == '') {
        MyAlert(2,'Una herramienta necesita un título o nombre');
    } else {
        if (url == '') {
            MyAlert(2,'Necesita escribir o copiar el enlace de la herramienta');
        } else {
            var formData = new FormData(document.getElementById("frm-tools"));
            formData.append("dato", "valor");

            $.ajax({
                url: "/herramienta/agregar",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    modal.modal('hide');

                    $("#nombre").val('');
                    $("#logo_fisico").val('');
                    $("#logo_link").val('');
                    $("#link").val('');

                    MostrarHerramientas();
                    MyAlert(1, 'Su nueva herramienta fue configurada correctamente');
                },
                error: function(){
                    MyAlert(2,'Su  nueva herramienta no pudo ser configurada, vuelva a intentarlo');
                }
            });
        }
    }
});

//Validar tamaño de archivo
//comentado por que interferia la implementacion de fineUploader en comunicados
//**CORREGIR**: El selector no debe apuntar a todos los input de tipo file, solo especificos
/*$(document).on('change', 'input[type="file"]', function(){
    var file_name = this.files[0].name;
    var file_size = this.files[0].size;

    //5MB
    if (file_size > 5000000) {
        MyAlert(2, 'El archivo no debe superar los 5MB');

        this.value = '';
        this.files[0].name = '';
    } else {
        var archivo = this.value;
        var extensiones = archivo.substring(archivo.lastIndexOf("."));

        if(extensiones != ".jpg" && extensiones != ".jpeg" && extensiones != ".png" && extensiones != ".gif")
        {

            MyAlert(2, 'Archivo no válido, intente con un archivo de imagen');

            this.value = '';
            this.files[0].name = '';
        }
    }
});*/

//Mostrar herramientas
function MostrarHerramientas(){
    $.ajax({
        url: "/herramienta/listar",
        type: "GET",
        /* data: {id_tarea: id}, */
        success:function(data){

            /* console.log(data) */
            Herramientas = '';

            if (data.herramientas.length > 0) {
                data.herramientas.forEach(function (herramienta, indice){
                    Herramientas += '<div class="tools-item" data-toggle="tooltip" data-placement="top" title="'+ herramienta.c_link +'">';
                    if(herramienta.b_mantenimiento==1){
                        Herramientas += '<div class="text-right tools-delete-box"><a href="#" class="pt-1 pb-1 badge badge-warning boton_editar" onclick="EditarHerramienta('+ herramienta.id_herramienta +')"><i class="i-Pen-5"></i></a><a href="#" class="badge badge-danger boton_eliminar" onclick="EliminarHerramienta('+ herramienta.id_herramienta +')">x</a></div>';
                    }
                    Herramientas += '<a class="tools-link" id="tool_link_'+ herramienta.id_herramienta +'" href="'+ herramienta.c_link +'" target="_blank">';
                    /* Herramientas +='<input type="hidden" id="tool_'+ herramienta.id_herramienta +'" name="tool_'+ herramienta.id_herramienta +'" value="">'; */
                    if (herramienta.c_logo_fisico == null && herramienta.c_logo_link == null) {
                        Herramientas += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="/assets/images/briefcase.png" alt="Tool">';
                    } else if (herramienta.c_logo_fisico == null){
                        Herramientas += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="'+ herramienta.c_logo_link +'" alt="Tool">';
                    } else {
                        Herramientas += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="' + '/herramienta/logo/' + herramienta.c_logo_fisico + '" alt="Tool">';
                    }
                    Herramientas += '<small id="tool_name_'+ herramienta.id_herramienta +'" class="tools-name">'+ herramienta.c_nombre +'</small>';
                    Herramientas += '</a>';
                    Herramientas += '</div>';
                })
            };

            $('#tools-list').html(Herramientas);
        },
        error: function(){
            MyAlert(2, 'Error al intentar obtener sus herramientas');
        }
    })
};

//Eliminar herramienta
/* function EliminarHerramienta(id){
    Swal.fire({
        text: "¿Quiere eliminar esta herramienta?",
        showCancelButton: true,
        confirmButtonColor: '#ffffff',
        cancelButtonColor: '#e74c3c',
        confirmButtonText: 'Si, eliminar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/herramienta/eliminar',
                type: 'POST',
                data: {
                    id_herramienta: id
                },
                success:function(data){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Herramienta eliminada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    MostrarHerramientas();
                    $('#quiero_cancelar').hide();
                    $('#quiero_eliminar').show();
                },
                error: function(){
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        text: 'Problemas al intentar eliminar la herramienta, vuelva a intentarlo',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#quiero_cancelar').hide();
                    $('#quiero_eliminar').show();
                }
            })
        }
    })
} */

//Cargar datos para Editar
function EditarHerramienta(id){
    modal = $('#MODAL-TOOLS');

    $("#id_tool").val(id);

    nombre = $("#nombre").val($('#tool_name_'+id).text());
    url = $("#link").val($('#tool_link_'+id).attr('href'));

    $('#btn_guardar').hide();
    $('#btn_actualizar').show();

    modal.modal('show');
}

//Actualziar datos de herramienta
$('#btn_actualizar').click(function(){
    event.preventDefault();

    var f = $(this);

    nombre = $("#nombre").val();
    file = $("#logo_fisico").val();
    link = $("#logo_link").val();
    url = $("#link").val();

    modal = $('#MODAL-TOOLS');

    if (nombre == '') {
        MyAlert(2,'Su nueva herramienta necesita un título');
    } else {
        if (url == '') {
            MyAlert(2,'Necesita escribir o copiar el enlace de la herramienta');
        } else {
            var formData = new FormData(document.getElementById("frm-tools"));
            formData.append("dato", "valor");

            $.ajax({
                url: "/herramienta/actualizar",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    modal.modal('hide');

                    $("#nombre").val('');
                    $("#logo_fisico").val('');
                    $("#logo_link").val('');
                    $("#link").val('');

                    MostrarHerramientas();

                    MyAlert(1, 'Su herramienta fue actualizada correctamente');

                    $('#btn_guardar').show();
                    $('#btn_actualizar').hide();

                    CancelarEliminar();
                },
                error: function(){
                    MyAlert(2,'Su herramienta no pudo ser actualizada, vuelva a intentarlo');
                }
            });
        }
    }
});

//Eliminar herramienta
function EliminarHerramienta(id){
    MyAlert(3, '¿Quiere eliminar esta herramienta?');

    $('#btn-si').click(function(e){
        event.preventDefault(e);

        $.ajax({
            url: '/herramienta/eliminar',
            type: 'POST',
            data: {
                id_herramienta: id
            },
            success:function(data){
                MostrarHerramientas();
                $('#quiero_cancelar').hide();
                $('#quiero_eliminar').show();
                MyAlert(1, 'Herramienta eliminada correctamente');
            },
            error: function(){
                $('#quiero_cancelar').hide();
                $('#quiero_eliminar').show();

                MyAlert(2, 'Problemas al intentar eliminar la herramienta, vuelva a intentarlo');
            }
        })
    });
}

function MostrarEliminar(){
    $('.boton_editar').show();
    $('.boton_eliminar').show();
    $('#quiero_cancelar').show();
    $('#quiero_eliminar').hide();
}

function CancelarEliminar(){
    $('.boton_editar').hide();
    $('.boton_eliminar').hide();
    $('#quiero_cancelar').hide();
    $('#quiero_eliminar').show();
}

$('#file-pc').click(function(){
    $('#logo_fisico').show();
    $('#logo_link').hide();
});

$('#file-web').click(function(){
    $('#logo_fisico').hide();
    $('#logo_link').show();
});

//Modales para alerts
function MyAlert(tipo, text){

    modal = $('#MODAL-ALERT-SUCCESS');
    $('#alert-text').text(text);

    success = $('.icono-success');
    info = $('.icono-info');
    question = $('.icono-question');

    btn_si = $('#btn-si');
    btn_cancelar = $('#btn-cancelar');
    btn_entendido = $('#btn-entendido');

    success.hide();
    info.hide();
    question.hide();

    btn_si.hide();
    btn_cancelar.hide();
    btn_entendido.hide();

    modal.modal('show')

    switch (tipo) {
        case 1:
            success.show();
            setTimeout(function(){
                modal.modal('hide')
            }, 1500);
            break;

        case 2:
            info.show();
            btn_entendido.show();
            break;

        case 3:
            question.show();
            btn_si.show();
            btn_cancelar.show();
            break;

        default:
            break;
    }
}

function LimpiarInputs(){
    $("#nombre").val('');
    $("#logo_fisico").val('');
    $("#logo_link").val('');
    $("#link").val('');
}

</script>
