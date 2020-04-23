<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
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
    </head>


    <body class="text-left">
        @php
        $tipo_usuario = '';

            if(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0){
                //se trata de un superadministrador del colegio
                $tipo_usuario = 'superadministrador';
            }else if(!is_null(Auth::user()->id_docente)){
                $tipo_usuario = 'docente';
            }else if(!is_null(Auth::user()->id_alumno)){
                $tipo_usuario = 'alumno';
            }else{
                //es un usuario root de Innova Sistemas  Integrales
                $tipo_usuario = 'root';
            }

            $colegio = '';
            $re_alumno = '';
            $re_docente = '';
            //consulta del usuario
            $imagen_usuario = 'user.png';
            if($tipo_usuario=='docente'){
                $re_docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
                $colegio = $re_docente->colegio;
                /*if($re_docente->c_sexo==='M'){
                    $imagen_usuario = 'teacherman.png';
                }else{
                    $imagen_usuario = 'teacherwoman.png';
                }*/
            }else if($tipo_usuario=='alumno'){
                $re_alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);

                $colegio = $re_alumno->seccion->grado->colegio;
                /*if($re_alumno->c_sexo==='M'){
                    $imagen_usuario = 'studentman.png';
                }else{
                    $imagen_usuario = 'studentwoman.png';
                }*/
            }else if($tipo_usuario=='superadministrador'){
                $colegio = App\Colegio_m::where('id_superadministrador','=',Auth::user()->id)->first();
            }

        @endphp
        <!-- Pre Loader Strat  -->
        <div class='loadscreen' id="preloader">
            <div class="loader spinner-bubble spinner-bubble-primary">
            </div>
        </div>
        <!-- Pre Loader end  -->

    
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

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->

        <!-- ============ Large Sidebar Layout End ============= -->

        @include('layouts.herramientas.customizer')



        {{-- common js --}}
        <script src="{{  asset('assets/js/common-bundle-script.js')}}"></script>
        {{-- page specific javascript --}}
        @yield('page-js')

        {{-- theme javascript --}}
        {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
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

        {{-- laravel js --}}
        {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

        @yield('bottom-js')
    </body>

</html>