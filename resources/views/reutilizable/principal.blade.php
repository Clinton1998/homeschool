<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @php
            $colegio = '';
            $re_alumno = '';
            $re_docente = '';
            $tipo_usuario = '';
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
            $fecha_corte = '';
            if (!is_null($colegio->t_corte_prueba) && is_null($colegio->t_corte_normal)) {
                //version prueba del usuario, con dias gratuitos
                $fecha_corte = $colegio->t_corte_prueba;
            } else if (is_null($colegio->t_corte_prueba) && !is_null($colegio->t_corte_normal)) {
                //version normal cuando ya se pagó por el sistema
                $fecha_corte = $colegio->t_corte_normal;
            }
            if (date('Y-m-d H:i:s') >= $fecha_corte) {
                Session::flush();
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
        @endif
        {{-- page specific css --}}
        @yield('page-css')

        <!--Push js-->
        <script src="{{asset('assets/js/libreria/push/push.min.js')}}"></script>
        <!--end Push js-->
        <script src="{{asset('js/app.js')}}" defer></script>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
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
  <div class="modal-dialog modal-dialog-centered" role="document">
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
        <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Leído</button>
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
        @if($tipo_usuario=='superadministrador')
            <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>
            <script src="{{asset('assets/js/superadmin/general.js')}}"></script>
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
