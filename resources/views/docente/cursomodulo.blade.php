<div class="content-header">
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h4 class="content-title">Módulos</h4>
        <button type="button" id="btn-nuevo-modulo" class="btn" data-toggle="modal" data-target="#MODAL" style="margin: -15px 0 5px 0; color: #FFF; background: {{$curso->col_curso}}">Nuevo módulo</button>
    </div>
</div>

@php
    $num = 0;
@endphp

<div class="content-main">
    <div id="container-reload" class="my-scroll">
        @if ($modulos->count() > 0)
            @foreach ($modulos as $m)
                <div class="box-card card">
                    <div class="card-header">
                        <div class="box-title">
                            <strong style="display: flex; align-items: center">
                                <span>
                                    @php
                                        $num++;
                                        echo '<span class="badge  badge-dark p-1 mr-1">'.$num.'</span>'; 
                                    @endphp
                                </span>
                                <span href="#" class="hs_upper" style="margin-bottom: -2px"> {{$m->c_nombre}}</span>
                            </strong>
                            <div>
                                <a href="#" class="badge badge-warning m-1" onclick="EditarModulo({{$m->id_modulo}},'{{$m->c_nombre}}')">Editar</a>
                                <a href="#" class="badge badge-danger" onclick="EliminarModulo({{$m->id_modulo}}, {{$m->id_seccion_categoria}})">Eliminar</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="box-content">
                            <div class="box-descripcion">
                                <div class="box-files" id="box_files{{$m->id_modulo}}">
                                    @php
                                        $sub_item = 0;
                                    @endphp
                                    @if ($archivos->count() > 0)
                                        @foreach ($archivos as $a)
                                            @if ($a->id_modulo == $m->id_modulo)
                                                <div class="box-file">
                                                    <div class="box-file-header">
                                                        <div class="box-file-header-title">
                                                            @php
                                                                $sub_item++;
                                                                echo '<span class="mr-1">'.$num.'.'.$sub_item.'.'.'</span><p class="hs_capitalize-first">'.$a->c_nombre.'</p>';
                                                            @endphp
                                                        </div>
                                                        <a href="#" class="badge badge-light" onclick="EliminarArchivo({{$a->id_archivo}}, {{$a->id_modulo}})">Eliminar</a>
                                                    </div>
                                                    <div class="boc-file-footer">
                                                        @if (($a->c_url != null) && ($a->c_link != null))
                                                            <a href="{{url('/docente/cursos/descargar_archivo/'.$a->id_archivo)}}" class="box-file-link" download="{{$a->c_url}}">Descargar archivo</a>
                                                            <a href="{{$a->c_link}}" class="box-file-link" target="_blank">Ver Link</a>                                                        
                                                        @else
                                                            @if ($a->c_url != null)
                                                                <a href="{{url('/docente/cursos/descargar_archivo/'.$a->id_archivo)}}" class="box-file-link" download="{{$a->c_url}}">Descargar archivo</a>
                                                            @endif

                                                            @if ($a->c_link != null)
                                                                <a href="{{$a->c_link}}" class="box-file-link" target="_blank">Ver Link</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="#" onclick="AbrirModal({{$m->id_modulo}})" class="btn btn-sm btn-primary mt-2">Agregar archivo</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="box-card card">
                <div class="card-header">
                    <div class="box-title">
                        <strong><a href="#" class="hs_upper">Este curso aún no tiene módulos creados</a></strong>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal MODULO -->
<div class="modal fade" id="MODAL" tabindex="-1" role="dialog" aria-labelledby="MODALLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_modulo" method="POST" action="{{url('/docente/cursos/crear_modulo')}}" novalidate>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id_mo" name="id_mo">
                    <input type="hidden" id="id_sc" name="id_sc" value="{{$id_sc->id_seccion_categoria}}">
                    <div class="form-group">
                        <label for="nombre_modulo">Nombre del módulo</label>
                        <input type="text" id="nombre_modulo" name="nombre_modulo" class="form-control" autofocus required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_actualizar_modulo" class="btn btn-warning">Actualizar</button>
                    <button type="button" id="btn_crear_modulo" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal ARCHIVOS -->
<div class="modal fade" id="MODAL-FILE" tabindex="-1" role="dialog" aria-labelledby="MODAL-FILELabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="frm_archivo" name="frm_archivo" method="POST" action="{{url('/docente/cursos/agregar_archivo')}}" novalidate>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id_m_key" name="id_m_key">
                    <div class="form-group">
                        <label for="nombre_archivo">Nombre del archivo</label>
                        <input type="text" id="nombre_archivo" name="nombre_archivo" class="form-control" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="file">Archivo</label>
                        <input type="file" name="el_archivo" id="el_archivo" class="form-control hs_upload">
                    </div>
                    <div class="form-group">
                        <label for="url">Enlace externo</label>
                        <input type="url" name="url_archivo" id="url_archivo" class="form-control" placeholder="(Opcional)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {{-- <button type="button" id="btn_agregar_archivo" class="btn btn-primary">Agregar archivo</button> --}}
                    <button type="submit" id="btn_agregar_archivo" class="btn btn-primary">Agregar archivo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>

