<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @php
            $colegio = '';
            $re_alumno = '';
            $re_docente = '';
            $tipo_usuario = '';
            $msg_concord = null;
            $estado_fecha_concord = null;
            $falta_concord = null;
            if(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0){
                //se trata de un superadministrador del colegio
                $colegio = App\Colegio_m::where('id_superadministrador','=',Auth::user()->id)->first();
                $tipo_usuario ='superadministrador';
            }else if(!is_null(Auth::user()->id_docente)){
                $re_docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
                $colegio = $re_docente->colegio;
                $tipo_usuario ='docente';
            }else if(!is_null(Auth::user()->id_alumno)){
                $re_alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
                $colegio = $re_alumno->seccion->grado->colegio;
                $tipo_usuario ='alumno';
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
                      }else{
                        if($array_response['estado_fecha']=='porvencer'){
                          $msg_concord = $array_response['message'];
                          $estado_fecha_concord = 'porvencer';
                        }else if($array_response['estado_fecha']=='vencido'){
                          $msg_concord = $array_response['message'];
                          $estado_fecha_concord = 'vencido';
                          $falta_concord = $array_response['falta'];
                        }else if($array_response['estado_fecha']=='vigente'){
                          $msg_concord = $array_response['message'];
                          $estado_fecha_concord = 'vigente';
                        }
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
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Home School</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        @yield('before-css')
        {{-- theme css --}}
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome-free-5.10.1-web/css/all.css')}}">
        @if($tipo_usuario=='superadministrador')
            <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
            <link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">
        @endif
        {{-- page specific css --}}
        @yield('page-css')
        <!--vanilla toast-->
        <link rel="stylesheet" href="{{asset('assets/styles/css/libreria/vanillatoast/vanillatoasts.css')}}">
        <!--end vanilla toast-->
        <!--Push js-->
        <script src="{{asset('assets/js/libreria/push/push.min.js')}}"></script>
        <!--end Push js-->
        <script src="{{asset('js/app.js')}}" defer></script>
        @if($tipo_usuario=='docente' || $tipo_usuario=='alumno')
          @if(request()->is('docente/tarea/*')  || request()->is('alumno/tareapendiente/*') || request()->is('alumno/tareavencida/*') || request()->is('alumno/tareaenviada/*'))
            <script src="{{asset('js/comment.js')}}" defer></script>
          @endif
        @endif
        <script>
            window.Laravel = <?php echo json_encode([
                //'csrfToken' => csrf_token(),
                'X-CSRF-TOKEN' => csrf_token()
            ]); ?>
        </script>
        <script>
            window.Laravel.userId = <?php echo Auth::user()->id; ?>
        </script>
    </head>
    <body class="text-left">
        <div class='loadscreen' id="preloader">
            <div class="loader spinner-bubble spinner-bubble-light">
            </div>
        </div>

        <div class="app-admin-wrap layout-sidebar-large clearfix">
            @if($tipo_usuario=="superadministrador")
                @include('layouts.menusegunusuario.superadministrador')
                @include('layouts.sidebarsegunusuario.superadministrador')
                @include('layouts.tools')
            @elseif($tipo_usuario=='docente')
                @include('layouts.menusegunusuario.docente')
                @include('layouts.sidebarsegunusuario.docente')
            @elseif($tipo_usuario=='alumno')
                @include('layouts.menusegunusuario.alumno')
                @include('layouts.sidebarsegunusuario.alumno')
            @else
                @include('layouts.menusegunusuario.root')
                @include('layouts.sidebarsegunusuario.root')
            @endif
            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap sidenav-open d-flex flex-column">
                <div class="main-content">
                    @yield('main-content')
                </div>
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Large Sidebar Layout End ============= -->


<div class="modal fade" id="mdlShowComunicado" tabindex="-1" role="dialog" aria-labelledby="mdlShowComunicadoTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mdlShowComunicadoTitle">Nuevo comunicado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="text-primary" id="tituloShowComunicado"></h5>
        <p id="descripcionShowComunicado"></p>
        <div id="archivoShowComunicado"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="OPEN-NTF-MAIN" tabindex="-1" role="dialog" aria-labelledby="OPEN-NTFLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pl-2 pr-2">
                        <div class="text-center hs_capitalize-first"><strong id="n-title"></strong></div>
                        <br>
                        <div id="n-content" class="hs_capitalize-first"></div>
                        <br>
                        <div id="n-date" class="text-right"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="" class="btn btn-primary" data-dismiss="modal">Anuncio leído</button>
                </div>
            </div>
        </div>
    </div>



        {{-- common js --}}
        <script src="{{  asset('assets/js/common-bundle-script.js')}}"></script>
        <!--vanilla toast-->
        <script src="{{  asset('assets/js/libreria/vanillatoast/vanillatoasts.js')}}"></script>
        <!--end vanilla toast-->
        @if($tipo_usuario=='superadministrador')
            <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>
            <script src="{{asset('assets/js/superadmin/general.js')}}"></script>
            <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
            <script>
              toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "60000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
              }
            </script>

            @if(is_null($colegio->t_corte_prueba) && !is_null($colegio->c_token) && !empty($colegio->c_token))
              <script>
                $('#mdlLicenciaConcord').on('show.bs.modal',function(){
                  $('#mdlActualizarClave').modal('hide');
                });
                $('#mdlActualizarClave').on('show.bs.modal',function(){
                  $('#mdlLicenciaConcord').modal('hide');
                });
                $('#btnActualizarClaveLicencia').on('click',fxActualizarClaveLicencia);
                function fxActualizarClaveLicencia(){
                  $('#mdlActualizarClave').modal('hide');
                  $.ajax({
                    type: 'POST',
                    url: '/licencia/clave/actualizar',
                    data: {
                      token: $('#inpTokenLicencia').val(),
                      clave: $('#inpNuevaClaveLicencia').val()
                    },
                    error: function(error){
                      alert('Ocurrió un error');
                      console.error(error);
                      location.reload();
                    }
                  }).done(function(data){
                    if(data.correcto){
                      toastr.success('Clave de licencia actualizada');
                      location.reload();
                    }else{
                      location.reload();
                    }
                  });
                }
              </script>
            @endif
            @if(request()->is('/') || request()->is('home'))
              @if(!is_null($msg_concord))
                @if($estado_fecha_concord=='porvencer')
                  <script>
                    toastr.warning('{{$msg_concord}}');
                  </script>
                @elseif($estado_fecha_concord=='vencido')
                  <script>
                    toastr.error('{{$msg_concord}}');
                  </script>
                @endif
              @endif

            @else
              @if(!is_null($msg_concord))
                @if($estado_fecha_concord=='vencido')
                  @if(((int)$falta_concord*(-1))>=28)
                    <script>
                        toastr.error('{{$msg_concord}}');
                    </script>
                  @endif
                @endif
              @endif
            @endif
        @endif
        {{-- page specific javascript --}}
        @yield('page-js')
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>
        <script src="{{asset('assets/js/customizer.script.js')}}"></script>
        <script>
            $.ajaxSetup({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
        </script>
        @yield('bottom-js')
    </body>

</html>
