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
        
        <!--<div class="dropdown widget_dropdown">
            <i class="i-Safe-Box text-muted header-icon" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="menu-icon-grid">
                    <a href="#"><i class="i-Shop-4"></i> Home</a>
                    <a href="#"><i class="i-Library"></i> UI Kits</a>
                    <a href="#"><i class="i-Drop"></i> Apps</a>
                    <a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>
                    <a href="#"><i class="i-Checked-User"></i> Sessions</a>
                    <a href="#"><i class="i-Ambulance"></i> Support</a>
                </div>
            </div>
        </div>-->
        <!-- Notificaiton -->
        <!--<div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-primary">3</span>
                <i class="i-Bell text-muted header-icon"></i>
            </div>
            
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>New message</span>
                            <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">10 sec ago</span>
                        </p>
                        <p class="text-small text-muted m-0">James: Hey! are you busy?</p>
                    </div>
                </div>
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Receipt-3 text-success mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>New order received</span>
                            <span class="badge badge-pill badge-success ml-1 mr-1">new</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">2 hours ago</span>
                        </p>
                        <p class="text-small text-muted m-0">1 Headphone, 3 iPhone x</p>
                    </div>
                </div>
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Empty-Box text-danger mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>Product out of stock</span>
                            <span class="badge badge-pill badge-danger ml-1 mr-1">3</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">10 hours ago</span>
                        </p>
                        <p class="text-small text-muted m-0">Headphone E67, R98, XL90, Q77</p>
                    </div>
                </div>
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Data-Power text-success mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>Server Up!</span>
                            <span class="badge badge-pill badge-success ml-1 mr-1">3</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">14 hours ago</span>
                        </p>
                        <p class="text-small text-muted m-0">Server rebooted successfully</p>
                    </div>
                </div>
            </div>
        </div>-->
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
