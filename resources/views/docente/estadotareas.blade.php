@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection
@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style.css')}}">
</head>

<body>
    <h3 class="titulo">ESTADO DE TAREAS</h3>
    
    <div class="contenedor-estado-tareas row">
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
                            <span class="badge badge-success w-badge" id="spanCategoria">{categoria}</span>
                        </div>
                        <h4 style="margin-top: 10px;" id="nombreTarea"></h4>
                        <p id="observacionTarea"></p>
                        
                        <!--<div class="panel-botonera">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="CerrarPanel()">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-primary">Guardar cambios</button>   
                        </div>-->
    
                        <div class="accordion" id="accordionRightIcon">
                            <div class="card">
                                <!-- Lista de alumnos que cumplieron la tarea -->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-1" aria-expanded="false">
                                            Enviaron
                                            <span class="badge-alumnos-que-enviaron badge badge-pill badge-outline-success" id="badgeEnviaron"></span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-pendientes-1" class="collapse " data-parent="#lista-pendientes-1" style="">
                                    <div class="card-body">
                                        <ul id="alumnos-que-enviaron" class="contenedor-scroll list-group">
                                            <!-- CUANDO FALTA REVISAR LA TAREA -->
                                            <li class="tarea-pendiente-alumno list-group-item" >
                                                {nombre-de-alumno}
                                                <a href="#" class="badge badge-success">
                                                    Revisarxd
                                                </a>
                                            </li>
                                                                                    
                                            <!-- CUANDO YA SE HA REVISADO LA TAREA -->
                                            <li class="tarea-pendiente-alumno list-group-item">
                                                {nombre-de-alumno}
                                                <span class="btn-revisar badge badge-light">Revisado</span>
                                                <a href="#" class="badge badge-warning">
                                                    <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </li>
    
                                        </ul>
                                    </div>
                                </div>
                                <!-- Lista de alumnos que NO cumplieron la tarea -->
                                <div class="card-header header-elements-inline">
                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#lista-pendientes-2" aria-expanded="false">
                                            No enviaron
                                            <span class="badge-alumnos-que-no-enviaron badge badge-pill badge-outline-danger" id="badgeNoEnviaron"></span>
                                        </a>
                                    </h6>
                                </div>
                                <div id="lista-pendientes-2" class="collapse " data-parent="#lista-pendientes-2" style="">
                                    <div class="card-body">
                                        <ul id="alumnos-que-no-enviaron" class="contenedor-scroll list-group">
                                            <li class="tarea-pendiente-alumno list-group-item">
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

        <div id="panel-estado-de-tareas" class="col-md-6">
            <div class="card text-left">
                <div class="card-body">
    
                    <!-- Título de pestañas -->
                    <ul class="pestanas nav nav-pills" id="myPillTab" role="tablist">
                        <li class="nav-item">
                            <a onclick="CerrarPanel()" class="nav-link " id="home-icon-pill" data-toggle="pill" href="#tareas-enviadas" role="tab" aria-controls="homePIll" aria-selected="false">
                                Enviadas
                            <span class="badge-enviadas badge  badge-square-warning">{{$tareas_enviadas->count()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-icon-pill" data-toggle="pill" href="#tareas-calificadas" role="tab" aria-controls="profilePIll" aria-selected="false">
                                Calificadas
                                <span class="badge-calificadas badge  badge-square-success">{{$tareas_calificadas->count()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="contact-icon-pill" data-toggle="pill" href="#tareas-pendientes" role="tab" aria-controls="contactPIll" aria-selected="true">
                                Pendientes
                                <span class="badge-pendientes badge  badge-square-danger">{{$tareas_pendientes_por_calificar->count()}}</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Contenido de pestañas -->

                    <div class="contenedor-scroll tab-content" id="myPillTabContent">
                        <div class="tab-pane fade " id="tareas-enviadas" role="tabpanel" aria-labelledby="home-icon-pill">
                            <!-- Card -->
                            @if($tareas_enviadas->count()<=0)
                                <h4 class="text-primary">No hay enviados</h4>
                            @else
                                @foreach($tareas_enviadas as $tarea)
                                    <div class="card card-tarea" onclick="fxInfoTarea({{$tarea->id_tarea}});">
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
                                    <div class="card card-tarea" id="cardTareaCalificada{{$tarea->id_tarea}}"  onclick="fxAplicarTarea({{$tarea->id_tarea}})">
                                    <div class="card-body">
                                    <h6 class="mb-3">
                                    <span class="badge badge-success w-badge">{{$tarea->categoria->c_nombre}}</span>
                                    {{$tarea->c_titulo}}
                                    </h6>
                                    <p class="text-20 text-success line-height-1 mb-3"><i class="i-Arrow-Down-in-Circle"></i> Calificado</p>
                                    <small class="text-muted">Fecha de calificación: {{$tarea->updated_at}}</small>
                                    </div>
                                    </div>
                                @endforeach
                            @endif
                            
                        </div>

                        <div class="tab-pane fade show active" id="tareas-pendientes" role="tabpanel" aria-labelledby="contact-icon-pill">
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
                                    <h6 class="mb-2 text-muted">
                                    <span class="badge badge-success w-badge">{{$tarea->categoria->c_nombre}}</span>
                                    {{$tarea->c_titulo}}
                                    </h6>
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

    <!-- MODAL: Detalle de Tareas CALIFICADAS y PENDIENTEs -->
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

                    <form  id="frmCalificarTareaDeAlumno" method="POST" class="needs-validation" action="{{ url('docente/tarea/calificarrespuesta') }}" novalidate>
                        @csrf
                        <input type="hidden" id="id_puente" name="id_puente">
                    <strong>Respuesta</strong>
                    <div class="tarea-pendiente-respuesta">
                        <p id="respuestaObservacion"></p>
                    </div>
                    <strong>Archivo adjunto</strong>
                    <div class="tarea-pendiente-respuesta">
                        <p>{No hay archivos adjuntos}</p>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fxConfirmarRevision(event);">Tarea revisada</button>
                </div>
            </div>
        </div>
    </div>

    
    <!-- MODAL: Detalle de Tareas ENVIADAS -->
    <div class="modal fade" id="modal-tarea-enviada-detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span href="#" class="badge badge-success" id="infCategoria">{categoria}</span>
                    <h4 class="enviados-titulo" id="infTitulo">{Título de tarea}</h4>
                    <p class="enviados-descripcion" id="infDescripcion">{Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam ea deleniti, fugiat consectetur officiis harum praesentium! Quas nesciunt hic inventore fuga, magnam aliquam, iure natus blanditiis dolorem rem, assumenda vitae.}</p>
                    <div class="enviados-detalle" id="infGrupo"><strong>Grupo: </strong><p>{1 - c}</p></div>
                    <div class="enviados-detalle" id="infFechaEnvio"><strong>Fecha de envio: </strong><p>{dd-mm-yyyy}</p></div>
                    <div class="enviados-detalle" id="infFechaEntrega"><strong>Fecha de entrega: </strong><p>{dd-mm-yyyy}</p></div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

</body>

@endsection

@section('page-js')
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/docente/estadotareas.js')}}"></script>


@endsection