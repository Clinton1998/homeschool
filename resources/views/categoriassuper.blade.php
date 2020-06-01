@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')

<head>
  <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
</head>

<body onload="LlenarSelects()">

    <!--Contendor principal de los Cards-->
    <div class="row justify-content-center">

        <!--Aside: Asignaturas o cursos-->
        <div id="hs_aside_cursos" class="mb-3 col col-lg-5 col-md-5 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="hs_box_close">
                        <span id="hs_btn_close">X</span>
                    </div>

                    <div class="hs_encabezado">
                        <h4 class="text-center">Cursos</h4>
                        <div class="hs_encabezado-linea" style="margin-bottom: 5px;"></div>
                        <small>En este apartado, usted puede registrar cursos, áreas o asignaturas.</small>
                    </div>

                    <br>

                    <!--Formulario de asignaturas-->
                    <form id="frm_create_asignatura" method="POST" action="{{route('super/categorias/create_asignatura')}}" class="mb-2">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nom_asignatura">Nombre del curso</label>
                                    <input type="text" class="form-control" id="nom_asignatura" name="nom_asignatura" required placeholder="Ejemplo: Matemática">
                                    <div class="invalid-feedback">
                                        El curso necesita un nombre
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nom_asignatura">Color</label>
                                    <input disabled type="color" class="form-control" id="color_asignatura" name="color_asignatura" value="#bdc3c7">
                                    <div class="hs_mask" data-toggle="modal" data-target="#modal-color"></div>
                                    <div class="invalid-feedback">
                                        Necesitas establecer un color
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-group">
                                    <label for="nom_asignatura"> </label>
                                    <div>
                                        <button type="button" class="btn btn-secondary mr-1" onclick="Clear();">Cancelar</button>
                                        <button type="submit" id="btn_create_asignatura" class="btn btn-primary">Guardar</button>
                                        <button type="submit" id="btn_update_asignatura" class="btn btn-warning">Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--Modal de Color-->
                    <div id="modal-color" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Color de etiqueta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="hs_paleta">
                                        <div class="hs_muestra" style="background-color: #1abc9c;">#1abc9c</div>
                                        <div class="hs_muestra" style="background-color: #16a085;">#16a085</div>
                                        <div class="hs_muestra" style="background-color: #2ecc71;">#2ecc71</div>
                                        <div class="hs_muestra" style="background-color: #27ae60;">#27ae60</div>
                                        <div class="hs_muestra" style="background-color: #3498db;">#3498db</div>
                                        <div class="hs_muestra" style="background-color: #2980b9;">#2980b9</div>
                                        <div class="hs_muestra" style="background-color: #9b59b6;">#9b59b6</div>
                                        <div class="hs_muestra" style="background-color: #8e44ad;">#8e44ad</div>
                                        <div class="hs_muestra" style="background-color: #f1c40f;">#f1c40f</div>
                                        <div class="hs_muestra" style="background-color: #f39c12;">#f39c12</div>
                                        <div class="hs_muestra" style="background-color: #e67e22;">#e67e22</div>
                                        <div class="hs_muestra" style="background-color: #d35400;">#d35400</div>
                                        <div class="hs_muestra" style="background-color: #e74c3c;">#e74c3c</div>
                                        <div class="hs_muestra" style="background-color: #c0392b;">#c0392b</div>
                                        <div class="hs_muestra" style="background-color: #95a5a6;">#95a5a6</div>
                                        <div class="hs_muestra" style="background-color: #7f8c8d;">#7f8c8d</div>
                                        <div class="hs_muestra" style="background-color: #34495e;">#34495e</div>
                                        <div class="hs_muestra" style="background-color: #2c3e50;">#2c3e50</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tbl_asignaturas" class="hs_tabla nowrap table table-striped table-hover" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Curso</th>
                                    <th>Color</th>
                                    <th>Fecha</th>
                                    <th>Color</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--Section: Asignaturas - Secciones-->
        <div class="mb-3 col col-lg-7 col-md-7 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <div id="hs_separator">
                                <strong>AGREGAR CURSOS</strong>
                            </div>
                        </div>
                        <div class="ul-widget__head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line ul-widget-nav-tabs-line"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#ul-widget2-tab1-content"
                                        role="tab">
                                        Inicial
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#ul-widget2-tab2-content"
                                        role="tab">
                                        Primaria
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#ul-widget2-tab3-content"
                                        role="tab">
                                        Secundaria
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ul-widget__body">
                    <div class="tab-content">

                        <div class="tab-pane active" id="ul-widget2-tab1-content">
                            <div class="botonera-superior-derecha">
                                <button id="btn_inicial" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_asign_inicial">Asignar</button>
                            </div>

                            <div class="table-responsive">
                                <table id="tbl_inicial" class=" hs_tabla display table table-striped nowrap" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>id_s_c</th>
                                            <th>id_s</th>
                                            <th>id_c</th>
                                            <th>Asignatura</th>
                                            <th>Grado</th>
                                            <th>Sección</th>
                                            <th>Acciones</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="ul-widget2-tab2-content">
                            <div class="botonera-superior-derecha">
                                <button id="btn_primaria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_asign_primaria">Asignar</button>
                            </div>

                            <div class="table-responsive">
                                <table id="tbl_primaria" class=" hs_tabla display table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>id_s_c</th>
                                            <th>id_s</th>
                                            <th>id_c</th>
                                            <th>Asignatura</th>
                                            <th>Grado</th>
                                            <th>Sección</th>
                                            <th>Acciones</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane " id="ul-widget2-tab3-content">
                            <div class="botonera-superior-derecha">
                                <button id="btn_secundaria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_asign_secundaria">Asignar</button>
                            </div>

                            <div class="table-responsive">
                                <table id="tbl_secundaria" class=" hs_tabla display table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>id_s_c</th>
                                            <th>id_s</th>
                                            <th>id_c</th>
                                            <th>Asignatura</th>
                                            <th>Grado</th>
                                            <th>Sección</th>
                                            <th>Acciones</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Crear asignación de cursos para Inicial-->
    <div class="modal fade" id="modal_asign_inicial" tabindex="-1" role="dialog" aria-labelledby="modal_asign_inicialLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar cursos</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frm_create_inicial" method="POST" action="{{route('super/categorias/create_seccion_categoria')}}" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="asignaturas">Asignatura(s)</label>
                            <select id="asignaturas" name="asignaturas[]" multiple>

                            </select>
                            <div class="invalid-feedback">
                                Seleccione uno o varias asignaturas
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="secciones">Sección(es)</label>
                            <select id="secciones" name="secciones[]" multiple>
                                @foreach ($inicial as $item)
                                    <option value="{{$item->id_seccion}}">{{substr($item->nom_grado,3)}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione una o varias secciones
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_asign_inicial" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Actualizar asignación de cursos para Inicial-->
    <div class="modal fade" id="modal_update_inicial" tabindex="-1" role="dialog" aria-labelledby="modal_asign_inicialLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frm_update_inicial" method="POST" action="{{route('super/categorias/update_seccion_categoria')}}" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="asignatura">Asignatura</label>
                            <select id="asignatura" name="asignatura" class="form-control">

                            </select>
                            <div class="invalid-feedback">
                                Seleccione una asignatura
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="seccion">Sección</label>
                            <select id="seccion" name="seccion" class="form-control">
                                @foreach ($inicial as $item)
                                    <option value="{{$item->id_seccion}}">{{substr($item->nom_grado,3)}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione una sección
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_update_inicial" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Crear asignación de cursos para Primaria-->
    <div class="modal fade" id="modal_asign_primaria" tabindex="-1" role="dialog" aria-labelledby="modal_asign_primariaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar cursos</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frm_create_primaria" method="POST" action="{{route('super/categorias/create_seccion_categoria')}}" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="asignaturas2">Asignatura(s)</label>
                            <select id="asignaturas2" name="asignaturas2[]" multiple>

                            </select>
                            <div class="invalid-feedback">
                                Seleccione uno o varias asignaturas
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="secciones2">Sección(es)</label>
                            <select id="secciones2" name="secciones2[]" multiple>
                                @foreach ($primaria as $item)
                                    <option value="{{$item->id_seccion}}">{{ucfirst(strtolower(substr($item->nom_grado,3)))}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione una o varias secciones
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_asign_primaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Actualizar asignación de cursos para Primaria-->
    <div class="modal fade" id="modal_update_primaria" tabindex="-1" role="dialog" aria-labelledby="modal_asign_primariaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frm_update_primaria" method="POST" action="{{route('super/categorias/update_seccion_categoria')}}" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="asignatura2">Asignatura</label>
                            <select id="asignatura2" name="asignatura2" class="form-control">

                            </select>
                            <div class="invalid-feedback">
                                Seleccione una asignatura
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="seccion2">Sección</label>
                            <select id="seccion2" name="seccion2" class="form-control">
                                @foreach ($primaria as $item)
                                    <option value="{{$item->id_seccion}}">{{ucfirst(strtolower(substr($item->nom_grado,3)))}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione una sección
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_update_primaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Crear asignación de cursos para Secundaria-->
    <div class="modal fade" id="modal_asign_secundaria" tabindex="-1" role="dialog" aria-labelledby="modal_asign_secundariaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar cursos</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frm_create_secundaria" method="POST" action="{{route('super/categorias/create_seccion_categoria')}}" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="asignaturas3">Asignatura(s)</label>
                            <select id="asignaturas3" name="asignaturas3[]" multiple>

                            </select>
                            <div class="invalid-feedback">
                                Seleccione uno o varias asignaturas
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="secciones3">Sección(es)</label>
                            <select id="secciones3" name="secciones3[]" multiple>
                                @foreach ($secundaria as $item)
                                    <option value="{{$item->id_seccion}}">{{ucfirst(strtolower(substr($item->nom_grado,3)))}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione una o varias secciones
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_asign_secundaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Actualizar asignación de cursos para secundaria-->
    <div class="modal fade" id="modal_update_secundaria" tabindex="-1" role="dialog" aria-labelledby="modal_asign_secundariaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frm_update_secundaria" method="POST" action="{{route('super/categorias/update_seccion_categoria')}}" novalidate>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="asignatura3">Asignatura</label>
                            <select id="asignatura3" name="asignatura3" class="form-control">

                            </select>
                            <div class="invalid-feedback">
                                Seleccione una asignatura
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="seccion3">Sección</label>
                            <select id="seccion3" name="seccion3" class="form-control">
                                @foreach ($secundaria as $item)
                                    <option value="{{$item->id_seccion}}">{{ucfirst(strtolower(substr($item->nom_grado,3)))}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione una sección
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_update_secundaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update 16-05-2020 --}}
    {{-- Lista de docentes inicial--}}
    {{-- El modal se reutiliza para docentes de primaria y secundaria--}}

    <div class="modal fade" id="docentes_inicial" tabindex="-1" role="dialog" aria-labelledby="docentes_inicialLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Docentes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinnerInfoDocentes">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>

                <div id="divDocentes" style="display: none;">
                    {{-- Inicio de de card --}}
                    <div class="card_list">
                        <div class="card_list_fotografia">
                            <img class="card_list_fotografia_img" src="{{asset('assets/images/user.png')}}" alt="{nombre del alumno}">
                        </div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize">Juan Cárdenas Valdiviezo</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p>DNI: 123456789</p>
                                </div>
                            </div>

                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong>Telf.: 950404040</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext">correo_electronico_extenso@gmail.com</p>
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
    {{-- ---------------------- --}}

</body>
@endsection

@section('page-js')

<script>
    $(document).ready( function () {
        $("#nom_asignatura").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });
    });
</script>

<script src="{{asset('assets/js/superadmin/asignaturas.js')}}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
@endsection
