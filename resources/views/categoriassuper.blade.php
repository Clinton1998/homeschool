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

<body>
    <h2 class="hs_titulo">Asignaturas o cursos</h2>

    <div class="row hs_contenedor">
        <div class="card  col col-lg-7 col-sm-12">
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
            <div class="ul-widget__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="ul-widget2-tab1-content">
                        <div class="botonera-superior-derecha">
                            <button id="btnInicial" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCategoria"><i class="i-Add-User text-white mr-2"></i>Nuevo curso</button>
                        </div>
        
                        <div class="table-responsive">
                            <table id="ul-contact-list" class=" hs_tabla display table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grado</th>
                                        <th>Sección</th>
                                        <th><small></small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($TMP as $item)
                                    @if (strtoupper($item->c_nivel_academico) === "INICIAL")
                                        <tr>
                                            <td class="hs_capitalize">
                                                {{$item->nom_categoria}}
                                            </td>
                                            <td class="hs_capitalize">
                                                {{substr($item->nom_grado,3)}}
                                            </td>
                                            <td class="hs_upper">
                                                {{$item->nom_seccion}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" id="btnAplicarCategoria{{$item->id_categoria}}" onclick="fxAplicarCategoria({{$item->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-4"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarCategoria{{$item->id_categoria}}" onclick="fxConfirmacionEliminarCategoria({{$item->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="ul-widget2-tab2-content">
                        <div class="botonera-superior-derecha">
                            <button id="btnPrimaria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCategoria2"><i class="i-Add-User text-white mr-2"></i>Nuevo curso</button>
                        </div>
        
                        <div class="table-responsive">
                            <table id="ul-contact-list1" class=" hs_tabla display table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grado</th>
                                        <th>Sección</th>
                                        <th><small></small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($TMP as $item)
                                @if (strtoupper($item->c_nivel_academico) === "PRIMARIA")
                                    <tr>
                                        <td class="hs_capitalize">
                                            {{$item->nom_categoria}}
                                        </td>
                                        <td class="hs_capitalize">
                                            {{ucfirst(strtolower(substr($item->nom_grado,3)))}}
                                        </td>
                                        <td class="hs_upper">
                                            {{$item->nom_seccion}}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" id="btnAplicarCategoria{{$item->id_categoria}}" onclick="fxAplicarCategoria({{$item->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-4"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarCategoria{{$item->id_categoria}}" onclick="fxConfirmacionEliminarCategoria({{$item->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane " id="ul-widget2-tab3-content">
                        <div class="botonera-superior-derecha">
                            <button id="btnSecundaria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCategoria3"><i class="i-Add-User text-white mr-2"></i>Nuevo curso</button>
                        </div>
        
                        <div class="table-responsive">
                            <table id="ul-contact-list2" class=" hs_tabla display table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grado</th>
                                        <th>Sección</th>
                                        <th><small></small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($TMP as $item)
                                @if (strtoupper($item->c_nivel_academico) === "SECUNDARIA")
                                    <tr>
                                        <td class="hs_capitalize">
                                            {{$item->nom_categoria}}
                                        </td>
                                        <td class="hs_capitalize">
                                            {{ucfirst(substr(strtolower($item->nom_grado),3))}}
                                        </td>
                                        <td>
                                            {{$item->nom_seccion}}
                                        </td>
                                        <td class="hs_upper">
                                            <button type="button" class="btn btn-sm btn-warning" id="btnAplicarCategoria{{$item->id_categoria}}" onclick="fxAplicarCategoria({{$item->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-4"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarCategoria{{$item->id_categoria}}" onclick="fxConfirmacionEliminarCategoria({{$item->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Guardar 1-->
    <div class="modal fade" id="mdlAgregarCategoria" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva asignatura o curso</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmRegistroCategoria" method="POST" action="{{route('super/categorias/agregar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="frm" name="frm" value="1">

                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="nombre">Nombre de asignatura o curso</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
        
                        @foreach ($tmp_secciones as $item)
                            @if (strtoupper($item->c_nivel_academico) == "INICIAL")
                                <input type="hidden" id="nivel_academico" name="nivel_academico" value="{{$item->c_nivel_academico}}">
                            @endif
                        @endforeach

                        <!--Grados-Secciones-->
                        <div class="form-group">
                            <label for="grado-seccion">Para la sección</label>
                            <select id="optgroups" name="optgroups[]" multiple>
                                @foreach ($tmp_secciones as $item)
                                    @if (strtoupper($item->c_nivel_academico) == "INICIAL")
                                        <!--Nivel académico-->
                                        <option value="{{$item->id_seccion}}">{{substr($item->nom_grado,3)}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un grado-sección
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-lg" form="frmRegistroCategoria">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Guardar 2-->
    <div class="modal fade" id="mdlAgregarCategoria2" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoria2Label" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva asignatura o curso</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmRegistroCategoria2" method="POST" action="{{route('super/categorias/agregar')}}" novalidate>
                        
                        @csrf
                        <input type="hidden" id="frm" name="frm" value="2">
                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="nombre2">Nombre de asignatura o curso</label>
                            <input type="text" class="form-control" id="nombre2" name="nombre2" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
        
                        @foreach ($tmp_secciones as $item)
                            @if (strtoupper($item->c_nivel_academico) == "PRIMARIA")
                                <input type="hidden" id="nivel_academico2" name="nivel_academico2" value="{{$item->c_nivel_academico}}">
                            @endif
                        @endforeach

                        <!--Grados-Secciones-->
                        <div class="form-group">
                            <label for="optgroups2">Para la sección</label>
                            <select id="optgroups2" name="optgroups2[]" multiple>
                                @foreach ($tmp_secciones as $item)
                                    @if (strtoupper($item->c_nivel_academico) == "PRIMARIA")
                                        <option value="{{$item->id_seccion}}">{{ucfirst(substr(strtolower($item->nom_grado),3))}} <span class="hs_upper"> {{strtoupper($item->nom_seccion)}}</span></option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un grado-sección
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-lg" form="frmRegistroCategoria2">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Guardar 3-->
    <div class="modal fade" id="mdlAgregarCategoria3" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoria3Label" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva asignatura o curso</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmRegistroCategoria3" method="POST" action="{{route('super/categorias/agregar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="frm" name="frm" value="3">

                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="nombre3">Nombre de asignatura o curso</label>
                            <input type="text" class="form-control" id="nombre3" name="nombre3" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
        
                        @foreach ($tmp_secciones as $item)
                            @if (strtoupper($item->c_nivel_academico) == "SECUNDARIA")
                                <input type="hidden" id="nivel_academico3" name="nivel_academico3" value="{{$item->c_nivel_academico}}">
                            @endif
                        @endforeach
                        
                        <!--Grados-Secciones-->
                        <div class="form-group">
                            <label for="optgroups3">Para la sección</label>
                            <select id="optgroups3" name="optgroups3[]" multiple>
                                @foreach ($tmp_secciones as $item)
                                    @if (strtoupper($item->c_nivel_academico) == "SECUNDARIA")
                                        <!--Nivel académico-->
                                        <option value="{{$item->id_seccion}}">{{ucfirst(substr(strtolower($item->nom_grado),3))}} {{strtoupper($item->nom_seccion)}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un grado-sección
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-lg" form="frmRegistroCategoria3">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Actualizar -->
    <div class="modal fade" id="mdlEditarCategoria" tabindex="-1" role="dialog" aria-labelledby="mdlEditarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar asignatura o curso</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmEdicionCategoria" method="POST" action="{{route('super/categorias/actualizar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="id_categoria" name="id_categoria">
        
                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="actnombre">Nombre de asignatura o curso</label>
                            <input type="text" class="form-control hs_capitalize" id="actnombre" name="actnombre" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmEdicionCategoria">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Actualizar -->
     <div class="modal fade" id="mdlEditarCategoria2" tabindex="-1" role="dialog" aria-labelledby="mdlEditarCategoria2Label" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar asignatura o curso</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmEdicionCategoria" method="POST" action="{{route('super/categorias/actualizar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="id_categoria" name="id_categoria">
        
                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="actnombre2">Nombre de asignatura o curso</label>
                            <input type="text" class="form-control hs_capitalize" id="actnombre2" name="actnombre2" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmEdicionCategoria2">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Actualizar -->
     <div class="modal fade" id="mdlEditarCategoria3" tabindex="-1" role="dialog" aria-labelledby="mdlEditarCategoria3Label" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar asignatura o curso</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmEdicionCategoria" method="POST" action="{{route('super/categorias/actualizar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="id_categoria" name="id_categoria">
        
                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="actnombre">Nombre de asignatura o curso</label>
                            <input type="text" class="form-control hs_capitalize" id="actnombre" name="actnombre" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmEdicionCategoria">Actualizar</button>
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
    $('#ul-contact-list1').DataTable( {
        //paging: false,
        //"bInfo" : false
    } );
    $('#ul-contact-list2').DataTable( {
        //paging: false,
        //"bInfo" : false
    } );
</script>

<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/superadmin/categorias.js')}}"></script>
@endsection