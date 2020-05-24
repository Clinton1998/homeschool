<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-panel-alumno.css')}}">
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
            <li class="menu-lateral-item {{ request()->is('alumno/cursos*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('alumno/cursos')}}">
                    <i class="nav-icon i-Sidebar-Window"></i>
                    <br>
                    <span>Mis Cursos</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('alumno/calendario*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('alumno/calendario')}}">
                    <i class="nav-icon i-Calendar"></i>
                    <br>
                    <span>Mi calendario</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('alumno/tareas*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('alumno/tareas')}}">
                    <i class="nav-icon i-Box-Full"></i>
                    <br>
                    <span>Mis tareas</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('alumno/docentes*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('alumno/docentes')}}">
                    <i class="nav-icon i-Geek"></i>
                    <br>
                    <span>Mis docentes</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('alumno/companieros*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('alumno/companieros')}}">
                    <i class="nav-icon i-MaleFemale"></i>
                    <br>
                    <span>Mis compañeros</span>
                </a>
            </li>
            
        </ul>
        <!-- FIN DE NUEVO MENU SLIDER -->
        
        <!--<ul class="navigation-left">

            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('home')}}">
                    <i class="nav-icon i-Optimization"></i>
                    <span class="nav-text">Tablero</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('alumno/calendario*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('alumno/calendario')}}">
                    <i class="nav-icon i-Calendar"></i>
                    <span class="nav-text">Mi calendario</span>
                </a>
                <div class="triangle"></div>
            </li>
            
            <li class="nav-item {{ request()->is('alumno/tareas*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('alumno/tareas')}}">
                    <i class="nav-icon i-Box-Full"></i>
                    <span class="nav-text">Mis tareas</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('alumno/docentes*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('alumno/docentes')}}">
                    <i class="nav-icon i-Geek"></i>
                    <span class="nav-text">Mis docentes</span>
                </a>
                <div class="triangle"></div>
            </li>
            
            <li class="nav-item {{ request()->is('alumno/companieros*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('alumno/companieros')}}">
                    <i class="nav-icon i-MaleFemale"></i>
                    <span class="nav-text">Mis compañeros</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>-->
    </div>

    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->