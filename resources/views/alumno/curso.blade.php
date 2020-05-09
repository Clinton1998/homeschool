@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
@endsection

@section('main-content')
<body>
    <div class="curso-main">
        <!--header-->
        <div class="curso-header" style="background: {{$cursos->col_curso}}">
            <h4 class="curso-name hs_capitalize-first">{{$cursos->nom_curso}}</h4>
            <a class="curso-back btn btn-secondary" href="{{url('/alumno/cursos')}}">
                <i class="nav-icon i-Arrow-Left"></i>
                Ir a cursos
            </a>
        </div>
    
        <!--Content-->
        <div class="curso-content">
            <div class="curso-load">
                <div id="cm">
                    @include('alumno.cursomodulo')
                </div>
                <div id="ct">
                    @include('alumno.cursotarea')
                </div>
                <div id="ca">
                    @include('alumno.cursoanuncio')
                </div>
                <div id="cc">
                    @include('alumno.cursocalificacion')
                </div>
                <div id="cd">
                    @include('alumno.cursodocente')
                </div>
                <div id="cal">
                    @include('alumno.cursoalumno')
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
                    <li>
                        <a class="option" href="#"><i class="mr-2 nav-icon i-Speach-Bubbles"></i>Foros</a>
                    </li>
                    <li>
                        @php
                            $counter_tareas = 0      
                        @endphp
                        @foreach ($tareas as $t)
                            @if($t->pivot->c_estado=='APEN' && $t->estado==1 && $t->t_fecha_hora_entrega > date('Y-m-d H:i:s'))
                                @php
                                    $counter_tareas++
                                @endphp
                            @endif
                        @endforeach
                        
                        @if ($counter_tareas > 0)
                            <a class="show-ct option" href="#"><i class="mr-2 nav-icon i-Bell"></i>Tareas <span class="card-notify-count">@php echo $counter_tareas @endphp</span></a>
                        @else
                            <a class="show-ct option" href="#"><i class="mr-2 nav-icon i-Bell"></i>Tareas</a>
                        @endif
                    </li>
                    <li>
                        <a class="show-ca option" href="#"><i class="mr-2 nav-icon i-Mailbox-Empty"></i>Anuncios</a>
                    </li>
                    <li>
                        <a class="show-cc option" href="#"><i class="mr-2 nav-icon i-Medal-2"></i>Calificaciones</a>
                    </li>
                </ul>
            </div>
            <div class="options-group">
                <div class="options-title">
                    <p class="options-name">Información general</p>
                </div>
                <ul class="options">
                    <li>
                        <a class="show-cd option" href="#"><i class="mr-2 nav-icon i-Geek"></i>Docente</a>
                    </li>
                    <li>
                        <a class="show-cal option" href="#"><i class="mr-2 nav-icon i-Student-Hat-2"></i>Alumnos</a>
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
            <li>
                <a class="item" href="#"><i class="nav-icon i-Speach-Bubbles"></i><span>Foros</span></a>
            </li>
            <li>
                <a class="show-ct item" href="#"><i class="nav-icon i-Bell"></i><span>Tareas</span></a>
            </li>
            <li>
                <a class="show-ca item" href="#"><i class="nav-icon i-Mailbox-Empty"></i><span>Anuncios</span></a>
            </li>
            <li>
                <a class="show-cc item" href="#"><i class="nav-icon i-Medal-2"></i><span>Calificaciones</span></a>
            </li>
            <li>
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
            </li>
        </ul>
    </div>
</body>
@endsection

@section('page-js')

<script>
    document.getElementById('btn-more').addEventListener("click", function(){
        document.getElementById('item-more').classList.toggle('show-item-more');
    });

    $(document).ready( function () {
        $("#cm").hide();
        $("#ct").show();
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