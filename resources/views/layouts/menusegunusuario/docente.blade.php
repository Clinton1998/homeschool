<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/header-nav.css')}}">
</head>

<div class="main-header">
    <div class="header_container">
        {{-- menu amberguesa --}}
        <div class="burger_menu">
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        {{-- información del colegio --}}
        <div class="school_center">
            <div class="school_info">
                @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
                    <img class="school_image" src="{{asset('assets/images/colegio/school.png')}}" alt="Logo">
                @else
                    <img class="school_image" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" alt="Logo">
                @endif
                <div class="school_name">
                    {{$colegio->c_nombre}}
                </div>
            </div>
        </div>
        {{-- información del usuario --}}
        <div class="user_info">
            {{-- iconos --}}
            <div class="user_icons">
                {{-- pantalla completa --}}
                <i class="i-Full-Screen header-icon d-none d-md-inline-block" data-fullscreen data-toggle="tooltip" title="Pantalla completa"></i>

                {{-- chat del usuario --}}
                <div class="user_chat user_chat_off">
                    <div>
                        <a class="i-Speach-Bubble-Dialog header-icon" href="{{url('/chat')}}" data-toggle="tooltip" data-placement="bottom" title="Chat"></a>
                    </div>
                </div>
                {{-- notificaciones de usuario --}}
                <div class="user_notify">
                    <div id="app">
                        <notificacion v-bind:notificaciones="notificaciones"></notificacion>
                    </div>
                </div>
            </div>
            {{-- nombre de usuario --}}
            <div class="user_name">
                <p class="user_name_text ml-1 mr-1">{{$re_docente->c_nombre}}</p>
            </div>
            {{-- opciones de perfil de usuario --}}
            <div class="user_profile">
                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div  class="">
                        @if(is_null($re_docente->c_foto)  || empty($re_docente->c_foto))
                            @if(strtoupper($re_docente->c_sexo)=='M')
                                <img class="user_avatar" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @else
                                <img class="user_avatar" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @endif
                        @else
                            <img class="user_avatar" src="{{url('super/docente/foto/'.$re_docente->c_foto)}}" alt="Foto del docente" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @endif

                        <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <p class="user_name_text user_name_in">{{$re_docente->c_nombre}}</p>
                                {{-- <i class="i-Lock-User mr-1"></i> --}}ID: {{ Auth::user()->email }}
                            </div>
                            <a href="{{url('/docente/cambiarcontrasena')}}" class="dropdown-item">Cambiar contraseña</a>
                            {{-- <a class="dropdown-item">Acerca del software</a> --}}
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
    </div>
    <div id="chat_float">
        <div class="user_chat uc">
            <a class="i-Speach-Bubble-Dialog header-icon" href="{{url('/chat')}}" data-toggle="tooltip" data-placement="bottom" title="Chat"></a>
        </div>
    </div>
</div>

