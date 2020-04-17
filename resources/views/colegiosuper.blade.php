@extends('reutilizable.principal')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">


@endsection

@section('main-content')


<section class="ul-contact-detail">
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card pt-3" >
                <div class="text-center">
                    @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
                        <img class="w-30" src="{{asset('assets/images/colegio/school.png')}}" alt="Logo de la institución educativa">
                    @else
                        <img class="w-30" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" alt="Logo de la institución educativa">
                    @endif
                    
                </div>
                <div class="card-body">
                    <div class="ul-contact-detail__info">
                        <div class="row">
                            <div class="col-6 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <h5>RUC</h5>
                                <span>{{$colegio->c_ruc}}</span>
                                </div>
                                <div class="ul-contact-detail__info-1">
                                    <h5>Email</h5>
                                <span>{{$colegio->c_correo}}</span>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <h5>Razon social</h5>
                                <span>{{$colegio->c_razon_social}}</span>
                                </div>
                                 <div class="ul-contact-detail__info-1">
                                    <h5>Teléfono</h5>
                                    <span>{{$colegio->c_telefono}}</span>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <div class="ul-contact-detail__info-1">
                                        <h5>Representante legal</h5>
                                <span class="text-primary">{{$colegio->c_dni_representante}}</span> <span>{{$colegio->c_representante_legal}}</span>
                                </div>
                            </div>
                            <!--<div class="col-12 text-center">
                                
                                    <div class="ul-contact-detail__social">
                                        <div class="ul-contact-detail__social-1">
                                            <button type="button" class="btn btn-d btn-icon m-1">
                                                <span class="ul-btn__icon"><i class="i-Teacher"></i></span>
                                            </button>
                                            <span class="t-font-boldest ul-contact-detail__followers">900</span>
                                        </div>
                                        <div class="ul-contact-detail__social-1">
                                            <button type="button" class="btn btn-dribble btn-icon m-1">
                                                <span class="ul-btn__icon"><i class="i-Dribble"></i></span>
                                                
                                            </button>
                                            <span class="t-font-boldest ul-contact-detail__followers">658</span>
                                        </div>
                                    </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-8">
            <!-- begin::basic-tab -->
            <div class="card mb-4 mt-4">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @if($errors->has('contrasenia') || $errors->has('repite_contrasenia'))
                                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                                <a class="nav-item nav-link active show " id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Datos de acceso</a>
                            @else
                                <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                                <a class="nav-item nav-link " id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Datos de acceso</a>
                            @endif
                            <a class="nav-item nav-link" id="nav-logo-tab" data-toggle="tab" href="#nav-logo" role="tab" aria-controls="nav-logo" aria-selected="false">Logo</a>
                        </div>
                    </nav>
                    <div class="tab-content ul-tab__content" id="nav-tabContent">
                        @if($errors->has('contrasenia') || $errors->has('repite_contrasenia'))
                            <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @else
                            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @endif
                        
                            <form method="POST" action="{{ route('super/colegio/actualizar') }}" id="frmactualizacioncolegio">
                                @csrf
                                <div class="form-group row">
                                    <label for="inpActRuc" class="col-sm-2 col-form-label text-right">RUC</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('ruc') is-invalid @enderror" id="inpActRuc" name="ruc" value="{{$colegio->c_ruc}}" readonly>
                                        @error('ruc')
                                             <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>

                                    <label for="inpActRazonSocial" class="col-sm-2 form-label text-right">Razon social</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('razon_social') is-invalid @enderror" id="inpActRazonSocial" name="razon_social" value="{{$colegio->c_razon_social}}" readonly>
                                        @error('razon_social')
                                             <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inpActCorreo" class="col-sm-2 col-form-label text-right">Correo</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('correo') is-invalid @enderror"  id="inpActCorreo" name="correo" value="{{$colegio->c_correo}}">
                                        @error('correo')
                                             <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>

                                    <label for="inpActTelefono" class="col-sm-2 col-form-label text-right">Teléfono</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="inpActTelefono" name="telefono" value="{{$colegio->c_telefono}}">
                                        @error('telefono')
                                             <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <h6 class="text-center text-primary">Representante legal</h6>
                                <div class="form-group row">
                                    <label for="inpActDniRepresentante" class="col-sm-2 col-form-label text-right">DNI</label>

                                    <div class="col-sm-4 input-group mb-3">
                                        <input type="text"id="inpActDniRepresentante" name="dni"
                                        class="form-control @error('dni') is-invalid @enderror" value="{{$colegio->c_dni_representante}}">    
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary ladda-button"  data-style="expand-right" id="btnBuscarPorDNI">Buscar</button>
                                        </div>
                                        @error('dni')
                                             <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>
                                    <label for="inpActNombreRepresentante" class="col-sm-2 col-form-label text-right">Nombre</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="inpActNombreRepresentante" name="nombre" value="{{$colegio->c_representante_legal}}">
                                        @error('nombre')
                                             <span class="invalid-feedback" role="alert">
                                                 <strong>{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-12 col-sm-6 offset-sm-3">
                                        <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if($errors->has('contrasenia') || $errors->has('repite_contrasenia'))
                            <div class="tab-pane fade active show" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        @else
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        @endif
                                        <div class="form-group row">
                                            <label for="inpNombreUsuario" class="col-sm-2 col-form-label">Usuario</label>
                                            <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inpNombreUsuario" value="{{Auth::user()->email}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inpPasswordUsuario" class="col-sm-2 col-form-label">Contraseña</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inpPasswordUsuario" value="Tu contraseña secreta" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="text-primary">Cambiar contraseña</h5>
                                        <form method="POST" action="{{ route('super/usuario/cambiarcontrasena') }}" id="frmactualizacioncolegio">
                                            @csrf
                                        <div class="form-group row">
                                            <label for="inpContra" class="col-sm-2 col-form-label">Nueva contraseña</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control @error('contrasenia') is-invalid @enderror" name="contrasenia" id="inpContra" required>
                                                @error('contrasenia')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inpContraRepet" class="col-sm-2 col-form-label">Repite contraseña</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control @error('repite_contrasenia') is-invalid @enderror" id="inpContraRepet" name="repite_contrasenia" required>
                                                @error('repite_contrasenia')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                                            </div>
                                        </div>
                                    </form>
                        </div>
                        <div class="tab-pane fade" id="nav-logo" role="tabpanel" aria-labelledby="nav-logo-tab">
                            <div class="row mb-4">
                                <div class="col-md-12 mb-4">
                                    <div class="card text-left">

                                        <div class="card-body">
                                            <h4 class="card-title">Logo de colegio</h4>
                                            <form id="frmSubidaLogoColegio" class="needs-validation" method="POST" action="{{route('super/colegio/cambiarlogo')}}" enctype="multipart/form-data" novalidate>
                                                @csrf
                                                <div class="form-group">
                                                    <input type='file' class="form-control form-control-lg" id="logocolegio" name="logocolegio" required>
                                                    <span class="invalid-feedback" role="alert">
                                                        Elige el logo de tu colegio
                                                    </span>
                                                </div>                                                
                                                <div class="form-group row">
                                                    <div class="col-xs-12 col-sm-6 offset-3">
                                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Subir</button>
                                                    </div>
                                                </div>                                                
                                            </form> 
                                        </div>
                                    </div>
                
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end::basic-tab -->
        </div>
    </div>
</section>


@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/superadmin/colegio.js')}}"></script>

@endsection