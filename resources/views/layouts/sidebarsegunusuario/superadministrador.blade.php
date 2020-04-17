<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-item-hold" href="{{route('home')}}">
                    <i class="nav-icon i-Bar-Chart"></i>
            <span class="nav-text">Tablero</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('super/colegio*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('super/colegio')}}">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Colegio</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('super/docente*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('super/docentes')}}">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Docentes</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('super/alumno*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('super/alumnos')}}">
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
            <li class="nav-item {{ request()->is('super/categorias*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('super/categorias')}}">
                    <i class="nav-icon i-File-Horizontal-Text"></i>
                    <span class="nav-text">Categorias y materias</span>
                </a>
                <div class="triangle"></div>
            </li>
            
        </ul>
    </div>

    
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->