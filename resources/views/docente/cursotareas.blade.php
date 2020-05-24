<div class="content-header">
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h4 class="content-title">Tareas</h4>
        <div>
            <button type="button" id="btn-nuevo-anuncio" class="btn" data-toggle="modal" data-target="#NUEVA-TAREA" style="margin: -15px 0 5px 0; color: #FFF; background: {{$curso->col_curso}}">Nueva tarea</button>
        </div>
    </div>
</div>

<div class="content-main">
    <div id="tareas-reload" class="my-scroll">
        <div class="box-invert">
            <table class="curso_table">
                <thead class="mobile">
                    <tr>
                        <th class="celda_oculta">Título de tarea</th>
                        <th>Fecha de envío</th>
                        <th>Fecha de cierre</th>
                        <th>Ver</th>
                        <th>Estado</th>
                        <th>Cierre definitivo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cont_env = 0;
                        $cont_cal = 0;
                        $cont_pen = 0;
                    @endphp
                    @foreach ($tareas as $t)
                        @php
                            $cont = 1;
                        @endphp
                        @foreach($t->alumnos_asignados()->where('alumno_d.id_seccion','=',$curso->id_seccion)->get() as $item)
                            @if ($cont == 1)
                                <tr class="desk">
                                    <td class="celda_oculta">&nbsp;</td>
                                    <td colspan="6" class="celda_titulo text-left pl-2"><strong class="hs_capitalize-first">{{$t->c_titulo}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="celda_oculta text-left pl-2 hs_capitalize-first">{{$t->c_titulo}}</td>
                                    <td><small>{{substr($t->created_at,0,-3)}}</small></td>
                                    <td><small><strong>{{substr($t->t_fecha_hora_entrega,0,-3)}}</strong></small></td>
                                    <td>
                                        <abbr title="Detalles de la tarea enviada"><a class="tarea_show_details pt-2 pb-2 pr-2" href="#" onclick="VerTarea({{$t->id_tarea}})">Tarea</a></abbr>
                                        &nbsp;
                                        <abbr title="Respuestas a la tarea"><a class="tarea_show_answers pt-2 pb-2" href="/docente/estadotareas">Respuesta<span class="celda_oculta">s</span></a></abbr>
                                    </td>
                                    <td>
                                        <div class="td_estado">
                                            @foreach ($tareas_pendientes as $tp)
                                                @if ($tp->id_tarea == $t->id_tarea)
                                                    <span class="text-danger">Pendiente</span> 
                                                    @php $cont_pen++ @endphp
                                                @endif
                                            @endforeach
                                            @foreach ($tareas_calificadas as $tc)
                                                @if ($tc->id_tarea == $t->id_tarea)
                                                    <span class="text-success">Calificado</span> 
                                                    @php $cont_cal++ @endphp
                                                @endif
                                            @endforeach
                                            @php $cont_env++ @endphp
                                        </div>
                                    </td>
                                    <td><a class="btn btn-secondary btn-sm" href="#">Fin<span class="celda_oculta">alizar</span></a></td>
                                </tr>
                                <span class="anc-content" id="TT-{{$t->id_tarea}}">{{$t->c_titulo}}</span>
                                <span class="anc-content" id="TO-{{$t->id_tarea}}">{{$t->c_observacion}}</span>
                                <span class="anc-content" id="TU-{{$t->id_tarea}}">{{$t->c_url_archivo}}</span>
                                <span class="anc-content" id="TC-{{$t->id_tarea}}">{{$t->created_at}}</span>
                                <span class="anc-content" id="TE-{{$t->id_tarea}}">{{$t->t_fecha_hora_entrega}}</span>
                            @endif
                            @php
                                $cont = 0;
                            @endphp
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="tarea_contadores">
                <span class="tarea_contador badge badge-pill badge-outline-secondary p-2 mb-2 ml-1">@php echo 'Enviado&nbsp;'. $cont_env @endphp</span>
                <span class="tarea_contador badge badge-pill badge-outline-info p-2 mb-2 ml-1">@php echo 'Vigente&nbsp;'. ($cont_env - ($cont_cal + $cont_pen)) @endphp</span>
                <span class="tarea_contador badge badge-pill badge-outline-success p-2 mb-2 ml-1">@php echo 'Calificado&nbsp;'. $cont_cal @endphp</span>
                <span class="tarea_contador badge badge-pill badge-outline-danger p-2 mb-2 ml-1">@php echo 'Pendiente&nbsp;'. $cont_pen @endphp</span>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Nueva Tarea --}}
