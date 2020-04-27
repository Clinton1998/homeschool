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
        <link rel="shortcut icon" href="{{asset('assets/images/Logo-HS.png')}}">
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
            <div class="loader spinner-bubble spinner-bubble-primary">
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





        {{-- common js --}}
        <script src="{{  asset('assets/js/common-bundle-script.js')}}"></script>
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