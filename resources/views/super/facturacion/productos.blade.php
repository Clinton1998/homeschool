@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
@endsection

@section('main-content')
@foreach($errors->all() as $error)
    <h1>{{$error}}</h1>
@endforeach
<section class="ul-contact-detail">
    <h2 class="hs_titulo">Productos o servicios</h2>

    <div class="row hs_contenedor">
        <div class="card  col col-sm-12">
            <div class="card-body">
                <div class="hs_encabezado">
                    <h4 class="hs_encabezado-titulo">Productos o servicios</h4>
                    <div class="hs_encabezado-linea"></div>
                </div>
                
                <div class="botonera-superior-derecha">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#mdlCrearProducto">Nuevo producto</button>
                </div>

                <div class="table-responsive">
                    <table id="ul-contact-list" class="hs_tabla display table table-striped" style="width:100%">
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
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
                                            <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="producto" checked >
                                            <span>Producto</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="radio-btn form-check form-check-inline" data-toggle="modal" data-target="#modal-seleccion-alumnos">
                                        <label class="radio radio-success">
                                            <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="servicio" >
                                            <span>Servicio</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="inpNombreProducto" class="ul-form__label">Nombre:</label>
                            <input type="text" class="form-control @error('nombre_producto') is-invalid @enderror" name="nombre_producto" id="inpNombreProducto" placeholder="Ingrese el nombre del producto" required>
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
                                <input type="checkbox" id="chkModoCodigo" name="modo_codigo_producto" value="generado">
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inpCodigoProducto" class="ul-form__label">Código:</label>
                            <input type="text" class="form-control @error('codigo_producto') is-invalid @enderror" name="codigo_producto" id="inpCodigoProducto" placeholder="Ingrese código de producto" required>
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
                                    <option value="{{$tributo->id_tributo}}">{{$tributo->c_nombre}}</option>
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
                            <input type="text" class="form-control @error('unidad_producto') is-invalid @enderror" name="unidad_producto" id="inpUnidadProducto" placeholder="Ingrese una unidad" required>
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
                            <input type="text" class="form-control @error('unidad_sunat_producto') is-invalid @enderror" name="unidad_sunat_producto" id="inpUnidadSunatProducto" placeholder="Enter Contact Number" required>
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
                            <input type="text" class="form-control @error('precio_producto_sin_igv') is-invalid @enderror" name="precio_producto_sin_igv" id="inpPrecioProductoSinIgv" placeholder="Ingrese precio sin IGV" required>
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
                            <input type="text" class="form-control @error('precio_producto_con_igv') is-invalid @enderror" name="precio_producto_con_igv" id="inpPrecioProductoConIgv" placeholder="Ingrese precio con IGV" required>
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
</section>

@endsection

@section('page-js')
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/productos.js')}}"></script>
    @if($errors->has('tipo_producto') || $errors->has('nombre_producto') ||
     $errors->has('codigo_producto') || $errors->has('tributo_producto') || 
     $errors->has('unidad_producto') || $errors->has('unidad_sunat_producto') ||
     $errors->has('precio_producto_sin_igv') || $errors->has('precio_producto_con_igv'))
        <script>
            $('#mdlCrearProducto').modal('show');
        </script>
    @endif
    
@endsection