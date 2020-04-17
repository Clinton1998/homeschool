@extends('reutilizable.principal')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style.css')}}">
</head>

<body>
    <h3 class="titulo">ESTADO DE TAREAS</h3>
    
    <div class="contenedor-estado-tareas row">
        <div id="panel-estado-de-tareas" class="col-md-6">
            <div class="card text-left">
                <div class="card-body">
    
                    <!-- Título de pestañas -->
                    <ul class="pestanas nav nav-pills" id="myPillTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " id="home-icon-pill" data-toggle="pill" href="#tareas-enviadas" role="tab" aria-controls="homePIll" aria-selected="false">
                                Enviadas
                                <span class="badge  badge-round-light">{{$tareas_enviadas->count()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-icon-pill" data-toggle="pill" href="#tareas-calificadas" role="tab" aria-controls="profilePIll" aria-selected="false">
                                Calificadas
                                <span class="badge  badge-round-light">{{$tareas_calificadas->count()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="contact-icon-pill" data-toggle="pill" href="#tareas-pendientes" role="tab" aria-controls="contactPIll" aria-selected="true">
                                Pendientes
                                <span class="badge  badge-round-danger">{{$tareas_pendientes_por_calificar->count()}}</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Contenido de pestañas -->

                    <div class="tab-content" id="myPillTabContent">
                        
                        <div class="tab-pane fade " id="tareas-enviadas" role="tabpanel" aria-labelledby="home-icon-pill">
                            
                            @if($tareas_enviadas->count()<=0)
                                <h4 class="text-primary">No hay enviados</h4>
                            @else
                                @foreach($tareas_enviadas as $tarea)
                                    <!-- Card -->
                                    <div class="card card-tarea">
                                    <div class="card-body">
                                    <h6 class="mb-3">{{$tarea->c_titulo}}</h6>
                                    <p class="text-20 text-warning line-height-1 mb-3"><i class="i-Arrow-Up-in-Circle"></i> Enviado</p>
                                    <small class="text-muted">Fecha de envio: {{$tarea->created_at}}</small>
                                    </div>
                                    </div>
                                @endforeach
                            @endif                            
                        </div>

                        <div class="tab-pane fade " id="tareas-calificadas" role="tabpanel" aria-labelledby="profile-icon-pill">

                            @if($tareas_calificadas->count()<=0)
                                <h4 class="text-primary">No hay calificados</h4>
                            @else
                                @foreach($tareas_calificadas as $tarea)
                                    <!-- Card -->
                                    <div class="card card-tarea">
                                    <div class="card-body">
                                    <h6 class="mb-3">{{$tarea->c_titulo}}</h6>
                                    <p class="text-20 text-success line-height-1 mb-3"><i class="i-Arrow-Down-in-Circle"></i> Calificado</p>
                                    <small class="text-muted">Fecha de calificación: {{$tarea->updated_at}}</small>
                                    </div>
                                    </div>
                                @endforeach
                            @endif
                            
                            

                        </div>

                        <div class="tab-pane fade show active" id="tareas-pendientes" role="tabpanel" aria-labelledby="contact-icon-pill">
                            <!-- Card -->
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
                                    <div class="card-tarea card" id="cardTareaPendiente{{$tarea->id_tarea}}" onclick="fxAplicarTarea({{$tarea->id_tarea}});">
                                        <div class="card-body">
                                            <h6 class="mb-2 text-muted">
                                                <span class="badge badge-success w-badge">{{$tarea->categoria->c_nombre}}</span>
                                                {{$tarea->c_titulo}}
                                            </h6>
                                            <p class="mb-1 text-22 font-weight-light">{{$porcentaje_revision}}%</p>
                                            <div class="progress mb-1" style="height: 4px">
                                            <div class="progress-bar bg-danger" style="width: {{$porcentaje_revision}}%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small class="text-muted">Estado de revisión</small>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div id="panel-pendientes-detalle" class="mostrar-panel col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="text-center" id="spinnerInfoTarea" style="display:block;">
                        <div class="spinner-bubble spinner-bubble-primary m-5"></div>
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
                            <span class="badge badge-success w-badge" id="spanCategoria"></span>
                            <span class="badge badge-info w-badge" id="spanRevisados">Revisados: <span id="spnNRevisados"></span> de <span id="spnNTotales"></span></span>
                        </div>
                        <h4 style="margin-top: 10px;" id="nombreTarea"></h4>
                        <p id="observacionTarea"></p>

                        <!--<h1>Archivo subido</h1>-->

                        <hr>
                        
                        <!--<div class="panel-botonera">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="CerrarPanel()">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-primary">Guardar cambios</button>   
                        </div>-->
    
                        <!-- right control icon -->
                        <div class="accordion" id="accordionRightIcon">
                            <div class="card">
                                <!-- Lista de alumnos que cumplieron la tarea -->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-1" aria-expanded="false">
                                            Enviaron
                                            <span class="badge badge-pill badge-outline-success" id="badgeEnviaron">{n}</span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-pendientes-1" class="collapse " data-parent="#lista-pendientes-1" style="">
                                    <div class="card-body">
                                        <ul class="list-group" id="listEnviaron">
                                            <li class="tarea-pendiente-alumno list-group-item">
                                                {nombre-de-alumno}
                                                <span class="btn-revisar badge badge-light m-2" onclick="">Revisado</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Lista de alumnos que NO cumplieron la tarea -->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-2" aria-expanded="false">
                                            No enviaron
                                            <span class="badge badge-pill badge-outline-danger" id="badgeNoEnviaron">{n}</span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-pendientes-2" class="collapse " data-parent="#lista-pendientes-2" style="">
                                    <div class="card-body">
                                        <ul class="list-group" id="ListNoEnviaron">
                                            <li class="list-group-item">
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

    <!-- Modal -->
    <div class="modal fade" id="modal-tarea-pendiente-revisar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Respuesta a la tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Respuesta</strong>
                    <div class="tarea-pendiente-respuesta">
                        <p>{Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem quisquam error aperiam asperiores quasi praesentium at cupiditate tempore neque ullam! Ipsam accusamus iusto omnis aliquam voluptate ducimus totam consectetur reprehenderit.}</p>
                    </div>
                    <strong>Archivo adjunto</strong>
                    <div class="tarea-pendiente-respuesta">
                        <p>{No hay archivos adjuntos}</p>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-default">Calificación</span>
                        </div>
                        <input type="text" id="txtCalificacion" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <br>
                    <strong>Comentario u observación</strong>
                    <div class="form-group">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="(Opcional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Tarea revisada</button>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection
@section('page-js')
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/docente/estadotareas.js')}}"></script>
@endsection