@extends('reutilizable.principal')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
</head>

<section>
    <h2 class="hs_titulo">Herramientas para videoconferencia</h2>

    <div class="hs_message card">
        <div class="card-body">
            <p>
                <strong>HOMESCHOOL de INNOVA SISTEMAS INTEGRALES S.A.C</strong><br>
                Sugiere las siguientes herramientas para realizar una videoclase o una video conferencia. Estas herramientas son gratuitas y de uso público, por lo que pueden presentar ciertas limitaciones y restricciones. Si Ud. o su institución, desea utilizar una herramienta de uso privado, escribanos a <strong><em>soporte@innovaqp.com</em></strong>
            </p>
        </div>
    </div>

    <div class="apps">
        <div class="meet" disabled>
            <div class="card">
                <div class="card-body">
                    <div class="text-right" style="height: 10px">
                        <i class="nav-icon i-Medal-2 text-warning" style="font-size: 30px; display: absolute"></i>
                    </div>
                    <img class="app-logo" src="{{asset('assets/images/meet.png')}}" alt="Meet">
                    <h3 class="app-name"3>Google Meet</h3>
                    <a class="app-btn btn-meet  btn" href="#" onclick="window.open('https://meet.google.com/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br>
                    <br>
                    <p class="app-description"p>Google Meet es la aplicación de videoconferencias de Google, para navegadores web y dispositivos móviles, enfocada al entorno laboral.</p>
                    <a class="link-meet text-link" href="https://meet.google.com/" target="_blank">Ir a página</a>
                    <br><a class="link-meet text-link" href="https://youtu.be/9vpxVSh9tiI" target="_blank"><strong>Ver videotutorial</strong></a>
                </div>
            </div>
        </div>
        <div class="jitsi">
            <div class="card">
                <div class="card-body">
                    <img class="app-logo logo-jitsi" src="{{asset('assets/images/jitsi-blue.png')}}" alt="Jitsi">
                    <h3 class="app-name"3>Jitsi Meet</h3>
                    <a class="app-btn btn-jitsi  btn" href="#" onclick="window.open('https://meet.jit.si/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br>
                    <br>
                    <p class="app-description"p>Jitsi Meet es una herramienta multiplataforma y gratuita que permite hacer videoconferencias grupales a través de Internet.</p>
                    <a class="link-jitsi text-link" href="https://jitsi.org/" target="_blank">Ir a página</a>
                    <br><a class="link-jitsi text-link" href="https://youtu.be/tR3mKe8wFVA" target="_blank"><strong>Ver videotutorial</strong></a>
                </div>
            </div>
        </div>
        <div class="skype">
            <div class="card">
                <div class="card-body">
                    <img class="app-logo" src="{{asset('assets/images/skype.png')}}" alt="Skype">
                    <h3 class="app-name">Skype</h3>
                    <a class="app-btn btn-skype btn" href="#" onclick="window.open('https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=13&ct=1589058309&rver=7.1.6819.0&wp=MBI_SSL&wreply=https%3A%2F%2Flw.skype.com%2Flogin%2Foauth%2Fproxy%3Fclient_id%3D572381%26redirect_uri%3Dhttps%253A%252F%252Fweb.skype.com%252FAuth%252FPostHandler%26state%3Df60d6495-0165-4cce-9502-7033241cb584%26site_name%3Dlw.skype.com&lc=1033&id=293290&mkt=es-ES&psi=skype&lw=1&cobrandid=2befc4b5-19e3-46e8-8347-77317a16a5a5&client_flight=ReservedFlight33%2CReservedFlight67','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br>
                    <br>
                    <p class="app-description">Skype es un software que permite que todo el mundo se comunique, mediante llamadas y videollamadas gratuitas individuales y grupales.</p>
                    <a class="link-skype text-link" href="https://www.skype.com/es/" target="_blank">Ir a página</a>
                    <br><a class="link-skype text-link" href="https://youtu.be/7lAAV9SRdsw" target="_blank"><strong>Ver videotutorial</strong></a>
                </div>
            </div>
        </div>
        <div class="zoom" disabled>
            <div class="card">
                <div class="card-body">
                    <img class="app-logo" style="border-radius: 50%" src="{{asset('assets/images/zoom.png')}}" alt="Zoom">
                    <h3 class="app-name"3>Zoom</h3>
                    <a class="app-btn btn-jitsi  btn" href="#" onclick="window.open('https://zoom.us/join','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br>
                    <br>
                    <p class="app-description"p>Zoom es un servicio de videoconferencia basado en la nube que puede usar para reunirse virtualmente con otros, ya sea por video o solo audio.</p>
                    <a class="link-jitsi text-link" href="https://zoom.us/" target="_blank">Ir a página</a>
                    <br><a class="link-jitsi text-link" href="https://youtu.be/QSR1s_tNauk" target="_blank"><strong>Ver videotutorial</strong></a>
                </div>
            </div>
        </div>
    </div>
</section>







