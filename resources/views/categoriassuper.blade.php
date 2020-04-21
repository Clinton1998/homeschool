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

<body onload="GradoSeccion();">
    <h2 class="hs_titulo">Materias</h2>

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
                            <table id="zero_configuration_table" class=" hs_tabla display table table-striped table-bordered" style="width:100%;">
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
                                @if ($item->c_nivel_academico === "INICIAL")
                                    <tr>
                                        <td>
                                            {{$item->nom_categoria}}
                                        </td>
                                        <td>
                                            {{$item->nom_grado}}
                                        </td>
                                        <td>
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
                            <button id="btnPrimaria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCategoria"><i class="i-Add-User text-white mr-2"></i>Nuevo curso</button>
                        </div>
        
                        <div class="table-responsive">
                            <table id="zero_configuration_table" class=" hs_tabla display table table-striped table-bordered" style="width:100%;">
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
                                @if ($item->c_nivel_academico === "PRIMARIA")
                                    <tr>
                                        <td>
                                            {{$item->nom_categoria}}
                                        </td>
                                        <td>
                                            {{$item->nom_grado}}
                                        </td>
                                        <td>
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
                            <button id="btnSecundaria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlAgregarCategoria"><i class="i-Add-User text-white mr-2"></i>Nuevo curso</button>
                        </div>
        
                        <div class="table-responsive">
                            <table id="zero_configuration_table" class=" hs_tabla display table table-striped table-bordered" style="width:100%;">
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
                                @if ($item->c_nivel_academico === "SECUNDARIA")
                                    <tr>
                                        <td>
                                            {{$item->nom_categoria}}
                                        </td>
                                        <td>
                                            {{$item->nom_grado}}
                                        </td>
                                        <td>
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
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Guardar -->
    <div class="modal fade" id="mdlAgregarCategoria" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo curso o asignatura</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmRegistroCategoria" method="POST" action="{{route('super/categorias/agregar')}}" novalidate>
                        @csrf
                        <!--Nombre de Asignatura-->
                        <div class="form-group">
                            <label for="nombre">Nombre de materia</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>
        
                        <!--Grados-Secciones-->
                        <div class="form-group">
                            <label for="grado-seccion">Para la sección</label>
                            <select id="optgroups" name="optgroups[]" multiple>
                                @foreach ($TMP as $item)
                                    @if ($item->c_nivel_academico == "INICIAL")
                                        <!--Nivel académico-->
                                        <input type="hidden" id="nivel_academico" name="nivel_academico" value="{{$item->c_nivel_academico}}">
                                        <option value="{{$item->id_seccion}}">{{$item->nom_grado}} {{$item->nom_seccion}}</option>
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

    <!-- Actualizar -->
    <div class="modal fade" id="mdlEditarCategoria" tabindex="-1" role="dialog" aria-labelledby="mdlEditarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar categoría</h5> <!-- Según sea el botón que llame al MODAL -->
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
                            <label for="actnombre">Nombre de materia</label>
                            <input type="text" class="form-control" id="actnombre" name="actnombre" required placeholder="Ejemplo: Matemática">
                            <div class="invalid-feedback">
                                Es necesario poner un nombre
                            </div>
                        </div>

                        <!--Grados-Secciones-->
                        <div class="form-group">
                            <label for="actnivel_academico">Para la sección</label>
                            <select id="actnivel_academico" name="actnivel_academico" required>
                                @foreach ($TMP as $item)
                                    @if ($item->c_nivel_academico == "INICIAL")
                                        <option value="{{$item->c_nivel_academico}}">{{$item->nom_grado}} {{$item->nom_seccion}}</option>
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
                    <button type="submit" class="btn btn-primary" form="frmEdicionCategoria">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('page-js')

<script>
    function GradoSeccion(){
        var found = [];
        $("select option").each(function() {
            if($.inArray(this.value, found) != -1) $(this).remove();
            found.push(this.value);
        });
    }
</script>

<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/superadmin/categorias.js')}}"></script>
@endsection