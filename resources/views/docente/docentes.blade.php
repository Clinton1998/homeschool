@extends('reutilizable.principal')

@section('main-content')
<head>
    <style>
        :root {
            --color-primario: #5B30B1;
        }

        /*Sobreescribiendo Clases de Bootstrap*/

        .row {
            display: flex;
            justify-content: space-around;
        }

        .column {
            padding: 0;
            margin-bottom: 30px;
        }

        .btn {
            background-color: var(--color-primario);
            color: #FFF;
        }

        .btn:hover {
            background-color: var(--color-primario);
            color: #FFF;
        }

        /* Estilo propio */

        .color {
            background-color: var(--color-primario);
        }

        .titulo {
            background-color: rgb(238, 238, 238);
            color: var(--color-primario);
            width: 100%;
            margin-bottom: 30px;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 20px;
        }

        .buscador {
            background-color: rgb(238, 238, 238);
            padding: 15px;
            border-bottom: solid 1px lightgray;
        }

        .lista-docentes{
            height: 300px;
            overflow-y: scroll;
            scroll-behavior: smooth;
        }

        .foto-perfil{
            height: 35px;
            opacity: .7;
            margin-right: 15px
        }
        
        .datos-docente {
            text-align: center;
            padding: 25px;
        }

        .datos-docente .foto-perfil-lg {
            margin: 20px auto;
            height: 100px;
            opacity: .8;
        }

        .datos-docente  h5{
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="">
        <div class="row">
            <h3 class="titulo">DOCENTES CON LOS QUE TRABAJO</h3>
        </div>

        <div class="row">
            <div class="card column col-md-7">
                <div class="buscador">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inpBuscarNombreDocente" placeholder="Nombre de docente"
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn" type="button" id="button-addon2">Buscar</button>
                        </div>
                    </div>
                </div>

                <div class="text-center" id="spinnerBuscadorDocente" style="display:none;">
                    <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                </div>

                <ul class="lista-docentes list-group list-group-flush" id="listDocentes">
                    @foreach($docentes as $docente)
                        <li class="list-group-item">
                            <a href="#" class="a-info-docente">
                                <input type="hidden" value="{{$docente->id_docente}}">
                            @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                                @if(strtoupper($docente->c_sexo)=='M')
                                    <img class="foto-perfil" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                                @else
                                    <img class="foto-perfil" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                                @endif
                            @else
                                <img class="foto-perfil" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Foto del docente">
                            @endif
                            {{$docente->c_nombre}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card column col-md-4">
                @php
                    $docente_default = $docentes->first();
                @endphp
                <div class="text-center" id="spinnerInfoDocente" style="display: none;">
                    <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                </div>
                <div class="datos-docente" id="divInfoDocente">
                    @if(is_null($docente_default->c_foto)  || empty($docente_default->c_foto))
                        @if(strtoupper($docente_default->c_sexo)=='M')
                            <img class="foto-perfil-lg" id="imgInfoDocente" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Fotografía">
                        @else
                            <img class="foto-perfil-lg" id="imgInfoDocente" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Fotografía">
                        @endif
                    @else
                        <img class="foto-perfil-lg" id="imgInfoDocente" src="{{url('super/docente/foto/'.$docente_default->c_foto)}}" alt="Fotografía">
                    @endif
                    <h3 id="infoNombreDocente">{{$docente_default->c_nombre}}</h3>
                    <h4>Especialidad</h4>
                    <p id="infoEspecilidadDocente">{{$docente_default->c_especialidad}}</p>
                    <h4>Correo electrónico</h4>
                    <p id="infoCorreoDocente">{{$docente_default->c_correo}}</p>
                    <h4>Teléfono</h4>
                    <p id="infoTelefonoDocente">{{$docente_default->c_telefono}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
<!-- page script -->
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/docente/docentes.js')}}"></script>
@endsection