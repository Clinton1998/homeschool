@extends('reutilizable.principal')
@section('main-content')
<section class="ul-contact-page">
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="form-group ul-form-group d-flex align-items-center">
                <input type="text" class="form-control ul-form-input" placeholder="Ingresa un nombre.....">
            </div>
        </div>

        @foreach($companieros as $companiero)
            <div class="col-lg-3 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="ul-contact-page__profile">
                            <div class="user-profile">
                                @if(is_null($companiero->c_foto)  || empty($companiero->c_foto))
                                    @if(strtoupper($companiero->c_sexo)=='M')
                                        <img class="profile-picture mb-1" src="{{asset('assets/images/usuario/studentman.png')}}" alt="Foto del alumno">
                                    @else
                                        <img class="profile-picture mb-1" src="{{asset('assets/images/usuario/studentwoman.png')}}" alt="Foto de la alumna">
                                    @endif

                                @else
                                    <img class="profile-picture mb-1" src="{{url('super/alumno/foto/'.$companiero->c_foto)}}" alt="Foto del alumno">
                                @endif
                            </div>
                            <div class="ul-contact-page__info">
                                <p class="m-0 text-24">{{$companiero->c_nombre}}</p>
                                <p class="text-muted m-0">{{$companiero->c_nacionalidad}}</p>
                                <p class="text-muted mt-3">{{$companiero->c_direccion}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
  
    </div>
  </section>
@endsection