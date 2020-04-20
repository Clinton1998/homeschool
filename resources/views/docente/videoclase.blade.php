@extends('reutilizable.principal')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style.css')}}">
</head>
<button type="button" class="btn btn-primary btn-lg" onclick="window.open('https://accounts.google.com/signin/v2/dentifier?service=talk&continue=https%3A%2F%2Fhangouts.google.com%2F&flowName=GlifWebSignIn&flowEntry=ServiceLogin','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Abrir hangout</button>
<!--<body onload="ContadorSeleccionados()">
    <h2 class="titulo">Videoclase</h2>

    <div class="contenedor-estado-tareas row">
        <div class=" col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-dark" role="alert">
                        Bienvenida(o), desde este módulo usted podrá iniciar una <strong>videoclase</strong> con sus alumnnos o colegas...
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 1:
                        </strong>
                        <p class="pasos-indicacion">
                            
                        </p>
                    </div>
                    <div class="pasos-accion">
                        <a type="button" class="abrir-hangoust btn btn-raised ripple btn-raised-secondary col col-lg-4 col--12" target="_blank" href="https://accounts.google.com/signin/v2/identifier?service=talk&continue=https%3A%2F%2Fhangouts.google.com%2F&flowName=GlifWebSignIn&flowEntry=ServiceLogin">
                            Abrir Hangouts
                        </a>
                    </div>sm

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 2:
                        </strong>
                        <p class="pasos-indicacion">
                            
                        </p>
                    </div>
                    <div class="pasos-accion">
                        <div class="form-group mb-12">
                            <input type="text" class="form-control" id="txt-vinculo" placeholder="Pegue aquí el vinculo copiado">
                        </div>
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 3:
                        </strong>
                        <p class="pasos-indicacion">
                            
                        </p>
                    </div>
                    <div class="GRUPO-SELECCIONADO row">
                        <div class="col col-lg-6 col-sm-12">
                            <div class="">
                                <button type="button" class="btn btn-raised ripple btn-raised-secondary col col-lg-8 col-sm-12" data-toggle="modal" data-target="#Modal-Integrantes">
                                    Seleccionar integrantes
                                </button>

                                <br><br>
                                
                                <div id="mostrar-contador" class="col col-lg-8 col-sm-12" style="text-align: center">
                                    <small id="mostrar-contador-label">Integrantes seleccionados</small>
                                    <h1 id="contador-seleccionados"></h1>
                                </div>
                            </div>
                        </div>
                        <div class="lista-grupo-seleccionado col col-lg-6 col-sm-12 pasos-accion">
                            <ul id="alumnos-que-no-enviaron" class="gs contenedor-scroll-grupo list-group" style="margin: 0">
                                <li class="tarea-pendiente-alumno seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="tarea-pendiente-alumno seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="tarea-pendiente-alumno seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="tarea-pendiente-alumno seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="tarea-pendiente-alumno seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 4:
                        </strong>
                        <p class="pasos-indicacion">
                            Enviar vinculo para iniciar la videoclase
                        </p>
                    </div>
                    <div class="pasos-accion">
                        <button type="button" class="btn btn-primary btn-lg col col-sm-12" style="margin-top: 20px">
                            Enviar vinculo
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    
     <div class="modal fade" id="Modal-Integrantes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seleccionar integrantes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">
                                Grupos
                            </h3>
                        </div>
                        <div class="ul-widget__head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line ul-widget-nav-tabs-line"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#ul-widget2-tab1-content"
                                        role="tab">
                                        Mis alumnos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#ul-widget2-tab2-content"
                                        role="tab">
                                        Docentes
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ul-widget__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="ul-widget2-tab1-content">
                                <div class="accordion" id="accordionRightIcon">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0" style="display: flex;">
                                                <label class="checkbox checkbox-outline-primary">
                                                    <input type="checkbox">
                                                    <span></span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a data-toggle="collapse" class="text-default collapsed" href="#GRUPO-ALUMNOS-1">
                                                    {Alumnos de 1 - B}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="GRUPO-ALUMNOS-1" class="collapse " data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <ul id="alumnos-que-no-enviaron" class="contenedor-scroll-grupo list-group">
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion" id="accordionRightIcon">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0" style="display: flex;">
                                                <label class="checkbox checkbox-outline-primary">
                                                    <input type="checkbox">
                                                    <span></span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a data-toggle="collapse" class="text-default collapsed" href="#GRUPO-ALUMNOS-2">
                                                    {Alumnos de 3 - A}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="GRUPO-ALUMNOS-2" class="collapse " data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <ul id="alumnos-que-no-enviaron" class="contenedor-scroll-grupo list-group">
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="tab-pane" id="ul-widget2-tab2-content">
                                <div class="accordion" id="accordionRightIcon">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0" style="display: flex;">
                                                <label class="checkbox checkbox-outline-primary">
                                                    <input type="checkbox">
                                                    <span></span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a data-toggle="collapse" class="text-default collapsed" href="#GRUPO-DOCENTES">
                                                    {Todos los docentes}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="GRUPO-DOCENTES" class="collapse show" data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <ul id="alumnos-que-no-enviaron" class="contenedor-scroll-grupo list-group">
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="tarea-pendiente-alumno list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="ContadorSeleccionados()">Grupo seleccionado</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ContadorSeleccionados(){

            var numIntegranntes = document.querySelector(".gs").childElementCount;

            if(numIntegranntes > 0){
                document.getElementById("contador-seleccionados").innerHTML = numIntegranntes;
            }
            else{
                document.getElementById("mostrar-contador-label").style.opacity = 0;
            }
        }
    </script>
</body>-->




@endsection