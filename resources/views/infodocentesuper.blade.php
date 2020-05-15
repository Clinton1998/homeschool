@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/style-super.css')}}">
@endsection
@section('main-content')
    <section>
        <div class="row">

            <div class="col-lg-8 col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active show" id="nav-editar-tab" data-toggle="tab" href="#nav-editar" role="tab" aria-controls="nav-editar" aria-selected="true">Editar</a>
                                <a class="nav-item nav-link " id="nav-dicta-tab" data-toggle="tab" href="#nav-dicta" role="tab" aria-controls="nav-dicta" aria-selected="false">Secciones asignadas</a>
                                <a class="nav-item nav-link " id="nav-asignaturas-tab" data-toggle="tab" href="#nav-asignaturas" role="tab" aria-controls="nav-asignaturas" aria-selected="false">Asignaturas asignadas</a>
                                <a class="nav-item nav-link" id="nav-foto-tab" data-toggle="tab" href="#nav-foto" role="tab" aria-controls="nav-foto" aria-selected="false">Foto</a>
                                <a class="nav-item nav-link" id="nav-acceso-tab" data-toggle="tab" href="#nav-acceso" role="tab" aria-controls="nav-acceso" aria-selected="false">Datos de acceso</a>
                            </div>
                        </nav>
                        <div class="tab-content ul-tab__content" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="nav-editar" role="tabpanel" aria-labelledby="nav-editar-tab">
                                <form id="frmActualizacionDocente" class="needs-validation" method="POST" action="{{route('super/docente/actualizar')}}" novalidate>
                                    @csrf
                                    <input type="hidden" id="id_docente" name="id_docente" value="{{$docente->id_docente}}">
                                    <div class="form-group row">
                                        <label for="dni" class="col-sm-2 col-form-label ">Número de DNI</label>
                                        <div class="col-sm-4">
                                            <div class="input-group mb-3">
                                                <input type="text" id="dni" name="dni"
                                                class="form-control @error('dni') is-invalid @enderror" value="{{$docente->c_dni}}" minlength="8" minlength="8" required>    
                                               
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-light ladda-button"  data-style="expand-right" id="btnBuscarPorDNI">Buscar</button>
                                                </div>
                                                <span class="invalid-feedback" role="alert">
                                                    Debe ser un DNI válido
                                                </span>
                                            </div>
                                            
                                            @error('dni')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <label for="nombre" class="col-sm-2 col-form-label ">Apellidos y Nombres</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nombre" name="nombre"
                                                class="form-control hs_capitalize @error('nombre') is-invalid @enderror" value="{{$docente->c_nombre}}" required>    
                                                <span class="invalid-feedback" role="alert">
                                                    El nombre es requerido
                                                    </span>
                                            @error('nombre')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nacionalidad" class="col-sm-2 col-form-label ">Nacionalidad</label>
                                        <div class="col-sm-4">
                                        <input type="text" id="nacionalidad" name="nacionalidad" class="hs_capitalize form-control  @error('nacionalidad') is-invalid @enderror" value="{{$docente->c_nacionalidad}}" required>
                                        <span class="invalid-feedback" role="alert">
                                            La nacionalidad es requerido
                                            </span>

                                        @error('nacionalidad')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </div>

                                        <label for="sexo" class="col-sm-2 col-form-label ">Sexo</label>
                                        <div class="col-sm-4">
                                            <select name="sexo" id="sexo" class="form-control @error('sexo') is-invalid @enderror" required>
                                                @if(strtoupper($docente->c_sexo)=='M')
                                                    <option value="M" selected>Masculino</option>
                                                    <option value="F">Femenino</option>
                                                @else
                                                    <option value="M">Masculino</option>
                                                    <option value="F" selected>Femenino</option>
                                                @endif
                                            </select>

                                            @error('nacionalidad')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fecha_nacimiento" class="col-sm-2 col-form-label ">Fecha de nacimiento</label>
                                        <div class="col-sm-4">
                                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{$docente->t_fecha_nacimiento}}" required>
                                        <span class="invalid-feedback" role="alert">
                                            Deber ser una fecha correcta
                                            </span>
                                        @error('fecha_nacimiento')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </div>

                                        <label for="correo" class="col-sm-2 col-form-label ">Correo</label>
                                        <div class="col-sm-4">
                                        <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{$docente->c_correo}}" required>
                                        <span class="invalid-feedback" role="alert">
                                            Debe ser un correo válido
                                            </span>
                                        @error('correo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-2 col-form-label ">Teléfono</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{$docente->c_telefono}}" required>
                                            <span class="invalid-feedback" role="alert">
                                                El telefono es requerido
                                                </span>
                                            @error('telefono')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>


                                        <label for="especialidad" class="col-sm-2 col-form-label ">Especialidad</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control hs_capitalize @error('especialidad') is-invalid @enderror" id="especialidad" name="especialidad" value="{{$docente->c_especialidad}}">
                                            <span class="invalid-feedback" role="alert">
                                                Especialidad es requerido
                                                </span>
                                            @error('especialidad')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                       
                                    </div>

                                    <div class="form-group row">
                                        <label for="direccion" class="col-sm-2 col-form-label ">Dirección</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="hs_capitalize-first form-control  @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{$docente->c_direccion}}" required>
                                            <span class="invalid-feedback" role="alert">
                                                La dirección es requerido
                                                </span>
                                            @error('direccion')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col" style="display:flex; justify-content: space-between;">
                                            <a href="{{route('super/docentes')}}" class="btn btn-light float-right">Atrás</a>
                                            <button type="submit" class="btn btn-primary float-right">Actualizar datos</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
    
                            <div class="tab-pane fade" id="nav-dicta" role="tabpanel" aria-labelledby="nav-dicta-tab">
                                <div class="row">
                                    <div class="col-12">
                                    <button type="button" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar seccion a {{$docente->c_nombre}}" onclick="fxMostrarSeccionesAAgregar({{$docente->id_docente}},'{{$docente->c_nombre}}')">+</button>
                                    </div>
                                </div>
                                <br>
                                <div class="accordion" id="accordionRightIcon">
                                    @foreach($docente->secciones->where('estado','=',1) as $seccion)                                        
                                        <div class="card " id="cardSeccion{{$seccion->id_seccion}}">
                                            <div class="card-header header-elements-inline">
                                                <span class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                    <span class="collapsed">
                                                        <strong>{{substr($seccion->grado->c_nombre,3)}} "{{$seccion->c_nombre}}"</strong>
                                                        <small>({{$seccion->grado->c_nivel_academico}})</small>
                                                    </span> 
                                                </span>
                                                <button type="button" class="btn btn-sm btn-danger float-right" id="btnQuitarSeccionDeDocente{{$seccion->id_seccion}}" onclick="fxQuitarSeccionDeDocente({{$docente->id_docente}},{{$seccion->id_seccion}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"><i class="i-Eraser-2"></i></button>
                                            </div>
                                        </div>
                                        <br>
                                    @endforeach
                                </div>
                            </div>


                            <div class="tab-pane fade" id="nav-asignaturas" role="tabpanel" aria-labelledby="nav-asignaturas-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar asignatura a {{$docente->c_nombre}}" onclick="fxMostrarCategoriasAAgregar()">+</button>
                                    </div>
                                </div>
                                <br>
                                <div class="accordion" id="accordionRightIcon">

                                        @foreach($cursos as $curso)
                                            <div class="card " id="cardCategoria{{$curso['pivot']}}">
                                                <div class="card-header header-elements-inline">
                                                    <span class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                        <span class="collapsed">
                                                            <strong>{{$curso['curso']['c_nombre']}}</strong>
                                                            <small>({{substr($curso['seccion']['grado']['c_nombre'],3)}} "{{$curso['seccion']['c_nombre']}}" {{$curso['seccion']['grado']['c_nivel_academico']}})</small>
                                                        </span> 
                                                    </span>
                                                    <button type="button" class="btn btn-sm btn-danger float-right" id="btnQuitarCategoriaDeDocente{{$curso['pivot']}}" onclick="fxQuitarCategoriaDeDocente({{$docente->id_docente}},{{$curso['pivot']}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"><i class="i-Eraser-2"></i></button>
                                                </div>
                                            </div>
                                            <br>
                                        @endforeach
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-foto" role="tabpanel" aria-labelledby="nav-foto-tab">
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-4">
                                        <div class="card text-left">
    
                                            <div class="card-body">
                                            <form id="frmSubidaFotoDocente" method="post" action="{{url('super/docente/cambiarfoto')}}" class="needs-validation"  enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                <input type="hidden" id="fotoid_docente" name="fotoid_docente" value="{{$docente->id_docente}}">
                                                    <div class="form-group">
                                                        <input type='file' class="hs_upload form-control form-control-lg" id="fotodocente" name="fotodocente" required>
                                                        <span class="invalid-feedback" role="alert">
                                                            Fotografía del docente
                                                        </span>
                                                    </div>                                                
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <button type="submit" class="btn btn-primary float-right">Actulizar fotografía</button>
                                                        </div>
                                                    </div>                                                
                                                </form> 
                                            </div>
                                        </div>
                    
                                    </div>
    
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-acceso" role="tabpanel" aria-labelledby="nav-acceso-tab">
                                
                                <div class="form-group row">
                                    <label for="inpNombreUsuario" class="col-sm-3 col-form-label">Usuario</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inpNombreUsuario" value="{{$usuario_del_docente->email}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inpPasswordUsuario" class="col-sm-3 col-form-label">Contraseña</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inpPasswordUsuario" value="Contraseña secreta" readonly>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="text-primary">Cambiar contraseña</h5>
                                <form method="POST" class="needs-validation" action="{{ url('super/docente/cambiarcontrasena') }}" id="frmActulizarContraDocente" novalidate>
                                    @csrf
                                    <input type="hidden" id="infid_docente" id="infid_docente" value="{{$docente->id_docente}}">
                                    <div class="form-group row">
                                        <label for="inpContra" class="col-sm-3 col-form-label">Nueva contraseña</label>
                                        
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control @error('contrasena') is-invalid @enderror" name="contrasena" id="inpContra" minlength="6" required>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Debe ser como mínimo 6 caracteres</strong>
                                            </span>
                                            @error('contrasena')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inpContraRepet" class="col-sm-3 col-form-label">Repite contraseña</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control @error('repite_contrasena') is-invalid @enderror" id="inpContraRepet" name="repite_contrasena" minlength="6" required>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Debe ser como mínimo 6 caracteres</strong>
                                            </span>
                                            @error('repite_contrasena')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary float-right">Actualizar contraseña</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="text-center pt-4">

                    @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                        @if(strtoupper($docente->c_sexo)=='M')
                            <img class="w-30" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                        @else
                            <img class="w-30" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                        @endif
                        
                    @else
                        <img class="w-30" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Foto del docente">
                    @endif
                    </div>
                    
                    <div class="card-body">
                        <div class="ul-contact-detail__info">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="ul-contact-detail__info-1">
                                        <h5>DNI</h5>
                                        <span>{{$docente->c_dni}}</span>
                                    </div>
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Nombre</h5>
                                        <span class="hs_capitalize">{{$docente->c_nombre}}</span>
                                    </div>
                                </div>

                                <div class="col-6 text-center">
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Nacionalidad</h5>
                                        <span class="hs_capitalize">{{$docente->c_nacionalidad}}</span>
                                    </div>
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Sexo</h5>
                                        <span>{{$docente->c_sexo}}</span>
                                    </div>
                                </div>

                                <div class="col-6 text-center">
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Fecha de nacimiento</h5>
                                        <span>{{$docente->t_fecha_nacimiento}}</span>
                                    </div>
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Telefono</h5>
                                        <span>{{$docente->c_telefono}}</span>
                                    </div>
                                </div>


                                <div class="col-6 text-center">
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Correo</h5>
                                        <span><a href="mailto:{{$docente->c_correo}}">{{$docente->c_correo}}</a></span>
                                    </div>
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Dirección</h5>
                                        <span class="hs_capitalize-first">{{$docente->c_direccion}}</span>
                                     </div>
                                </div>
                                
                                <div class="col-6 text-center">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
  </section>


  <!--MODAL-->
  <div class="modal fade" id="mdlAgregarCategoriaASeccion" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaASeccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asignar sección</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <form id="frmAgregarSeccionADocente" class="needs-validation" method="POST" action="{{route('super/docente/agregarseccion')}}" novalidate>
                @csrf
                <input type="hidden" id="sec_id_docente" name="sec_id_docente">
                
                <div class="form-group">
                    <label for="optsecciones">Eliga una o varias secciones</label>
                    
                    <select id="optsecciones" name="optsecciones[]" multiple required>
                        @foreach($TMP as $seccion)
                            <option value="{{$seccion->id_seccion}}">{{substr($seccion->nom_grado,3)}} "{{$seccion->nom_seccion}}" {{$seccion->c_nivel_academico}}</option>
                        @endforeach
                    </select>
                    
                    <span class="invalid-feedback" role="alert">
                        Seccion es necesario
                    </span>
                </div>
                
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmAgregarSeccionADocente">Agregar</button>
        </div>
      </div>
    </div>
  </div>

  <!--modal Asignar Asignaturas-->
  <div class="modal fade" id="mdlAgregarCategoriaADocente" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaADocenteLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="mdlAgregarCategoriaADocenteLabel">Asignar asignatura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <form id="frmAgregarCategoriaADocente" class="needs-validation" method="POST" action="{{route('super/docente/agregarcategoria')}}" novalidate>
                @csrf
                <input type="hidden" id="cat_id_docente" name="cat_id_docente" value="{{$docente->id_docente}}">
                <div class="form-group">
                    <label for="optseccion">Elige sección</label>
                    <select name="optseccion" id="optseccion" class="form-control" required>
                        <option value="">--Seleccione--</option>
                        @foreach($docente->secciones()->where('seccion_d.estado','=',1)->get() as $seccion)
                            <option value="{{$seccion->id_seccion}}">{{substr($seccion->grado->c_nombre,3)}} "{{$seccion->c_nombre}}" ({{$seccion->grado->c_nivel_academico}})</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback" role="alert">
                        Seccion es necesario
                    </span>
                </div>
                <div class="form-group">
                    <label for="optcategorias">Eliga una o varias asignaturas</label>
                    <select id="optcategorias" name="optcategorias[]" multiple required>
                    </select>
                    <span class="invalid-feedback" role="alert">
                        Curso es necesario
                    </span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmAgregarCategoriaADocente">Agregar</button>
        </div>
      </div>
    </div>
  </div>
  <!--endModal-->

@endsection
@section('page-js')

<script>
    $(document).ready( function () {
        $("#apellido").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#nombre").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#nacionalidad").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#especialidad").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#correo").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#direccion").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });
    });

    jQuery(document).ready(function() {
        jQuery('#dni').keypress(function(tecla) {
            if(tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        jQuery('#apellido').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#nombre').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#nacionalidad').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#especialidad').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#telefono').keypress(function(tecla) {
            if(tecla.charCode < 48 || tecla.charCode > 57) return false;
        });
    });
</script>

<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/superadmin/infodocente.js')}}"></script>
@endsection