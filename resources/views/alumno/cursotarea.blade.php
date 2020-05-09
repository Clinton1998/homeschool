<div class="content-header">
    <h4 class="content-title">Tareas</h4>
</div>

<div class="content-main">
    <div class="my-scroll">
        @foreach ($tareas as $t)
            @if($t->pivot->c_estado=='APEN' && $t->t_fecha_hora_entrega>date('Y-m-d H:i:s'))
                <div class="box-card card">
                    <div class="card-header">
                        <div class="box-title">
                            <strong><a target="_blank" href="{{url('alumno/cursos/tarea_pen/'.$t->id_tarea)}}" class="hs_upper">{{$t->c_titulo}}</a></strong>
                            
                            <div class="box-ver">
                                <strong><a class="box-link" target="_blank" href="{{url('alumno/tareapendiente/'.$t->id_tarea)}}">ver tarea <i class="nav-icon i-Right"></i></a></strong>
                            </div>
                            {{-- <div class="box-puntuacion">
                                <strong>Puntos: </strong>
                                <p>20</p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="box-content">
                            <div class="box-descripcion">
                                <p class="hs_capitalize-first">
                                    {{$t->c_observacion}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="box-fechas">
                            <div class="box-fecha-envio">
                                <p>Enviado: </p>
                                <p> {{$t->created_at}}</p>
                            </div>
                            <div class="box-fecha-cierre">
                                <strong>Fecha de cierre: </strong>
                                <p> {{$t->t_fecha_hora_entrega}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>