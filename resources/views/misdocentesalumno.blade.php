@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
@endsection
@section('main-content')
<section class="ul-contact-page">
    <div class="row">
        <div class="col-xs-12 col-sm-4 mb-4">
            <div class="input-group">
                <input type="text" class="form-control" id="inpBuscarNombreDocente" placeholder="Nombre de docente"
                    aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center" id="spinnerBuscadorDocente" style="display:none;">
        <div class="spinner-bubble spinner-bubble-primary m-5"></div>
    </div>

    <div class="row" id="rowMisDocentes">
        @foreach($docentes as $docente)
            <div class="col-lg-4 col-xl-4 mb-2">
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
                                <p class="m-0 text-24">{{$docente->c_nombre}}</p>
                                <p class="text-muted m-0">{{$docente->c_nacionalidad}}</p>
                                <p class="text-muted mt-3">{{$docente->c_direccion}}</p>
                            <p class="text-muted mt-3"><a href="mailto:{{$docente->c_correo}}">{{$docente->c_correo}}</a></p>
                            <p class="text-muted mt-3">{{$docente->c_telefono}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

  
    </div>
  </section>
@endsection
@section('page-js')
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/alumno/misdocentes.js')}}"></script>
@endsection