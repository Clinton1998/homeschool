@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
    <link  rel="stylesheet" href="{{asset('fine-uploader/fine-uploader-new.css')}}">
    <script src="{{asset('fine-uploader/fine-uploader.js')}}"></script>
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Seleccionar archivos</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>Procesando archivos caídos...</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Quitar</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Reintentar</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Eliminar</button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Sí</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancelar</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
@endsection

@section('main-content')
<section class="contact-list">
    <div class="row">
        <div class="col-xs-12 col-md-6 offset-md-3 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="" style="display: flex; flex-wrap: wrap;">
                        <div class="col-lg-8 col-sm-12" style="padding-left: 0;">
                            <h4 class="hs_upper">{{$tarea->c_titulo}}</h4>
                            <p class="ul-task-manager__paragraph mb-3 text-justify hs_capitalize-first">{{$tarea->c_observacion}}</p>
                            @if(!is_null($tarea->c_url_archivo) && !empty($tarea->c_url_archivo))
                                <h5>Archivos adjuntos</h5>
                                  <span class="d-block">
                                    <a href="{{url('/docente/tarea/archivo/'.$tarea->id_tarea.'/'.$tarea->c_url_archivo)}}" class="text-primary" cdownload="{{$tarea->c_url_archivo}}">
                                        Descargar Archivo {{$tarea->c_url_archivo}}
                                        </a>
                                  </span>
                                  @foreach($tarea->archivos()->where('estado','=',1)->get() as $archivo)
                                    <span class="d-block">
                                      <a href="{{url('/docente/tarea/archivo/'.$tarea->id_tarea.'/'.$archivo->c_url_archivo)}}" class="text-primary" cdownload="{{$archivo->c_url_archivo}}">
                                          Descargar Archivo {{$archivo->c_url_archivo}}
                                          </a>
                                    </span>
                                  @endforeach
                            @endif
                            @if(is_null($tarea->docente->c_foto)  || empty($tarea->docente->c_foto))
                                @if(strtoupper($tarea->docente->c_sexo)=='M')
                                    <img  class="rounded-circle" width="50" height="50" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Docente">
                                @else
                                    <img class="rounded-circle" width="50" height="50" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Docente">
                                @endif
                            @else
                                    <img class="rounded-circle" width="50" height="50" src="{{url('super/docente/foto/'.$tarea->docente->c_foto)}}" alt="Docente">
                            @endif
                                <span class="hs_capitalize">{{mb_strtolower($tarea->docente->c_nombre)}}</span>
                        </div>
                        <ul class="col-lg-4 col-sm-12 list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right; padding-right: 0;">
                            <li><span class="ul-task-manager__font-date text-muted">{{$tarea->created_at}}</span></li>
                            <li class="dropdown" style="padding-right: 0;">
                                <span class="badge badge-pill badge-danger p-1 m-1" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}}">{{$tarea->categoria->c_nombre}}</span>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div>
                        <h5><strong>Respuesta</strong></h5>
                        @php
                            $alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
                            $puente = DB::table('alumno_tarea_respuesta_p')->select('id_respuesta')->where([
                                'id_tarea' => $tarea->id_tarea,
                                'id_alumno' => $alumno->id_alumno
                            ])->first();

                            $respuesta = App\Respuesta_d::findOrFail($puente->id_respuesta);
                        @endphp

                        @if(!is_null($respuesta->c_url_archivo) && !empty($respuesta->c_url_archivo))
                              <strong>Archivos adjuntos</strong>
                              <span class="d-block">
                                    <a href="{{url('alumno/tarea/respuestaarchivo/'.$tarea->id_tarea.'/'.$respuesta->id_respuesta.'/'.$respuesta->c_url_archivo)}}" class="text-primary" cdownload="{{$respuesta->c_url_archivo}}">
                                    Descargar archivo {{$respuesta->c_url_archivo}}
                                    </a>
                              </span>
                              @foreach($respuesta->archivos()->where('estado','=',1)->get() as $archivo)
                              <span class="d-block">
                                    <a href="{{url('alumno/tarea/respuestaarchivo/'.$tarea->id_tarea.'/'.$respuesta->id_respuesta.'/'.$archivo->c_url_archivo)}}" class="text-primary" cdownload="{{$archivo->c_url_archivo}}">
                                    Descargar archivo {{$archivo->c_url_archivo}}
                                    </a>
                              </span>
                              @endforeach
                        @endif
                        <p>
                            {{$respuesta->c_observacion}}
                        </p>
                    </div>

                </div>

                <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                    <span>Fecha de entrega: <span class="font-weight-semibold text-primary">{{$tarea->t_fecha_hora_entrega}}</span></span>
                    @if(!($tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s')))
                        <button type="button" class="btn btn-primary float-right" id="btnEditarRespuesta"  data-toggle="modal" data-target="#mdlPresentarTarea">Editar respuesta</button>
                    @endif
                </div>

                <div class="card-body" id="vue-comentario">
                  <comment-app :task="{{$tarea}}" :user="{{Auth::user()}}" :comentar="'enviado'" ></comment-app>
                </div>


                <!--<div class="card-body">
                    <strong>Comentario</strong>

                    <form id="frmComentarTarea" method="post" action="{{url('/alumno/tarea/comentarenviado')}}" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="id_tarea" value="{{$tarea->id_tarea}}">
                        <input class="form-control form-control-lg mb-6" id="txtComentario" name="comentario" rows="2" placeholder="Escribe aquí..." required autofocus>
                        <div class="mb-4">
                            <br>
                        <button type="submit" class="btn btn-primary float-right">Publicar comentario</button>
                        </div>
                    </form>

                    <br>
                    <h5 class=""><strong>Comentarios recientes</strong></h5>

                    <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                        <div class="caja-comentarios">
                            @if($tarea->comentarios()->count()<=0)
                                <h4 class="text-secondary">Sin comentarios</h4>
                            @else
                                @foreach($tarea->comentarios()->orderBy('created_at','DESC')->get() as $comentario)
                                    <div class="comentario mb-4">
                                    <strong class="comentario-persona">
                                        @if(!is_null($comentario->comenta->id_docente))
                                            @if(is_null($comentario->comenta->docente->c_foto)  || empty($comentario->comenta->docente->c_foto))
                                                @if(strtoupper($comentario->comenta->docente->c_sexo)=='M')
                                                <img  class="rounded-circle" width="36" height="36" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Fotografía">
                                                @else
                                                <img class="rounded-circle" width="36" height="36" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Fotografía">
                                                @endif
                                            @else
                                                <img class="rounded-circle" width="36" height="36" src="{{url('super/docente/foto/'.$comentario->comenta->docente->c_foto)}}" alt="Fotografía">
                                            @endif
                                            <span class="hs_capitalize">{{$comentario->comenta->docente->c_nombre}}</span>
                                        @else
                                            @if(is_null($comentario->comenta->alumno->c_foto)  || empty($comentario->comenta->alumno->c_foto))
                                                @if(strtoupper($comentario->comenta->alumno->c_sexo)=='M')
                                                    <img class="rounded-circle" width="36" height="36"  src="{{asset('assets/images/usuario/studentman.png')}}" alt="Fotografía">
                                                @else
                                                    <img class="rounded-circle" width="36" height="36"  src="{{asset('assets/images/usuario/studentwoman.png')}}" alt="Fotografía">
                                                @endif
                                            @else
                                                <img class="rounded-circle" width="36" height="36"  src="{{url('super/alumno/foto/'.$comentario->comenta->alumno->c_foto)}}" alt="Fotografía">
                                            @endif

                                            <span class="hs_capitalize">{{$comentario->comenta->alumno->c_nombre}}</span>
                                        @endif
                                        ({{$comentario->created_at}})
                                    </strong>
                                    <p class="comentario-contenido">{{$comentario->c_descripcion}}</p>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>-->


            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="mdlPresentarTarea" tabindex="-1" role="dialog" aria-labelledby="mdlPresentarTareaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlPresentarTareaLabel">Respuesta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label class="switch switch-success mr-3">
                  <span>Adjuntar archivo</span>
                  <input type="checkbox" id="chkConArchivoRespuesta">
                  <span class="slider"></span>
              </label>
          </div>
          <div id="divFrmRespuestaSinArchivo">
            <form id="frmEditarRespuesta" method="post" action="{{url('/alumno/tarea/editarrespuesta')}}" class="needs-validation" novalidate>
                @csrf
                @error('preobservacion')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{$message}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @enderror
                <input type="hidden" name="preid_respuesta" value="{{$respuesta->id_respuesta}}">
                <input type="hidden" name="preid_tarea" value="{{$tarea->id_tarea}}">
                <div class="form-group">
                  <textarea name="preobservacion" id="preobservacionSinArchivo" cols="30" rows="5" class="form-control" placeholder="Escribe algo aquí..." required></textarea>
                  <div class="invalid-feedback">
                      Ingresa algo
                  </div>
                </div>
            </form>
          </div>

          <div id="divFrmRespuestaConArchivo" style="display: none;">
            <form id="qq-form" method="post" action="{{url('/alumno/tarea/respuesta/editargenerado')}}" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                @error('preobservacion')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{$message}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @enderror
                <input type="hidden" name="g_id_respuesta" id="gIdRepsuesta" value="">
                <input type="hidden" name="preid_respuesta" id="inpIdRespuestaConArchivo" value="{{$respuesta->id_respuesta}}">
                <input type="hidden" name="preid_tarea" id="inpIdTareaConArchivo" value="{{$tarea->id_tarea}}">
                <div class="form-group">
                  <textarea name="preobservacion" id="preobservacionConArchivo" cols="30" rows="3" class="form-control input-modo-con-archivo" placeholder="Escribe algo aquí..." required></textarea>
                  <div class="invalid-feedback">
                      Ingresa algo
                  </div>
                </div>
                <div id="uploader-respuesta"></div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnSubEditarRespuestaConArchivo" form="qq-form" style="display: none;">Presentar tarea</button>
          <button type="submit" class="btn btn-primary" id="btnSubEditarRespuestaSinArchivo" form="frmEditarRespuesta">Presentar tarea</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-js')
  @if($errors->has('preobservacion') || $errors->has('prearchivo'))
    <script>
        $('#mdlPresentarTarea').modal('show');
    </script>
  @endif
  <!-- page script -->
  <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
  <script src="{{asset('assets/js/alumno/infotareaenviado.js')}}"></script>
  <script>
      var uploader = new qq.FineUploader({
          element: document.getElementById('uploader-respuesta'),
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
                      $('#btnSubEditarRespuestaConArchivo').attr('disabled','true');
                      $('#gIdRepsuesta').val(responseJSON.id_respuesta);
                  }else{
                      $('.input-modo-con-archivo').removeAttr('readonly');
                      $('#btnSubEditarRespuestaConArchivo').removeAttr('disabled');
                  }
              },
              onAllComplete: function(succeeded,failed) {
                  $('#btnSubEditarRespuestaConArchivo').attr('disabled','true');
                  if(failed.length==0){
                      $.ajax({
                          type: 'POST',
                          url: '/alumno/tarea/respuesta/confirmaredicion',
                          data: {
                              id_tarea: $('#inpIdTareaConArchivo').val(),
                              id_respuesta: $('#inpIdRespuestaConArchivo').val()
                          },
                          error: function(error){
                              alert('Ocurrío un error');
                              console.error(error);
                              location.reload();
                          }
                      }).done(function(data){
                          if(data.correcto){
                            location.reload();
                          }else{
                            alert('Algo salió mal. Recarga la pagina e intenta de nuevo');
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
  </script>
@endsection
