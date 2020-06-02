@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/libreria/jqueryui/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <style>
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
    </style>
@endsection

@section('main-content')
    <input type="hidden" id="inpNumFilaProducto" value="1">
    <select  id="selTributos" style="display: none;">
        <option value=""></option>
        @foreach($tributos_para_producto as $tributo)
            <option value="{{$tributo->id_tributo}}">{{$tributo->c_nombre}}</option>
        @endforeach
    </select>
    <section class="ul-contact-detail">
        <!--<h2 class="hs_titulo">Productos o servicios</h2>-->
        <div class="row hs_contenedor">
            <div class="card  col col-sm-12">
                <div class="card-header">

                    <div class="float-left">
                        <h3 class="d-inline-block" style="margin-right: 1.5em;"><span>{{date('Y-m-d')}}</span>&nbsp;&nbsp;<span>{{($serie_para_comprobante->tipo_documento->c_codigo_sunat=='01')?'FACTURA': 'BOLETA'}}</span>&nbsp;&nbsp;
                        <span>{{$serie_para_comprobante->c_serie}}</span>&nbsp;&nbsp;<span class="text-primary font-weight-bold">1</span></h3>
                        <div class="d-inline-block tipo-impresion-border">
                            <span>{{$moneda_para_comprobante->c_nombre}}</span>
                        </div>
                        <div class="d-inline-block moneda-border">
                            <span>{{$tipo_impresion_comprobante}}</span>
                        </div>
                    </div>
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-warning">+ Productos</button>
                        <button type="button" class="btn btn-primary">Previsualizar</button>
                        <button type="button" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-danger" onclick="location.reload();">Cancelar</button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($alumno_para_comprobante))
                        <label class="switch switch-info mr-3">
                            <span>Para alumno(a) DNI: {{$alumno_para_comprobante->c_dni}} Apellidos y nombres: {{$alumno_para_comprobante->c_nombre}}</span>
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    @endif
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
                                @if(isset($alumno_para_representante) && !empty($tipo_dato_cliente_para_alumno))
                                    @if($tipo_dato_cliente_para_alumno=='alumno')
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion" value="{{$alumno->c_direccion}}">
                                    @elseif($tipo_dato_cliente_para_alumno=='representante1')
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion" value="{{$alumno->c_direccion_representante1}}">
                                    @elseif($tipo_dato_cliente_para_alumno=='representante2')
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion" value="{{$alumno->c_direccion_representante2}}">
                                    @else
                                        <input type="text" class="form-control form-control-sm" id="inpDireccion">
                                    @endif
                                @else
                                    <input type="text" class="form-control form-control-sm" id="inpDireccion">
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inpFecha">Observaciones:</label>
                                <input type="text" class="form-control form-control-sm" id="inpFecha">
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm float-right" id="btnAgregarProductoOServicio" data-toggle="tooltip" data-placement="top" title="Agregar producto o servicio">+</button>
                    <div class="table-responsive">
                        <table id="tabProductos" class="table table-sm table-bordered table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Unidad</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Total</th>
                                    <th>Tributo</th>
                                    <th>Quitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td>1</td>
                                    <td><select id="selFiltroCodigoCom1" style="width: 100%;" class="campo-variable-com"></select></td>
                                    <td><select type="text" id="selFiltroNombreCom1" style="width: 100%;" class="campo-variable-com"></select></td>
                                    <td></td>
                                    <td><input type="number" class="form-control form-control-sm campo-variable-com calc-cantidad" value="1" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td>
                                    <td><input type="text" class="form-control form-control-sm campo-variable-com calc-precio" value="0.00" style="display: none;" onchange="fxCalcularTotalPorProducto(event);"></td>
                                    <td><input type="text" class="form-control form-control-sm campo-variable-com calc-total" value="0.00" style="display:  none;" onchange="fxCalcularPrecioDeProducto(event);"></td>
                                    <td><select class="form-control form-control-sm campo-variable-com" style="display: none;">
                                            <option value=""></option>
                                            @foreach($tributos_para_producto as $tributo)
                                                <option value="{{$tributo->id_tributo}}">{{$tributo->c_nombre}}</option>
                                            @endforeach
                                        </select></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="fxQuitarProducto(event);">X</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-2">
                            <h4> Importe: <span class="text-primary" id="spnImporteComprobante">0.00</span></h4>
                        </div>

                        <div class="col-md-2">
                            <h4> IGV: <span class="text-primary" id="spnIgvComprobante">0.00</span></h4>
                        </div>

                        <div class="col-md-2">
                            <h4> SubTotal: <span class="text-primary" id="spnSubTotalComprobante">0.00</span></h4>
                        </div>

                        <div class="col-md-2">
                            <h4> Descuento: <span class="text-primary" id="spanDescuentoComprobante">0.00</span></h4>
                        </div>

                        <div class="col-md-2">
                            <h4> Total: <span class="text-primary" id="spanTotalComprobante">0.00</span></h4>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('page-js')
    <script src="{{asset('assets/js/libreria/jqueryui/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/comprobante.js')}}"></script>

@endsection
