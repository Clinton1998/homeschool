@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">
@endsection
@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style.css')}}">
</head>

<body>
    <h2 class="titulo">Asignación de tareas</h2>
    
    <div class="mis-alumnos-contenedor card col col-lg-6">
        <div class="card-body">
            <div class="tareas-encabezado">
                <h4>Lista de tareas asignadas</h4>
                <div class="tareas-linea"></div>
            </div>

            <a href="" class="btn btn-primary" id="btn-nueva-tarea" data-toggle="modal" data-target="#modal-tarea-nueva">+ Crear nueva tarea</a>
            <br>
            <br>

            <div id="tareas">
                <!-- Tarea -->
                @foreach($tareas as $tarea)
                    <div class="tarea" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">
                        <div>
                            <span class="badge badge-success">{{$tarea->categoria->c_nombre}} - {{$tarea->categoria->c_nivel_academico}}</span>
                        </div>
                        <h4 class="tarea-titulo">{{$tarea->c_titulo}}</h4>
                        <p class="tarea-descripcion">{{$tarea->c_observacion}}</p>
                        <div class="tarea-fechas">
                            <div class="tarea-fecha-publicacion">
                                <small>Fecha de publicación: </small>
                                <small>{{$tarea->created_at}}</small>
                            </div>
                            <div class="tarea-fecha-entrega">
                                <small>Fecha de entrega: </small>
                                <small>{{$tarea->t_fecha_hora_entrega}}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
        
            </div>

        </div>
    </div>
  
    <!-- Modal Tarea nueva -->
    <div class="modal fade" id="modal-tarea-nueva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar nueva tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="frmAsignarTarea" method="post" action="{{route('docente/tarea/registrar')}}" class="needs-validation"  enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" id="id_docente" name="id_docente" value="{{$docente->id_docente}}">
                    <div class="form-group">
                        <label class="label-text" for="txtTitulo">Título de tarea</label>
                        <input class="form-control" id="txtTitulo" name="titulo" type="text" placeholder="Ejemplo: Los planetas" required>
                        <span class="invalid-feedback" role="alert">
                            El título es requerido
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="txtDescripcion">Descripción</label>
                        <textarea class="form-control" id="txtDescripcion" name="descripcion" rows="3" placeholder="Opcional"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="txtArchivo">Archivo</label>
                        <input type="file" class="form-control form-control-lg" name="archivo" id="txtArchivo">
                    </div>
                    
                    <div class="form-group">
                        <label class="label-text" for="cbGradoSeccion">Para</label>
                        <select id="cbGradoSeccion" name="seccion" required>
                                <option value=""></option>
                            @foreach($docente->secciones->where('estado','=',1) as $seccion)
                                <option value="{{$seccion->id_seccion}}">{{$seccion->c_nombre}} - {{$seccion->grado->c_nombre}} - {{$seccion->grado->c_nivel_academico}}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback" role="alert">
                            Elige una sección
                        </span>
                    </div>
                    
                    <div class="radio-alumnos form-group" id="divRadioAlumno">
                        <div class="radio-btn form-check form-check-inline">
                            <label class="radio radio-light">
                                <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option1" checked >
                                <span>Todos los alumnos</span>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="radio-btn form-check form-check-inline" data-toggle="modal" data-target="#modal-seleccion-alumnos">
                            <label class="radio radio-light">
                                <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option2" >
                                <span>Seleccionar alumnos</span>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="alert alert-card alert-danger" role="alert" id="alertNoHayCategorias" style="display: none;">
                            <strong class="text-capitalize">Aviso!</strong> No tienes ninguna categoría para esta sección, pídele al super administrador de tu institución,que cree una categoría.
                        </div>

                        <label for="selCategoria">Categoría</label>
                        <select name="categoria" id="selCategoria" class="form-control" disabled required>
                        </select>
                        <span class="invalid-feedback" role="alert">
                            Elige una categoría
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="label-text" for="txtFechaEntrega">Fecha de entrega</label>
                        <input class="form-control" id="txtFechaEntrega"  name="fecha_hora_entrega" type="date" placeholder="Ejemplo: Los planetas" disabled required>
                        <span class="invalid-feedback" role="alert">
                            Seleccionar una fecha
                        </span>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitAsignarTarea" form="frmAsignarTarea">Asignar tarea</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Selección de alumnos -->
    <div class="modal fade" id="modal-seleccion-alumnos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Seleccionar alumnos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alumnos-scroll" id="divAlumnosDeSeccion">                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Listo</button>
            </div>
        </div>
        </div>
    </div>
</body>

@endsection

@section('page-js')
    <script src="{{asset('assets/js/tooltip.script.js') }}"></script>
    <script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/docente/asignartareas.js')}}"></script>
@endsection