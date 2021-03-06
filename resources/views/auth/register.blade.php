<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Home School</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">
    </head>

    <body>
        <div class="auth-layout-wrap" style="background-image: url({{asset('assets/images/photo-wide-4.jpeg')}})">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-4">
                                <form method="POST" action="{{ route('register') }}" id="frmregistrocolegio">
                                    @csrf
                                <h1 class="mb-3 text-18">Institución educativa</h1>
                                        <div class="form-group">
                                            <label for="ruc">RUC</label>
                                             <div class="input-group mb-3">
                                                <input type="text"id="ruc" name="ruc"
                                             class="form-control-rounded form-control @error('ruc') is-invalid @enderror" value="{{old('ruc')}}" minlength="11" maxlength="11" required autocomplete="ruc" autofocus>    
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary ladda-button"  data-style="expand-right" id="btnBuscarPorRuc">Buscar</button>
                                                </div>

                                                @error('ruc')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label for="razonsocial">Razon social</label>
                                            <input type="text" id="razonsocial" name="razonsocial" 
                                        class="form-control-rounded form-control @error('razonsocial') is-invalid @enderror" value="{{old('razonsocial')}}" required readonly>
        
                                            @error('razonsocial')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="nombrecolegio">Nombre de la institución</label>
                                        <input type="text" id="nombrecolegio" name="nombrecolegio" class="form-control-rounded form-control @error('nombrecolegio') is-invalid @enderror" value="{{old('nombrecolegio')}}" required>

                                            @error('nombrecolegio')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
        
                                        <div class="form-group">
                                            <label for="correo">Correo electrónico</label>
                                            <input type="email" id="correo" name="correo"
                                                class="form-control-rounded form-control @error('correo') is-invalid @enderror" value="{{old('correo')}}" required>
        
                                            @error('correo')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror 
                                        </div>
        
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" id="telefono" name="telefono"
                                        class="form-control-rounded form-control @error('telefono') is-invalid @enderror" value="{{old('telefono')}}" required>
        
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror 
                                        </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4">
                                            @if($errors->has('email'))
                                            <div class="form-group">
                                                <label for="dni">DNI representante legal</label>

                                                <div class="input-group mb-3">
                                                    
                                                    <input id="dni" type="text"
                                                    class="form-control-rounded form-control @error('dni') is-invalid @enderror"
                                                    name="dni" value="" minlength="8" maxlength="8" required autocomplete="dni" form="frmregistrocolegio">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary ladda-button"  data-style="expand-right" id="btnBuscarPorDni">Buscar</button>
                                                    </div>

                                                    @error('dni')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="nombre">Nombre representante legal</label>
                                                <input id="nombre" type="text"
                                                    class="form-control-rounded form-control @error('nombre') is-invalid @enderror"
                                                    name="nombre" value="" required readonly form="frmregistrocolegio">
        
                                                @error('nombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                    
                                    
                                            <h1 class="mb-3 text-15">Datos de acceso para la plataforma</h1>

                                            <div class="form-group">
                                                <label for="email">Nombre de usuario</label>
                                                <input id="email" type="text"
                                                    class="form-control-rounded form-control @error('email') is-invalid @enderror"
                                                    name="email" value="" autocomplete="email" form="frmregistrocolegio" required readonly>
        
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Es necesario un usuario válido, pruebe otra vez.</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input id="password" type="password"
                                                    class="form-control-rounded form-control @error('password') is-invalid @enderror"
                                                    name="password" minlength="6" required autocomplete="new-password" form="frmregistrocolegio">
        
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="repassword">Repite contraseña</label>
                                                <input id="password-confirm" type="password"
                                                    class="form-control-rounded form-control" name="password_confirmation"
                                                     autocomplete="new-password" form="frmregistrocolegio" minlength="6" required>
                                            </div>

                                            @else
                                            <div class="form-group">
                                                <label for="dni">DNI representante legal</label>

                                                <div class="input-group mb-3">
                                                    
                                                    <input id="dni" type="text"
                                                    class="form-control-rounded form-control @error('dni') is-invalid @enderror"
                                                    name="dni" value="{{ old('dni') }}" minlength="8" maxlength="8" required autocomplete="dni" form="frmregistrocolegio">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary ladda-button"  data-style="expand-right" id="btnBuscarPorDni">Buscar</button>
                                                    </div>
                                                    @error('dni')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="nombre">Nombre representante legal</label>
                                                <input id="nombre" type="text"
                                                    class="form-control-rounded form-control @error('nombre') is-invalid @enderror"
                                                    name="nombre" value="{{ old('nombre') }}" required readonly form="frmregistrocolegio">
        
                                                @error('nombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                    
                                    
                                            <h1 class="mb-3 text-15">Datos de acceso para la plataforma</h1>

                                            <div class="form-group">
                                                <label for="email">Nombre de usuario</label>
                                                <input id="email" type="text"
                                                    class="form-control-rounded form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" autocomplete="email" form="frmregistrocolegio" required readonly>
        
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Es necesario un usuario válido, pruebe otra vez.</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input id="password" type="password"
                                                    class="form-control-rounded form-control @error('password') is-invalid @enderror"
                                                    name="password" minlength="6" required autocomplete="new-password" form="frmregistrocolegio">
        
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="repassword">Repite contraseña</label>
                                                <input id="password-confirm" type="password"
                                                    class="form-control-rounded form-control" name="password_confirmation"
                                                     autocomplete="new-password" form="frmregistrocolegio" minlength="6" required>
                                            </div>

                                            @endif
                                    
                                        <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3" form="frmregistrocolegio">Registrar</button>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
        <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
        <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
        
        <script src="{{asset('assets/js/ladda.script.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
        
        <script src="{{asset('assets/js/auth/register.js')}}"></script>
    </body>

</html>