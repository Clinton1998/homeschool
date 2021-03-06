<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-panel-super.css')}}">

    <style>
        .bg-primary-super{
            background-color: #4563BF;
        }
        .bg-primary-super:hover{
            cursor: pointer;
            border-left: 0.8em solid #F1C40F;
        }
        .card-necesario-activo{
            border-left: 0.8em solid #F1C40F;
        }
    </style>
</head>

<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- INICIO DE NUEVO MENU SLIDER -->
        <ul class="menu-lateral ">
            <li class="menu-lateral-item {{ (request()->is('/') || request()->is('home'))? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('home')}}">
                    <i class="nav-icon i-Optimization"></i>
                    <br>
                    <span>Tablero</span>
                </a>
            </li>

              <li class="menu-lateral-item {{ request()->is('super/colegio*') ? 'item-activo' : '' }}">
                  <a class="menu-lateral-item-link" href="{{route('super/colegio')}}">
                      <i class="nav-icon i-University"></i>
                      <br>
                      <span>Colegio</span>
                  </a>
              </li>




            @if($colegio->c_bloque_fact=='VISIB')
              <li class="nav-item menu-lateral-item {{ request()->is('super/facturacion/*') ? 'item-activo' : '' }}" data-item="itemfacturacion">
                  <a class="nav-item-hold menu-lateral-item-link" href="#">
                      <i class="nav-icon i-Library"></i>
                      <span class="nav-text">Facturación electrónica</span>
                  </a>
                  <div class="triangle"></div>
              </li>
            @elseif($colegio->c_bloque_fact=='VISME')
              <li class="nav-item menu-lateral-item">
                  <a class="nav-item-hold menu-lateral-item-link" href="#" data-toggle="modal" data-target="#mdlMensajeModuloFacturacion">
                      <i class="nav-icon i-Library"></i>
                      <span class="nav-text">Facturación electrónica</span>
                  </a>
              </li>
            @endif
            <li class="menu-lateral-item {{ request()->is('super/gradoseccion*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/gradoseccion')}}">
                    <i class="nav-icon i-Tag"></i>
                    <br>
                    <span>Grados y secciones</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/categorias*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/categorias')}}">
                    <i class="nav-icon i-Library"></i>
                    <br>
                    <span>Cursos</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/docente*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/docentes')}}">
                    <i class="nav-icon i-Geek"></i>
                    <br>
                    <span>Docentes</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/alumno*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/alumnos')}}">
                    <i class="nav-icon i-Student-Hat-2"></i>
                    <br>
                    <span>Alumnos</span>
                </a>
            </li>
            <li class="menu-lateral-item {{ request()->is('super/videoconferencia*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/videoconferencia')}}">
                    <i class="nav-icon i-Movie"></i>
                    <br>
                    <span>Video conferencia</span>
                </a>
            </li>

            <li class="menu-lateral-item {{ request()->is('super/comunicados*') ? 'item-activo' : '' }}">
                <a class="menu-lateral-item-link" href="{{route('super/comunicados')}}">
                    <i class="nav-icon i-Megaphone"></i>
                    <br>
                    <span>Comunicados</span>
                </a>
            </li>
        </ul>
        <!-- FIN DE NUEVO MENU SLIDER -->
    </div>

    @if($colegio->c_bloque_fact=='VISIB')
        <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
              @php
                  //obtenemos la moneda utilizada en la plataforma
                  $moneda_default_pref = App\Moneda_m::where([
                      'b_principal' => 1,
                      'estado' => 1
                  ])->first();
                  //obtenemos la preferencia para boleta
                  $sunat_boleta_pref = '03';
                  $tipo_boleta_pref = App\Tipo_documento_m::where([
                      'c_codigo_sunat' => $sunat_boleta_pref,
                      'estado' => 1
                  ])->first();

                  $preferencia_boleta_pref = App\Preferencia_d::where([
                      'id_usuario' => Auth::user()->id,
                      'id_tipo_documento' => $tipo_boleta_pref->id_tipo_documento,
                      'estado' =>1
                  ])->first();

                  //obtenemos la preferencia para factura
                  $sunat_factura_pref = '01';
                  $tipo_factura_pref = App\Tipo_documento_m::where([
                      'c_codigo_sunat' => $sunat_factura_pref,
                      'estado' => 1
                  ])->first();

                  $preferencia_factura_pref = App\Preferencia_d::where([
                      'id_usuario' => Auth::user()->id,
                      'id_tipo_documento' => $tipo_factura_pref->id_tipo_documento,
                      'estado' =>1
                  ])->first();
              @endphp

              <ul class="childNav" data-parent="itemfacturacion">
                  <li class="nav-item">
                      <a class="{{ Route::currentRouteName()=='super/facturacion/series' ? 'item-activo' : '' }}" href="{{route('super/facturacion/series')}}">
                          <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                          <span class="item-name">Series</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="{{ Route::currentRouteName()=='super/facturacion/preferencias' ? 'item-activo' : '' }}" href="{{route('super/facturacion/preferencias')}}">
                          <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                          <span class="item-name">Preferencias</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="{{ Route::currentRouteName()=='super/facturacion/productos' ? 'item-activo' : '' }}" href="{{route('super/facturacion/productos')}}">
                          <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                          <span class="item-name">Productos o servicios</span>
                      </a>
                  </li>
                  <li class="nav-item">
                      @if(!is_null($preferencia_boleta_pref) && !empty($preferencia_boleta_pref))
                          @if(strtoupper($preferencia_boleta_pref->c_modo_emision)=='DET')
                              <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? '' : '' }}" href="#" onclick="fxElegirTipoComprobante('B',event);">
                                  <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                                  <span class="item-name">Boleta de venta</span>
                              </a>
                          @else
                              <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? '' : '' }}" href="{{url('/super/facturacion/comprobante?_token='.csrf_token().'&serie_comprobante='.$preferencia_boleta_pref->id_serie.'&moneda_comprobante='.$moneda_default_pref->id_moneda.'&tipo_impresion_comprobante='.$preferencia_boleta_pref->id_tipo_impresion.'&datos_adicionales_calculo='.$preferencia_boleta_pref->b_datos_adicionales_calculo)}}">
                                  <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                                  <span class="item-name">Boleta de venta</span>
                              </a>
                          @endif
                      @else
                          {{--siempre mostramos el modo detallado sin valores por defecto para los listbox--}}
                          <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? '' : '' }}" href="#" onclick="fxElegirTipoComprobante('B',event);">
                              <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                              <span class="item-name">Boleta de venta</span>
                          </a>
                      @endif
                  </li>

                  <li class="nav-item">
                      @if(!is_null($preferencia_factura_pref) && !empty($preferencia_factura_pref))
                          @if(strtoupper($preferencia_factura_pref->c_modo_emision)=='DET')
                              <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? '' : '' }}" href="#" onclick="fxElegirTipoComprobante('F',event);">
                                  <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                                  <span class="item-name">Factura</span>
                              </a>
                          @else
                              <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? '' : '' }}" href="{{url('/super/facturacion/comprobante?_token='.csrf_token().'&serie_comprobante='.$preferencia_factura_pref->id_serie.'&moneda_comprobante='.$moneda_default_pref->id_moneda.'&tipo_impresion_comprobante='.$preferencia_factura_pref->id_tipo_impresion.'&datos_adicionales_calculo='.$preferencia_factura_pref->b_datos_adicionales_calculo)}}">
                                  <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                                  <span class="item-name">Factura</span>
                              </a>
                          @endif
                      @else
                          {{--siempre mostramos el modo detallado sin valores por defecto para los listbox--}}
                          <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? '' : '' }}" href="#" onclick="fxElegirTipoComprobante('F',event);">
                              <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                              <span class="item-name">Factura</span>
                          </a>
                      @endif
                  </li>

              </ul>
        </div>
    @endif


    <div class="sidebar-overlay"></div>
