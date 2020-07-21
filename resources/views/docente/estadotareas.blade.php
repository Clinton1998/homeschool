@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection
@section('main-content')
<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}">
</head>
<body>
    <h2 class="titulo">Estado de tareas</h2>

    <div class="contenedor-estado-tareas row">
        <div id="panel-estado-de-tareas" class="col-md-6">
            <div class="card text-left">
                <div class="card-body">

                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">
                            </h3>
                        </div>
                        <div class="ul-widget__head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line ul-widget-nav-tabs-line"
                                role="tablist">
                                <li class="nav-item">
                                    <a onclick="CerrarPanel()" class="nav-link" data-toggle="tab" href="#tareas-enviadas"
                                        role="tab">
                                        Enviados
                                        <span style="font-size: 13px" class="badge-enviadas badge  badge-square-warning">{{$tareas_enviadas->count()}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tareas-pendientes"
                                        role="tab">
                                        Por Calificar
                                        <span style="font-size: 13px" class="badge-pendientes badge  badge-square-danger">{{$tareas_pendientes_por_calificar->count()}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tareas-calificadas"
                                        role="tab">
                                        Calificados
                                        <span style="font-size: 13px" class="badge-calificadas badge  badge-square-success">{{$tareas_calificadas->count()}}</span>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ul-widget__body">
                        <div class="contenedor-scroll tab-content">
                            <div class="tab-pane " id="tareas-enviadas">
                                @if($tareas_enviadas->count()<=0)
                                    <h4 class="text-primary">No hay enviados</h4>
                                @else
                                    @foreach($tareas_enviadas as $tarea)
                                        <div class="card card-tarea" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="mb-3 hs_upper">{{$tarea->c_titulo}}</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span class="badge badge-secondary p-2 hs_capitalize" style="font-size: 11px; color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                    </div>
                                                </div>
                                                <p class="text-20 text-warning line-height-1 mb-3"><i class="i-Arrow-Up-in-Circle"></i> Enviado</p>
                                                <small class="text-muted">Fecha de envio: {{$tarea->created_at}}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="tab-pane" id="tareas-calificadas">
                                @if($tareas_calificadas->count()<=0)
                                    <h4 class="text-primary">No hay calificados</h4>
                                @else
                                    @foreach($tareas_calificadas as $tarea)
                                        <!-- Card -->
                                        <div class="card card-tarea" id="cardTareaCalificada{{$tarea->id_tarea}}"  onclick="fxAplicarTarea({{$tarea->id_tarea}})">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="hs_upper">{{$tarea->c_titulo}}</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span class="badge badge-secondary p-2 hs_capitalize" style="font-size: 11px;; color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                    </div>
                                                </div>
                                                <p class="text-20 text-success line-height-1 mb-3"><i class="i-Arrow-Down-in-Circle"></i> Calificado</p>
                                                <small class="text-muted">Fecha de calificación: {{$tarea->updated_at}}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="tab-pane active" id="tareas-pendientes">
                                @if($tareas_pendientes_por_calificar->count()<=0)
                                <h4 class="text-primary">No hay nada para revisar</h4>
                                @else
                                    @foreach($tareas_pendientes_por_calificar as $tarea)
                                        @php
                                            //proceso para determinar el porcentaje de revision
                                            $alumnos_de_tarea = $tarea->alumnos_asignados;
                                            //porcentaje de revision
                                            $porcentaje_revision = 0;
                                            //contador de alumnos revisados
                                            $count_revisados = 0;
                                            $total = 0;
                                            foreach($alumnos_de_tarea as $alumno){
                                                if(!is_null($alumno->pivot->id_respuesta)){
                                                    $total++;
                                                    if(strtoupper($alumno->pivot->c_estado)=='ACAL'){
                                                    $count_revisados++;
                                                }
                                                }
                                            }
                                            if($count_revisados>0){
                                                $porcentaje_revision = (100*$count_revisados)/($total);
                                            }
                                        @endphp
                                        <!-- Card -->
                                        <div class="card-tarea card" id="cardTareaPendiente{{$tarea->id_tarea}}" onclick="fxAplicarTarea({{$tarea->id_tarea}})">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="hs_upper">{{$tarea->c_titulo}}</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span class="badge badge-secondary p-2 hs_capitalize" style="font-size: 11px; color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                    </div>
                                                </div>

                                                <p class="mb-1 text-22 font-weight-light">{{$porcentaje_revision}}%</p>
                                                <div class="progress mb-1" style="height: 4px">
                                                <div class="progress-bar bg-danger" style="width: {{$porcentaje_revision}}%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                                </div>
                                                <small class="text-muted">
                                                Calificados: {{$count_revisados}}  |  Por calificar: {{$total-$count_revisados}}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="panel-pendientes-detalle" class="mostrar-panel col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="text-center" id="spinnerInfoTarea" style="display:block;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>

                    <div id="divInfoTarea" style="display: none;">
                        <div class="cerrar-panel" onclick="CerrarPanel()">
                            <span>
                                <svg class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                        <div>
                            <span class="badge w-badge" id="spanCategoria">{categoria}</span>
                        </div>
                        <h4 style="margin-top: 10px;" id="nombreTarea" class="hs_upper"></h4>
                        <p id="observacionTarea" class="hs_capitalize-first"></p>
                        <div id="archivoTarea" class="hs_capitalize-first"></div>

                        <div class="accordion" id="accordionRightIcon">
                            <div class="card">
                                <!-- Lista de alumnos que cumplieron la tarea a tiempo -->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-1" aria-expanded="false">
                                            Enviaron a tiempo
                                            <span class="badge-alumnos-que-enviaron badge badge-pill badge-outline-success" id="badgeEnviaron"></span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-pendientes-1" class="collapse " data-parent="#accordionRightIcon" style="">
                                    <div class="card-body">
                                        <ul id="alumnos-que-enviaron" class="contenedor-scroll list-group">
                                            <!-- CUANDO FALTA REVISAR LA TAREA -->
                                            <li class="tarea-pendiente-alumno list-group-item hs_capitalize" >
                                                {nombre-de-alumno}
                                                <a href="#" class="badge badge-success" style="margin-left: 5px;">
                                                    Revisarxd
                                                </a>
                                            </li>

                                            <!-- CUANDO YA SE HA REVISADO LA TAREA -->
                                            <li class="tarea-pendiente-alumno list-group-item hs_capitalize">
                                                {nombre-de-alumno}
                                                <span class="btn-revisar badge badge-light" style="margin: auto 5px;">Revisado</span>
                                                <a href="#" class="badge badge-warning" >
                                                    <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <!--enviaron la tarea fuera de plazo-->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-fuera-de-plazo" aria-expanded="false">
                                            Enviaron tarde
                                            <span class="badge-alumnos-que-enviaron badge badge-pill badge-outline-warning" id="badgeFueraDePlazo">1</span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-fuera-de-plazo" class="collapse " data-parent="#accordionRightIcon" style="">
                                    <div class="card-body">
                                        <ul id="alumnos-que-enviaron-fuera-de-plazo" class="contenedor-scroll list-group">
                                            <!-- CUANDO FALTA REVISAR LA TAREA -->
                                            <li class="tarea-pendiente-alumno list-group-item hs_capitalize" >
                                                {nombre-de-alumno}
                                                <a href="#" class="badge badge-success" style="margin-left: 5px;">
                                                    Revisarxd
                                                </a>
                                            </li>

                                            <!-- CUANDO YA SE HA REVISADO LA TAREA -->
                                            <li class="tarea-pendiente-alumno list-group-item hs_capitalize">
                                                {nombre-de-alumno}
                                                <span class="btn-revisar badge badge-light" style="margin: auto 5px;">Revisado</span>
                                                <a href="#" class="badge badge-warning" >
                                                    <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <!--endTareaEnviadaFueraDePlazo-->

                                <!-- Lista de alumnos que NO cumplieron la tarea -->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-2" aria-expanded="false">
                                            No enviaron
                                            <span class="badge-alumnos-que-no-enviaron badge badge-pill badge-outline-danger" id="badgeNoEnviaron"></span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-pendientes-2" class="collapse " data-parent="#accordionRightIcon" style="">
                                    <div class="card-body">
                                        <ul id="alumnos-que-no-enviaron" class="contenedor-scroll list-group">
                                            <li class="tarea-pendiente-alumno list-group-item hs_capitalize">
                                                {nombre-de-alumno}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Detalle de Tareas CALIFICADAS y PENDIENTEs -->
    <div class="modal fade" id="modal-tarea-pendiente-revisar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Respuesta a la tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="text-center" id="spinnerInfoTareaPendiente" style="display: none;">
                      <div class="spinner-bubble spinner-bubble-light m-5"></div>
                  </div>
                  <div id="divFrmTareaPendiente" style="display: none;">
                    <form  id="frmCalificarTareaDeAlumno" method="POST" action="{{ url('/docente/tarea/calificarrespuesta') }}">
                        @csrf
                        <input type="hidden" id="id_puente" name="id_puente">
                        <strong>Respuesta</strong>
                        <div class="tarea-pendiente-respuesta">
                            <p id="respuestaObservacion"></p>
                        </div>
                        <strong>Archivo adjunto</strong>
                        <div class="tarea-pendiente-respuesta" id="divRespuestaArchivos">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroup-sizing-default">Calificación</span>
                            </div>
                            <input type="text" id="txtCalificacion" name="calificacion" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <br>
                        <strong>Comentario u observación</strong>
                        <div class="form-group">
                            <textarea class="form-control" id="txtComentario"  name="comentario_calificacion" rows="3" placeholder="(Opcional)"></textarea>
                        </div>
                      </form>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fxConfirmarRevision(event);">Tarea revisada</button>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection

@section('page-js')
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/docente/estadotareas.js')}}"></script>
@endsection
