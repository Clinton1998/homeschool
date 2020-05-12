@extends('reutilizable.principal')

@section('main-content')
<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}">
</head>

<body>
    <h2 class="titulo">Docentes</h2>

    <div class="mis-alumnos-contenedor card col col-lg-6">
        <div class="card-body">
            <div class="tareas-encabezado">
                <h4>Lista de docentes con los que trabajo</h4>
                <div class="tareas-linea"></div>
            </div>

            <div class="input-group">
                <input type="text" class="form-control" id="inpBuscarNombreDocente" placeholder="Nombre de docente"
                    aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button>
                </div>
            </div>

            <br>

            <div class="text-center" id="spinnerBuscadorDocente" style="display:none;">
                <div class="spinner-bubble spinner-bubble-primary m-5"></div>
            </div>

            <ul class="contenedor-scroll-grupo lista-docentes list-group list-group-flush" id="listDocentes">
                @foreach($docentes as $docente)
                    <li class="list-group-item tarea-pendiente-alumno" style="padding: 0;">
                        <a href="#" class="a-info-docente" data-toggle="modal" data-target="#modal-datos-docente" style="color: #000000; display: block; padding: 12px 20px;">
                            <input type="hidden" value="{{$docente->id_docente}}">
                        @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                            @if(strtoupper($docente->c_sexo)=='M')
                                <img class="foto-perfil" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Fotografía">
                            @else
                                <img class="foto-perfil" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Fotografía">
                            @endif
                        @else
                            <img class="foto-perfil" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Fotografía">
                        @endif
                        <span class="hs_capitalize">{{$docente->c_nombre}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-datos-docente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos del docente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $docente_default = $docentes->first();
                    @endphp
                        <div class="text-center" id="spinnerInfoDocente" style="display: none;">
                            <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                        </div>
                    @if(!is_null($docente_default) && !empty($docente_default))
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
                            <h3 id="infoNombreDocente" class="hs_capitalize">{{$docente_default->c_nombre}}</h3>
                            <h4>Especialidad</h4>
                            <p id="infoEspecilidadDocente" class="hs_capitalize">{{$docente_default->c_especialidad}}</p>
                            <h4>Correo electrónico</h4>
                            <p id="infoCorreoDocente" class="hs_lower">{{$docente_default->c_correo}}</p>
                            <h4>Teléfono</h4>
                            <p id="infoTelefonoDocente">{{$docente_default->c_telefono}}</p>
                        </div>
                    @else
                        <div class="datos-docente" id="divInfoDocente">
                            <img class="foto-perfil-lg" id="imgInfoDocente" src="" alt="Fotografía">
                            <h3 id="infoNombreDocente" class="hs_capitalize"></h3>
                            <h4></h4>
                            <p id="infoEspecilidadDocente" class="hs_capitalize"></p>
                            <h4></h4>
                            <p id="infoCorreoDocente" class="hs_lower"></p>
                            <h4></h4>
                            <p id="infoTelefonoDocente"></p>
                        </div>
                    @endif
                    
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
</body>

@endsection
@section('page-js')
<!-- page script -->
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/docente/docentes.js')}}"></script>
@endsection