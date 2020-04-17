@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
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