</div>

@if($colegio->c_bloque_fact=='VISIB')
<!--modal elegir boleta o factura-->
    <div class="modal" id="mdlElegirTipoComprobante" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="frmNecesarioParaComprobante" class="needs-validation" method="GET" action="{{url('/super/facturacion/comprobante')}}" novalidate>
                        @csrf
                    <div class="text-center" id="spinnerBasicoNecesario" style="display: none;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>

                    <div id="divBasicoNecesario" style="display: none;">

                        <div class="form-group row">
                            <label for="selNecesarioSerie" class="ul-form__label ul-form--margin col-lg-3 col-form-label ">Serie:</label>
                            <div class="col">
                                <select name="serie_comprobante" id="selNecesarioSerie" class="form-control form-control-lg input-necesario" required>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selNecesarioMoneda" class="ul-form__label ul-form--margin col-lg-3 col-form-label ">Moneda:</label>
                            <div class="col">
                                <select name="moneda_comprobante" id="selNecesarioMoneda" class="form-control form-control-lg input-necesario" required>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selNecesarioTipoImpresion" class="ul-form__label ul-form--margin col-lg-3 col-form-label ">Tipo impresion:</label>
                            <div class="col">
                                <select name="tipo_impresion_comprobante" id="selNecesarioTipoImpresion" class="form-control form-control-lg input-necesario">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-lg-3 col">
                                <label class="checkbox checkbox-info">
                                    <input type="checkbox" name="datos_adicionales_calculo" id="chkDatosAdicionalesCalculo" value="1">
                                    <span>Mostrar datos adicionales de cálculo</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" id="inpNecesarioIdAlumno" name="id_alumno_comprobante" value="">
                        <input type="hidden" id="inpNecesarioTipoDatoClienteParaAlumno" name="tipo_dato_cliente_comprobante">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-lg" id="btnSiguienteBasicoParaComprobante" style="display: none;" data-toggle="modal" data-target="#mdlElegirAlumnoParaComprobante">Siguiente</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!--final modal elegir boleta o factura-->
