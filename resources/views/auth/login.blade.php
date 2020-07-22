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
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/css/style-panel-docente.css')}}">

        <style>
            a {
                color: black;
            }

            .btn-primary {
                background-color: #3498db;
                border: none;
            }

            .btn-primary:active,
            .btn-primary:link,
            .btn-primary:visited,
            .btn-primary:focus {
                background-color: #2980b9 !important;
                box-shadow: none !important;
                border: none !important;
            }

            .btn-primary:hover {
                background-color: #2980b9;
                box-shadow: none;
            }

            .form-control:focus {
                border-color: #3498db;
                box-shadow: none;
            }

            .text-primary {
                color: #3498db; !important;
            }
        </style>

    </head>

    <body>

        <div class="login_container">
            <div class="login_form">
                <div class="login_controls">
                    @if(Session::has('message'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{Session::get('message')}}
                            @if(Session::has('cuotas'))
                            <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#mdlCuotas">Ver cuotas</a>
                            @endif
                            @if(Session::has('btnactualizarclave'))
                                <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#mdlActualizarClave">Actualizar clave</a>
                            @endif
                        </div>
                    @endif
                    <form method="POST" id="frmLogin" action="{{ route('login') }}">
                        @csrf
                        {{-- Usuario --}}
                        <div class="form-group text-left">
                            <label for="email" style="color: white">Usuario</label>
                            @if(Session::has('actclave_usuario'))
                            <input type="text" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ Session::get('actclave_usuario') }}" required autocomplete="usuario"
                                autofocus>
                            @else
                            <input type="text" id="email"
                                class="form-control  @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="usuario"
                                autofocus>
                            @endif
    
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- Contraseña --}}
                        <div class="form-group text-left">
                            <label for="password" style="color: white">Contraseña</label>
                            @if(Session::get('actclave_password'))
                            <input type="password" id="password"
                                class="form-control  @error('password') is-invalid @enderror"
                                name="password" value="{{Session::get('actclave_password')}}" required autocomplete="current-password">
                            @else
                                <input type="password" id="password"
                                    class="form-control  @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                            @endif
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        {{-- Recuérdame --}}
                        <div class="form-group text-right" >
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                    <label class="form-check-label" for="remember" style="color: white">
                                        {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>
    
                        {{-- Ingresar --}}
                        <button class="form_button">Ingresar</button>
                    </form>
    
                    {{-- Registrar mi colegio --}}
                    <div class="hs_login-footer mt-2">
                        <a href="/register" id="btn-registrar" class="" style="color: white; margin-top: 10px">Registrar mi colegio</a>
    
                        {{-- @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="hs_olvide-contraseña text-muted"><u>Olvidé mi contraseña</u></a>
                        @endif --}}
                    </div>
                </div>
            </div>

        </div>

        @if(Session::has('cuotas'))
            <div id="mdlCuotas" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Número cuota</th>
                                <th>F.V.</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                $cuotas = Session::get('cuotas');
                                @endphp
                                @for($i = 0; $i<count($cuotas); $i++)
                                <tr>
                                    <td>{{$cuotas[$i]['c_numero_cuota']}}</td>
                                    <td>{{$cuotas[$i]['t_fecha_vencimiento']}}</td>
                                    <td>{{$cuotas[$i]['n_monto']}}</td>
                                    @if($cuotas[$i]['c_estado']=='PEN')
                                        <td>Pendiente</td>
                                    @else
                                        <td>Pagado</td>
                                    @endif
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
            </div>

        @endif

        @if(Session::has('btnactualizarclave'))
            <div id="mdlActualizarClave" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-info text-center">Actualizar Clave de licencia</h2>
                    <div class="form-group">
                        <input type="hidden" id="inpTokenLicencia" value="{{Session::get('btnactualizarclave')}}">
                        <label for="inpNuevaClaveLicencia">Ingrese nueva clave suministrada por el proveedor</label>
                        <input type="text" class="form-control form-control-lg" id="inpNuevaClaveLicencia" style="font-size: 3em;" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnActualizarClaveLicencia">Actualizar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
            </div>

        @endif

        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
        <!--<script src="{{asset('assets/js/script.js')}}"></script>-->
        @if(Session::has('btnactualizarclave'))
          <script src="{{asset('assets/js/auth/login.js')}}"></script>
        @endif
    </body>

</html>
