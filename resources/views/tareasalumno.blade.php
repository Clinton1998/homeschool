@extends('reutilizable.principal')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
</head>

<h2 class="hs_titulo">Mis tareas</h2>

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pendientes-basic-tab" data-toggle="tab" href="#pendientesBasic" role="tab" aria-controls="pendientesBasic" aria-selected="true">Pendientes</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" id="vencidos-basic-tab" data-toggle="tab" href="#vencidosBasic" role="tab" aria-controls="vencidosBasic" aria-selected="false">Vencidos</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" id="enviados-basic-tab" data-toggle="tab" href="#enviadosBasic" role="tab" aria-controls="enviadosBasic" aria-selected="false">Enviados</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="completados-basic-tab" data-toggle="tab" href="#completadosBasic" role="tab" aria-controls="completadosBasic" aria-selected="false">Calificados</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pendientesBasic" role="tabpanel" aria-labelledby="pendientes-basic-tab">
                    @include('layouts.taskmanager.alumno.pendientes')
            </div>
            
            <div class="tab-pane fade" id="vencidosBasic" role="tabpanel" aria-labelledby="vencidos-basic-tab">
                    @include('layouts.taskmanager.alumno.vencidos')
            </div>

            <div class="tab-pane fade" id="enviadosBasic" role="tabpanel" aria-labelledby="enviados-basic-tab">
                    @include('layouts.taskmanager.alumno.enviados')
            </div>

            <div class="tab-pane fade" id="completadosBasic" role="tabpanel" aria-labelledby="completados-basic-tab">
                    @include('layouts.taskmanager.alumno.calificados')
            </div>
        </div>
    </div>
</div>
   
@endsection

@section('page-js')

@endsection
