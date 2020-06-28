@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
    <link  rel="stylesheet" href="{{asset('fine-uploader/fine-uploader-new.css')}}">
    <script src="{{asset('fine-uploader/fine-uploader.js')}}"></script>
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Seleccionar archivos</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>Procesando archivos caídos...</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Quitar</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Reintentar</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Eliminar</button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Sí</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancelar</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
@endsection

@section('main-content')
<body>
    <div class="curso-main">
        <!--header-->
        <div class="curso-header" style="background: {{$curso->col_curso}}">
            <div>
                <h4 class="curso-name hs_capitalize-first">{{mb_strtolower($curso->nom_curso)}}</h4>
                <small class="celda_oculta curso-name curso-name-sub hs_capitalize-first">{{substr($curso->nom_grado,3)}} "{{strtoupper($curso->nom_seccion)}}" - {{$curso->nom_nivel}}</small>
            </div>
            <a class="curso-back btn btn-secondary" href="{{url('/docente/cursos')}}">
                <i class="nav-icon i-Arrow-Left"></i>
                Ir a cursos
            </a>
        </div>

        <!--Content-->
        <div class="curso-content">
            <div class="curso-load">
                <div id="cm">
                    @include('docente.cursomodulo')
                </div>
                <div id="ct">
                    @include('docente.cursotareas')
                </div>
                <div id="ca">
                    @include('docente.cursoanuncio')
                </div>
                {{-- <div id="cc">
                    @include('docente.cursocalificacion')
                </div> --}}
                {{-- <div id="cd">
                    @include('docente.cursodocente')
                </div> --}}
                <div id="cal">
                    @include('docente.cursoalumno')
                </div>
            </div>
        </div>

        <!--Aside-->
        <div class="curso-aside">
            <div class="options-group">
                <div class="options-title">
                    <p class="options-name">Opciones del curso</p>
                </div>
                <ul class="options">
                    <li>
                        <a class="show-cm option" href="#"><i class="mr-2 nav-icon i-Check"></i>Módulos</a>
                    </li>
                    {{-- <li>
                        <a class="option" href="#"><i class="mr-2 nav-icon i-Speach-Bubbles"></i>Foros</a>
                    </li> --}}
                    <li>
                        <a class="show-ct option" href="#"><i class="mr-2 nav-icon i-Notepad"></i>Tareas</a>
                    </li>
                    <li>
                        <a class="show-ca option" href="#"><i class="mr-2 nav-icon i-Bell"></i>Anuncios</a>
                    </li>

                    {{-- <li>
                        <a class="show-cc option" href="#"><i class="mr-2 nav-icon i-Medal-2"></i>Calificaciones</a>
                    </li> --}}
                </ul>
            </div>
            <div class="options-group">
                <div class="options-title">
                    <p class="options-name">Información general</p>
                </div>
                <ul class="options">
                    {{-- <li>
                        <a class="show-cd option" href="#"><i class="mr-2 nav-icon i-Geek"></i>Docente</a>
                    </li> --}}
                    <li>
                        <a class="show-cal option" href="#"><i class="mr-2 nav-icon i-MaleFemale"></i>Alumnos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!--Float Menu-->
    <div class="curso-menu">
        <ul class="items">
            <li>
                <a class="show-cm item" href="#"><i class="nav-icon i-Check"></i><span>Módulos</span></a>
            </li>
            {{-- <li>
                <a class="show-ct item" href="#"><i class="nav-icon i-Speach-Bubbles"></i><span>Foros</span></a>
            </li> --}}
            <li>
                <a class="show-ct item" href="#"><i class="nav-icon i-Notepad"></i><span>Tareas</span></a>
            </li>
            <li>
                <a class="show-ca item" href="#"><i class="nav-icon i-Bell"></i><span>Anuncios</span></a>
            </li>
            {{-- <li>
                <a class="show-cc item" href="#"><i class="nav-icon i-Medal-2"></i><span>Calificaciones</span></a>
            </li> --}}
            <li>
                <a class="show-cal item" href="#"><i class="nav-icon i-MaleFemale"></i><span>Alumnos</span></a>
            </li>
            {{-- <li>
                <a id="btn-more" class="item" href="#">
                    <i class="nav-icon">
                        <svg class="dots bi bi-three-dots-vertical" width="25px" height="25px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm0-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd"/>
                        </svg>
                    </i>
                </a>
                <ul id="item-more" class="item-more-hide">
                    <li>
                        <a class="show-cd item" href="#"><i class="nav-icon i-Geek"></i><span>Docente</span></a>
                    </li>
                    <li class="mt-2">
                        <a class="show-cal item" href="#"><i class="nav-icon i-Student-Hat-2"></i><span>Alumnos</span></a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</body>
@endsection

@section('page-js')

<script>
    /* document.getElementById('btn-more').addEventListener("click", function(){
        document.getElementById('item-more').classList.toggle('show-item-more');
    }); */

    $(document).ready( function () {
        $("#cm").show();
        $("#ct").hide();
        $("#ca").hide();
        $("#cc").hide();
        $("#cd").hide();
        $("#cal").hide();

        $('.show-cm').click(function(){
            $("#cm").show();
            $("#ct").hide();
            $("#ca").hide();
            $("#cc").hide();
            $("#cd").hide();
            $("#cal").hide();
        });

        $('.show-ct').click(function(){
            $("#cm").hide();
            $("#ct").show();
            $("#ca").hide();
            $("#cc").hide();
            $("#cd").hide();
            $("#cal").hide();
        });

        $('.show-ca').click(function(){
            $("#cm").hide();
            $("#ct").hide();
            $("#ca").show();
            $("#cc").hide();
            $("#cd").hide();
            $("#cal").hide();
        });

        $('.show-cc').click(function(){
            $("#cm").hide();
            $("#ct").hide();
            $("#ca").hide();
            $("#cc").show();
            $("#cd").hide();
            $("#cal").hide();
        });

        $('.show-cd').click(function(){
            $("#cm").hide();
            $("#ct").hide();
            $("#ca").hide();
            $("#cc").hide();
            $("#cd").show();
            $("#cal").hide();
        });

        $('.show-cal').click(function(){
            $("#cm").hide();
            $("#ct").hide();
            $("#ca").hide();
            $("#cc").hide();
            $("#cd").hide();
            $("#cal").show();
        });
    });
</script>

@endsection
