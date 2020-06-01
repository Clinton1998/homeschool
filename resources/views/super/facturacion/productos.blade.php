@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
@endsection

@section('main-content')
<section class="ul-contact-detail">
    <!--<h2 class="hs_titulo">Productos o servicios</h2>-->

    <div class="row hs_contenedor">
        <div class="card  col col-sm-12">
            <div class="card-body">
                <div class="hs_encabezado">
                    <h4 class="hs_encabezado-titulo">Productos o servicios</h4>
                    <div class="hs_encabezado-linea"></div>
                </div>

                <div class="botonera-superior-derechadddddxdxdd row">
                    <div class="col">
                        <div class="form-group">
                            <label for="inpFiltroNombreCodigo">Nombre/Código</label>
                            <input type="text" class="form-control form-control-sm" id="inpFiltroNombreCodigo">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="selFiltroTipo">Tipo</label>
                            <select  id="selFiltroTipo" class="form-control form-control-sm" id="selFiltroTipo">
                                <option value="todos" selected>TODOS</option>
                                <option value="producto">PRODUCTO</option>
                                <option value="servicio">SERVICIO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="selFiltroUnidad">Unidad</label>
                            <select id="selFiltroUnidad" class="form-control form-control-sm">
                                <option value="todos" selected>TODOS</option>
                                @foreach($unidades as $unidad)
                                    <option value="{{$unidad->c_unidad}}">{{$unidad->c_unidad}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mt-3">
                            <button type="button" class="btn btn-danger btn-sm btn-icon m-1" id="btnVerProductosEliminados">
                                <span class="ul-btn__icon"><i class="i-File-Trash"></i></span>
                                <span class="ul-btn__text">Registros eliminados</span>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mt-2">
                            <button class="btn btn-primary float-right" type="button" data-toggle="modal" data-target="#mdlCrearProducto">Nuevo</button>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table id="tabProductos" class="hs_tabla display table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Unidad</th>
                                <th>Unidad sunat</th>
                                <th>Precio sin IGV</th>
                                <th>Precio con IGV</th>
                                <th>Tributo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $fila_producto = 1;
                            @endphp
                            @foreach($productos_o_servicios as $producto)
                                <tr>
                                    <td>{{$fila_producto}}</td>
                                    <td>{{$producto->c_codigo}}</td>
                                    <td>{{strtoupper($producto->c_tipo)}}</td>
                                    <td>{{$producto->c_nombre}}</td>
                                    <td>{{$producto->c_unidad}}</td>
                                    <td>{{$producto->c_unidad_sunat}}</td>
                                    <td>{{$producto->n_precio_sin_igv}}</td>
                                    <td>{{$producto->n_precio_con_igv}}</td>
                                    <td>{{$producto->tributo->c_nombre}}</td>
                                    <td>
                                        <a href="#" class="badge badge-warning" id="btnAplicarProducto{{$producto->id_producto_servicio}}" onclick="fxAplicarProducto({{$producto->id_producto_servicio}},event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a>
                                        <a href="#" class="badge badge-danger" id="btnConfirmacionEliminarProducto{{$producto->id_producto_servicio}}" onclick="fxConfirmacionEliminarProducto({{$producto->id_producto_servicio}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>
                                    </td>
                                </tr>
                                @php
                                    $fila_producto++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!--modal crear producto-->
<div class="modal fade" id="mdlCrearProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Crear nuevo producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmNuevoProducto" class="needs-validation" method="POST" action="{{url('/super/facturacion/producto/agregar')}}" novalidate>
                    @csrf
                    <div class="card-body">
                        @error('tipo_producto')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{$message}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @enderror
                        <div class="form-row">
                            <div class="form-group col-md-4 radio-alumnos" id="divRadioAlumno">
                                <label class="ul-form__label">Tipo:</label>
                                <div>
                                    <div class="radio-btn form-check form-check-inline">
                                        <label class="radio radio-success">
                                            <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="producto" {{(old('tipo_producto')=='producto' || old('tipo_producto')=='')?'checked':''}} >
                                            <span>Producto</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="radio-btn form-check form-check-inline">
                                        <label class="radio radio-success">
                                            <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="servicio" {{(old('tipo_producto')=='servicio')?'checked':''}}>
                                            <span>Servicio</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-8">
                                <label for="inpNombreProducto" class="ul-form__label">Nombre:</label>
                                <input type="text" class="form-control @error('nombre_producto') is-invalid @enderror" name="nombre_producto" id="inpNombreProducto" placeholder="Ingrese el nombre del producto" value="{{old('nombre_producto')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('nombre_producto'))
                                        @error('nombre_producto')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo nombre producto es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <span>Manual</span>
                                <label class="switch switch-success mr-3 mt-5">
                                    <span>Autogenerado</span>
                                    <input type="checkbox" id="chkModoCodigo" name="modo_codigo_producto" value="generado" {{(old('modo_codigo_producto')!='')?'checked':''}}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inpCodigoProducto" class="ul-form__label">Código:</label>
                                <input type="text" class="form-control @error('codigo_producto') is-invalid @enderror" name="codigo_producto" id="inpCodigoProducto" placeholder="Ingrese código de producto" value="{{old('codigo_producto')}}" {{(old('modo_codigo_producto')!='')?'readonly':''}} required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('codigo_producto'))
                                        @error('codigo_producto')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo codigo producto es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="selTributoProducto" class="ul-form__label">Tributo:</label>
                                <select name="tributo_producto" id="selTributoProducto" class="form-control @error('tributo_producto') is-invalid @enderror" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tributos as $tributo)
                                        @if(old('tributo_producto') == $tributo->id_tributo)
                                            <option value="{{$tributo->id_tributo}}" selected>{{$tributo->c_nombre}}</option>
                                        @else
                                            <option value="{{$tributo->id_tributo}}">{{$tributo->c_nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('tributo_producto'))
                                        @error('tributo_producto')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo tributo producto es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inpUnidadProducto" class="ul-form__label">Unidad:</label>
                                <input type="text" class="form-control @error('unidad_producto') is-invalid @enderror" name="unidad_producto" id="inpUnidadProducto" placeholder="Ingrese una unidad" value="{{old('unidad_producto')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('unidad_producto'))
                                        @error('unidad_producto')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo unidad producto es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inpUnidadSunatProducto" class="ul-form__label">Unidad SUNAT:</label>
                                <input type="text" class="form-control @error('unidad_sunat_producto') is-invalid @enderror" name="unidad_sunat_producto" id="inpUnidadSunatProducto" placeholder="Enter Contact Number" value="{{old('unidad_sunat_producto')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('unidad_sunat_producto'))
                                        @error('unidad_sunat_producto')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo unidad sunat producto es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inpPrecioProductoSinIgv" class="ul-form__label">Precio sin IGV:</label>
                                <input type="text" class="form-control @error('precio_producto_sin_igv') is-invalid @enderror" name="precio_producto_sin_igv" id="inpPrecioProductoSinIgv" placeholder="Ingrese precio sin IGV" value="{{old('precio_producto_sin_igv')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('precio_producto_sin_igv'))
                                        @error('precio_producto_sin_igv')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo precio producto sin igv es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inpPrecioProductoConIgv" class="ul-form__label">Precio con IGV:</label>
                                <input type="text" class="form-control @error('precio_producto_con_igv') is-invalid @enderror" name="precio_producto_con_igv" id="inpPrecioProductoConIgv" placeholder="Ingrese precio con IGV" value="{{old('precio_producto_con_igv')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('precio_producto_con_igv'))
                                        @error('precio_producto_con_igv')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo precio producto con igv es obligatorio
                                    @endif
                                    </strong>
                            </span>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary ladda-button" data-style="expand-left" form="frmNuevoProducto">
                    <span class="ladda-label">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!--final modal crear producto-->

<!--modal editar producto-->
<div class="modal fade" id="mdlEditarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinnerEditarProducto" style="display: none;">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>
                <div id="divFrmProducto" style="display: block;">
                    <form id="frmActualizarProducto" class="needs-validation" method="POST" action="{{url('/super/facturacion/producto/actualizar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="inpIdProducto" name="id_producto" value="{{old('id_producto')}}">
                        <div class="card-body">
                            @error('tipo')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{$message}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @enderror
                            <div class="form-row">
                                <div class="form-group col-md-4 radio-alumnos" id="divRadioAlumno">
                                    <label class="ul-form__label">Tipo:</label>
                                    <div>
                                        <div class="radio-btn form-check form-check-inline">
                                            <label class="radio radio-success">
                                                <input type="radio" name="tipo" [value]="1" formcontrolname="radio" class="form-check-input" id="optTipoProducto" value="producto" {{(old('tipo')=='producto')?'checked':''}} >
                                                <span>Producto</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="radio-btn form-check form-check-inline">
                                            <label class="radio radio-success">
                                                <input type="radio" name="tipo" [value]="1" formcontrolname="radio" class="form-check-input" id="optTipoServicio" value="servicio" {{(old('tipo')=='servicio')?'checked':''}}>
                                                <span>Servicio</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="inpNombre" class="ul-form__label">Nombre:</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="inpNombre" placeholder="Ingrese el nombre del producto" value="{{old('nombre')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('nombre'))
                                        @error('nombre')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo nombre es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <span>Manual</span>
                                    <label class="switch switch-success mr-3 mt-5">
                                        <span>Autogenerado</span>
                                        <input type="checkbox" id="chkModoCodigoEditar" name="modo_codigo" value="generado" {{(old('modo_codigo')!='')?'checked':''}}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inpCodigo" class="ul-form__label">Código:</label>
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" id="inpCodigo" placeholder="Ingrese código de producto" value="{{old('codigo')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('codigo'))
                                        @error('codigo')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo codigo es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="selTributo" class="ul-form__label">Tributo:</label>
                                    <select name="tributo" id="selTributo" class="form-control @error('tributo') is-invalid @enderror" required>
                                        <option value="">--Seleccione--</option>
                                        @foreach($tributos as $tributo)
                                            @if(old('tributo')==$tributo->id_tributo)
                                                <option value="{{$tributo->id_tributo}}" selected>{{$tributo->c_nombre}}</option>
                                            @else
                                                <option value="{{$tributo->id_tributo}}">{{$tributo->c_nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('tributo'))
                                        @error('tributo')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo tributo es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>

                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inpUnidad" class="ul-form__label">Unidad:</label>
                                    <input type="text" class="form-control @error('unidad') is-invalid @enderror" name="unidad" id="inpUnidad" placeholder="Ingrese una unidad" value="{{old('unidad')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('unidad'))
                                        @error('unidad')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo unidad es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inpUnidadSunat" class="ul-form__label">Unidad SUNAT:</label>
                                    <input type="text" class="form-control @error('unidad_sunat') is-invalid @enderror" name="unidad_sunat" id="inpUnidadSunat" placeholder="Enter Contact Number" value="{{old('unidad_sunat')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('unidad_sunat'))
                                        @error('unidad_sunat')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo unidad sunat es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inpPrecioSinIgv" class="ul-form__label">Precio sin IGV:</label>
                                    <input type="text" class="form-control @error('precio_sin_igv') is-invalid @enderror" name="precio_sin_igv" id="inpPrecioSinIgv" placeholder="Ingrese precio sin IGV" value="{{old('precio_sin_igv')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('precio_sin_igv'))
                                        @error('precio_sin_igv')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo precio sin igv es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inpPrecioConIgv" class="ul-form__label">Precio con IGV:</label>
                                    <input type="text" class="form-control @error('precio_con_igv') is-invalid @enderror" name="precio_con_igv" id="inpPrecioConIgv" placeholder="Ingrese precio con IGV" value="{{old('precio_con_igv')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('precio_con_igv'))
                                        @error('precio_con_igv')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo precio con igv es obligatorio
                                    @endif
                                    </strong>
                            </span>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"  form="frmActualizarProducto">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
<!--final modal editar producto-->

<!--modal ver productos eliminados-->
<div class="modal fade" id="mdlProductosEliminados" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Productos o servicios eliminados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinnerProductosEliminados" style="display: block;">
                    <div class="spinner-bubble spinner-bubble-light m-5"></div>
                </div>
                <div id="divTabla" style="display: none;">
                    <div class="table-responsive">
                        <table id="tabEliminados" class="hs_tabla display table table-sm table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Restaurar</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--final modal ver productos eliminados-->
@endsection

@section('page-js')
    <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <!--<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>-->
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/productos.js')}}"></script>
    @if($errors->has('tipo_producto') || $errors->has('nombre_producto') ||
     $errors->has('codigo_producto') || $errors->has('tributo_producto') ||
     $errors->has('unidad_producto') || $errors->has('unidad_sunat_producto') ||
     $errors->has('precio_producto_sin_igv') || $errors->has('precio_producto_con_igv'))
        <script>
            $('#mdlCrearProducto').modal('show');
        </script>
    @endif

    @if($errors->has('id_producto') || $errors->has('tipo') || $errors->has('nombre') ||
     $errors->has('codigo') || $errors->has('tributo') ||
     $errors->has('unidad') || $errors->has('unidad_sunat') ||
     $errors->has('precio_sin_igv') || $errors->has('precio_con_igv'))
        <script>
            $('#mdlEditarProducto').modal('show');
        </script>
    @endif

@endsection
