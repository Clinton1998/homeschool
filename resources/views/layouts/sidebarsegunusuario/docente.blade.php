<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-panel-docente.css')}}">
</head>

<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- INICIO DE NUEVO MENU SLIDER -->
        <ul class="menu-lateral ">
            <li class="menu-lateral-item {{ (request()->is('/') || request()->is('home')) ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('home')}}">
                    <i class="nav-icon i-Optimization"></i>
                    <br>
                    <span>Tablero</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('docente/cursos*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/cursos')}}">
                    <i class="nav-icon i-Sidebar-Window"></i>
                    <br>
                    <span>Mis Cursos</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('docente/estadotareas*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/estadotareas')}}">
                    <i class="nav-icon i-Folder-With-Document"></i>
                    <br>
                    <span>Estado de tareas</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('docente/asignartareas*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/asignartareas')}}">
                    <i class="nav-icon i-Notepad"></i>
                    <br>
                    <span>Historial de tareas</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('docente/videoclase*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/videoclase')}}">
                    <i class="nav-icon i-Movie"></i>
                    <br>
                    <span>Videoclase</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('docente/alumno*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/alumno')}}">
                    <i class="nav-icon i-Student-Hat-2"></i>
                    <br>
                    <span>Mis alumnos</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('docente/docente*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/docente')}}">
                    <i class="nav-icon i-Geek"></i>
                    <br>
                    <span>Docentes</span>
                </a>
            </li>

        </ul>
        <!-- FIN DE NUEVO MENU SLIDER -->
    </div>
    <div class="sidebar-overlay"></div>
</div>

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

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>

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
        var f = $(this);

        nombre = $("#nombre").val();
        file = $("#logo_fisico").val();
        link = $("#logo_link").val();
        url = $("#link").val();

        modal = $('#MODAL-TOOLS');

        if (nombre == '') {
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'Su nueva herramienta, necesita un título',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });
        } else {
            if (url == '') {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Necesita escribir o copiar el enlace de la herramienta',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
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
                        /* $("#box_files"+id_modulo).load(" #box_files"+id_modulo); */

                        modal.modal('hide');

                        $("#nombre").val('');
                        $("#logo_fisico").val('');
                        $("#logo_link").val('');
                        $("#link").val('');

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Su nueva herramienta fue configurada correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        MostrarHerramientas();
                    },
                    error: function(){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            text: 'Su herramienta no pudo ser configurada, vuelva a intentarlo',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        }
    });

    //Validar tamaño de archivo
    $(document).on('change', 'input[name="logo_fisico"]', function(){
        var file_name = this.files[0].name;
        var file_size = this.files[0].size;

        //5MB
        if (file_size > 5000000) {

            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'El archivo no debe superar los 5MB',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });

            this.value = '';
            this.files[0].name = '';
        } else {
            var archivo = this.value;
            var extensiones = archivo.substring(archivo.lastIndexOf("."));

            if(extensiones != ".jpg" && extensiones != ".jpeg" && extensiones != ".png" && extensiones != ".gif")
            {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Archivo no válido, intente con otro archivo',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });

                this.value = '';
                this.files[0].name = '';
            }
        }
    });

    //Mostrar herramientas
    function MostrarHerramientas(){
        $.ajax({
            url: "/herramienta/listar",
            type: "GET",
            /* data: {id_tarea: id}, */
            success:function(data){
                Comentarios = '';

                if (data.herramientas.length > 0) {
                    data.herramientas.forEach(function (herramienta, indice){
                        Comentarios += '<div class="tools-item" data-toggle="tooltip" data-placement="top" title="'+ herramienta.c_link +'">';
                            if(herramienta.b_mantenimiento==1){
                                Comentarios += '<div class="text-right tools-delete-box"><a href="#" class="pt-1 pb-1 badge badge-warning boton_editar" onclick="EditarHerramienta('+ herramienta.id_herramienta +')"><i class="i-Pen-5"></i></a><a href="#" class="badge badge-danger boton_eliminar" onclick="EliminarHerramienta('+ herramienta.id_herramienta +')">x</a></div>';
                            }
                            Comentarios += '<a class="tools-link" id="tool_link_'+ herramienta.id_herramienta +'" href="'+ herramienta.c_link +'" target="_blank">';
                                /* Comentarios +='<input type="hidden" id="tool_'+ herramienta.id_herramienta +'" name="tool_'+ herramienta.id_herramienta +'" value="">'; */
                                if (herramienta.c_logo_fisico == null && herramienta.c_logo_link == null) {
                                    Comentarios += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="/assets/images/briefcase.png" alt="Tool">';
                                } else if (herramienta.c_logo_fisico == null){
                                    Comentarios += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="'+ herramienta.c_logo_link +'" alt="Tool">';
                                } else {
                                    Comentarios += '<img id="tool_image_'+ herramienta.id_herramienta +'" class="tools-img" src="' + '/herramienta/logo/' + herramienta.c_logo_fisico + '" alt="Tool">';
                                }
                                Comentarios += '<small id="tool_name_'+ herramienta.id_herramienta +'" class="tools-name">'+ herramienta.c_nombre +'</small>';
                            Comentarios += '</a>';
                        Comentarios += '</div>';
                    })
                };

                $('#tools-list').html(Comentarios);
            },
            error: function(){
                alert('Error al leer los comentarios');
            }
        })
    };

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
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'Su herramienta, necesita un título',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });
        } else {
            if (url == '') {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Necesita escribir o copiar el enlace de la herramienta',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
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

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Su herramienta fue actualizada correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#btn_guardar').show();
                        $('#btn_actualizar').hide();
                        CancelarEliminar();
                    },
                    error: function(){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            text: 'Su herramienta no pudo ser actualizada, vuelva a intentarlo',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        }
    });

    //Eliminar herramienta
    function EliminarHerramienta(id){
        Swal.fire({
            text: "¿Quiere eliminar esta herramienta?",
            icon: 'question',
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

    function LimpiarInputs(){
    $("#nombre").val('');
    $("#logo_fisico").val('');
    $("#logo_link").val('');
    $("#link").val('');
}
</script>
