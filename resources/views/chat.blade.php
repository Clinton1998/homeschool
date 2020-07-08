<!doctype html>
<html lang="es">
<head>
    @php
            $colegio = '';
            if(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0){
                //se trata de un superadministrador del colegio
                $colegio = App\Colegio_m::where('id_superadministrador','=',Auth::user()->id)->first();
                $tipo_usuario ='superadministrador';
            }else if(!is_null(Auth::user()->id_docente)){
                $re_docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
                $colegio = $re_docente->colegio;
            }else if(!is_null(Auth::user()->id_alumno)){
                $re_alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
                $colegio = $re_alumno->seccion->grado->colegio;
            }

            if(!is_null($colegio->t_corte_prueba)){
              if (date('Y-m-d H:i:s') >= $colegio->t_corte_prueba) {
                  Session::flush();
              }
            }else if(!is_null($colegio->c_token) && !empty($colegio->c_token)){
              $configuracion = DB::table('configuracion_m')->first();
              //se valida con el software CONCORD
              $token = $colegio->c_token;
              $clave = $colegio->c_clave;
              $ch = curl_init($configuracion->c_api_concord.'/validar?clave='.$clave);
              curl_setopt($ch, CURLOPT_HTTPHEADER,['token:'.$token]);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
              $response = curl_exec($ch);
              curl_close($ch);
              $array_response = json_decode($response,true);
              if($array_response['success']){
                if($array_response['estado']){
                    if($array_response['estado_cuota']){
                      Session::flush();
                    }else{
                      //validacion de licencia
                      if($array_response['estado_fecha']=='cortado'){
                          Session::flush();
                      }
                    }
                }else{
                  //cuando el token no esta disponible o la clave es incorrecta
                  Session::flush();
                }
              }else{
                //cuando el token es incorrecto
                Session::flush();
              }
            }

        @endphp
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Home school</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('assets/chat/dist/media/img/favicon.png')}}" type="image/png">

    <!-- Soho css -->
    <link rel="stylesheet" href="{{asset('assets/chat/dist/css/soho.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <script src="{{asset('js/chat.js')}}" defer></script>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <script>
            window.Laravel.userId = <?php echo Auth::user()->id; ?>
        </script>
</head>
<body class="dark">

<!-- new group modal -->
<div class="modal" id="newGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-users"></i> Nuevo grupo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="group_name" class="col-form-label">Nombre de grupo</label>
                        <input type="text" class="form-control" id="group_name">
                    </div>
                    <div class="form-group">
                        <label for="optusuarios">Usuarios</label>
                        <select id="optusuarios" multiple>
                            @foreach($usuarios as $usuario)
                                    @php
                                        $nombre = '';
                                        if(is_null($usuario->id_docente) && is_null($usuario->id_alumno) && $usuario->b_root==0){
                                            $nombre = (App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first())->c_representante_legal;
                                        }else if(!is_null($usuario->id_docente)){
                                            $nombre = (App\Docente_d::findOrFail($usuario->id_docente))->c_nombre;
                                        }else if(!is_null($usuario->id_alumno)){
                                            $nombre = (App\Alumno_d::findOrFail($usuario->id_alumno))->c_nombre;
                                        }
                                    @endphp
                                    <option value="{{$usuario->id}}">{{$nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCrearGrupo">Crear grupo</button>
            </div>
        </div>
    </div>
</div>
<!-- ./ new group modal -->



<div class="layout" id="chat">


    <nav class="navigation">
        <div class="nav-group">
            <ul>
                <li>
                    <a class="logo" href="{{asset('/home')}}">
                        @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
                            <img class="img-fluid" src="{{asset('assets/images/colegio/school.png')}}" alt="Logo">
                        @else
                            <img class="img-fluid" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" alt="Logo">
                        @endif
                    </a>
                </li>
                <li>
                    <a data-navigation-target="chats" class="active" href="#">
                        <i class="ti-comment-alt"></i>
                    </a>
                </li>
                <li>
                    <a data-navigation-target="friends" href="#" class="notifiy_badge">
                        <i class="ti-user"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <chat-app :user="{{Auth::user()}}"><chat-app>

</div>

<script src="{{asset('assets/chat/vendor/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/chat/vendor/popper.min.js')}}"></script>
<script src="{{asset('assets/chat/vendor/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/chat/dist/js/soho.min.js')}}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/chat/dist/js/examples.js')}}"></script>
</body>
</html>
