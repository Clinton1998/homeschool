@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection
@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
</head>

<body>
    <h2 class="hs_titulo">Grados y secciones</h2>

    <div class="row hs_contenedor">
        <div class="card  col col-lg-7 col-sm-12">
            <div class="card-body">
                <div class="hs_encabezado">
                    <h4 class="hs_encabezado-titulo">Mis grados y secciones</h4>
                    <div class="hs_encabezado-linea"></div>
                </div>

                <div class="botonera-superior-derecha">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#hs_MODAL" onclick="GradoSeccion()">Nueva sección</button>
                </div>

                <div class="table-responsive">
                    <table id="ul-contact-list" class="hs_tabla display table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nivel</th>
                                <th>Grado</th>
                                <th>Sección</th>
                                <th>Acciones</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($TMP as $item)
                                <tr>
                                    <td>
                                        {{ucfirst(strtolower($item->c_nivel_academico))}}
                                    </td>
                                    <td>
                                        @if ($item->c_nombre === '1-.3 AÑOS' || $item->c_nombre === '2-.4 AÑOS' || $item->c_nombre === '3-.5 AÑOS')
                                            {{substr($item->nom_grado,3)}}
                                        @else
                                            {{ucfirst(substr(strtolower($item->c_nombre),3))}}
                                        @endif
                                    </td>
                                    <td class="hs_upper text-center">
                                        {{$item->nom_seccion}}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="badge badge-warning" id="btnActualizarSeccion{{$item->id_seccion}}" onclick="fxActualizarSeccion({{$item->id_seccion}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a>
                                        <a href="#" class="badge badge-danger" id="btnConfirmacionEliminarSeccion{{$item->id_seccion}}" onclick="fxConfirmacionEliminarSeccion({{$item->id_seccion}});" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>
                                    </td>
                                    <td>
                                        {{-- Llamada a modal Alumnos--}}
                                        <a href="#" class="badge badge-success" onclick="fxAlumnosDeSeccion({{$item->id_seccion}},event);">
                                           Alumnos
                                        </a>
                                         {{-- Llamada a modal Docentes--}}
                                        <a href="#" class="badge badge-info" onclick="fxDocentesDeSeccion({{$item->id_seccion}},event);">
                                            Docentes
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Guardar -->
    <div class="modal fade" id="hs_MODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nueva sección</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmAgregarSeccion" class="needs-validation" method="POST" action="{{url('/super/gradoseccion/agregar')}}" novalidate>
                        <div class="form-group">
                            @csrf
                            <label for="picker2">Nivel - Grado</label>
                            <select class="form-control" id="id_grado" name="id_grado">
                                <option>-- Eliga el nivel-grado --</option>
                                @foreach ($grados as $item)
                                    @if ($item->c_nombre === '1-.3 AÑOS' || $item->c_nombre === '2-.4 AÑOS' || $item->c_nombre === '3-.5 AÑOS')
                                        <option value="{{$item->id_grado}}">{{ucfirst(strtolower($item->c_nivel_academico))}} - {{substr($item->c_nombre,3)}} </option>
                                    @else
                                        <option value="{{$item->id_grado}}">{{ucfirst(strtolower($item->c_nivel_academico))}} - {{ucfirst(substr(strtolower($item->c_nombre),3))}} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Sección</label>
                            <input type="text" class="form-control" id="nombre"name="nombre"  placeholder="Ejemplo: A" required>
                            <div class="invalid-feedback">
                                La sección es necesaria
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmAgregarSeccion">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Actualizar -->
    <div class="modal fade" id="hs_MODAL-2" tabindex="-1" role="dialog" aria-labelledby="hs_MODAL-2Label" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nueva sección</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmActualizar" class="needs-validation" method="POST" action="{{url('/super/gradoseccion/actualizar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="id_seccion" name="id_seccion">

                        <div class="form-group">
                            <label for="actnombre">Sección</label>
                            <input type="text" class=" hs_upper form-control" id="actnombre" name="actnombre"  placeholder="Ejemplo: A" required>
                            <div class="invalid-feedback">
                                La sección es necesaria
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmActualizar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- lista de alumnos --}}
    <div class="modal fade" id="alumnos_seccion" tabindex="-1" role="dialog" aria-labelledby="alumnos_seccionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alumnos de la sección</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinnerInfoAlumnos">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>
                <div id="divAlumnos" style="display: none;">
                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Valeria Espinoza Rázuri</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Apoderado:&nbsp;</strong>
                                        <p class="hs_capitalize">Eva María Rázuri Torres&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_telefono">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Telf.:&nbsp;</strong>
                                        <p>950404040&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    {{-- lista de docentes --}}
    <div class="modal fade" id="docentes_seccion" tabindex="-1" role="dialog" aria-labelledby="docentes_seccionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Docentes de la sección</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinnerInfoDocentes">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>
                <div id="divDocentes">
                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">Matemática y Computación&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}

                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">Matemática y Computación&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}

                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">Matemática y Computación&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}

                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">Matemática y Computación&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}

                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">Matemática y Computación&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}

                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize"><i class="nav-icon i-ID-Card">&nbsp;</i>Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p><i class="nav-icon i-ID-Card">&nbsp;</i>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong><i class="nav-icon i-Address-Book">&nbsp;</i>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext"><i class="nav-icon i-Mail-with-At-Sign">&nbsp;</i>correo_electronico_extenso@gmail.com</p>
                                </div>
                            </div>

                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">Matemática y Computación&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="#" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin de card --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

</body>

@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>

<script>

    $('#ul-contact-list').DataTable( {
        //paging: false,
        //"bInfo" : false
    } );

    $(document).ready( function () {
        $("#nombre").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toUpperCase());
            });
        });
        $("#actnombre").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toUpperCase());
            });
        })
    });

    jQuery(document).ready(function() {
        jQuery('#nombre').keypress(function(tecla) {
            if((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90)) return false;
        });
        jQuery('#actnombre').keypress(function(tecla) {
            if((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90)) return false;
        });
    });

</script>

<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/ladda.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/superadmin/secciones.js')}}"></script>

@endsection
