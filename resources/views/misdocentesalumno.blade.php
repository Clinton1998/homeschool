@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
@endsection
@section('main-content')
<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
</head>

<h2 class="hs_titulo">Mis docentes</h2>

<div class="card">
    <div class="card-body">
        <div class="row mb-3" style="displa: flex; justify-content: center;">
            <div class="col-lg-4 col-sm-5 col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control" id="inpBuscarNombreDocente" placeholder="Nombre de docente"
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button>
                    </div>
                </div>
                <div class="text-center" id="spinnerBuscadorDocente" style="display:none;">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>
            </div>
        </div>
        <div class="hs_encabezado">
            <div class="hs_encabezado-linea"></div>
        </div>
        <div class="row" id="rowMisDocentes" style="displa: flex; justify-content: center;">
            @foreach($docentes as $docente)
                <div class="box-card card docente-card col-lg-3">
                    <div class="card-body text-center docente-card-body">
                        @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                            @if(strtoupper($docente->c_sexo)=='M')
                                <img class="docente-photo" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                            @else
                                <img class="docente-photo" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                            @endif
                        @else
                            <img class="docente-photo" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Foto del docente">
                        @endif
                        <h5 class="docente-name hs_upper">{{$docente->c_nombre}}</h5>
                        <strong>Cursos a cargo</strong>
                        @foreach ($cursos_docente as $c)
                            @if ($c->id_docente == $docente->id_docente)
                                <p class="docente-specialty hs_capitalize-first">{{$c->nom_curso}}</p>
                            @endif
                        @endforeach
                        <br>
                        <strong>Correo electrónico</strong>
                        <a href="mailto:{{$docente->c_correo}}"><p class="docente-email">{{$docente->c_correo}}</p></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@section('page-js')
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/alumno/misdocentes.js')}}"></script>
@endsection