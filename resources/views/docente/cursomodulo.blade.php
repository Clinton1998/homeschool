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
                                                        <a href="{{url('/docente/cursos/descargar_archivo/'.$a->id_archivo)}}" class="box-file-link" download="{{$a->c_url}}">Descargar</a>
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
                    <label for="el_archivo"></label>
                    <input type="file" name="el_archivo" id="el_archivo" class="form-control hs_upload">
                </div>

                {{-- <div [formGroup]="radioGroup">
                    <label class="radio radio-light">
                        <input id="radio1" type="radio" name="radio" [value]="1" formControlName="radio" checked>
                        <span>Subir un archivo</span>
                        <span class="checkmark"></span>
                    </label>
                    <div class="form-group">
                        <input type="file" name="el_archivo" id="el_archivo" class="form-control hs_upload">
                    </div>

                    <label class="radio radio-light">
                        <input id="radio2" type="radio" name="radio" [value]="2" formControlName="radio">
                        <span>Agregar un link</span>
                        <span class="checkmark"></span>
                    </label>
                    <div class="form-group">
                        <input type="url" name="url_archivo" id="url_archivo" class="form-control" disabled>
                    </div>
                </div> --}}
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

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
                alert('Módulo creado correctamente :)');
            },
            error: function(){
                alert('No se puedo crear el módulo :(');
            }
        });
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
                alert('Módulo actualizado correctamente :)');
            },
            error: function(){
                alert('No se pudo actualizar el módulo :(');
            }
        });
    });

    //Eliminar módulo
    function EliminarModulo(id, id_sc){
        ruta = '/docente/cursos/eliminar_modulo';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_modulo = id;
        
        rpt = confirm('¿Seguro(a) que quiere eliminar este módulo?');

        if (rpt) {
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
                    alert('Módulo eliminado correctamente :)');
                },
                error: function(){
                    alert('No se pudo eliminar el módulo :(');
                }
            });
        }
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
                    alert('Archivo agregado :)');
                    $('#id_m_key').val('');
                    $('#nombre_archivo').val('');
                    $('#el_archivo').val('');
                    $('#url_archivo').val('');
                },
                error: function(){
                    alert('No se puedo agregar :(');
                }
        });
    });

    //Eliminar archivo
    function EliminarArchivo(id_a, id_m){
        ruta = '/docente/cursos/eliminar_archivo';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_archivo = id_a;
        id_modulo = id_m;
        
        rpt = confirm('¿Seguro(a) que quiere eliminar este archivo?');

        if (rpt) {
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
                    alert('Archivo eliminado correctamente :)');
                },
                error: function(){
                    alert('No se pudo eliminar el archivo :(');
                }
            });
        }
    };
    
    //Radios
    $('input[name="radio"]').on('click', function(){  
        if($("#radio1").is(':checked')) {  
            $('#el_archivo').prop('disabled', false);
            $('#url_archivo').prop('disabled', true);
        } 
        
        if($("#radio2").is(':checked')) {  
            $('#el_archivo').prop('disabled', true);
            $('#url_archivo').prop('disabled', false);
        }  
    });

    //Agregar archivo v.1
    /* 
        $('#btn_agregar_archivo').click(function(){
            ruta = '/docente/cursos/agregar_archivo';
            metodo = 'POST';
            tipoDato = 'json';

            id_modulo = $('#id_m_key').val();
            nombre = $('#nombre_archivo').val();
            archivo = $('#el_archivo').val();
            url = $('#url_archivo').val();

            modal = $('#MODAL-FILE');

            $.ajax({
                url: ruta,
                type: metodo,
                dataType: tipoDato,
                data: {
                    id_modulo: id_modulo,
                    c_nombre: nombre,
                    c_archivo: archivo,
                    c_url: url
                },
                success:function(data){
                    $("#box_files"+id_modulo).load(" #box_files"+id_modulo);
                    modal.modal('hide');
                    alert('Archivo agregado :)');
                    $('#id_m_key').val('');
                    $('#nombre_archivo').val('');
                    $('#el_archivo').val('');
                    $('#url_archivo').val('');
                },
                error: function(){
                    alert('No se puedo agregar :(');
                }
            });
        }); 
    */
</script>