<div class="content-header">
    <h4 class="content-title">Calificaciones</h4>
</div>

<div class="content-main">
    <div class="my-scroll tbl-container">
        <table id="tbl-calificaciones" class="table-hover">
            <thead>
                <tr>
                    <th style="display: none">COD</th>
                    <th>Tarea</th>
                    <th>Entrega</th>
                    <th>Estado</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tareas as $t)
                    @if($t->pivot->c_estado=='APEN' || $t->pivot->c_estado=='AENV' || $t->pivot->c_estado=='ACAL')
                        <tr>
                            <td style="display: none">{{$t->id_tarea}}</td>

                            @if ($t->pivot->c_estado=='APEN')
                                <td class="hs_capitalize-first"><a class="tbl-tarea-see" target="_blank" href="{{url('alumno/tareapendiente/'.$t->id_tarea)}}">{{$t->c_titulo}}</a></td>
                            @elseif($t->pivot->c_estado=='AENV')
                                <td class="hs_capitalize-first"><a class="tbl-tarea-see" target="_blank" href="{{url('alumno/tareaenviada/'.$t->id_tarea)}}">{{$t->c_titulo}}</a></td>
                            @else
                                <td class="hs_capitalize-first"><a class="tbl-tarea-see" href="#">{{$t->c_titulo}}</a></td>
                            @endif
                            
                            <td><small>{{$t->t_fecha_hora_entrega}}</small></td>

                            @if ($t->pivot->c_estado=='APEN')
                                <td class="hs_capitalize-first"><small>POR HACER</small></td>
                                <td>-</td>
                            @elseif($t->pivot->c_estado=='AENV')
                                <td class="hs_capitalize-first"><small>PRESENTADO</small></td>
                                <td><small>EN REVISIÓN</small></td>
                            @else
                                @php
                                    $respuesta = App\Respuesta_d::findOrFail($t->pivot->id_respuesta);
                                @endphp
                                <td class="hs_capitalize-first"><small>CALIFICADO</small></td>
                                <td>{{$respuesta->c_calificacion}}</td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>