@extends('reutilizable.principal')
@section('page-css')
  <link rel="stylesheet" href="{{asset('assets/styles/vendor/calendar/fullcalendar.min.css')}}">
@endsection

@section('main-content')
            <h1>Tareas</h1>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <span class="badge badge-pill badge-info p-1 m-1">Pendientes</span>
                    <span class="badge badge-pill badge-warning p-1 m-1">Por vencer</span>
                    <span class="badge badge-pill badge-danger p-1 m-1">Vencidos</span>
                    <span class="badge badge-pill badge-primary p-1 m-1">Enviados</span>
                    <span class="badge badge-pill badge-success p-1 m-1">Completados</span>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-white">Balanceo de ecuaciones quimicas</h6>
                                <small>3 days ago</small>
                            </div>
                            <!--<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>-->

                            <small>Asignado por Joel Leonardo Apaza Chavez.</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Titulo de la tarea 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Titulo de la tarea 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-secondary">Titulo de la tarea 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-success">Titulo de la tarea 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-danger">Titulo de la tarea 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-warning">Titulo de la tarea 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Titulo de la tarea 1</a>
                    </div>
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
<script src="{{asset('assets/js/calendar.script.js')}}"></script>

@endsection