<!--<body onload="ContadorSeleccionados()">
    <h2 class="hs_titulo">Videoconferencia</h2>

    <div class="hs_contenedor row">
        <div class=" col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-dark" role="alert">
                        <strong>Bienvenida(o)</strong>, desde este módulo usted podrá iniciar una <strong>videoconferencia</strong> con alumnnos o docentes.
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 1:
                        </strong>
                        <p class="pasos-indicacion">
                            
                        </p>
                    </div>
                    <div class="pasos-accion">
                        <a type="button" class="abrir-hangouts btn btn-raised ripple btn-raised-secondary col col-lg-4 col-sm-12" target="_blank" href="https://accounts.google.com/signin/v2/identifier?service=talk&continue=https%3A%2F%2Fhangouts.google.com%2F&flowName=GlifWebSignIn&flowEntry=ServiceLogin">
                            Abrir Hangouts
                        </a>
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 2:
                        </strong>
                        <p class="pasos-indicacion">
                            
                        </p>
                    </div>
                    <div class="pasos-accion">
                        <div class="form-group mb-12">
                            <input type="text" class="form-control" id="txt-vinculo" placeholder="Pegue aquí el vinculo copiado">
                        </div>
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 3:
                        </strong>
                        <p class="pasos-indicacion">
                            
                        </p>
                    </div>
                    <div class="GRUPO-SELECCIONADO row">
                        <div class="col col-lg-6 col-sm-12">
                            <div class="">
                                <button type="button" class="btn btn-raised ripple btn-raised-secondary col col-lg-8 col-sm-12" data-toggle="modal" data-target="#Modal-Integrantes">
                                    Seleccionar integrantes
                                </button>

                                <br><br>
                                
                                <div id="mostrar-contador" class="col col-lg-8 col-sm-12" style="text-align: center">
                                    <small id="mostrar-contador-label">Integrantes seleccionados</small>
                                    <h1 id="contador-seleccionados"></h1>
                                </div>
                            </div>
                        </div>
                        <div class="lista-grupo-seleccionado col col-lg-6 col-sm-12 pasos-accion">
                            <ul id="alumnos-que-no-enviaron" class="gs contenedor-scroll-grupo list-group" style="margin: 0">
                                <li class="hs_item-lista seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="hs_item-lista seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="hs_item-lista seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="hs_item-lista seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                                <li class="hs_item-lista seleccionados list-group-item">
                                    {Nombre de integrante}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pasos">
                        <strong class="pasos-numero-paso">
                            PASO 4:
                        </strong>
                        <p class="pasos-indicacion">
                            Enviar vinculo para iniciar la videoclase
                        </p>
                    </div>
                    <div class="pasos-accion">
                        <button type="button" class="btn btn-primary btn-lg col col-sm-12" style="margin-top: 20px">
                            Enviar vinculo
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

     <div class="modal fade" id="Modal-Integrantes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seleccionar integrantes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">
                                Grupos
                            </h3>
                        </div>
                        <div class="ul-widget__head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line ul-widget-nav-tabs-line"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#ul-widget2-tab1-content"
                                        role="tab">
                                        Alumnos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#ul-widget2-tab2-content"
                                        role="tab">
                                        Docentes
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ul-widget__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="ul-widget2-tab1-content">
                                <div class="accordion" id="accordionRightIcon">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0" style="display: flex;">
                                                <label class="checkbox checkbox-outline-primary">
                                                    <input type="checkbox">
                                                    <span></span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a data-toggle="collapse" class="text-default collapsed" href="#GRUPO-ALUMNOS-1">
                                                    {Alumnos de 1 - B}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="GRUPO-ALUMNOS-1" class="collapse " data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <ul id="alumnos-que-no-enviaron" class="contenedor-scroll-grupo list-group">
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion" id="accordionRightIcon">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0" style="display: flex;">
                                                <label class="checkbox checkbox-outline-primary">
                                                    <input type="checkbox">
                                                    <span></span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a data-toggle="collapse" class="text-default collapsed" href="#GRUPO-ALUMNOS-2">
                                                    {Alumnos de 3 - A}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="GRUPO-ALUMNOS-2" class="collapse " data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <ul id="alumnos-que-no-enviaron" class="contenedor-scroll-grupo list-group">
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de alumno}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="tab-pane" id="ul-widget2-tab2-content">
                                <div class="accordion" id="accordionRightIcon">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0" style="display: flex;">
                                                <label class="checkbox checkbox-outline-primary">
                                                    <input type="checkbox">
                                                    <span></span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a data-toggle="collapse" class="text-default collapsed" href="#GRUPO-DOCENTES">
                                                    {Todos los docentes}
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="GRUPO-DOCENTES" class="collapse show" data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <ul id="alumnos-que-no-enviaron" class="contenedor-scroll-grupo list-group">
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                    <li class="hs_item-lista list-group-item">
                                                        <label class="checkbox checkbox-outline-primary">
                                                            <input type="checkbox">
                                                            <p>{Nombre de docente}</p>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="ContadorSeleccionados()">Grupo seleccionado</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ContadorSeleccionados(){

            var numIntegranntes = document.querySelector(".gs").childElementCount;

            if(numIntegranntes > 0){
                document.getElementById("contador-seleccionados").innerHTML = numIntegranntes;
            }
            else{
                document.getElementById("mostrar-contador-label").style.opacity = 0;
            }
        }
    </script>
</body>-->

@endsection