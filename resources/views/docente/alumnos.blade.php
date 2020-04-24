@extends('reutilizable.principal')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}">
</head>

<body>
    <h2 class="titulo">Mis alumnos</h2>
    
    <div class="mis-alumnos-contenedor card col col-lg-6">
            
        <!-- Lista de alumnos por Grado y Sección -->
        <div class="card-body">
            <div class="tareas-encabezado">
                <h4>Lista de alumnos por grupos</h4>
                <div class="tareas-linea"></div>
            </div>

            <div class="accordion" id="accordion-alumnos">
                <!-- ES IMPORTANTE revisar algunos datos para todo funcione de manera automática
                1. data-target="#lista-1" debe corresponderse con id="lista-1" ... -->
                
                <!-- Grado: X  Sección: Y -->

                @foreach($secciones as $seccion)
                    <div class="agrupacion">
                        <div class="accordion-titulo" >
                            <div class="accordion-titulo-left">
                            <strong>Seccion: </strong><p>{{$seccion->c_nombre}}</p><strong>Grado: </strong><p>{{$seccion->grado->c_nombre}} - {{$seccion->grado->c_nivel_academico}}</p>
                        </div>
                        <div class="accordion-titulo-right" data-toggle="collapse" data-target="#lista-{{$seccion->id_seccion}}" aria-expanded="false" aria-controls="collapseOne">
                            <svg class="bi bi-caret-down-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 01.753 1.659l-4.796 5.48a1 1 0 01-1.506 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div id="lista-{{$seccion->id_seccion}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-alumnos">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($seccion->alumnos->where('estado','=',1) as $alumno)
                                    <li class="list-group-item" id="liListGroupAlumno{{$alumno->id_alumno}}" onclick="fxAplicarAlumno({{$alumno->id_alumno}});">{{$alumno->c_nombre}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    </div>
                @endforeach
            </div>            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-datos-alumno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos del alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="modal-foto-alumno" src="http://127.0.0.1:8000/assets/images/usuario/studentman.png" alt="fotografía" id="fotoAlumno">
                    <h4 id="nombreAlumno"></h4>
                    <br>
                    <strong>Correo electrónico</strong>
                    <p id="correoAlumno"></p>
                    <br>
                    <hr>
                    <h4>Representantes</h4>
                    <h5 id="nombreRepresentante1">Clinton</h5>
                    <strong>Número de teléfono</strong>
                    <p id="telefono1">{999-999999}</p>
                    <br>
                    <h5 id="nombreRepresentante2">Clinton</h5>
                    <strong>Número de teléfono</strong>
                    <p id="telefono2">{999-999999}</p>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
</body>

@endsection

@section('page-js')
    <script src="{{asset('assets/js/docente/alumnos.js')}}"></script>
@endsection