<div class="main-header">
    <div class="logo">
        @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
            <img class="" src="{{asset('assets/images/colegio/school.png')}}" alt="Logo de la institución educativa">
        @else
            <img class="" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" alt="Logo de la institución educativa">
        @endif
    </div>

    <div class="menu-toggle">
        <div></div>
                <div></div>
        <div></div>
    </div>

    <div class="d-flex align-items-center">
        {{$colegio->c_nombre}}
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <div class="d-flex align-items-center">Bienvenido(a) {{$re_alumno->c_nombre}}</div>
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Notificaiton -->
        
        <div id="app">
            <notificacion v-bind:notificaciones="notificaciones"></notificacion>
        </div>
        <!-- Notificaiton End -->

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div  class="user col align-self-end">

            @if(is_null($re_alumno->c_foto)  || empty($re_alumno->c_foto))
                @if(strtoupper($re_alumno->c_sexo)=='M')
                    <img src="{{asset('assets/images/usuario/studentman.png')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @else
                    <img src="{{asset('assets/images/usuario/studentwoman.png')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @endif
            @else
                <img src="{{url('super/alumno/foto/'.$re_alumno->c_foto)}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @endif
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{Auth::user()->email}}
                    </div>
                    <a  href="{{url('/alumno/cambiarcontrasena')}}" class="dropdown-item">Cambiar contraseña</a>
                    <a class="dropdown-item">Acerca del software</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- header top menu end -->
