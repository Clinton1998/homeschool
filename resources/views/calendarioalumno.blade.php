@extends('reutilizable.principal')
@section('page-css')
  <link rel="stylesheet" href="{{asset('assets/styles/vendor/calendar/fullcalendar.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
@endsection

@section('main-content')

<div class="row">
    <div class="col-sm-8">
        <div class="card mb-4 o-hidden">
            <div class="card-body">
                <div class="hs_encabezado">
                    <h4 class="hs_encabezado-titulo">Mi calendario</h4>
                    <div class="hs_encabezado-linea"></div>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="hs_encabezado">
                    <h4 class="hs_encabezado-titulo">Etiquetas</h4>
                    <div class="hs_encabezado-linea"></div>
                </div>
                <div class="col">
                    <span class="badge badge-pill badge-warning pl-2 pr-2 m-1">Pendientes</span>
                    <span class="badge badge-pill badge-danger pl-2 pr-2 m-1">Vencidos</span>
                    <span class="badge badge-pill badge-info pl-2 pr-2 m-1">Enviados</span>
                    <span class="badge badge-pill badge-success pl-2 pr-2 m-1">Calificados</span>
                    <br><br>
                    @foreach ($tareas_del_alumno as $tarea)
                        @php
                            $clase = '';
                            $url = '';
                            if($tarea->pivot->c_estado=='APEN' && $tarea->t_fecha_hora_entrega>date('Y-m-d H:i:s')){
                                $url = '/alumno/tareapendiente/'.$tarea->id_tarea;
                                $clase  = 'badge-warning';
                                $text = 'Pendiente';
                            }else if($tarea->pivot->c_estado=='APEN' && $tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s')){
                                $url = '/alumno/tareas';
                                $clase  = 'badge-danger';
                                $text = 'Vencido';
                            }else if($tarea->pivot->c_estado=='AENV'){
                                $url = '/alumno/tareaenviada/'.$tarea->id_tarea;
                                $clase  = 'badge-info';
                                $text = 'Enviado';
                            }else if($tarea->pivot->c_estado=='ACAL'){
                                $url = '/alumno/tareas';
                                $clase  = 'badge-success';
                                $text = 'Calificado';
                            }
                        @endphp

                        <a href="{{url($url)}}" class="" style="background: #ecece9; display: flex; flex-direction: column; margin-bottom: 10px; border-radius: 2px; overflow: hidden">
                            <strong style="font-size: 12px; padding: 2px 0 0 5px; color: white; background: {{$tarea->categoria->c_nivel_academico}}">{{$tarea->categoria->c_nombre}}</strong>
                            <div style="border: solid 1px lightgrey">
                                <p class="hs_upper" style="margin: 2px 0 5px 5px; font-size: 10px">{{$tarea->c_titulo}}</p>
                                <div style="display: flex; flex-direction: row; padding: 5px; flex-grow: 1">
                                    <div style="display: flex; flex-direction:column; width: 100%">
                                        <small>Asignado por: <span class="hs_capitalize">{{mb_strtolower($tarea->docente->c_nombre)}}</span></small>
                                        <small>Fecha de entrega: {{$tarea->t_fecha_hora_entrega}}</small>
                                    </div>
                                    <div style="align-self: flex-end">
                                        <span class="bagde badge-pill {{$clase}} pl-2 pr-2" style="font-size: 9px">{{$text}}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                    @endforeach
                    
                    <a href="{{route('alumno/tareas')}}" class="btn btn-link float-right">Ver todo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')


<script src="{{asset('assets/js/vendor/calendar/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/calendar/locale-all.js')}}"></script>
<script src="{{asset('assets/js/calendar.script.js')}}"></script>

@endsection
