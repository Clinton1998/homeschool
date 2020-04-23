@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
@endsection
@section('main-content')
    <section>
        <div class="row">
            <div class="col-sm-4">
                
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
                                        <span>{{$docente->c_nombre}}</span>
                                    </div>
                                </div>

                                <div class="col-6 text-center">
                                    <div class="ul-contact-detail__info-1">
                                        <h5>Nacionalidad</h5>
                                        <span>{{$docente->c_nacionalidad}}</span>
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
                                </div>
                                
                                <div class="col-12 text-center">
                                    <div class="ul-contact-detail__info-1">
                                            <h5>Dirección</h5>
                                            <span>{{$docente->c_direccion}}</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-sm-8">



                <div class="card mb-4 mt-4">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active show" id="nav-editar-tab" data-toggle="tab" href="#nav-editar" role="tab" aria-controls="nav-editar" aria-selected="true">Editar</a>
                                <a class="nav-item nav-link " id="nav-dicta-tab" data-toggle="tab" href="#nav-dicta" role="tab" aria-controls="nav-dicta" aria-selected="false">Secciones asignadas</a>
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
                                        <label for="dni" class="col-sm-2 col-form-label text-right">DNI</label>
                                        <div class="col-sm-4">
                                            <div class="input-group mb-3">
                                                <input type="text" id="dni" name="dni"
                                                class="form-control @error('dni') is-invalid @enderror" value="{{$docente->c_dni}}" minlength="8" minlength="8" required>    
                                               
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary ladda-button"  data-style="expand-right" id="btnBuscarPorDNI">Buscar</button>
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

                                        <label for="nombre" class="col-sm-2 col-form-label text-right">Nombre</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nombre" name="nombre"
                                                class="form-control @error('nombre') is-invalid @enderror" value="{{$docente->c_nombre}}" required>    
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
                                        <label for="nacionalidad" class="col-sm-2 col-form-label text-right">Nacionalidad</label>
                                        <div class="col-sm-4">
                                        <input type="text" id="nacionalidad" name="nacionalidad" class="form-control @error('nacionalidad') is-invalid @enderror" value="{{$docente->c_nacionalidad}}" required>
                                        <span class="invalid-feedback" role="alert">
                                            La nacionalidad es requerido
                                            </span>

                                        @error('nacionalidad')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </div>

                                        <label for="sexo" class="col-sm-2 col-form-label text-right">Sexo</label>
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
                                        <label for="fecha_nacimiento" class="col-sm-2 col-form-label text-right">F. Nacimiento</label>
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

                                        <label for="correo" class="col-sm-2 col-form-label text-right">Correo</label>
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
                                        <label for="telefono" class="col-sm-2 col-form-label text-right">Teléfono</label>
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


                                        <label for="especialidad" class="col-sm-2 col-form-label text-right">Especialidad</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control @error('especialidad') is-invalid @enderror" id="especialidad" name="especialidad" value="{{$docente->c_especialidad}}">
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
                                        <label for="direccion" class="col-sm-2 col-form-label text-right">Dirección</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{$docente->c_direccion}}" required>
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
                                        <div class="col-xs-12 col-sm-6 offset-3">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Actualizar</button>
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
                                    <div class="accordion" id="accordionRightIcon">
                                        @php
                                            $fs = 0;
                                        @endphp
                                        @foreach($docente->secciones->where('estado','=',1) as $seccion)
                                            @php
                                                $fs++;
                                            @endphp
                                            <div class="card " id="cardSeccion{{$seccion->id_seccion}}">
                                                <div class="card-header header-elements-inline">
                                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                    <span class="text-primary collapsed">#{{$fs}}  {{$seccion->c_nombre}} - <span class="text-info">{{$seccion->grado->c_nombre}} - {{$seccion->grado->c_nivel_academico}}</span></span>
                                                    </h6>
                                                <button type="button" class="btn btn-sm btn-danger float-right" id="btnQuitarSeccionDeDocente{{$seccion->id_seccion}}" onclick="fxQuitarSeccionDeDocente({{$docente->id_docente}},{{$seccion->id_seccion}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar"><i class="i-Eraser-2"></i></button>
                                                </div>
                                            </div>
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
                                                        <input type='file' class="form-control form-control-lg" id="fotodocente" name="fotodocente" required>
                                                        <span class="invalid-feedback" role="alert">
                                                            Foto del docente
                                                        </span>
                                                    </div>                                                
                                                    <div class="form-group row">
                                                        <div class="col-xs-12 col-sm-6 offset-3">
                                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Subir</button>
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
                                    <label for="inpNombreUsuario" class="col-sm-2 col-form-label">Usuario</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inpNombreUsuario" value="{{$usuario_del_docente->email}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inpPasswordUsuario" class="col-sm-2 col-form-label">Contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inpPasswordUsuario" value="Contraseña secreta" readonly>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="text-primary">Cambiar contraseña</h5>
                                <form method="POST" class="needs-validation" action="{{ url('super/docente/cambiarcontrasena') }}" id="frmActulizarContraDocente" novalidate>
                                    @csrf
                                <input type="hidden" id="infid_docente" id="infid_docente" value="{{$docente->id_docente}}">
                                <div class="form-group row">
                                    <label for="inpContra" class="col-sm-2 col-form-label">Nueva contraseña</label>
                                    
                                    <div class="col-sm-10">
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
                                    <label for="inpContraRepet" class="col-sm-2 col-form-label">Repite contraseña</label>
                                    <div class="col-sm-10">
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
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                                    </div>
                                </div>
                            </form>



                            </div>
                        </div>
                    </div>
                </div>












            </div>
        </div>
  </section>


  
  <div class="modal fade" id="mdlAgregarCategoriaASeccion" tabindex="-1" role="dialog" aria-labelledby="mdlAgregarCategoriaASeccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <form id="frmAgregarSeccionADocente" class="needs-validation" method="POST" action="{{route('super/docente/agregarseccion')}}" novalidate>
                @csrf
                <input type="hidden" id="id_docente" name="id_docente">
                <div class="row">
                <div class="col-sm-2">
                <h3>Agregar</h3>
                </div>
                <div class="col-sm-4">
                <select id="optsecciones" name="optsecciones[]" multiple required>
                    @foreach($grados as $grado)
                    <optgroup label="{{$grado->c_nombre}} - {{$grado->c_nivel_academico}}">
                            @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                <option value="{{$seccion->id_seccion}}">{{$seccion->c_nombre}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>                
                <div class="invalid-feedback">
                    Seccion es necesario
                </div>
                </div>
                <div class="col-sm-6">
                <h3>a "<span class="text-primary" id="spanNombreDocente">PRIMER</span>"</h3>
                </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmAgregarSeccionADocente">Agregar</button>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('page-js')
<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/superadmin/infodocente.js')}}"></script>
@endsection