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

<body>
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
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#hs_MODAL">Agregar</button>
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
                                  <tr>
                                      <td>
                                          Ciencias naturales
                                      </td>
                                      <td>
                                          Segundo
                                      </td>
                                      <td>
                                          A
                                      </td>
                                      <td>
                                          <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                          <a href="#" class="badge badge-danger m-2">X</a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          Matemática
                                      </td>
                                      <td>
                                          Primero
                                      </td>
                                      <td>
                                          A
                                      </td>
                                      <td>
                                        <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                        <a href="#" class="badge badge-danger m-2">X</a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          Matemática
                                      </td>
                                      <td>
                                          Primero
                                      </td>
                                      <td>
                                          A
                                      </td>
                                      <td>
                                        <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                        <a href="#" class="badge badge-danger m-2">X</a>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                    </div>

                    <div class="tab-pane" id="ul-widget2-tab2-content">
                      <div class="botonera-superior-derecha">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#hs_MODAL">Agregar</button>
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
                                  <tr>
                                      <td>
                                          Matemática
                                      </td>
                                      <td>
                                          Primero
                                      </td>
                                      <td>
                                          A
                                      </td>
                                      <td>
                                        <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                        <a href="#" class="badge badge-danger m-2">X</a>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                    </div>

                    <div class="tab-pane " id="ul-widget2-tab3-content">
                      <div class="botonera-superior-derecha">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#hs_MODAL">Agregar</button>
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
                                  <tr>
                                      <td>
                                          Ciencias naturales
                                      </td>
                                      <td>
                                          Segundo
                                      </td>
                                      <td>
                                          A
                                      </td>
                                      <td>
                                          <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                          <a href="#" class="badge badge-danger m-2">X</a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          Matemática
                                      </td>
                                      <td>
                                          Primero
                                      </td>
                                      <td>
                                          A
                                      </td>
                                      <td>
                                        <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                        <a href="#" class="badge badge-danger m-2">X</a>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>

   <!-- Modal -->
  <div class="modal fade" id="hs_MODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{Crear nueva materia} ó {Editar materia}</h5> <!-- Según sea el botón que llame al MODAL -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="txtSeccion">Nombre de materia</label>
                <input type="text" class="form-control" id="txtMateria" placeholder="Ejemplo: Matemática">
              </div>  
              <div class="form-group">
                  <label for="picker1">Para la sección</label>
                  <select class="form-control">
                      <option>-- Eliga un Grado y Sección --</option>
                      <option>Primero A</option>
                      <option>Primero B</option>
                      <option>Tercero A</option>
                  </select>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="">Guardar</button>
            </div>
        </div>
    </div>
  </div>
</body>







