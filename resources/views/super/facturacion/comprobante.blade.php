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
        .border-serie-comprobante{
            border: 2px solid black;
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
                        <h3 class="d-inline-block" style="margin-right: 1.5em;"><span id="spnFechaEmisionComprobante"><i class="text-fecha-emision">{{date('Y-m-d')}}</i><i class="input-fecha-emision" style="display: none;"><input type="date"  id="inpDateFechaEmision" style="display: inline-block;" value="{{date('Y-m-d')}}"></i></span><a href="#" onclick="fxMostrarCampoFecha(event);"><i class="i-Pen-5 text-muted" id="iconEditEmision"></i></a>&nbsp;&nbsp;<span>{{($serie_para_comprobante->tipo_documento->c_codigo_sunat=='01')?'FACTURA': 'BOLETA'}}</span>&nbsp;&nbsp;
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
                        <button type="button" class="btn btn-primary" id="btnPrevisualizarComrpobante">Previsualizar</button>
                        <button type="button" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-danger" id="btnCancelarEmision">Cancelar</button>
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
                        <div class="col-md-2">
                            <button type="button" class="btn btn-warning btn-sm btn-block"id="btnDescuentoGlobal">Descuento global</button>
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
                        <div class="form-group col-md-2">
                            <label for="inpImporteGlobal" class="ul-form__label">Importe:</label>
                            <input type="text" class="form-control form-control-lg" id="inpImporteGlobal" value="0.00" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inpIgvGlobal" class="ul-form__label">IGV:</label>
                            <input type="text" class="form-control form-control-lg" id="inpIgvGlobal" value="0.00" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="inpSubTotalGlobal" class="ul-form__label">SubTotal:</label>
                            <input type="text" class="form-control form-control-lg" id="inpSubTotalGlobal" value="0.00" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inpDescuentoGlobal" class="ul-form__label">Descuento:</label>
                            <input type="text" class="form-control form-control-lg is-invalid" id="inpDescuentoGlobal" value="0.00">
                            <div class="invalid-feedback" style="display: none;" id="divInvalidDescuento">
                                El monto no puede se mayor que SubTotal
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inpTotalGlobal" class="ul-form__label">Total:</label>
                            <input type="text" class="form-control form-control-lg" id="inpTotalGlobal" value="0.00" readonly>
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

    <!--modal para previsualizar comprobante-->
    <div class="modal" id="mdlPrevisualizarComprobante" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center" id="spinnerPrevisualizarComprobante" style="display: none;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>
                    <div class="mr-2 ml-2">
                        <div class="row">
                            <div class="col-3 d-flex align-items-center">
                                <img src="data:image/jpeg;base64,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" class="img-fluid" alt="Logo de la empresa">
                            </div>
                            <div class="col-6">
                                <span class="font-weight-bold d-block">Prueba SAC</span>
                                <span class="font-weight-bold d-block">De: <span>Empresa prueba Demo SAC</span> </span>
                                <span class="font-weight-bold d-block">RUC 1071761887</span>
                                <span class="d-block">CALLE VICTOR LIRA 260 AREQUIPA-AREQUIPA-AREQUIPA</span>
                                <span class="d-block">clintontapialagar@gmail.com</span>
                                <span>920192637 - Sucursal: Arequipa Victor Lira</span>
                            </div>
                            <div class="col-3 border-serie-comprobante font-weight-bold d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <span>BOLETA DE VENTA</span><br>
                                    <span>ELECTRONICA</span><br>
                                    <span>B001-00000693</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-3">Cliente:</div>
                            <div class="col-3">CLIENTE VARIOS</div>
                            <div class="col-3">Fecha de emisión:</div>
                            <div class="col-3">2020-06-04 12:52:42</div>
                        </div>
                        <div class="row">
                            <div class="col-3">Doc.tribh.no.dom.sin.ruc:</div>
                            <div class="col-3">--</div>
                            <div class="col-3">Fecha de vencimiento:</div>
                            <div class="col-3">2020-06-04</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Dirección:</div>
                            <div class="col">AREQUIPA-AREQUIPA-AREQUIPA</div>
                        </div>
                        <div class="row">
                            <div class="col">
                               <table class="table table-sm table-bordered" style="width: 100%;">
                                   <thead>
                                        <tr>
                                            <th>CANT.</th>
                                            <th>UNIDAD</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>P.UNIT</th>
                                            <th>DTO.</th>
                                            <th>TOTAL</th>
                                        </tr>
                                   </thead>
                               </table>
                            </div>
                        </div>
                        <div class="row font-weight-bold">
                            <div class="col-10 text-right">
                                OP. GRAVADAS: S/<br>
                                IGV: S/<br>
                                TOTAL A PAGAR: S/
                            </div>
                            <div class="col-2 text-right">
                                0.00<br>
                                0.00<br>
                                0.00
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Son: <span class="font-weight-bold">Seiscientos cincuenta con 00/100 soles</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--final modal para previsualizar comprobante-->
@endsection

@section('page-js')
    <script src="{{asset('assets/js/libreria/jqueryui/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/comprobante.js')}}"></script>

@endsection
