@extends('reutilizable.principal')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}">
</head>

<section>
    <h2 class="titulo">Herramientas para videoclase</h2>

    <div class="hs_message card">
        <div class="card-body">
            <p>
                <strong>HOMESCHOOL de INNOVA SISTEMAS INTEGRALES S.A.C</strong><br>
                Sugiere las siguientes herramientas para realizar una videoclase o una video conferencia. Estas herramientas son gratuitas y de uso público, por lo que pueden presentar ciertas limitaciones y restricciones. Si Ud. o su institución, desea utilizar una herramienta de uso privado, escribanos a <strong><em>soporte@innovaqp.com</em></strong>
            </p>
        </div>
    </div>

    <div class="apps">
        <div class="jitsi">
            <div class="card">
                <div class="card-body">
                    <img class="app-logo logo-jitsi" src="{{asset('assets/images/jitsi-blue.png')}}" alt="Jitsi">
                    <h3 class="app-name"3>Jitsi Meet</h3>
                    <p class="app-description"p>Jitsi Meet es una herramienta multiplataforma y gratuita que permite hacer videoconferencias grupales a través de Internet.</p>
                    <a class="app-btn btn-jitsi  btn" href="#" onclick="window.open('https://meet.jit.si/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br><br>
                    <a class="link-jitsi text-link" href="#" onclick="window.open('https://jitsi.org/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Más información</a>
                </div>
            </div>
        </div>
        <div class="hangouts">
            <div class="card">
                <div class="card-body">
                    <img class="app-logo" src="{{asset('assets/images/hangouts.png')}}" alt="Hangouts">
                    <h3 class="app-name">Google Hangouts</h3>
                    <p class="app-description">Google Hangouts es una herramienta para realizar una videoconferencia en directo y poder tener una sesión de preguntas y respuestas con otros usuarios.</p>
                    <a class="app-btn btn-hangouts btn" href="#" onclick="window.open('https://accounts.google.com/signin/v2/dentifier?service=talk&continue=https%3A%2F%2Fhangouts.google.com%2F&flowName=GlifWebSignIn&flowEntry=ServiceLogin','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br><br>
                    <a class="link-hangouts text-link" href="#" onclick="window.open('https://hangouts.google.com/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Más información</a>
                </div>
            </div>
        </div>
        <div class="meet" disabled>
            <div class="card">
                <div class="card-body">
                    <img class="app-logo" src="{{asset('assets/images/meet.png')}}" alt="Meet">
                    <h3 class="app-name"3>Google Meet</h3>
                    <p class="app-description"p>Google Meet es la aplicación de videoconferencias de Google, para navegadores web y dispositivos móviles, enfocada al entorno laboral.</p>
                    <a class="app-btn btn-meet  btn" href="#" onclick="window.open('https://meet.google.com/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Iniciar videoclase</a>
                    <br><br>
                    <a class="link-meet text-link" href="#" onclick="window.open('https://meet.google.com/','_blank','location=no,menubar=no,height=500,width=900,scrollbars=yes,status=yes')">Más información</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection