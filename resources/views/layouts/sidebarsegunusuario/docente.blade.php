<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-overwrite.css')}}">
</head>

<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- INICIO DE NUEVO MENU SLIDER -->
        <ul class="menu-lateral ">
            <li class="menu-lateral-item {{ request()->is('datatables/*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="">
                    <i class="nav-icon i-Optimization"></i>
                    <br>
                    <span>Tablero</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('docente/docente*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/docente')}}">
                    <i class="nav-icon i-Geek"></i>
                    <br>
                    <span>Docentes</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('docente/alumno*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/alumno')}}">
                    <i class="nav-icon i-Student-Hat-2"></i>
                    <br>
                    <span>Mis alumnos</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('docente/asignartareas*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/asignartareas')}}">
                    <i class="nav-icon i-Notepad"></i>
                    <br>
                    <span>Asignación de tareas</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('docente/estadotareas*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/estadotareas')}}">
                    <i class="nav-icon i-Folder-With-Document"></i>
                    <br>
                    <span>Estado de tareas</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('docente/videoclase*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('docente/videoclase')}}">
                    <i class="nav-icon i-Movie"></i>
                    <br>
                    <span>Videoclase</span>
                </a>
            </li>
        </ul>
        <!-- INICIO DE NUEVO MENU SLIDER -->
        
        <!--<ul class="navigation-left">

            <li class="nav-item {{ request()->is('datatables/*') ? 'active' : '' }}" data-item="item-dashboard">
                <a class="nav-item-hold" href="{{route('basic-tables')}}">
                    <i class="nav-icon i-Optimization"></i>
                    <span class="nav-text">Tablero</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('docente/docente*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('docente/docente')}}">
                    <i class="nav-icon i-Geek"></i>
                    <span class="nav-text">Docentes</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('docente/alumno*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('docente/alumno')}}">
                    <i class="nav-icon i-Student-Hat-2"></i>
                    <span class="nav-text">Mis alumnos</span>
                </a>
                <div class="triangle"></div>
            </li>
            
            <li class="nav-item {{ request()->is('docente/asignartareas*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('docente/asignartareas')}}">
                    <i class="nav-icon i-Notepad"></i>
                    <span class="nav-text">Asignación de tareas</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('docente/estadotareas*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('docente/estadotareas')}}">
                    <i class="nav-icon i-Folder-With-Document"></i>
                    <span class="nav-text">Estado de tareas</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('docente/videoclase*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('docente/videoclase')}}">
                    <i class="nav-icon i-Movie"></i>
                    <span class="nav-text">Videoclase</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>-->
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->