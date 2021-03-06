@extends('reutilizable.principal')
@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
</head>

<h2 class="hs_titulo">Mis compañeros</h2>

<div class="card">
    <div class="card-body">
        <div class="row mb-3" style="displa: flex; justify-content: center;">
            <div class="col-lg-4 col-sm-5 col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control ul-form-input" placeholder="Nombre de tu compañero">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="hs_encabezado">
            <div class="hs_encabezado-linea"></div>
        </div>
        <div class="row" style="displa: flex; justify-content: center;">
            @foreach($companieros as $companiero)
                <div class="col-lg-5 col-sm-12 col-xs-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="ul-contact-page__profile">
                                <div class="user-profile d-flex">
                                    @if(is_null($companiero->c_foto)  || empty($companiero->c_foto))
                                        @if(strtoupper($companiero->c_sexo)=='M')
                                            <img class="img-fluid rounded" src="{{asset('assets/images/usuario/studentman.png')}}" alt="Fotografía">
                                        @else
                                            <img class="img-fluid rounded" src="{{asset('assets/images/usuario/studentwoman.png')}}" alt="Fotografía">
                                        @endif
                                    @else
                                        <img class="img-fluid rounded" src="{{url('super/alumno/foto/'.$companiero->c_foto)}}" alt="Fotografía">
                                    @endif
                                </div>
                                <div class="ul-contact-page__info">
                                    <h4 class="hs_capitalize">{{mb_strtolower($companiero->c_nombre)}}</h4>
                                    <p class="text-muted m-0 hs_lower">{{$companiero->c_correo}}</p>
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
