<div id="task-manager">
    <!-- top-content-bar -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @foreach($tareas_del_alumno as $tarea)
                    @if($tarea->pivot->c_estado=='ACAL')
                            <div class="col-xl-6">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                            <div>
                                                <h5 class="hs_upper"><a href="">{{$tarea->c_titulo}}</a></h5>
                                                <p class="ul-task-manager__paragraph mb-3 text-justify">{{$tarea->c_observacion}}</p>
                                                @if(is_null($tarea->docente->c_foto)  || empty($tarea->docente->c_foto))
                                                    @if(strtoupper($tarea->docente->c_sexo)=='M')
                                                        <img class="rounded-circle" width="36" height="36" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                                                    @else
                                                        <img class="rounded-circle" width="36" height="36" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                                                    @endif
                                                @else
                                                    <img class="rounded-circle" width="36" height="36" src="{{url('super/docente/foto/'.$tarea->docente->c_foto)}}" alt="Foto del docente">
                                                @endif
                                                {{$tarea->docente->c_nombre}}
                                            </div>

                                            <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto">
                                                <li><span class="ul-task-manager__font-date text-muted">{{$tarea->created_at}}</span></li>
                                                <li class="dropdown">
                                                <span style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}}" class="badge badge-pill badge-danger p-1 m-1">{{$tarea->categoria->c_nombre}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <hr>
                                        @php
                                            $respuesta = App\Respuesta_d::findOrFail($tarea->pivot->id_respuesta);
                                        @endphp
                                        <p><strong class="">Calificación:</strong> {{$respuesta->c_calificacion}}</p>
                                        <p><strong class="">Comentario:</strong> {{$respuesta->c_comentario_calificacion}}</p>
                                    </div>
                                </div>
                            </div>    
                    @endif
                @endforeach
            </div>
            
        </div>


    </div>
        

</div>