<div class="modal fade" id="NUEVA-TAREA" tabindex="-1" role="dialog" aria-labelledby="NUEVA-TARELabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="frm_tarea_nueva" method="POST" action="{{url('/docente/cursos/agregar_archivo')}}" novalidate>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tarea_titulo">Título de tarea</label>
                        <input required type="text" id="tarea_titulo" name="tarea_titulo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tarea_desc">Descripción</label>&nbsp;<small>(Opcional)</small>
                        <textarea id="tarea_desc" name="tarea_desc" cols="30" rows="3" class="form-control" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between">
                            <div>
                                <label for="tarea_arch">Archivo</label>&nbsp;<small>(Opcional)</small>
                            </div>
                            <div>
                                <small><strong><i class="nav-icon i-Information text-danger"></i>&nbsp;El archivo no debe superar los 256MB</strong></small>
                            </div>
                        </div>
                        <input type="file" id="tarea_arch" name="tarea_arch" class="form-control hs_upload" style="height: 50px">
                        <div class="mt-1" style="text-align: justify; font-size: 10px">
                            Solo se permite la carga de un archivo por tarea, por lo que si desea adjuntar varios archivos, estos deben estar en un archivo comprimido (Zip, Rar, etc...)&nbsp;
                            <a class="box-link" href="http://www.imprimaonline.com/es/ayuda/tutoriales/como-comprimir-documentos-en-zip-o-rar/" target="_blank">Más información</a>
                        </div>
                    </div>
                    <div class="form-group radio-alumnos" id="divRadioAlumno">
                        <label for="radioAlumnos">Para&nbsp;&nbsp;</label>
                        <div>
                            <div class="radio-btn form-check form-check-inline">
                                <label class="radio radio-dark">
                                    <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option1" checked >
                                    <span>Toda la sección</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="radio-btn form-check form-check-inline" data-toggle="modal" data-target="#ALUMNOS-SECCION">
                                <label class="radio radio-dark">
                                    <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option2" >
                                    <span>Seleccionar alumnos</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_docente" name="id_docente" value="{{$docente->id_docente}}">
                    <input type="hidden" id="id_seccion" name="id_seccion" value="{{$curso->id_seccion}}">
                    <input type="hidden" id="id_categoria" name="id_categoria" value="{{$curso->id_categoria}}">
                    <div class="form-group">
                        <label for="tarea_fecha_entrega">Fecha y hora de entrega</label>
                        <div class="tarea_fecha_hora">
                            <input required type="date" id="tarea_fecha_entrega" name="tarea_fecha_entrega" class="col-6 form-control" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" step="1">
                            <input required type="time" id="tarea_hora_entrega" name="tarea_hora_entrega" class="col-5 form-control" value="23:59:00" step="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="progress" id="cargando" style="width: 100%; display: none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Subiendo archivo...</div>
                    </div>
                    <div id="tarea-btn-footer">
                        <button type="button" id="tarea-btn-cancelar"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="tarea-btn-enviar" class="btn btn-primary" form="frm_tarea_nueva">Enviar tarea</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Alumnos de la sección -->
<div class="modal fade" id="ALUMNOS-SECCION" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Seleccionar alumnos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @if ($alumnosseccion->count() > 0)
                @foreach ($alumnosseccion as $al)
                    <label class="checkbox checkbox-success">
                        <input type="checkbox" name="alumnos[]" value="{{$al->id_alumno}}" form="frm_tarea_nueva">
                        <span class="hs_capitalize">{{$al->c_nombre}}</span>
                        <span class="checkmark"></span>
                    </label>
                @endforeach
            @else
                <span>No hay alumnos disponibles</span>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Alumnos seleccionados</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal: Detalle de tarea -->
<div class="modal fade" id="DETALLE-TAREA" tabindex="-1" role="dialog" aria-labelledby="DETALLE-TARELabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tarea_details">
                    <div class="tarea_details_title" style="background: {{$curso->col_curso}}">
                        <strong id="dt-title"></strong>
                    </div>
                    <div class="tarea_details_box">
                        <p class="tarea_details_description" id="dt-description"></p>
                        <a class="tarea_details_download" href="#" id="dt-file">Descargar archivo</a>
                        <div class="tarea_details_time">
                            <div class="tarea_details_send">
                                <small><strong>ENVIADO:&nbsp;</strong></small>
                                <small><strong id="dt-send"></strong></small>
                            </div>
                            &nbsp;
                            <div class="tarea_details_end">
                                <small><strong>FECHA DE ENTREGA:&nbsp;</strong></small>
                                <small><strong id="dt-end"></strong></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tarea_comments_write">
                    <div class="tarea_comments_header">
                        <strong>Comentarios</strong>
                    </div>
                    <form action="">
                        <div class="tarea_comments_form">
                            <input type="hidden" id="id_tarea" name="id_tarea" value="">
                            <textarea name="tarea_comentario" id="tarea_comentario" class="tarea_comments_comment_docente" cols="30" rows="10" placeholder="Escribe un comentario"></textarea>
                            <div class="tarea_comments_send_btn" style="background: {{$curso->col_curso}}" onclick="EnviarComentario()">
                                <img class="tarea_comments_send" src="{{asset('assets/images/send.png')}}" alt="Send">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tarea_comments" id="tarea_comments">

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>

