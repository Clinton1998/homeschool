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
                    <span>Materias</span>
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
        </ul> 
        <!-- FIN DE NUEVO MENU SLIDER -->
        
        <!--<ul class="navigation-left">
            <li class="nav-item ">
            <a class="nav-item-hold" href="">
                    <i class="nav-icon i-Bar-Chart"></i>
            <span class="nav-text">Tablero</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item ">
                <a class="nav-item-hold" href="">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Colegio</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item ">
                <a class="nav-item-hold" href="">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Docentes</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item ">
                <a class="nav-item-hold" href="">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Alumnos</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('super/grados*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('super/grados')}}">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Grados</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('super/secciones*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('super/secciones')}}">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Secciones</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item ">
                <a class="nav-item-hold" href="">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Categorias y materias</span>
                </a>
                <div class="triangle"></div>
            </li>
            
        </ul>-->
    </div>

    
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->