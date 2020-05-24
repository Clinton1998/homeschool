<div class="content-header">
    <h4 class="content-title">Calificaciones</h4>
</div>

<div class="content-main">
    <div class="my-scroll">
        <div class="box-invert">
            <table class="curso_table">
                <thead class="mobile">
                    <tr>
                        <th style="display: none">COD</th>
                        <th class="celda_oculta">Título de tarea</th>
                        <th>Fecha de entrega</th>
                        <th>Tarea</th>
                        <th>Estado</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cont_env = 0;
                        $cont_cal = 0;
                        $cont_pen = 0;
                        $cont_ven = 0;
                    @endphp
                    @foreach($tareas as $t)
                        @if($t->pivot->c_estado=='APEN' || $t->pivot->c_estado=='AENV' || $t->pivot->c_estado=='ACAL')
                            <tr class="desk">
                                <td style="display: none"></td>
                                <td class="celda_oculta"></td>
                                <td colspan="4" class="celda_titulo text-left pl-2"><strong class="hs_capitalize-first">{{$t->c_titulo}}</strong></td>
                            </tr>
                            <tr>
                                <td style="display: none">{{$t->id_tarea}}</td>
                                <td class="celda_oculta text-left hs_capitalize-first">{{$t->c_titulo}}</td>
                                <td><small>{{$t->t_fecha_hora_entrega}}</small></td>

                                <td>
                                    @if ($t->pivot->c_estado=='APEN' && $t->t_fecha_hora_entrega >= date('Y-m-d H:i:s'))
                                        <abbr title="Ir a tarea"><a class="" target="_blank" href="{{url('alumno/tareapendiente/'.$t->id_tarea)}}">Ir a tarea</a></abbr>
                                    @elseif($t->pivot->c_estado=='APEN' && $t->t_fecha_hora_entrega < date('Y-m-d H:i:s'))
                                        <abbr title="Ir a tarea"><a class="" target="_blank" href="{{url('alumno/tareavencida/'.$t->id_tarea)}}">Ir a tarea</a></abbr>
                                    @elseif($t->pivot->c_estado=='AENV')
                                        <abbr title="Ir a tarea"><a class="" target="_blank" href="{{url('alumno/tareaenviada/'.$t->id_tarea)}}">Ir a tarea</a></abbr>
                                    @else
                                        -
                                    @endif
                                </td>

                                @if ($t->pivot->c_estado=='APEN' && $t->t_fecha_hora_entrega >= date('Y-m-d H:i:s'))
                                    <td class="hs_capitalize-first"><span class="text-danger">Por hacer</span></td> @php $cont_pen++ @endphp
                                    <td></td>
                                @elseif($t->pivot->c_estado=='APEN' && $t->t_fecha_hora_entrega < date('Y-m-d H:i:s'))
                                    <td class="hs_capitalize-first"><span>Vencido</span></td> @php $cont_ven++ @endphp
                                    <td>-</td>
                                @elseif($t->pivot->c_estado=='AENV')
                                    <td class="hs_capitalize-first"><span class="text-info">Presentado</span></td> @php $cont_env++ @endphp
                                    <td><small>En revisión</small></td>
                                @else
                                    @php
                                        $respuesta = App\Respuesta_d::findOrFail($t->pivot->id_respuesta);
                                    @endphp
                                    <td class="hs_capitalize-first"><span class="text-success">Calificado</span></td> @php $cont_cal++ @endphp
                                    <td><abbr title="Comentario del docente:&nbsp;{{$respuesta->c_comentario_calificacion}}">{{$respuesta->c_calificacion}}</abbr> </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="tarea_contadores">
                <span class="tarea_contador badge badge-pill badge-outline-info p-2 mb-2 ml-1">@php echo 'Presentado&nbsp;'. $cont_env @endphp</span>
                <span class="tarea_contador badge badge-pill badge-outline-success p-2 mb-2 ml-1">@php echo 'Calificado&nbsp;'. $cont_cal @endphp</span>
                <span class="tarea_contador badge badge-pill badge-outline-danger p-2 mb-2 ml-1">@php echo 'Pendiente&nbsp;'. $cont_pen @endphp</span>
                <span class="tarea_contador badge badge-pill badge-outline-secondary p-2 mb-2 ml-1">@php echo 'Vencido&nbsp;'. $cont_ven @endphp</span>
            </div>
        </div>  
    </div>
</div>