<section class="contact-list">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card mt-4">
                
                <div class="card-body">
                    <div class="card-title">
                        <button type="button" class="btn btn-primary btn-md m-1 float-right" data-toggle="modal" data-target="#mdlAgregarCategoria"><i class="i-Add-User text-white mr-2"></i> Agregar categoria</button>
                    </div>
                    <br>
                    <div class="row">
                    <div class="col-sm-3">
                        <h3 class="text-primary">Categorias en la institución</h3>
                        <ul class="list-group">
                            @php
                                $f = 0;    
                            @endphp
                            @foreach($categorias as $categoria)
                                @php
                                    $f++;
                                @endphp
                                        <li class="list-group-item"><span class="text-primary">#{{$f}} {{$categoria->c_nombre}}</span> - <span class="text-info">{{$categoria->c_nivel_academico}}</span>
                                        <div class="float-right">
                                            <button type="button" class="btn btn-sm btn-warning" id="btnAplicarCategoria{{$categoria->id_categoria}}" onclick="fxAplicarCategoria({{$categoria->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarCategoria{{$categoria->id_categoria}}" onclick="fxConfirmacionEliminarCategoria({{$categoria->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="i-Eraser-2"></i></button>
                                        </div>
                                        </li>
                            @endforeach
                        </ul>
                        </div>
                        <div class="col-sm-9">
                            <h3 class="text-primary">Categoria en las secciones</h3>
                            <div class="row">
                                @foreach($secciones as $seccion)
                                    <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <span class="text-primary">{{$seccion->c_nombre}} - {{$seccion->grado->c_nombre}} - {{$seccion->grado->c_nivel_academico}}</span>
                                                <button type="button" class="btn btn-primary float-right" id="btnAgregarCategoriaASeccion{{$seccion->id_seccion}}" onclick="fxAplicarSeccion({{$seccion->id_seccion}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar categoria a seccion {{$seccion->c_nombre}}">+</button>
                                                </div>
                                            </div>
                                        <ul class="list-group">
                                            @php
                                                $fcat = 0;
                                            @endphp
                                            @foreach($seccion->categorias->where('estado','=',1) as $categoria)
                                                @php
                                                    $fcat++;
                                                @endphp
                                                <li class="list-group-item"><span class="text-primary">#{{$fcat}} {{$categoria->c_nombre}}</span> - <span class="text-info">{{$categoria->c_nivel_academico}}</span>
                                                  <button type="button" class="btn btn-sm btn-danger float-right" id="btnConfirmacionQuitarCategoriaDeSeccion{{$categoria->id_categoria}}" onclick="fxQuitarCategoriaDeSeccion({{$seccion->id_seccion}},{{$categoria->id_categoria}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"><i class="i-Eraser-2"></i></button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</section>
  
  <!-- Modal -->
  <div class="modal fade" id="mdlAgregarCategoria" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlAgregarCategoriaLabel">Agregar categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" id="frmRegistroCategoria" method="POST" action="{{route('super/categorias/agregar')}}" novalidate>
                @csrf
              <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
                  <div class="invalid-feedback">
                        El nombre es requerido
                </div>
              </div>

              <div class="form-group">
                  <label for="nivel_academico">Nivel académico</label>
                  <select name="nivel_academico" id="nivel_academico" class="form-control">
                    <option value=""></option>
                    <option value="INICIAL">INICIAL</option>
                    <option value="PRIMARIA">PRIMARIA</option>
                    <option value="SECUNDARIA">SECUNDARIA</option>
                  </select>
                  <div class="invalid-feedback">
                    El nivel es requerido
                </div>
              </div>
              <hr>
              <h3>Agregar <span id="spanNombreNuevaCategoria"></span> en</h3>
              <div class="form-group">
                <select id="optgroups" name="optgroups[]" multiple>
                    @foreach($grados as $grado)
                    <optgroup label="{{$grado->c_nombre}} - {{$grado->c_nivel_academico}}">
                            @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                <option value="{{$seccion->id_seccion}}">{{$seccion->c_nombre}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                  </select>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmRegistroCategoria">Registrar</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal -->
  <div class="modal fade" id="mdlEditarCategoria" tabindex="-1" role="dialog" aria-labelledby="mdlEditarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlEditarCategoriaLabel">Editar categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="needs-validation" id="frmEdicionCategoria" method="POST" action="{{route('super/categorias/actualizar')}}" novalidate>
                @csrf
                <input type="hidden" id="id_categoria" name="id_categoria">

                <div class="form-group">
                    <label for="actnombre">Nombre</label>
                    <input type="text" class="form-control" id="actnombre" name="actnombre" required>
                    <div class="invalid-feedback">
                        El nombre es requerido
                    </div>
                </div>

                <div class="form-group">
                    <label for="actnivel_academico">Nivel académico</label>
                    <select name="actnivel_academico" id="actnivel_academico" class="form-control" required>
                      <option value=""></option>
                      <option value="INICIAL">INICIAL</option>
                      <option value="PRIMARIA">PRIMARIA</option>
                      <option value="SECUNDARIA">SECUNDARIA</option>
                    </select>
                    <div class="invalid-feedback">
                        El nivel es requerido
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmEdicionCategoria">Actualizar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="mdlAgregarCategoriaASeccion" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaASeccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <form id="frmAgregarCategoriaASeccion" class="needs-validation" method="POST" action="{{route('super/categorias/agregarcategoriaaseccion')}}" novalidate>
                @csrf
                <input type="hidden" id="id_seccion" name="id_seccion">
                <div class="row">
                <div class="col-sm-2">
                <h3>Añadir</h3>
                </div>
                <div class="col-sm-4">
                <select name="nombrecategoria" id="nombrecategoria" required>
                </select>
                <div class="invalid-feedback">
                    La categoria es necesario
                </div>
                </div>
                <div class="col-sm-6">
                <h3>a seccion "<span class="text-primary" id="spanNombreSeccion">PRIMER</span>"</h3>
                </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmAgregarCategoriaASeccion">Agregar</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-js')
<!-- page script -->
<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/superadmin/categorias.js')}}"></script>


@endsection