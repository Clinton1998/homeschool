@extends('reutilizable.principal')
@section('page-css')
    <!--<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">-->
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
@endsection

@section('main-content')
    <section class="ul-contact-detail">
        <!--<h2 class="hs_titulo">Productos o servicios</h2>-->

        <div class="row hs_contenedor">
            <div class="card  col col-sm-12">
                <div class="card-body">
                    <div class="hs_encabezado">
                        <h4 class="hs_encabezado-titulo">Series</h4>
                        <div class="hs_encabezado-linea"></div>
                    </div>

                    <div class="botonera-superior-derechadddddxdxdd row">
                        <div class="col">
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-danger btn-sm btn-icon m-1" id="btnVerSeriesEliminados">
                                    <span class="ul-btn__icon"><i class="i-Facebook-2"></i></span>
                                    <span class="ul-btn__text">Registros eliminados</span>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-2">
                                <button class="btn btn-primary float-right" type="button" data-toggle="modal" data-target="#mdlCrearSerie">Nuevo</button>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table id="tabSeries" class="hs_tabla display table table-sm table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo documento</th>
                                <th>Documento afectado</th>
                                <th>Serie</th>
                                <th>¿Por defecto?</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $fila_serie = 1;
                                @endphp
                                @foreach($series as $serie)
                                    <tr>
                                        <td>{{$fila_serie}}</td>
                                        <td>{{$serie->tipo_documento->c_nombre}}</td>
                                        <td>
                                            @if(strtoupper($serie->c_documento_afectacion)=='B')
                                                Boleta
                                            @elseif(strtoupper($serie->c_documento_afectacion)=='F')
                                                Factura
                                            @endif
                                        </td>
                                        <td>{{$serie->c_serie}}</td>
                                        <td>{{$serie->b_principal}}</td>
                                        <td>
                                            <a href="#" class="badge badge-warning" id="btnAplicarSerie{{$serie->id_serie}}" onclick="fxAplicarSerie({{$serie->id_serie}},event);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-5" style="font-size: 17px"></i></a>
                                            <a href="#" class="badge badge-danger" id="btnConfirmacionEliminarSerie{{$serie->id_serie}}" onclick="fxConfirmacionEliminarSerie({{$serie->id_serie}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2" style="font-size: 17px"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                        $fila_serie++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- modal crear serie -->
    <div class="modal fade" id="mdlCrearSerie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear nueva serie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmNuevaSerie" class="needs-validation" method="POST" action="{{url('/super/facturacion/serie/agregar')}}" novalidate>
                    @csrf
                            <div class="form-group">
                                <label for="selTipoDocumentoSerie">Tipo de documento</label>
                                <select name="tipo_documento" id="selTipoDocumentoSerie" class="form-control @error('tipo_documento') is-invalid @enderror" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_de_documento as $tipo)
                                        @if(old('tipo_documento')==$tipo->id_tipo_documento)
                                            <option value="{{$tipo->id_tipo_documento}}" selected>{{$tipo->c_nombre}}</option>
                                        @else
                                            <option value="{{$tipo->id_tipo_documento}}">{{$tipo->c_nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('tipo_documento'))
                                        @error('tipo_documento')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo tipo documento es obligatorio
                                    @endif
                                    </strong>
                                </span>
                            </div>

                            @if($errors->has('documento_afectacion') || old('documento_afectacion'))
                                <div class="form-group" id="divDocumentoAfectacion">
                                    <label for="selDocumentoAfectacion">Documento afectación</label>
                                    <select name="documento_afectacion" id="selDocumentoAfectacion" class="form-control" required>
                                        @if(old('documento_afectacion')=='B')
                                            <option value="">--Seleccione--</option>
                                            <option value="B" selected>BOLETA</option>
                                            <option value="F">FACTURA</option>
                                        @elseif(old('documento_afectacion')=='F')
                                            <option value="">--Seleccione--</option>
                                            <option value="B">BOLETA</option>
                                            <option value="F" selected>FACTURA</option>
                                        @else
                                            <option value="">--Seleccione--</option>
                                            <option value="B">BOLETA</option>
                                            <option value="F">FACTURA</option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($errors->has('documento_afectacion'))
                                                @error('documento_afectacion')
                                                    {{$message}}
                                                @enderror
                                            @else
                                                El campo documento afectacion es obligatorio
                                            @endif
                                        </strong>
                                    </span>
                                </div>
                            @else
                                <div class="form-group" id="divDocumentoAfectacion" style="display: none;">
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="inpSerie">Serie</label>
                                <input type="text" name="serie" id="inpSerie" class="form-control @error('serie') is-invalid @enderror" value="{{old('serie')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('serie'))
                                        @error('serie')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo serie es obligatorio
                                    @endif
                                    </strong>
                                </span>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmNuevaSerie">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!--final modal crear serie-->

    <!--modal editar serie-->
    <div class="modal fade" id="mdlEditarSerie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar serie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="spinnerEditarSerie" style="display: none;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>
                    <div id="divFrmEditarSerie" style="display: block;">
                        <form id="frmEditarSerie" class="needs-validation" method="POST" action="{{url('/super/facturacion/serie/actualizar')}}" novalidate>
                            @csrf
                            <input type="hidden" id="inpIdSerie" name="id_serie" value="{{old('id_serie')}}">
                            <div class="form-group">
                                <label for="selTipoDocumento">Tipo de documento</label>
                                <select name="tipo_documento_serie" id="selTipoDocumento" class="form-control @error('tipo_documento_serie') is-invalid @enderror" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_de_documento as $tipo)
                                        @if(old('tipo_documento_serie')==$tipo->id_tipo_documento)
                                            <option value="{{$tipo->id_tipo_documento}}" selected>{{$tipo->c_nombre}}</option>
                                        @else
                                            <option value="{{$tipo->id_tipo_documento}}">{{$tipo->c_nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('tipo_documento_serie'))
                                        @error('tipo_documento_serie')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo tipo documento es obligatorio
                                    @endif
                                    </strong>
                                </span>
                            </div>

                            @if($errors->has('documento_afectacion_serie') || old('documento_afectacion_serie'))
                                <div class="form-group" id="divDocumentoAfectacionEdicion">
                                    <label for="selDocumentoAfectacionSerie">Documento afectación</label>
                                    <select name="documento_afectacion_serie" id="selDocumentoAfectacionSerie" class="form-control" required>
                                        @if(old('documento_afectacion_serie')=='B')
                                            <option value="">--Seleccione--</option>
                                            <option value="B" selected>BOLETA</option>
                                            <option value="F">FACTURA</option>
                                        @elseif(old('documento_afectacion_serie')=='F')
                                            <option value="">--Seleccione--</option>
                                            <option value="B">BOLETA</option>
                                            <option value="F" selected>FACTURA</option>
                                        @else
                                            <option value="">--Seleccione--</option>
                                            <option value="B">BOLETA</option>
                                            <option value="F">FACTURA</option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($errors->has('documento_afectacion_serie'))
                                                @error('documento_afectacion_serie')
                                                {{$message}}
                                                @enderror
                                            @else
                                                El campo documento afectacion es obligatorio
                                            @endif
                                        </strong>
                                    </span>
                                </div>
                            @else
                                <div class="form-group" id="divDocumentoAfectacionEdicion" style="display: none;">
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="inpSerieSerie">Serie</label>
                                <input type="text" name="numero_serie" id="inpSerieSerie" class="form-control @error('numero_serie') is-invalid @enderror" value="{{old('numero_serie')}}" required>
                                <span class="invalid-feedback" role="alert">
                                <strong>
                                    @if($errors->has('numero_serie'))
                                        @error('numero_serie')
                                        {{$message}}
                                        @enderror
                                    @else
                                        El campo serie es obligatorio
                                    @endif
                                    </strong>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmEditarSerie">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!--final modal editar serie-->

    <!--modal series eliminados-->
    <div class="modal fade" id="mdlSeriesEliminados" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Series eliminados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="spinnerSeriesEliminados" style="display: block;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>
                    <div id="divTabla" style="display: none;">
                        <div class="table-responsive">
                            <table id="tabEliminados" class="hs_tabla display table table-sm table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo de documento</th>
                                    <th>Documento afectado</th>
                                    <th>Serie</th>
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
    <!--final modal series eliminados-->
@endsection

@section('page-js')
    <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <!--<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>-->
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/facturacion/series.js')}}"></script>

    @if($errors->has('tipo_documento') || $errors->has('documento_afectacion') || $errors->has('serie'))
        <script>
            $('#mdlCrearSerie').modal('show');
        </script>
    @endif

    @if($errors->has('tipo_documento_serie') || $errors->has('documento_afectacion_serie') || $errors->has('numero_serie'))
        <script>
            $('#mdlEditarSerie').modal('show');
        </script>
    @endif
@endsection
