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
                                @if(!is_null($t->c_url_archivo) && !empty($t->c_url_archivo))
                                <span class="anc-content" id="TA-{{$t->id_tarea}}">
                                  <span class="d-block"><a href="/docente/tarea/archivo/{{$t->id_tarea}}/{{$t->c_url_archivo}}" class="text-primary" cdownload="{{$t->c_url_archivo}}">Descargar Archivo {{$t->c_url_archivo}}</a></span>
                                  @foreach($t->archivos()->where('estado','=',1)->get() as $archivo)
                                      <span class="d-block"><a href="/docente/tarea/archivo/{{$t->id_tarea}}/{{$archivo->c_url_archivo}}" class="text-primary" cdownload="{{$archivo->c_url_archivo}}">Descargar Archivo {{$archivo->c_url_archivo}}</a></span>
                                  @endforeach
                                </span>
                                @endif
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                  <div class="form-group">
                      <label class="switch switch-success mr-3">
                          <span>Adjuntar archivo</span>
                          <input type="checkbox" id="chkConArchivoNuevaTarea">
                          <span class="slider"></span>
                      </label>
                  </div>

                  <div id="divFrmTareaSinArchivo">
                    <form id="frm_tarea_nueva" method="POST" action="{{url('/docente/cursos/crear_tarea')}}" class="needs-validation" novalidate>
                      @csrf
                      <div class="form-group">
                          <label for="tarea_titulo_sin_archivo">Título de tarea</label>
                          <input type="text" id="tarea_titulo_sin_archivo" name="tarea_titulo" class="form-control" required>
                          <span class="invalid-feedback" role="alert">
                              El título es requerido
                          </span>
                      </div>
                      <div class="form-group">
                          <label for="tarea_desc_sin_archivo">Descripción</label>&nbsp;<small>(Opcional)</small>
                          <textarea id="tarea_desc_sin_archivo" name="tarea_desc" cols="30" rows="3" class="form-control" style="resize: none"></textarea>
                      </div>
                      <div class="form-group radio-alumnos" id="divRadioAlumnoSinArchivo">
                          <label class="mr-3">Para&nbsp;</label>
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
                      <input type="hidden" name="id_docente" value="{{$docente->id_docente}}">
                      <input type="hidden" name="id_seccion" value="{{$curso->id_seccion}}">
                      <input type="hidden" name="id_categoria" value="{{$curso->id_categoria}}">
                      <div class="form-group">
                          <label for="tarea_fecha_entrega_sin_archivo">Fecha y hora de entrega</label>
                          <div class="tarea_fecha_hora">
                              <input required type="date" id="tarea_fecha_entrega_sin_archivo" name="tarea_fecha_entrega" class="col-6 form-control" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" step="1">
                              <input required type="time" id="tarea_hora_entrega_sin_archivo" name="tarea_hora_entrega" class="col-5 form-control" value="23:59:00" step="1">
                          </div>
                      </div>
                      </form>
                  </div>
                  <div id="divFrmTareaConArchivo" style="display: none;">
                    <form enctype="multipart/form-data" id="qq-form" class="needs-validation" method="POST" action="{{url('/docente/cursos/tarea/generar')}}" novalidate>
                      @csrf
                      <input type="hidden" name="g_id_tarea" id="gIdTarea" value="">
                      <div class="form-group">
                          <label for="tarea_titulo_con_archivo">Título de tarea</label>
                          <input type="text" id="tarea_titulo_con_archivo" name="tarea_titulo" class="form-control input-modo-con-archivo" required>
                          <span class="invalid-feedback" role="alert">
                              El título es requerido
                          </span>
                      </div>
                      <div class="form-group">
                          <label for="tarea_desc_con_archivo">Descripción</label>&nbsp;<small>(Opcional)</small>
                          <textarea id="tarea_desc_con_archivo" name="tarea_desc" cols="30" rows="3" class="form-control input-modo-con-archivo" style="resize: none"></textarea>
                      </div>
                      <div id="uploader-tarea"></div>
                      <div class="form-group radio-alumnos" id="divRadioAlumnoConArchivo">
                          <label class="mr-3">Para&nbsp;</label>
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
                      <input type="hidden" name="id_docente" value="{{$docente->id_docente}}">
                      <input type="hidden" name="id_seccion" value="{{$curso->id_seccion}}">
                      <input type="hidden" name="id_categoria" value="{{$curso->id_categoria}}">
                      <div class="form-group">
                          <label for="tarea_fecha_entrega_con_archivo">Fecha y hora de entrega</label>
                          <div class="tarea_fecha_hora">
                              <input required type="date" id="tarea_fecha_entrega_con_archivo" name="tarea_fecha_entrega" class="col-6 form-control input-modo-con-archivo" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}" step="1">
                              <input required type="time" id="tarea_hora_entrega_con_archivo" name="tarea_hora_entrega" class="col-5 form-control input-modo-con-archivo" value="23:59:00" step="1">
                          </div>
                      </div>
                      </form>
                  </div>
                </div>
                <div class="modal-footer">
                    <div id="tarea-btn-footer">
                        <button type="button" id="tarea-btn-cancelar"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="tarea-btn-enviar-con-archivo" class="btn btn-primary" form="qq-form" style="display:none;">Enviar tarea</button>
                        <button type="submit" id="tarea-btn-enviar-sin-archivo" class="btn btn-primary" form="frm_tarea_nueva">Enviar tarea</button>
                    </div>
                </div>

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
                <div id="divAlumnosTareaSinArchivo">
                  @foreach ($alumnosseccion as $al)
                      <label class="checkbox checkbox-success">
                          <input type="checkbox" name="alumnos[]" value="{{$al->id_alumno}}" form="frm_tarea_nueva">
                          <span class="hs_capitalize">{{mb_strtolower($al->c_nombre)}}</span>
                          <span class="checkmark"></span>
                      </label>
                  @endforeach
                </div>
                <div id="divAlumnosTareaConArchivo" style="display: none;">
                  @foreach ($alumnosseccion as $al)
                      <label class="checkbox checkbox-success">
                          <input type="checkbox" name="alumnos[]" value="{{$al->id_alumno}}" form="qq-form">
                          <span class="hs_capitalize">{{mb_strtolower($al->c_nombre)}}</span>
                          <span class="checkmark"></span>
                      </label>
                  @endforeach
                </div>
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
    <div class="modal-dialog modal-lg" role="document">
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
                        <div class="tarea_details_download" id="dt-file">
                        </div>
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
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>
<script>
    var uploader = new qq.FineUploader({
        element: document.getElementById('uploader-tarea'),
        thumbnails: {
            placeholders: {
                waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
            }
        },
      validation: {
            //256MB
          sizeLimit: 268435456
      },
        messages: {
            sizeError: '¡{file} es demasiado grande! Sus archivos deben estar restringidos a {sizeLimit} o más pequeños.',
            noFilesError: 'No hay ningun archivo para subir, seleccione un archivo es obligatorio'
        },
        text: {
            failUpload: 'Falló al subir',
            waitingForResponse: 'Subiendo. Espere por favor'
        },
        callbacks: {
            onComplete: function(id,name,responseJSON){
                if(responseJSON.success){
                    $('.input-modo-con-archivo').attr('readonly','true');
                    $('#tarea-btn-enviar-con-archivo').attr('disabled','true');
                    $('#gIdTarea').val(responseJSON.id_tarea);
                }else{
                    $('.input-modo-con-archivo').removeAttr('readonly');
                    $('#tarea-btn-enviar-con-archivo').removeAttr('disabled');
                }
            },
            onAllComplete: function(succeeded,failed) {
                $('#tarea-btn-enviar-con-archivo').attr('disabled','true');
                if(failed.length==0){
                    $.ajax({
                        type: 'POST',
                        url: '/docente/cursos/tarea/confirmar',
                        data: {
                            id_tarea: $('#gIdTarea').val()
                        },
                        error: function(error){
                            alert('Ocurrío un error');
                            console.error(error);
                            location.reload();
                        }
                    }).done(function(data){
                        if(data.correcto){
                            location.reload();
                        }
                    });
                }else{
                    alert('Algo salió mal. Recarga la pagina e intenta de nuevo');
                    location.reload();
                }
            }
        },
        maxConnections: 1,
        autoUpload: false,
        debug: false
    });
  $(document).ready(function(){
    $('#chkConArchivoNuevaTarea').on('change',function(){
      if($(this).prop('checked')){
        $('#divFrmTareaSinArchivo').attr('style','display: none;');
        $('#tarea-btn-enviar-sin-archivo').attr('style','display: none;');
        $('#tarea-btn-enviar-con-archivo').show();
        $('#divAlumnosTareaSinArchivo').attr('style','display: none;');
        $('#divAlumnosTareaConArchivo').show();
        $('#divFrmTareaConArchivo').show();
      }else{
        $('#divFrmTareaConArchivo').attr('style','display: none;');
        $('#tarea-btn-enviar-con-archivo').attr('style','display: none;');
        $('#tarea-btn-enviar-sin-archivo').show();
        $('#divAlumnosTareaConArchivo').attr('style','display: none;');
        $('#divAlumnosTareaSinArchivo').show();
        $('#divFrmTareaSinArchivo').show();
      }
    });

    $('#tarea_titulo_sin_archivo').on('change',function(){
      $('#tarea_titulo_con_archivo').val($(this).val());
    });
    $('#tarea_titulo_con_archivo').on('change',function(){
        $('#tarea_titulo_sin_archivo').val($(this).val());
    });

    $('#tarea_desc_sin_archivo').on('change',function(){
      $('#tarea_desc_con_archivo').val($(this).val());
    });
    $('#tarea_desc_con_archivo').on('change',function(){
      $('#tarea_desc_sin_archivo').val($(this).val());
    });
  });
    //Ver detalle de tarea y comentarios
    function VerTarea(id){

        $('#id_tarea').val(id);

        $('#dt-title').text($('#TT-'+id).text());
        $('#dt-description').text($('#TO-'+id).text());
        //verificamos si la tarea tiene archivos
        if($('#TA-'+id).length>0){
            $('#dt-file').html($('#TA-'+id).html());
        }else{
            $('#dt-file').html('')
        }
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

        tarea_titu = $("#tarea_titulo_sin_archivo").val();
        tarea_fech = $("#tarea_fecha_entrega_sin_archivo").val();
        tarea_hora = $("#tarea_hora_entrega_sin_archivo").val();

        modal = $('#NUEVA-TAREA');

        if (tarea_titu == '') {
            Swal.fire({
                position: 'center',
                icon: 'info',
                text: 'Una tarea, necesita un título',
                showConfirmButton: true,
                confirmButtonColor: '#3498db'
            });
        } else {
            if (tarea_fech == '' || tarea_hora == '') {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'Necesita establecer una fecha y hora de entrega',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
            } else {
                var formData = new FormData(document.getElementById("frm_tarea_nueva"));
                formData.append("dato", "valor");
                $('#tarea-btn-footer').hide();

                $.ajax({
                    url: "/docente/cursos/crear_tarea",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $("#tareas-reload").load(" #tareas-reload");
                        modal.modal('hide');
                        $('#tarea_titulo_sin_archivo').val('');
                        $('#tarea_desc_sin_archivo').val('');
                        $('#tarea-btn-footer').show();

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Tarea enviada correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
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
