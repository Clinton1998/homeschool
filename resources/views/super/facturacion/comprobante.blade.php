@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/libreria/jqueryui/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
    <link href="{{asset('assets/styles/css/libreria/select2/select2.min.css')}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <style>
        .ui-autocomplete-loading {
            background: white url("/assets/images/ui-anim_basic_16x16.gif") right center no-repeat;
        }
        .ui-autocomplete-category {
            font-weight: bold;
            padding: .2em .4em;
            margin: .8em 0 .2em;
            line-height: 1.5;
        }
        .tipo-impresion-border{
            margin-left: 1.5em;
            padding: 0.2em;
            border: 2px dotted #4563BF;
            border-radius: 0.5em;
        }
        .moneda-border{
            margin-left: 1.5em;
            padding: 0.2em;
            border: 2px dotted #4563BF;
            border-radius: 0.5em;
        }
        .border-serie-comprobante{
            border: 2px solid black;
        }
    </style>
@endsection

@section('main-content')
    <input type="hidden" id="inpPorcentajeIgv" value="{{$tributos_para_producto->where('c_codigo_sunat','=','IGV')->first()->n_porcentaje}}">
    <input type="hidden" id="inpNumFilaProducto" value="1">

    <input type="hidden" id="inpDatosAdicionalesCalculo" value="{{$datos_adicionales_calculo}}">
    <input type="hidden" id="inpIdSerieParaComprobante" value="{{$serie_para_comprobante->id_serie}}">
    <input type="hidden" id="inpIdTipoDocumentoParaComprobante" value="{{$serie_para_comprobante->tipo_documento->id_tipo_documento}}">
    <input type="hidden" id="inpIdMonedaParaComprobante" value="{{$moneda_para_comprobante->id_moneda}}">
    <input type="hidden" id="inpIdTipoImpresionParaComprobante" value="{{$tipo_impresion_para_comprobante->id_tipo_impresion}}"">
    <select  id="selTributos" style="display: none;">
        @foreach($tributos_para_producto as $tributo)
            <option value="{{$tributo->c_codigo_sunat}}">{{$tributo->c_nombre}}</option>
        @endforeach
    </select>
    <section class="ul-contact-detail">
        <div class="row hs_contenedor">
            <div class="card  col col-sm-12">
                <div class="card-header">

                    <div class="float-left">
                        <h3 class="d-inline-block" style="margin-right: 1.5em;"><span id="spnFechaEmisionComprobante"><i class="text-fecha-emision">{{date('Y-m-d')}}</i><i class="input-fecha-emision" style="display: none;"><input type="date"  id="inpDateFechaEmision" style="display: inline-block;" value="{{date('Y-m-d')}}"></i></span><a href="#" onclick="fxMostrarCampoFecha(event);"><i class="i-Pen-5 text-muted" id="iconEditEmision"></i></a>&nbsp;&nbsp;<span>{{($serie_para_comprobante->tipo_documento->c_codigo_sunat=='01')?'FACTURA': 'BOLETA'}}</span>&nbsp;&nbsp;
                        <span>{{$serie_para_comprobante->c_serie}}</span>-<span class="text-primary font-weight-bold">00000001</span></h3>
                        <div class="d-inline-block tipo-impresion-border">
                            <span>{{$moneda_para_comprobante->c_nombre}}</span>
                        </div>
                        <div class="d-inline-block moneda-border">
                            <span>{{$tipo_impresion_para_comprobante->c_nombre}}</span>
                        </div>
                    </div>
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#mdlCrearProducto">+ Productos</button>
                        <button type="button" class="btn btn-success" id="btnGuardarComprobante">Guardar</button>
                        <button type="button" class="btn btn-danger" id="btnCancelarEmision">Cancelar</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-2">
                            <label class="switch switch-info">
                                <span>Alumno(a)</span>
                                @if(isset($alumno_para_comprobante))
                                    <input type="checkbox" id="chkComprobanteParaAlumno" value="{{$alumno_para_comprobante->id_alumno}}" checked>
                                @else
                                    <input type="checkbox" id="chkComprobanteParaAlumno" value="">
                                @endif
                                <span class="slider"></span>
                            </label>
                        </div>
                        @if(isset($alumno_para_comprobante))
                            <div class="form-group col-2 col-comprobante-para-alumno">
                                <input type="text" class="form-control form-control-sm" id="inpDniAlumnoParaComprobante" minlength="8" maxlength="8" placeholder="Ingrese DNI" value="{{$alumno_para_comprobante->c_dni}}">
                                <span class="invalid-feedback" role="alert" id="spnAlertDniAlumno" style="display: none;">
                                    <strong>
                                        No es alumno(a)
                                    </strong>
                                </span>
                            </div>
                            <div class="form-group col-2 col-comprobante-para-alumno">
                                <input type="text" class="form-control form-control-sm" id="inpNombreAlumnoParaComprobante" placeholder="Ingrese apellidos y nombres" value="{{$alumno_para_comprobante->c_nombre}}">
                            </div>
                        @else
                            <div class="form-group col-2 col-comprobante-para-alumno" style="display: none;">
                                <input type="text" class="form-control form-control-sm" id="inpDniAlumnoParaComprobante" minlength="8" maxlength="8" placeholder="Ingrese DNI">
                                <span class="invalid-feedback" role="alert" id="spnAlertDniAlumno" style="display: none;">
                                    <strong>
                                        No es alumno(a)
                                    </strong>
                                </span>
                            </div>
                            <div class="form-group col-2 col-comprobante-para-alumno" style="display: none;">
                                <input type="text" class="form-control form-control-sm" id="inpNombreAlumnoParaComprobante" placeholder="Ingrese apellidos y nombres">
                            </div>
                        @endif
                    </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                @if(($serie_para_comprobante->tipo_documento->c_codigo_sunat=='01'))
                                    <label for="inpDniRuc">RUC:</label>
                                    <input type="hidden" id="inpSoloRuc" value="si">
                                @else
                                    <label for="inpDniRuc">DNI/RUC:</label>
                                    <input type="hidden" id="inpSoloRuc" value="no">
                                @endif
                                @if(isset($alumno_para_comprobante) && !empty($tipo_dato_cliente_para_alumno))
                                    @if($tipo_dato_cliente_para_alumno=='alumno')
                                        <input type="text" class="form-control form-control-sm" id="inpDniRuc" name="documento_identidad" value="{{$alumno_para_comprobante->c_dni}}" required>
                                    @elseif($tipo_dato_cliente_para_alumno=='representante1')
                                        <input type="text" class="form-control form-control-sm" id="inpDniRuc" name="documento_identidad" value="{{$alumno_para_comprobante->c_dni_representante1}}" required>
                                    @elseif($tipo_dato_cliente_para_alumno=='representante2')
                                        <input type="text" class="form-control form-control-sm" id="inpDniRuc" name="documento_identidad" value="{{$alumno_para_comprobante->c_dni_representante2}}" required>
                                    @else
                                        <input type="text" class="form-control form-control-sm" id="inpDniRuc" name="documento_identidad" required>
                                    @endif
                                @else
                                    <input type="text" class="form-control form-control-sm" id="inpDniRuc" name="documento_identidad" required>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inpCliente">Cliente:</label>
                                @if(isset($alumno_para_comprobante) && !empty($tipo_dato_cliente_para_alumno))
                                    @if($tipo_dato_cliente_para_alumno=='alumno')
                                        <input type="text" class="form-control form-control-sm" id="inpNombreCliente" placeholder="Buscar" value="{{$alumno_para_comprobante->c_nombre}}" required>
                                    @elseif($tipo_dato_cliente_para_alumno=='representante1')
                                        <input type="text" class="form-control form-control-sm" id="inpNombreCliente" placeholder="Buscar" value="{{$alumno_para_comprobante->c_nombre_representante1}}" required>
                                    @elseif($tipo_dato_cliente_para_alumno=='representante2')
                                        <input type="text" class="form-control form-control-sm" id="inpNombreCliente" placeholder="Buscar" value="{{$alumno_para_comprobante->c_nombre_representante2}}" required>
                                    @else
                                        <input type="text" class="form-control form-control-sm" id="inpNombreCliente" placeholder="Buscar" required>
                                    @endif
                                @else
                                    <input type="text" class="form-control form-control-sm" id="inpNombreCliente" placeholder="Buscar" required>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inpDireccion">Dirección:</label>
                                @if(isset($alumno_para_comprobante) && !empty($tipo_dato_cliente_para_alumno))
                                    @if($tipo_dato_cliente_para_alumno=='alumno')
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion" value="{{$alumno_para_comprobante->c_direccion}}">
                                    @elseif($tipo_dato_cliente_para_alumno=='representante1')
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion" value="{{$alumno_para_comprobante->c_direccion_representante1}}">
                                    @elseif($tipo_dato_cliente_para_alumno=='representante2')
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion" value="{{$alumno_para_comprobante->c_direccion_representante2}}">
                                    @else
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion">
                                    @endif
                                @else
                                    <input type="text" class="form-control form-control-sm" id="inpDireccion">
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inpFecha">Observaciones:</label>
                                <input type="text" class="form-control form-control-sm" id="inpObservaciones">
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm float-right" id="btnAgregarProductoOServicio" data-toggle="tooltip" data-placement="top" title="Agregar producto o servicio">+</button>
                    <div class="table-responsive">
                        <table id="tabProductos" class="table table-sm table-bordered table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width: 2%;">#</th>
                                    <th style="width: 10%;">Código</th>
                                    <th style="width: 16%;">Nombre</th>
                                    <th style="width: 10%;">Unidad</th>
                                    <th style="width: 10%;">Cantidad</th>
                                    @if($datos_adicionales_calculo==1)
                                        <th style="width: 10%">V.V. UNIT</th>
                                        <th style="width: 10%">Impuesto. UNIT</th>
                                    @else
                                        <th style="width: 10%; display: none;">V.V. UNIT</th>
                                        <th style="width: 10%; display: none;">Impuesto. UNIT</th>
                                    @endif
                                    <th style="width: 10%;">P.V. UNIT</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 10%;">Tributo</th>
                                    <th style="width: 2%;">Quitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td>1</td>
                                    <td><select id="selFiltroCodigoCom1" style="width: 100%;" class="campo-variable-com"></select></td>
                                    <td><select type="text" id="selFiltroNombreCom1" style="width: 100%;" class="campo-variable-com"></select></td>
                                    <td></td>
                                    <td><input type="number" class="form-control form-control-sm campo-variable-com calc-cantidad" value="1" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td>
                                     @if($datos_adicionales_calculo==1)
                                            <td>
                                                <input type="text" class="form-control form-control calc-valor-unitario campo-variable-com" style="display: none;" onchange="fxCalcularTotalPorProducto(event);">
                                            </td>
                                            <td class="td-impuesto"></td>
                                     @else
                                             <td style="display: none;">
                                                 <input type="text" class="form-control form-control campo-variable-com calc-valor-unitario" style="display: none;" onchange="fxCalcularTotalPorProducto(event);">
                                             </td>
                                             <td style="display: none;" class="td-impuesto"></td>
                                     @endif
                                    <td><input type="text" class="form-control form-control-sm campo-variable-com calc-precio" value="0.00" style="display: none;" onchange="fxCalcularValorUnitarioDeProducto(event);"></td>
                                    <td><input type="text" class="form-control form-control-sm campo-variable-com calc-total" value="0.00" style="display:  none;" onchange="fxCalcularNuevoValorProducto(event);"></td>
                                    <td>
                                        <select class="form-control form-control-sm campo-variable-com calc-tributo" style="display: none;" onchange="fxActualizarValorDeProducto(event);">
                                            @foreach($tributos_para_producto as $tributo)
                                                <option value="{{$tributo->c_codigo_sunat}}">{{$tributo->c_nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="fxQuitarProducto(event);">X</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>TOTAL OP. GRAVADA:</h4>
                        </div>
                        <div class="col-md-1">
                            <h4><span class="text-primary" id="spnTotalOpGravada">0.00</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>TOTAL OP. EXONERADA:</h4>
                        </div>
                        <div class="col-md-1">
                            <h4><span class="text-primary" id="spnTotalOpExonerada">0.00</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>TOTAL OP. INAFECTA:</h4>
                        </div>
                        <div class="col-md-1">
                            <h4><span class="text-primary" id="spnTotalOpInafecta">0.00</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>TOTAL OP. GRATUITA:</h4>
                        </div>
                        <div class="col-md-1">
                            <h4><span class="text-primary" id="spnTotalOpGratuita">0.00</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>TOTAL IGV:</h4>
                        </div>
                        <div class="col-md-1">
                            <h4><span class="text-primary" id="spnTotalIgv">0.00</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <button type="button" class="btn btn-warning btn-sm d-inline-block" id="btnDescuentoGlobal">Descuento</button>
                            <h4 class="d-inline-block">TOTAL:</h4>
                        </div>
                        <div class="col-md-1">
                            <h4><span class="text-primary" id="spnTotalGlobal">0.00</span></h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>DESCUENTO:</h4>
                        </div>
                        <div class="col-md-1 text-md-left">
                            <h4><span class="text-primary" id="spnDescuentoComprobante">0.00</span></h4>
                        </div>
                    </div>


                    <div class="row">
                        <div class="offset-md-8 col-md-3 text-md-right">
                            <h4>TOTAL CON DESCUENTO:</h4>
                        </div>
                        <div class="col-md-1 text-md-left">
                            <h4><span class="text-primary" id="spnTotalConDescuentoComprobante">0.00</span></h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <!--modal para el descuento global-->
    <div class="modal" id="mdlAgregarDescuentoGlobal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Descuento Global</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inpTotalGlobal" class="ul-form__label">Total:</label>
                            <input type="text" class="form-control form-control-lg" id="inpTotalGlobal" value="0.00" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inpDescuentoGlobal" class="ul-form__label">Descuento:</label>
                            <input type="text" class="form-control form-control-lg is-invalid" id="inpDescuentoGlobal" value="0.00">
                            <div class="invalid-feedback" style="display: none;" id="divInvalidDescuento">
                                El monto no puede se mayor que SubTotal
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inpTotalConDescuentoGlobal" class="ul-form__label">Total con descuento:</label>
                            <input type="text" class="form-control form-control-lg" id="inpTotalConDescuentoGlobal" value="0.00" readonly>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnListoDescuentoGlobal">Listo</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!--final modal para el descuento global-->

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
                                                <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="producto" {{(old('tipo_producto')=='producto')?'checked':''}} >
                                                <span>Producto</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="radio-btn form-check form-check-inline">
                                            <label class="radio radio-success">
                                                @if(old('tipo_producto')=='' || empty(old('tipo_producto')))
                                                    <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="servicio" checked>
                                                @else
                                                    <input type="radio" name="tipo_producto" [value]="1" formcontrolname="radio" class="form-check-input" value="servicio" {{(old('tipo_producto')=='servicio')?'checked':''}}>
                                                @endif
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
                                                @if($tributo->c_codigo_sunat=='INA')
                                                    <option value="{{$tributo->id_tributo}}" selected>{{$tributo->c_nombre}}</option>
                                                @else
                                                    <option value="{{$tributo->id_tributo}}">{{$tributo->c_nombre}}</option>
                                                @endif
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
                                    <label for="inpPrecioProductoSinIgv" class="ul-form__label">Importe sin IGV:</label>
                                    <input type="text" class="form-control @error('precio_producto_sin_igv') is-invalid @enderror" name="precio_producto_sin_igv" id="inpPrecioProductoSinIgv" value="{{old('precio_producto_sin_igv')}}" readonly required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('precio_producto_sin_igv'))
                                        @error('precio_producto_sin_igv')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo importe producto sin igv es obligatorio
                                    @endif
                                </strong>
                            </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inpPrecioProductoConIgv" class="ul-form__label">Importe total:</label>
                                    <input type="text" class="form-control @error('precio_producto_con_igv') is-invalid @enderror" name="precio_producto_con_igv" id="inpPrecioProductoConIgv" value="{{old('precio_producto_con_igv')}}" required>
                                    <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('precio_producto_con_igv'))
                                        @error('precio_producto_con_igv')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo importe total producto con igv es obligatorio
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

@endsection

@section('page-js')
    <script src="{{asset('assets/js/libreria/jqueryui/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/libreria/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/comprobante.js')}}"></script>

@endsection
