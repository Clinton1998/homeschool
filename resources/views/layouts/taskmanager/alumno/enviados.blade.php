<div id="task-manager">
    <!-- top-content-bar -->
    
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="row">
                @foreach($tareas_del_alumno as $tarea)
                    @if($tarea->pivot->c_estado=='AENV')
                            <div class="col-xl-6">
                                <div class="card mt-4 mb-4">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                            <div>
                                                <h6><a href="">{{$tarea->c_titulo}}</a></h6>
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
                                                    Categoria: &nbsp;
                                                <span class="badge badge-pill badge-danger p-1 m-1">{{$tarea->categoria->c_nombre}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                        <span>Fecha de entrega: <span class="font-weight-semibold text-primary">{{$tarea->t_fecha_hora_entrega}}</span></span>
                                        <a href="{{url('alumno/tareaenviada/'.$tarea->id_tarea)}}" class="text-default">Ver</a>
                                    </div>
                                </div>
                            </div>    
                    @endif
                @endforeach
            </div>
            
        </div>


    </div>
        

</div>