<script>
    //Botones
    $('#btn-nuevo-modulo').click(function(){
        $('#btn_crear_modulo').show();
        $("#btn_actualizar_modulo").hide();
        $('#nombre_modulo').val('');
    })

    //Crear nuevo módulo
    $('#btn_crear_modulo').click(function(){
        
        ruta = '/docente/cursos/crear_modulo';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_sc = $('#id_sc').val();
        nombre_modulo = $('#nombre_modulo').val();
        
        modal = $('#MODAL');

        if (nombre_modulo == '') {
            MSJ('REQUIREMOD');
        } else {
            $.ajax({
                url: ruta,
                type: metodo,
                dataType: tipoDato,
                data: {
                    id_seccion_categoria: id_sc,
                    c_nombre: nombre_modulo
                },
                success:function(data){
                    $("#container-reload").load(" #container-reload");
                    modal.modal('hide');
                    MSJ('MAD');
                },
                error: function(){
                    MSJ('MADER');
                }
            });
        }
    });

    //Cargar módulo
    function EditarModulo(id, nombre){
        $('#id_mo').val(id);
        $("#nombre_modulo").val(nombre);
        $('#btn_crear_modulo').hide();
        $("#btn_actualizar_modulo").show();
        $('#MODAL').modal('show');
    };

    //Actualizar módulo
    $("#btn_actualizar_modulo").click(function() {
        
        ruta = '/docente/cursos/actualizar_modulo';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_modulo = $('#id_mo').val();
        id_sc = $('#id_sc').val();
        nombre_modulo = $('#nombre_modulo').val();
        
        modal = $('#MODAL');
        
        $.ajax({
            url: ruta,
            type: metodo,
            dataType: tipoDato,
            data: {
                id_modulo: id_modulo,
                id_seccion_categoria: id_sc,
                c_nombre: nombre_modulo
            },
            success:function(data){
                $("#container-reload").load(" #container-reload");
                modal.modal('hide');
                MSJ('MAC');
            },
            error: function(){
                MSJ('MACER');
            }
        });
    });

    //Eliminar módulo
    function EliminarModulo(id, id_sc){
        ruta = '/docente/cursos/eliminar_modulo';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_modulo = id;
        
        Swal.fire({
            text: "¿Seguro(a) que quiere eliminar este módulo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Si, eliminar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: ruta,
                    type: metodo,
                    dataType: tipoDato,
                    data: {
                        id_modulo: id_modulo,
                        id_seccion_categoria: id_sc
                    },
                    success:function(data){
                        $("#container-reload").load(" #container-reload");
                        MSJ('MEL');
                    },
                    error: function(){
                        MSJ('MELER');
                    }
                })
            }
        })
    };

    //Abrir modal de archivo
    function AbrirModal(m){
        $('#id_m_key').val(m);

        modal = $('#MODAL-FILE');
        modal.modal('show');
    };

    //Agregar archivo v.2
    $("#frm_archivo").on("submit", function(e){
        e.preventDefault();
        var f = $(this);

        nombre = $("#nombre_archivo").val();
        file = $("#el_archivo").val();
        link = $("#url_archivo").val();

        if (nombre == '') {
            MSJ('REQUIRE');
        } else {
            if (file == '' && link == '') {
                MSJ('FILI');
            } else {
                var formData = new FormData(document.getElementById("frm_archivo"));
                formData.append("dato", "valor");
                //formData.append(f.attr("el_archivo"), $(this)[0].files[0]);
                
                id_modulo = $('#id_m_key').val();
                modal = $('#MODAL-FILE');

                $.ajax({
                    url: "/docente/cursos/agregar_archivo",
                    type: "post",  
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#box_files"+id_modulo).load(" #box_files"+id_modulo);
                        modal.modal('hide');
                        $('#id_m_key').val('');
                        $('#nombre_archivo').val('');
                        $('#el_archivo').val('');
                        $('#url_archivo').val('');
                        MSJ('AAD');
                    },
                    error: function(){
                        MSJ('AADER');
                    }
                });
            }
        }
    });

    //Eliminar archivo
    function EliminarArchivo(id_a, id_m){
        ruta = '/docente/cursos/eliminar_archivo';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_archivo = id_a;
        id_modulo = id_m;
        
        Swal.fire({
            text: "¿Seguro(a) que quiere eliminar este archivo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Si, eliminar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: ruta,
                    type: metodo,
                    dataType: tipoDato,
                    data: {
                        id_archivo: id_archivo,
                        id_modulo: id_modulo
                    },
                    success:function(data){
                        $("#box_files"+id_modulo).load(" #box_files"+id_modulo);
                        MSJ('AEL');
                    },
                    error: function(){
                        MSJ('AELER');
                    }
                })
            }
        })
    };
       
    function MSJ(cod){
        switch (cod) {
            case 'MAD':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Módulo creado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'MADER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'No se puedo crear el módulo, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'MAC':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Módulo actualizado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'MACER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'No se puedo actualizar el módulo, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'MEL':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Módulo eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'MELER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'No se puedo eliminar el módulo, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'AAD':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Archivo agregado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'AADER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'No se puedo cargar el arhivo, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'AEL':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Archivo eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'AELER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'No se puedo eliminar el archivo, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'REQUIRE':
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Necesita nombrar el archivo',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
                break;
            case 'FILI':
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Debe subir un archivo o agregar un enlace externo',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
                break;
            case 'REQUIREMOD':
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Necesita nombrar el módulo',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
                break;
            default:
                break;
        }
    };
</script>