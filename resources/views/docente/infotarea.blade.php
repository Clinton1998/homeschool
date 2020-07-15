@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}">
@endsection

@section('main-content')
    @php
            $countEnviaron = 0;
            $countNoEnviaron = 0;
            foreach($tarea->alumnos_asignados as $alumno){
                if(is_null($alumno->pivot->id_respuesta)){
                    $countNoEnviaron++;
                }else{
                    $countEnviaron++;
                }
            }
    @endphp
<section class="contact-list">
    <div class="row">

        <div class="col-xs-12 col-md-6 offset-md-3">

            <div class="card mb-4">
                <div class="card-body">
                    <h6>{{substr($seccion_asignada->grado->c_nombre,3)}} "{{$seccion_asignada->c_nombre}}" {{$seccion_asignada->grado->c_nivel_academico}}</h6>
                    <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                        <div>
                        <h4 class="hs_upper">{{$tarea->c_titulo}}</h4>
                        <p class="hs_capitalize-first ul-task-manager__paragraph mb-3 text-justify">{{$tarea->c_observacion}}</p>
                        @if(!is_null($tarea->c_url_archivo) && !empty($tarea->c_url_archivo))
                            <strong>Archivos adjuntos</strong>
                            <span class="d-block">
                              <a href="{{url('/docente/tarea/archivo/'.$tarea->id_tarea.'/'.$tarea->c_url_archivo)}}" class="text-primary" cdownload="{{$tarea->c_url_archivo}}">
                                      Descargar Archivo {{$tarea->c_url_archivo}}
                                      </a>
                            </span>
                            @foreach($tarea->archivos()->where('estado','=',1)->get() as $archivo)
                                <span class="d-block"> <a href="{{url('/docente/tarea/archivo/'.$tarea->id_tarea.'/'.$archivo->c_url_archivo)}}" class="text-primary" cdownload="{{$archivo->c_url_archivo}}">
                                  Descargar Archivo {{$archivo->c_url_archivo}}
                                </a> </span>
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

                        <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right;">
                            <li><span class="ul-task-manager__font-date text-muted">{{$tarea->created_at}}</span></li>
                            <li class="dropdown">
                                <span style="padding: 5px 10px; color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};" class="hs_capitalize badge m-1">{{$tarea->categoria->c_nombre}}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                    <span>Fecha de entrega: <span class="font-weight-semibold text-primary">{{$tarea->t_fecha_hora_entrega}}</span></span>
                    @if($tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s'))
                        <a href="/docente/estadotareas" class="btn btn-primary btn-sm">Ver respuestas</a>
                    @endif
                </div>

            @if(!($tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s')))
                    <div class="accordion" id="accordionRightIcon">
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-1" aria-expanded="false">
                                        Enviaron
                                        <span class="badge-alumnos-que-enviaron badge badge-pill badge-outline-success" id="badgeEnviaron">{{$countEnviaron}}</span>
                                    </a>
                                </h6>
                            </div>
                            <div id="lista-pendientes-1" class="collapse " data-parent="#accordionRightIcon" style="">
                                <div class="card-body">
                                    <ul id="alumnos-que-enviaron" class="contenedor-scroll list-group">
                                        @foreach($tarea->alumnos_asignados as $alumno)
                                            @if(!is_null($alumno->pivot->id_respuesta))
                                                @if(!($alumno->pivot->c_estado=='ACAL'))
                                                    <li class="tarea-pendiente-alumno list-group-item">{{$alumno->c_nombre}}
                                                        <a href="#" class="badge badge-success p-2" style="margin-left: 5px;" onclick="fxAplicarRespuesta({{$alumno->pivot->id_alumno_docente_tarea}},event);">Ver respuesta
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-2" aria-expanded="false">
                                        No enviaron
                                        <span class="badge-alumnos-que-no-enviaron badge badge-pill badge-outline-danger" id="badgeNoEnviaron">{{$countNoEnviaron}}</span>
                                    </a>
                                </h6>
                            </div>
                            <div id="lista-pendientes-2" class="collapse " data-parent="#accordionRightIcon" style="">
                                <div class="card-body">
                                    <ul id="alumnos-que-no-enviaron" class="contenedor-scroll list-group">
                                        @foreach($tarea->alumnos_asignados as $alumno)
                                            @if(is_null($alumno->pivot->id_respuesta))
                                                <li class="tarea-pendiente-alumno list-group-item">{{$alumno->c_nombre}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif
                <div class="card-body" id="vue-comentario">
                  <comment-app :task="{{$tarea}}" :user="{{Auth::user()}}"></comment-app>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal" id="modal-tarea-pendiente-revisar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Respuesta a la tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinnerRespuestaDeTarea" style="display: none;">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>

                <div id="divRespuestaTarea" style="display: none;">
                  <div class="alert alert-info" role="alert">
                    La respuesta podrá calificarse después del minuto cumplido de la fecha <span id="spnFechaEntregaTarea">{{$tarea->t_fecha_hora_entrega}}</span>
                  </div>

                  <strong>Respuesta</strong>
                  <div class="tarea-pendiente-respuesta">
                    <p id="respuestaObservacion"></p>
                  </div>

                  <strong>Archivos adjuntos</strong>
                  <div class="tarea-pendiente-respuesta" id="divArchivosRespuesta">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
<script src="{{asset('assets/js/docente/infotarea.js')}}"></script>
@endsection
