@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">   
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}"> 
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
                            <p class="ul-task-manager__paragraph mb-3 text-justify">{{ucfirst($tarea->c_observacion)}}</p>
                            @if(!is_null($tarea->c_url_archivo) && !empty($tarea->c_url_archivo))
                                <h5>Archivo</h5>
                                <p>
                                    <a href="{{url('/docente/tarea/archivo/'.$tarea->id_tarea)}}" class="text-primary" cdownload="{{$tarea->c_url_archivo}}">
                                        Descargar Archivo: {{$tarea->c_url_archivo}}
                                        </a>
                                </p>
                            @endif
                            @if(is_null($tarea->docente->c_foto)  || empty($tarea->docente->c_foto))
                                @if(strtoupper($tarea->docente->c_sexo)=='M')
                                    <img  class="rounded-circle" width="50" height="50" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                                @else
                                    <img class="rounded-circle" width="50" height="50" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                                @endif
                            @else
                                    <img class="rounded-circle" width="50" height="50" src="{{url('super/docente/foto/'.$tarea->docente->c_foto)}}" alt="Foto del docente">
                            @endif
                                {{ucwords(strtolower($tarea->docente->c_nombre))}}
                        </div>
                        <ul class="col-lg-4 col-sm-12 list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right; padding-right: 0;">
                            <li><span class="ul-task-manager__font-date text-muted">{{$tarea->created_at}}</span></li>
                            <li class="dropdown" style="padding-right: 0;">
                                <span class="badge badge-pill badge-danger p-1 m-1" style="margin-right: 0;">{{$tarea->categoria->c_nombre}}</span>
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
                            <strong>Archivo adjunto</strong>
                            <p>
                                <a href="{{url('alumno/tarea/respuestaarchivo/'.$tarea->id_tarea.'/'.$respuesta->id_respuesta)}}" class="text-primary" cdownload="{{$respuesta->c_url_archivo}}">
                                    Descargar archivo {{$respuesta->c_url_archivo}}
                                    </a>
                            </p>
                        @endif

                        <p>
                            {{$respuesta->c_observacion}}
                        </p>
                    </div>

                </div>

                <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                    <span>Fecha de entrega: <span class="font-weight-semibold text-primary">{{$tarea->t_fecha_hora_entrega}}</span></span>
                    <button type="button" class="btn btn-primary float-right" id="btnEditarRespuesta" onclick="fxEditarRespuesta({{$respuesta->id_respuesta}});">Editar respuesta</button>
                </div>
                
                
                <div class="card-body">
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
                                            {{ucwords(strtolower($comentario->comenta->docente->c_nombre))}}
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

                                            {{ucwords(strtolower($comentario->comenta->alumno->c_nombre))}}
                                        @endif
                                        ({{$comentario->created_at}})
                                    </strong>
                                    <p class="comentario-contenido">{{$comentario->c_descripcion}}</p>
                                    </div>
                                @endforeach
                            @endif
                            
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="mdlPresentarTarea" tabindex="-1" role="dialog" aria-labelledby="mdlPresentarTareaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlPresentarTareaLabel">Respuesta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="frmEditarRespuesta" method="post" action="{{url('/alumno/tarea/editarrespuesta')}}" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" id="preid_respuesta" name="preid_respuesta">
                <input type="hidden" id="preid_tarea" name="preid_tarea" value="{{$tarea->id_tarea}}">
                <div class="form-group">
                <input type="file" class="form-control form-control-lg" id="prearchivo" name="prearchivo">
                </div>
                <div class="form-group">
                <textarea name="preobservacion" id="preobservacion" cols="30" rows="10" class="form-control" placeholder="Escribe algo aquí..." required>--</textarea>
                <div class="invalid-feedback">
                    Ingresa algo
                </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" form="frmEditarRespuesta">Presentar tarea</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-js')
<!-- page script -->

<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/alumno/infotareaenviado.js')}}"></script>
@endsection