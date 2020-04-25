<head>
    <style>
        .hs_lower {
            text-transform: lowercase;
        }

        .hs_upper {
            text-transform: uppercase;
        }

        .hs_capitalize {
            text-transform: capitalize;
        }

        .hs_capitalize-first::first-letter {
            text-transform: uppercase;
        }
    </style>
</head>

<div class="main-header">
    <div class="logo">
        @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
            <img class="" src="{{asset('assets/images/colegio/school.png')}}" alt="Institución Educativa">
        @else
            <img class="" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" alt="Institución Educativa">
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
        <div class="d-flex align-items-center">Bienvenido(a) {{$colegio->c_representante_legal}}</div>
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
            <img src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="Usuario">

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{ Auth::user()->email }}
                    </div>
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