@endif

@if($colegio->c_bloque_fact=='VISIB')
    <!--modal elegir alumno para comprobante-->
    <div class="modal" id="mdlElegirAlumnoParaComprobante" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-primary font-weight-bold text-center">¿Deseas elegir alumno(a)?</h3>

                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col mb-4 select-alumno">
                            <div class="card bg-primary-super" onclick="fxElegirAlumno('SI');" id="cardSiEsParaAlumno">
                                <div class="card-body">
                                    <h2 class="text-white text-center">SÍ</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4 select-alumno">
                            <div class="card bg-primary-super" onclick="fxElegirAlumno('NO');" id="cardNoEsParaAlumno">

                                <div class="card-body">
                                    <h2 class="text-white text-center">NO</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center" id="spinnerBasicoNecesarioParaAlumno" style="display: none;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>

                    <div id="divBasicoNecesarioParaAlumno" style="display: none;">
                        <h4 class="text-primary">Elige alumno(a)</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm" id="tabAlumnosParaComprobante" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Apellidos y nombres</th>
                                        <th>Grado-Sección-Nivel</th>
                                        <th>Elegir</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#mdlElegirTipoComprobante">Atrás</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!--final modal elegir alumno para comprobante-->
@endif

@if($colegio->c_bloque_fact=='VISIB')
    <!--modal elegir cliente para alumno en comprobante-->
    <div class="modal" id="mdlElegirClienteParaAlumno" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-primary font-weight-bold text-center">¿Cuál dato desea utilizar para el comprobante?</h3>

                    <div class="row row-cols-1 row-cols-md-2" id="divElegirCliente" style="display: none;">
                        <div class="col-12 mb-2 select-cliente">
                            <div class="card bg-primary-super" id="cardClienteAlumno">
                                <div class="card-body">
                                    <span class="text-white text-center"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2 select-cliente">
                            <div class="card bg-primary-super" id="cardClienteRepresentante1">
                                <div class="card-body">
                                    <span class="text-white text-center"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-2 select-cliente">
                            <div class="card bg-primary-super" id="cardClienteRepresentante2">
                                <div class="card-body">
                                    <span class="text-white text-center"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2 select-cliente">
                            <div class="card bg-primary-super" id="cardClientePersonalizado">
                                <div class="card-body">
                                    <span class="text-white text-center">Personalizado</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center" id="spinnerClienteNecesarioParaAlumno" style="display: none;">
                        <div class="spinner-bubble spinner-bubble-light m-5"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#mdlElegirAlumnoParaComprobante">Atrás</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!--final modal elegir cliente para alumno en comprobante-->
@endif

@if($colegio->c_bloque_fact=='VISME')
    <div id="mdlMensajeModuloFacturacion" class="modal" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">MODULO DESACTIVADO</h4>
                <p>Necesitas activar este módulo para su uso. Para más información, puedes comunicarte con Innova Sistemas, según los datos que se muestran.</p>
                <hr>
                <p class="mb-0">Numeros Telefonicos: 973477015 - 951028016 - 930274447</p>
                <p class="mb-0">e-mail: soporte@innovaqp.com - ventas@innovaqp.com - sistemasintegralesperu@gmail.com</p>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

    </div>
    </div>
@endif
