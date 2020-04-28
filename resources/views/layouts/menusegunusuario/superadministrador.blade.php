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
        .cursos-badge-comunicado{
            cursor: pointer;
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
            @if(is_null($colegio->c_logo)  || empty($colegio->c_logo))
                <img class="" src="{{asset('assets/images/colegio/school.png')}}" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="Usuario">
            @else
                <img class="" src="{{url('super/colegio/logo/'.$colegio->c_logo)}}" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" alt="Usuario">
            @endif
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
