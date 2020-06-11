@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
@endsection

@section('main-content')
    <section class="ul-contact-detail">
        <div class="row hs_contenedor">
            <div class="card  col col-sm-12">
                <div class="card-body">
                    <div class="hs_encabezado">
                        <h4 class="hs_encabezado-titulo">Preferencias</h4>
                        <div class="hs_encabezado-linea"></div>
                    </div>
                    @if($tipos_de_documento_para_preferencia->count()>0)
                        <div class="row mb-2">
                            <div class="col">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#mdlCrearPreferencia">Nuevo</button>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="tabPreferencias" class="hs_tabla display table table-sm table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">Documento</th>
                                    <th class="text-left">Serie</th>
                                    <th class="text-left">Tipo impresion</th>
                                    <th class="text-left">D.A Cálculo</th>
                                    <th class="text-left">Modo emisión</th>
                                    <th class="text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $filaPreferencia = 1;
                                @endphp
                                @foreach($preferencias as $preferencia)
                                    <tr>
                                        <td>{{$filaPreferencia}}</td>
                                        <td>{{$preferencia->tipo_documento->c_nombre}}</td>
                                        <td>{{$preferencia->serie->c_serie}}</td>
                                        <td>{{$preferencia->tipo_impresion->c_nombre}}</td>
                                        <td>
                                            @if($preferencia->b_datos_adicionales_calculo==1)
                                                <span class="badge badge-success font-weight-bold" style="font-size: 1.1em;">SÍ</span>
                                            @else
                                                <span class="badge badge-danger font-weight-bold" style="font-size: 1.1em;">NO</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(strtoupper($preferencia->c_modo_emision)=='DET')
                                                <span class="badge badge-info font-weight-bold" style="font-size: 1.1em;">DETALLADO</span>
                                            @else
                                                <span class="badge badge-info font-weight-bold" style="font-size: 1.1em;">DIRECTO</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="badge badge-warning" id="btnAplicarPreferencia{{$preferencia->id_preferencia}}" onclick="fxAplicarPreferencia({{$preferencia->id_preferencia}},event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a>
                                            <a href="#" class="badge badge-danger" id="btnConfirmacionEliminarPreferencia{{$preferencia->id_preferencia}}" onclick="fxConfirmacionEliminarPreferencia({{$preferencia->id_preferencia}},event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>
                                        </td>
                                    </tr>

                                    @php
                                        $filaPreferencia++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!--modal agregar preferencia-->
    <div class="modal" id="mdlCrearPreferencia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Crear nueva preferencia</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="frmAgregarPreferencia" class="needs-validation" method="POST" action="{{url('/super/facturacion/preferencia/agregar')}}" novalidate>
                        @csrf
                        <div class="form-group row">
                            <label for="selTipoDocumentoPreferencia" class="ul-form__label ul-form--margin col-lg-4 col-form-label ">Tipo de documento:</label>
                            <div class="col-lg-8">
                                <select type="text" name="tipo_documento_preferencia" class="form-control form-control-sm" id="selTipoDocumentoPreferencia" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_de_documento_para_preferencia as $tipo)
                                        <option value="{{$tipo->id_tipo_documento}}">{{$tipo->c_nombre}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong>El campo tipo de documento es obligatorio</strong>
                                </span>
                            </div>
                        </div>

                        <div class="text-center" id="spinnerNecesarioParaPreferencia" style="display: none;">
                            <div class="spinner-bubble spinner-bubble-light m-5"></div>
                        </div>

                        <div id="divNecesarioParaPreferencia" style="display: none;">
                            <div class="form-group row">
                                <label for="selSeriePreferencia" class="ul-form__label ul-form--margin col-lg-4 col-form-label ">Serie:</label>
                                <div class="col-lg-8">
                                    <select type="text" name="serie_preferencia" class="form-control form-control-sm" id="selSeriePreferencia" required>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                    <strong>El campo serie es obligatorio</strong>
                                </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="selTipoImpresionPreferencia" class="ul-form__label ul-form--margin col-lg-4 col-form-label ">Tipo de impresion:</label>
                                <div class="col-lg-8">
                                    <select type="text" name="tipo_impresion_preferencia" class="form-control form-control-sm" id="selTipoImpresionPreferencia" required>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                    <strong>El campo tipo de impresion es obligatorio</strong>
                                </span>
                                </div>
                            </div>

                            <div class="custom-separator"></div>
                            <div class="form-group row">
                                <label class="ul-form__label ul-form--margin col-lg-5 col-form-label ">Mostrar datos adicionales de cálculo:</label>
                                <div class="col-lg-7">

                                    <div class="ul-form__radio-inline">
                                        <label class=" ul-radio__position radio radio-info form-check-inline">
                                            <input type="radio" name="datos_adicionales_preferencia" value="1">
                                            <span class="ul-form__radio-font">SÍ</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="ul-radio__position radio radio-info">
                                            <input type="radio" name="datos_adicionales_preferencia" value="0" checked>
                                            <span class="ul-form__radio-font">NO</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="custom-separator"></div>

                            <div class="form-group row">
                                <label class="ul-form__label ul-form--margin col-lg-5 col-form-label ">Modo de emisión:</label>
                                <div class="col-lg-7">

                                    <div class="ul-form__radio-inline">
                                        <label class=" ul-radio__position radio radio-info form-check-inline">
                                            <input type="radio" name="modo_emision_preferencia" value="DET" checked>
                                            <span class="ul-form__radio-font">DETALLADO</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="ul-radio__position radio radio-info">
                                            <input type="radio" name="modo_emision_preferencia" value="DIR">
                                            <span class="ul-form__radio-font">DIRECTO</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="frmAgregarPreferencia">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>
    <!--final modal agregar preferencia-->

    <!--editar modal editar preferencia-->
    <div class="modal" id="mdlEditarPreferencia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar preferencia</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="frmEditarPreferencia" class="needs-validation" method="POST" action="{{url('/super/facturacion/preferencia/actualizar')}}" novalidate>
                        @csrf
                        <input type="hidden" id="inpIdPreferencia" name="id_preferencia">
                        <div class="text-center" id="spinnerNecesarioParaPreferenciaEdi" style="display: none;">
                            <div class="spinner-bubble spinner-bubble-light m-5"></div>
                        </div>

                        <div id="divNecesarioParaPreferenciaEdi" style="display: none;">
                            <div class="form-group row">
                                <label for="selTipoDocumentoPreferenciaEdi" class="ul-form__label ul-form--margin col-lg-4 col-form-label ">Tipo de documento:</label>
                                <div class="col-lg-8">
                                    <select type="text" name="tipo_documento" class="form-control form-control-sm" id="selTipoDocumentoPreferenciaEdi" required disabled>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                    <strong>El campo tipo de documento es obligatorio</strong>
                                </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="selSeriePreferenciaEdi" class="ul-form__label ul-form--margin col-lg-4 col-form-label ">Serie:</label>
                                <div class="col-lg-8">
                                    <select type="text" name="serie" class="form-control form-control-sm" id="selSeriePreferenciaEdi" required>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                    <strong>El campo serie es obligatorio</strong>
                                </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="selTipoImpresionPreferenciaEdi" class="ul-form__label ul-form--margin col-lg-4 col-form-label ">Tipo de impresion:</label>
                                <div class="col-lg-8">
                                    <select type="text" name="tipo_impresion" class="form-control form-control-sm" id="selTipoImpresionPreferenciaEdi" required>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                    <strong>El campo tipo de impresion es obligatorio</strong>
                                </span>
                                </div>
                            </div>

                            <div class="custom-separator"></div>
                            <div class="form-group row">
                                <label class="ul-form__label ul-form--margin col-lg-5 col-form-label ">Mostrar datos adicionales de cálculo:</label>
                                <div class="col-lg-7">

                                    <div class="ul-form__radio-inline">
                                        <label class=" ul-radio__position radio radio-info form-check-inline">
                                            <input type="radio" name="datos_adicionales" id="chkDatosAdicionalesSI" value="1">
                                            <span class="ul-form__radio-font">SÍ</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="ul-radio__position radio radio-info">
                                            <input type="radio" name="datos_adicionales" id="chkDatosAdicionalesNO" value="0">
                                            <span class="ul-form__radio-font">NO</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="custom-separator"></div>

                            <div class="form-group row">
                                <label class="ul-form__label ul-form--margin col-lg-5 col-form-label ">Modo de emisión:</label>
                                <div class="col-lg-7">

                                    <div class="ul-form__radio-inline">
                                        <label class=" ul-radio__position radio radio-info form-check-inline">
                                            <input type="radio" name="modo_emision" id="chkModoEmisionDet" value="DET">
                                            <span class="ul-form__radio-font">DETALLADO</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="ul-radio__position radio radio-info">
                                            <input type="radio" name="modo_emision" id="chkModoEmisionDir" value="DIR">
                                            <span class="ul-form__radio-font">DIRECTO</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="frmEditarPreferencia">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>
    <!--final modal editar preferencia-->

@endsection

@section('page-js')
    <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/preferencia.js')}}"></script>
@endsection
