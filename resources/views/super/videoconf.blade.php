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
@endsection
