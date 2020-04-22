@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">   
    
@endsection

@section('main-content')
<section class="contact-list">
        <div class="row">
            <div class="col-xs-12 col-md-6 offset-md-3">
                <form  id="frmCambiarContrasenaAlumno" method="POST" class="needs-validation" action="{{ url('/alumno/cambiarcontrasena') }}" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="nueva_contrasena">Nueva contraseña</label>
                        <input type="password" class="form-control @error('nueva_contrasena') is-invalid @enderror" name="nueva_contrasena" id="nueva_contrasena" minlength="6" required>
                        <span class="invalid-feedback" role="alert">
                            <strong>Debe ser como mínimo 6 caracteres</strong>
                        </span>
                        @error('nueva_contrasena')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="repite_nueva_contrasena">Repite la nueva contraseña</label>
                        <input type="password" class="form-control @error('repite_nueva_contrasena') is-invalid @enderror" id="repite_nueva_contrasena" name="repite_nueva_contrasena" minlength="6" required>
                        @error('repite_nueva_contrasena')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg">Cambiar</button>
                    </div>
                </form>
            </div>
        </div>
</section>
@endsection

@section('page-js')
<!-- page script -->

<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
@endsection