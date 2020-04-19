<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">

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
            
        </ul>
    </div>

    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->