<script>

    //Ver detalle de tarea y comentarios
    function VerTarea(id){

        $('#id_tarea').val(id);

        $('#dt-title').text($('#TT-'+id).text());
        $('#dt-description').text($('#TO-'+id).text());

        var link = '/docente/tarea/archivo/'+id;

        $('#dt-file').attr('href', link);
        
        send = $('#TC-'+id).text();
        send2 = send.substr(0, send.length - 3);
        
        end = $('#TE-'+id).text();
        end2 = end.substr(0, end.length - 3);

        $('#dt-send').text(send2);
        $('#dt-end').text(end2);

        MostrarComentarios(id);

        $('#DETALLE-TAREA').modal('show');
    };

    //Optener comentarios
    function MostrarComentarios(id){
        $.ajax({
            url: "/docente/cursos/comentarios",
            type: "GET",  
            data: {id_tarea: id},
            success:function(data){

                if (data.comentarios.length > 0) {
                    Comentarios = '';

                    data.comentarios.forEach(function (comentario, indice) {
                        data.comentarios_docente.forEach(function (comentario_docente, indice) {
                            if (comentario.id_comentario == comentario_docente.id_comentario) {
                                Comentarios += '<div class="tarea_comment c_docente">';
                                    Comentarios += '<div>';
                                        Comentarios += '<div class="tarea_comment_content">';
                                            Comentarios += '<strong class="tarea_comment_autor hs_capitalize">'+ comentario_docente.nom_docente +'</strong>';
                                            Comentarios += '<p class="tarea_comment_text hs_capitalize-first">'+ comentario.c_descripcion +'</p>';
                                        Comentarios += '</div>';
                                        Comentarios += '<div class="text-right">';
                                            Comentarios += '<small class="tarea_comment_time">'+ comentario.created_at +'</small>';
                                        Comentarios += '</div>';
                                    Comentarios += '</div>';
                                Comentarios += '</div>';
                            }
                        });

                        data.comentarios_alumno.forEach(function (comentario_alumno, indice) {
                            if (comentario.id_comentario == comentario_alumno.id_comentario) {
                                Comentarios += '<div class="tarea_comment c_alumno">';
                                    Comentarios += '<div>';
                                        Comentarios += '<div class="tarea_comment_content">';
                                            Comentarios += '<strong class="tarea_comment_autor hs_capitalize">'+ comentario_alumno.nom_alumno +'</strong>';
                                            Comentarios += '<p class="tarea_comment_text hs_capitalize-first">'+ comentario.c_descripcion +'</p>';
                                        Comentarios += '</div>';
                                        Comentarios += '<div class="text-left">';
                                            Comentarios += '<small class="tarea_comment_time">'+ comentario.created_at +'</small>';
                                        Comentarios += '</div>';
                                    Comentarios += '</div>';
                                Comentarios += '</div>';
                            }
                        });
                    });
                } else {
                    Comentarios = 'No hay comentarios en esta tarea';
                }

                $('#tarea_comments').html(Comentarios);
            },
            error: function(){
                alert('Error al leer los comentarios');
            }
        })
    };

    //Nueva tarea
    $('#frm_tarea_nueva').on("submit", function(e){
        e.preventDefault();

        var f = $(this);

        tarea_titu = $("#tarea_titulo").val();
        tarea_fech = $("#tarea_fecha_entrega").val();
        tarea_hora = $("#tarea_hora_entrega").val();

        modal = $('#NUEVA-TAREA');

        if (tarea_titu == '') {
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'Una tarea, necesita un título',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });

            $('#cargando').attr('style', 'display: none;');
        } else {
            if (tarea_fech == '' || tarea_hora == '') {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Necesita establecer una fecha y hora de entrega',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });

                $('#cargando').attr('style', 'display: none;');
            } else {
                var formData = new FormData(document.getElementById("frm_tarea_nueva"));
                formData.append("dato", "valor");

                $('#cargando').attr('style', 'display: block; width: 100%;');
                $('#tarea-btn-footer').hide();

                $.ajax({
                    url: "/docente/cursos/crear_tarea",
                    type: "post",  
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#tareas-reload").load(" #tareas-reload");
                        modal.modal('hide');
                        $('#tarea_titulo').val('');
                        $('#tarea_desc').val('');

                        $('#cargando').attr('style', 'display: none; width: 100%;');
                        $('#tarea-btn-footer').show();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Tarea enviada correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#tarea_arch').value = '';
                    },
                    error: function(){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            text: 'La tarea no pudo ser enviada, vuelva a intentarlo',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        }
    });

    //Crear comentario
    function EnviarComentario(){
        id = $('#id_tarea').val();

        $.ajax({
            url: "/docente/cursos/crear_comentario",
            type: "POST",  
            data: {
                id_tarea:  id,
                c_descripcion: $('#tarea_comentario').val()
            },
            success:function(data){
                $('#tarea_comentario').val('');
                
                MostrarComentarios(id);

                alert('Comentario enviado')
            },
            error: function(){
                alert('Error al leer los comentarios');
            }
        });
    }

    //Validar tamaño de archivo
    $(document).on('change', 'input[type="file"]', function(){
        var file_name = this.files[0].name;
        var file_size = this.files[0].size;

        //256MB
        if (file_size > 256000000) {
            
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'El archivo no debe superar los 256MB',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });

            this.value = '';
            this.files[0].name = '';
        } 
    });

</script>

