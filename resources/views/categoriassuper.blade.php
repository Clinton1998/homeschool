@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')

<head>
  <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
</head>

<body onload="LlenarSelects()">

    <div class="row justify-content-center">
        <!--Section: Asignaturas - Secciones-->
        <div class="mb-3 col col-lg-7 col-md-7 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="ul-widget__head">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">
    
                            </h3>
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
                                <table id="tbl_inicial" class=" hs_tabla display table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>id_s_c</th>
                                            <th>id_s</th>
                                            <th>id_c</th>
                                            <th>Asignatura</th>
                                            <th>Grado</th>
                                            <th>Sección</th>
                                            <th></th>
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
                                            <th></th>
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
                                            <th></th>
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

        <!--Aside: Asignaturas o cursos-->
        <div class="col col-lg-4 col-md-5 col-sm-12">
            <div class="card" style="background-color: #edeff2;">
                <div class="card-body">
                    <div class="hs_encabezado">
                        <br>
                        <h4 class="text-center">Cursos</h4>
                        <div class="hs_encabezado-linea"></div>
                    </div>
    
                    <!--Formulario de asignaturas-->
                    <form id="frm_create_asignatura" method="POST" action="{{route('super/categorias/create_asignatura')}}" class="mb-2">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="form-group">
                                    <label for="nom_asignatura">Nombre</label>
                                    <input type="text" class="form-control" id="nom_asignatura" name="nom_asignatura" required placeholder="Ejemplo: Matemática">
                                    <div class="invalid-feedback">
                                        El curso necesita un nombre
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label for="nom_asignatura">Color</label>
                                    <input type="color" class="form-control" id="color_asignatura" name="color_asignatura" required>
                                    <div class="invalid-feedback">
                                        Necesitas establecer un color
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" id="btn_create_asignatura" class="btn btn-primary btn-sm float-right">Guardar</button>
                                <button type="submit" id="btn_update_asignatura" class="btn btn-warning btn-sm float-right">Actualizar</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="Clear();">Cancelar</button>
                            </div>
                        </div>
                    </form>
    
                    <!--Tabla de asignaturas-->
                    <div class="table-responsive">
                        <table id="tbl_asignaturas" class="hs_tabla display table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Color</th>
                                    <th></th>
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

    <!--Crear asignación de Asignaturas para Inicial-->
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

    <!--Actualizar asignación de Asignaturas para Inicial-->
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

    <!--Crear asignación de Asignaturas para Primaria-->
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
                        <button type="submit" id="btn_asign_primaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Actualizar asignación de Asignaturas para Primaria-->
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
                        <button type="submit" id="btn_update_primaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Crear asignación de Asignaturas para Secundaria-->
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
                        <button type="submit" id="btn_asign_secundaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Actualizar asignación de Asignaturas para secundaria-->
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
                        <button type="submit" id="btn_update_secundaria" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
@endsection

@section('page-js')
<script src="{{asset('assets/js/superadmin/asignaturas.js')}}"></script>
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<!--<script src="{{asset('assets/js/superadmin/categorias.js')}}"></script>-->
@endsection