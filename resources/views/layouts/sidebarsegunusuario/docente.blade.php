<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">

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
            
            <li class="nav-item {{ request()->is('docente/*') ? 'active' : '' }}">
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
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->