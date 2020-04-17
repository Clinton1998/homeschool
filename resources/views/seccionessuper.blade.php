@extends('reutilizable.principal')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')
<section class="contact-list">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            
            <div class="card mt-4">
                
                <div class="card-body">
                    <div class="row">
                        @foreach($grados as $grado)
                            <div class="col-sm-4">
                            <h3><span class="text-primary">{{$grado->c_nombre}}</span> - <span class="text-info">{{$grado->c_nivel_academico}}</span> <button type="button" class="btn btn-primary float-right" id="btnAgregarSeccion{{$grado->id_grado}}" onclick="fxAplicarGrado({{$grado->id_grado}});" data-toggle="tooltip" data-placement="top" title="Agregar sección">+</button></h3>
                                <ul class="list-group">
                                    @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                        <li class="list-group-item">
                                        <div class="row" id="rowEdicionSeccion{{$seccion->id_seccion}}" style="display: none;">
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="actnombre{{$seccion->id_seccion}}" value="{{$seccion->c_nombre}}"> 
                                                </div>

                                                <div class="col-sm-5 float-right">
                                                    <button type="button" class="btn btn-sm btn-primary" id="btnActualizarSeccion{{$seccion->id_seccion}}" onclick="fxActualizarSeccion({{$seccion->id_seccion}});">Actualizar</button>
                                                    <button type="button" class="btn btn-sm btn-danger" id="btnCancelarEdicion{{$seccion->id_seccion}}" onclick="fxCancelarEdicion({{$seccion->id_seccion}});">Cancelar</button>
                                                </div>
                                            </div>
                                        <div id="rowNormalSeccion{{$seccion->id_seccion}}">
                                        <span id="spanNombreNormal{{$seccion->id_seccion}}">{{$seccion->c_nombre}}</span>
                                            <div class="float-right">
                                                <button type="button" class="btn btn-sm btn-warning" id="btnEditarSeccion{{$seccion->id_seccion}}" onclick="fxEditarSeccion({{$seccion->id_seccion}});" data-toggle="tooltip" data-placement="top" title="Editar"><i class="i-Edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarSeccion{{$seccion->id_seccion}}" onclick="fxConfirmacionEliminarSeccion({{$seccion->id_seccion}});" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="i-Eraser-2"></i></button>
                                            </div>
                                        </div>
                                            
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
</section>



  
  <!-- Modal -->
  <!--<div class="modal fade" id="mdlAgregarGrado" tabindex="-1" role="dialog" aria-labelledby="AgregarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AgregarModalLabel">Agregar grado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form id="frmRegistroGrado" class="needs-validation" method="POST" action="{{route('super/grados/agregar')}}" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <div class="invalid-feedback">
                                El nombre es requerido
                            </div>
                        </div>

                        <div class="form">
                            <label for="nivel_academico">Nivel académico</label>
                            <input type="text" class="form-control" id="nivel_academico" name="nivel_academico" required>
                            <div class="invalid-feedback">
                                El nivel es requerido
                            </div>
                        </div>
                    </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmRegistroGrado">Registrar</button>
        </div>
      </div>
    </div>
  </div>-->

  
  <!-- Modal -->
  <!--<div class="modal fade" id="mdlActualizarGrado" tabindex="-1" role="dialog" aria-labelledby="mdlActualizarGradoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlActualizarGradoLabel">Actualizar grado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="frmActualizarGrado" class="needs-validation" method="POST" action="{{route('super/grados/actualizar')}}" novalidate>
                @csrf
                <input type="hidden" id="actidgrado" name="actidgrado">
                <div class="form-group">
                    <label for="actnombre">Nombre</label>
                    <input type="text" class="form-control" id="actnombre" name="actnombre" required>
                    <div class="invalid-feedback">
                        El nombre es requerido
                    </div>
                </div>

                <div class="form">
                    <label for="actnivel_academico">Nivel académico</label>
                    <input type="text" class="form-control" id="actnivel_academico" name="actnivel_academico" required>
                    <div class="invalid-feedback">
                        El nivel es requerido
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmActualizarGrado">Actualizar</button>
        </div>
      </div>
    </div>
  </div>-->

  
  <!-- Modal -->
  <div class="modal fade" id="mdlAgregarSeccion" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarSeccionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <form id="frmAgregarSeccion" class="needs-validation" method="POST" action="{{route('super/secciones/agregar')}}" novalidate>
                <input type="hidden" id="id_grado" name="id_grado">
                <h1 class="text-center"><span class="text-primary" id="spanNombreGrado">PRIMER</span> - <span class="text-info" id="spanNivelGrado">SECUNDARIA</span></h1>
                <div class ="form-group">
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre de sección" required>
                  <div class="invalid-feedback">
                      La seccion es necesario
                  </div>
                </div>
                @csrf
                
                <!--<div class="row">
                <div class="col-sm-2">
                <h3>Añadir</h3>
                </div>
                <div class="col-sm-4">
                
                </div>
                <div class="col-sm-6">
                <h3>a <span class="text-primary" id="spanNombreGrado">PRIMER</span> - <span class="text-info" id="spanNivelGrado">SECUNDARIA</span></h3>
                </div>
                </div>-->
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmAgregarSeccion">Agregar</button>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('page-js')

<!-- page script -->
<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>

<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>

<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/ladda.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/superadmin/secciones.js')}}"></script>

@endsection