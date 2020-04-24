<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @php
            $tipo_usuario = '';
            $canal_pusher = '';
            $evento_pusher = '';
            if(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0){
                //se trata de un superadministrador del colegio
                $tipo_usuario = 'superadministrador';
            }else if(!is_null(Auth::user()->id_docente)){
                $tipo_usuario = 'docente';
            }else if(!is_null(Auth::user()->id_alumno)){
                $canal_pusher = 'my-alumno';
                $evento_pusher = 'my-event-alumno';
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
            }else if($tipo_usuario=='alumno'){
                $re_alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
                $colegio = $re_alumno->seccion->grado->colegio;
            }else if($tipo_usuario=='superadministrador'){
                $colegio = App\Colegio_m::where('id_superadministrador','=',Auth::user()->id)->first();
            }

        @endphp
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Home School</title>
        <script src="{{asset('js/app.js')}}" defer></script>
        <!--Push js-->
        <!--<script src="{{asset('assets/js/libreria/push/push.min.js')}}"></script>-->
        <!--end Push js-->
        <!--Pusher-->
        <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
        <!--<script>

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;
            var pusher = new Pusher('6e8b84639be32b05da2c', {
              cluster: 'us2',
              forceTLS: true
            });
            var channel = pusher.subscribe('App.User.{{Auth::user()->id}}');
            channel.bind('App\Notifications\NuevaTareaParaAlumnoNotification', function(data) {
              var respuesta = JSON.parse(JSON.stringify(data));
              console.log(respuesta);
                var new_noti = '<div class="dropdown-item para-contador d-flex">';
                new_noti += '<div class="notification-icon">';
                new_noti += '<i class="i-Speach-Bubble-6 text-primary mr-1"></i>';
                new_noti += '</div>';
                new_noti += '<div class="notification-details flex-grow-1">';
                new_noti += '<p class="m-0 d-flex align-items-center">';
                new_noti += '<span>'+respuesta.respuesta.titulo+'</span>';
                new_noti += '<span class="flex-grow-1"></span>';
                new_noti += '<span class="text-small text-muted ml-auto">'+respuesta.respuesta.created_at+'</span>';
                new_noti +='</p>';
                new_noti += '<p class="text-small text-muted m-0">'+respuesta.respuesta.mensaje+'</p>';
                new_noti += '</div>';
                new_noti += '</div>';
                $('#dropdownNotificaciones').prepend(new_noti);
                $('#dropdownNotification').find('span').text(($('#dropdownNotificaciones>.para-contador').length));
                
                Push.create(respuesta.respuesta.titulo, {
                    body: respuesta.respuesta.mensaje,
                    icon: '/assets/images/Logo-Innova.png',
                    timeout: 20000,
                    vibrate: [200,100],
                    onClick: function () {
                    window.focus();
                    this.close();
                    }
                });
            });
          </script>-->
        <!--end pusher-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        @yield('before-css')
        {{-- theme css --}}
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        
        <link rel="shortcut icon" href="{{asset('assets/images/Logo-HS.png')}}">

        {{-- page specific css --}}
        @yield('page-css')

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