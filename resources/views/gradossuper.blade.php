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
                    <!-- right control icon -->
                    <h3 class="card-title">
                        <div class="row">
                            <div class="col-sm-6">
                                Grados
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#mdlAgregarGrado">Agregar grado</button>
                            </div>
                        </div>
                    </h3>
                    <div class="accordion" id="accordionRightIcon">
                        <div class="row">
                        @php
                            $f = 0;
                        @endphp
                        @foreach($grados as $grado)
                            @php
                                $f++;
                            @endphp
                            <div class="col-xs-12 col-sm-6">
                                <div class="card ">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                        <a data-toggle="collapse" class="text-default collapsed" href="#accordion-item-icon-right-{{$f}}" aria-expanded="false">#{{$f}} <span class="badge badge-pill badge-primary p-2 m-1">{{$grado->c_nombre}}</span> <span class="badge badge-pill badge-info p-2 m-1">{{$grado->c_nivel_academico}}</span></a>
                                        <button type="button" class="btn btn-sm btn-warning" id="btnAplicarGrado{{$grado->id_grado}}" onclick="fxAplicarGrado({{$grado->id_grado}});" data-toggle="tooltip" data-placement="top" title="Editar"><i class="i-Edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarGrado{{$grado->id_grado}}" onclick="fxConfirmacionEliminarGrado({{$grado->id_grado}});"data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="i-Eraser-2"></i></button>
                                        </h6>
                                    </div>

                                <div id="accordion-item-icon-right-{{$f}}" class="collapse" data-parent="#accordionRightIcon" style="">
                                        <div class="card-body">
                                            <ul>
                                                @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                                    <li>{{$seccion->c_nombre}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </div>

                    </div>
                    <!-- /right control icon -->
                </div>
            </div>
        </div>

    </div>
</section>




  <!-- Modal -->
  <div class="modal fade" id="mdlAgregarGrado" tabindex="-1" role="dialog" aria-labelledby="AgregarModalLabel" aria-hidden="true">
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
                            <select name="nivel_academico" id="nivel_academico" class="form-control" required>
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
          <button type="submit" class="btn btn-primary btn-lg" form="frmRegistroGrado">Registrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="mdlActualizarGrado" tabindex="-1" role="dialog" aria-labelledby="mdlActualizarGradoLabel" aria-hidden="true">
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
          <button type="submit" class="btn btn-primary btn-lg" form="frmActualizarGrado">Actualizar</button>
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
<script src="{{asset('assets/js/superadmin/grados.js')}}"></script>

<script>
$('#ul-contact-list').DataTable();
</script>
@endsection
