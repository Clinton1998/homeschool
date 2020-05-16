<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/header-nav.css')}}">
</head>

<div class="main-header">
    {{-- menu amberguesa --}}
    <div class="burger_menu">
        <div class="menu-toggle">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div id="CORTE" class="d-flex align-items-center">
            @if(is_null($colegio->t_corte_normal) && !is_null($colegio->t_corte_prueba))
                @php
                    $fecha1= new DateTime($colegio->t_corte_prueba);
                    $fecha2= new DateTime( date('Y-m-d'));
                    $diff = $fecha1->diff($fecha2);    
                @endphp
                @if($diff->days==0)
                    <span class="badge badge-danger cursos-badge-comunicado" data-toggle="modal" data-target="#mdlInfoComunicadoSistema">Te quedan pocos minutos gratis</span>
                @elseif($diff->days==1)
                    <span class="badge badge-danger cursos-badge-comunicado" data-toggle="modal" data-target="#mdlInfoComunicadoSistema">Te quedan 1 día gratis</span>
                @else
                    <span class="badge badge-danger cursos-badge-comunicado" data-toggle="modal" data-target="#mdlInfoComunicadoSistema">Te quedan {{$diff->days}} días gratis</span>  
                @endif
            @endif
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
            <p class="user_name_text ml-1 mr-1">{{$colegio->c_representante_legal}}</p>
        </div>
        {{-- opciones de perfil de usuario --}}
        <div class="user_profile">
            <!-- User avatar dropdown -->
            <div class="dropdown">
                <div  class="">
                    @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
                        <img class="user_avatar" src="{{asset('assets/images/colegio/school.png')}}" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="Usuario">
                    @else
                        <img class="user_avatar" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="Usuario">
                    @endif
                    <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="userDropdown">
                        <div class="dropdown-header">
                            <p class="user_name_text user_name_in">{{$colegio->c_representante_legal}}</p>
                            {{-- <i class="i-Lock-User mr-1"></i> --}}ID: {{ Auth::user()->email }}
                        </div>
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

<!--modal para mostrar informacion de sistema-->
<div class="modal" tabindex="-1" role="dialog" id="mdlInfoComunicadoSistema">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <p>
          <strong>Estimado (a), <span id="spnNombreInfo">{{$colegio->c_representante_legal}}</span> esta es una versión gratuita de la PLATAFORMA EDUCATIVA HOMESCHOOL V.1.0. Podrás tener acceso a la misma por 6 días. Luego de este plazo deberás comunicarte al 973 477 015, para poder extender el plazo por todo el {{date('Y')}}.</strong>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
<!--endInformacionSistema-->
