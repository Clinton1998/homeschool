@extends('reutilizable.principal')
@section('page-css')
  <link rel="stylesheet" href="{{asset('assets/styles/vendor/calendar/fullcalendar.min.css')}}">
@endsection

@section('main-content')
            <h1>Tareas</h1>
            <h2>{{strtotime("now")}}</h2>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <span class="badge badge-pill badge-warning p-1 m-1">Pendientes</span>
                    <span class="badge badge-pill badge-danger p-1 m-1">Vencidos</span>
                    <span class="badge badge-pill badge-info p-1 m-1">Enviados</span>
                    <span class="badge badge-pill badge-success p-1 m-1">Calificados</span>
                    @foreach($tareas_del_alumno as $tarea)
                        @php
                            $clase = '';
                            if($tarea->pivot->c_estado=='APEN' && $tarea->t_fecha_hora_entrega>date('Y-m-d H:i:s')){
                                $clase  = 'list-group-item-warning';
                            }else if($tarea->pivot->c_estado=='APEN' && $tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s')){
                                $clase  = 'list-group-item-danger';
                            }else if($tarea->pivot->c_estado=='AENV'){
                                $clase  = 'list-group-item-info';
                            }else if($tarea->pivot->c_estado=='ACAL'){
                                $clase  = 'list-group-item-success';
                            }
                        @endphp
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action {{$clase}}">
                                <div>{{$tarea->c_titulo}}</div>
                                <small>Asignado por {{$tarea->docente->c_nombre}}</small>
                            </a>
                        </div>
                    @endforeach
                    <a href="{{route('alumno/tareas')}}" class="btn btn-link">Ver todo</a>
                </div>
                <div class="col-xs-8 col-sm-8">
                    <div class="card mb-4 o-hidden">
                        <div class="card-body">
                            <div id="calendar"></div>
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
