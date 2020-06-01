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
            <li class="menu-lateral-item {{ request()->is('home') ? 'item-activo' : '' }}">
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
                    <i class="nav-icon i-Movie"></i>
                    <br>
                    <span>Comunicados</span>
                </a>
            </li>

            <li class="nav-item menu-lateral-item {{ request()->is('super/facturacion/*') ? 'item-activo' : '' }}" data-item="itemfacturacion">
                <a class="nav-item-hold menu-lateral-item-link" href="#">
                    <i class="nav-icon i-Library"></i>
                    <span class="nav-text">Facturación electrónica</span>
                </a>
                <div class="triangle"></div>
            </li>

        </ul>
        <!-- FIN DE NUEVO MENU SLIDER -->
    </div>


    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="childNav" data-parent="itemfacturacion">
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='super/facturacion/series' ? 'item-activo' : '' }}" href="{{route('super/facturacion/series')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Series</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='super/facturacion/productos' ? 'item-activo' : '' }}" href="{{route('super/facturacion/productos')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Productos o servicios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Preferencias</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Comprobantes electrónicos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='super/facturacion/comprobante' ? 'item-activo' : '' }}" href="#" data-toggle="modal" data-target="#mdlElegirTipoComprobante">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Comprobante</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Notas electrónicos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::currentRouteName()=='accordion' ? 'open' : '' }}" href="{{route('accordion')}}">
                    <i class="nav-icon i-Split-Horizontal-2-Window"></i>
                    <span class="item-name">Nota</span>
                </a>
            </li>

        </ul>
    </div>


    <div class="sidebar-overlay"></div>
</div>

<div class="tools">
    <div id="tools-container" class="tools-container">
        <div class="tools-header">
            <div class="tools-title">
                <span>Mis herramientas</span>
            </div>
            <a class="tools-nav-min" href="#">-</a>
        </div>
        <div class="tools-nav">
            <input type="text" placeholder="Buscar tus herramientas" class="textBuscar" id="textBuscar">
        </div>
        <div class="tools-list" id="tools-list">

        </div>
        <div class="tools-footer">
            <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#MODAL-TOOLS">Agregar</a>
            <a  id="quiero_eliminar"  href="#" class="btn btn-sm" onclick="MostrarEliminar()">Quiero eliminar</a>
            <a  id="quiero_cancelar"  href="#" class="btn btn-sm" onclick="CancelarEliminar()">Cancelar</a>
        </div>
    </div>
</div>

<div id="tools-icon" class="tools-icon">
    <div class="maletin">

    </div>
</div>

<!--modal elegir boleta o factura-->
    <div class="modal" id="mdlElegirTipoComprobante" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="frmNecesarioParaComprobante" class="needs-validation" method="GET" action="{{url('/super/facturacion/comprobante')}}" novalidate>
                        @csrf

                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col mb-4 select-tipo">
                            <div class="card bg-primary-super" onclick="fxElegirTipoComprobante('B');" id="cardTipoBoleta">
                                <div class="card-body">
                                    <h2 class="text-white text-center">Boleta</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4 select-tipo">
                            <div class="card bg-primary-super" onclick="fxElegirTipoComprobante('F');" id="cardTipoFactura">

                                <div class="card-body">
                                    <h2 class="text-white text-center">Factura</h2>
                                </div>
                            </div>
                        </div>
                    </div>

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

                        <input type="hidden" id="inpNecesarioIdAlumno" name="id_alumno_comprobante" value="">
                        <!--<input type="hidden" id="inpNecesarioDniCliente" name="dni_comprobante" value="">
                        <input type="hidden" id="inpNecesarioNombreCliente" name="nombre_comprobante" value="">-->
                        <!--posibles valores = ['alumno','representante1','representante2','personalizado']-->
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

<!--modal elegir alumno para comprobante-->
<div class="modal" id="mdlElegirAlumnoParaComprobante" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-primary font-weight-bold text-center">¿Es para alumno?</h3>

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


<div class="modal fade" id="MODAL-TOOLS" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-tools-title">Nueva herramienta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form enctype="multipart/form-data" id="frm-tools" name="frm-tools" method="POST" action="{{url('/herramienta/agregar')}}" novalidate>
            @csrf
            <div class="modal-body">
                <div class="formgroup">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <br>
                <div class="formgroup">
                    <label for="link">Enlace de la herramienta</label>
                    <input type="url" name="link" id="link" class="form-control" placeholder="https://www.mi-herramienta-online.com" required>
                </div>

                <br>
                <div class="formgroup">
                    <label for="">Imagen</label>
                </div>

                <div class="form-group" style="display: flex; flex-wrap: wrap; justify-content: space-between">
                    <label class="radio radio-light mr-1" id="file-web">
                        <input type="radio" name="radio" [value]="2" formControlName="radio" checked>
                        <span>Desde un enlace web</span>
                        <span class="checkmark"></span>
                    </label>

                    <label class="radio radio-light" id="file-pc">
                        <input type="radio" name="radio" [value]="1" formControlName="radio">
                        <span>Desde mi dispositivo</span>
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="formgroup">
                    <input type="file" name="logo_fisico" id="logo_fisico" class="form-control hs_upload">
                    <input type="url" name="logo_link" id="logo_link" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="frm-tools">Guardar</button>
            </div>
        </form>
    </div>
    </div>
</div>

