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
                    <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                </div>
            </div>
        </div>
        <div class="hs_encabezado">
            <div class="hs_encabezado-linea"></div>
        </div>
        <div class="row" id="rowMisDocentes" style="displa: flex; justify-content: center;">
            @foreach($docentes as $docente)
                <div class="col-lg-5 col-xl-5 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="ul-contact-page__profile">
                                <div class="user-profile">
                                @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                                    @if(strtoupper($docente->c_sexo)=='M')
                                        <img class="profile-picture mb-1" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                                    @else
                                        <img class="profile-picture mb-1" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                                    @endif
                                @else
                                    <img class="profile-picture mb-1" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Foto del docente">
                                @endif
                                </div>
                                <div class="ul-contact-page__info">
                                    <h4 class="hs_capitalize">{{strtolower($docente->c_nombre)}}</h4>
                                    <p class="text-muted hs_capitalize">{{$docente->c_nacionalidad}}</p>
                                    <p class="text-muted">{{ucfirst(strtolower($docente->c_direccion))}}</p>
                                    <p class="text-muted hs_lower"><a href="mailto:{{$docente->c_correo}}">{{$docente->c_correo}}</a></p>
                                    <p class="text-muted">{{$docente->c_telefono}}</p>
                                </div>
                            </div>
                        </div>
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