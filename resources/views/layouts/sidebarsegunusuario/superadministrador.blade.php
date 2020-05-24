<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-panel-super.css')}}">
</head>

<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- INICIO DE NUEVO MENU SLIDER -->
        <ul class="menu-lateral ">
            <li class="menu-lateral-item {{ request()->is('home') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('home')}}">
                    <i class="nav-icon i-Optimization"></i>
                    <br>
                    <span>Tablero</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/colegio*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/colegio')}}">
                    <i class="nav-icon i-University"></i>
                    <br>
                    <span>Colegio</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/gradoseccion*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/gradoseccion')}}">
                    <i class="nav-icon i-Tag"></i>
                    <br>
                    <span>Grados y secciones</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/categorias*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/categorias')}}">
                    <i class="nav-icon i-Library"></i>
                    <br>
                    <span>Cursos</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/docente*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/docentes')}}">
                    <i class="nav-icon i-Geek"></i>
                    <br>
                    <span>Docentes</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/alumno*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/alumnos')}}">
                    <i class="nav-icon i-Student-Hat-2"></i>
                    <br>
                    <span>Alumnos</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/videoconferencia*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/videoconferencia')}}">
                    <i class="nav-icon i-Movie"></i>
                    <br>
                    <span>Videoconferencia</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('super/comunicados*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/comunicados')}}">
                    <i class="nav-icon i-Movie"></i>
                    <br>
                    <span>Comunicados</span>
                </a>
            </li>

            <li class="nav-item menu-lateral-item {{ request()->is('super/facturacion/*') ? 'item-activo' : '' }}" data-item="itemfacturacion">
                <a class="nav-item-hold menu-lateral-item-link" href="#">
                    <i class="nav-icon i-Library"></i>
                    <span class="nav-text">Facturación electrónica</span>
                </a>
                <div class="triangle"></div>
            </li>

        </ul> 
        <!-- FIN DE NUEVO MENU SLIDER -->
    </div>


    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="childNav" data-parent="itemfacturacion">
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='alerts' ? 'item-open' : '' }}" href="{{route('alerts')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Series</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='super/facturacion/productos' ? 'item-activo' : '' }}" href="{{route('super/facturacion/productos')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Productos o servicios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Preferencias</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Comprobantes electrónicos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Comprobante</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Notas electrónicos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Nota</span>
                </a>
            </li>

        </ul>
    </div>

    
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->