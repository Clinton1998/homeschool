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
                    <span class="badge badge-pill badge-warning p-1 m-1">Pendientes</span>
                    <span class="badge badge-pill badge-danger p-1 m-1">Vencidos</span>
                    <span class="badge badge-pill badge-info p-1 m-1">Enviados</span>
                    <span class="badge badge-pill badge-success p-1 m-1">Calificados</span>
                    @foreach($tareas_del_alumno as $tarea)
                        @php
                            $clase = '';
                            $url = '';
                            if($tarea->pivot->c_estado=='APEN' && $tarea->t_fecha_hora_entrega>date('Y-m-d H:i:s')){
                                $url = '/alumno/tareapendiente/'.$tarea->id_tarea;
                                $clase  = 'list-group-item-warning';
                            }else if($tarea->pivot->c_estado=='APEN' && $tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s')){
                                $url = '/alumno/tareas';
                                $clase  = 'list-group-item-danger';
                            }else if($tarea->pivot->c_estado=='AENV'){
                                $url = '/alumno/tareaenviada/'.$tarea->id_tarea;
                                $clase  = 'list-group-item-info';
                            }else if($tarea->pivot->c_estado=='ACAL'){
                                $url = '/alumno/tareas';
                                $clase  = 'list-group-item-success';
                            }
                        @endphp
                        <div class="list-group">
                            <br>
                            <a href="{{url($url)}}" class="list-group-item list-group-item-action {{$clase}}">
                                <div><strong class="hs_upper">{{$tarea->c_titulo}}</strong></div>
                                <small>Asignado por: <span class="hs_capitalize">{{strtolower($tarea->docente->c_nombre)}}</span></small>
                                <br>
                                <small>Fecha de entrega: {{$tarea->t_fecha_hora_entrega}}</small>
                            </a>
                        </div>
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
