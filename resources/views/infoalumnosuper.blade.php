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
                            <a class="nav-item nav-link " id="nav-dicta-tab" data-toggle="tab" href="#nav-dicta" role="tab" aria-controls="nav-dicta" aria-selected="false">Representantes</a>
                            <a class="nav-item nav-link" id="nav-foto-tab" data-toggle="tab" href="#nav-foto" role="tab" aria-controls="nav-foto" aria-selected="false">Foto</a>
                            <a class="nav-item nav-link" id="nav-acceso-tab" data-toggle="tab" href="#nav-acceso" role="tab" aria-controls="nav-acceso" aria-selected="false">Datos de acceso</a>
                        </div>
                    </nav>
                    <div class="tab-content ul-tab__content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-editar" role="tabpanel" aria-labelledby="nav-editar-tab">
                            <form id="frmActualizacionAlumno" class="needs-validation" method="POST" action="{{route('super/alumno/actualizar')}}" novalidate>
                                @csrf
                                <input type="hidden" id="id_alumno" name="id_alumno" value="{{$alumno->id_alumno}}">
                                <div class="form-group row">
                                    <label for="dni" class="col-sm-2 col-form-label  ">Número de DNI</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-3">
                                            <input type="text" id="dni" name="dni"
                                            class="form-control @error('dni') is-invalid @enderror" value="{{$alumno->c_dni}}" minlength="8" maxlength="8" required>    
                                            
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

                                    <label for="nombre" class="hs_capitalize col-sm-2 col-form-label  ">Nombre</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="nombre" name="nombre"
                                            class="form-control hs_capitalize @error('nombre') is-invalid @enderror" value="{{$alumno->c_nombre}}" required>    
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
                                    <label for="nacionalidad" class="col-sm-2 col-form-label  ">Nacionalidad</label>
                                    <div class="col-sm-4">
                                    <input type="text" id="nacionalidad" name="nacionalidad" class="hs_capitalize form-control @error('nacionalidad') is-invalid @enderror" value="{{$alumno->c_nacionalidad}}" required>
                                    <span class="invalid-feedback" role="alert">
                                        La nacionalida es requerido
                                        </span>

                                    @error('nacionalidad')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>

                                    <label for="sexo" class="col-sm-2 col-form-label  ">Sexo</label>
                                    <div class="col-sm-4">
                                        <select name="sexo" id="sexo" class="form-control @error('sexo') is-invalid @enderror" required>
                                            @if(strtoupper($alumno->c_sexo)=='M')
                                                <option value="M" selected>Masculino</option>
                                                <option value="F">Femenino</option>
                                            @else
                                                <option value="M">Masculino</option>
                                                <option value="F" selected>Femenino</option>
                                            @endif
                                        </select>

                                        @error('sexo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-2 col-form-label  ">F. Nacimiento</label>
                                    <div class="col-sm-4">
                                    <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{$alumno->t_fecha_nacimiento}}" required>
                                    <span class="invalid-feedback" role="alert">
                                        Deber ser una fecha correcta
                                        </span>
                                    @error('fecha_nacimiento')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>


                                    <label for="correo_alumno" class="col-sm-2 col-form-label  ">Correo</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control @error('correo_alumno') is-invalid @enderror" id="correo_alumno" name="correo_alumno" value="{{$alumno->c_correo}}">
                                    <span class="invalid-feedback" role="alert">
                                        --
                                        </span>
                                    @error('correo_alumno')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-2 col-form-label  ">Dirección</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="hs_capitalize-first form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{$alumno->c_direccion}}" required>
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
                                    <label for="adicional" class="col-sm-2 col-form-label  ">Información adicional</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control hs_capitalize-first @error('adicional') is-invalid @enderror" id="adicional" name="adicional" value="{{$alumno->c_informacion_adicional}}">
                                    </div>

                                    <label for="seccion" class="col-sm-2 col-form-label  ">Sección</label>
                                    <div class="col-sm-4">
                                        <select name="seccion" id="seccion" class="form-control form-control-sm @error('seccion') is-invalid @enderror" required>
                                            @foreach($TMP as $seccion)
                                                @if (strtoupper($seccion->c_nivel_academico) === 'INICIAL')
                                                    @if ($seccion->id_seccion == $alumno->id_seccion)
                                                        <option value="{{$seccion->id_seccion}}" selected>{{substr($seccion->nom_grado,3)}} "{{strtoupper($seccion->nom_seccion)}}" {{ucfirst(strtolower($seccion->c_nivel_academico))}}</option>
                                                    @else 
                                                        <option value="{{$seccion->id_seccion}}">{{substr($seccion->nom_grado,3)}} "{{strtoupper($seccion->nom_seccion)}}" {{ucfirst(strtolower($seccion->c_nivel_academico))}}</option>
                                                    @endif
                                                @else
                                                    @if ($seccion->id_seccion == $alumno->id_seccion)
                                                        <option value="{{$seccion->id_seccion}}" selected>{{ucfirst(strtolower(substr($seccion->nom_grado,3)))}} "{{strtoupper($seccion->nom_seccion)}}" {{ucfirst(strtolower($seccion->c_nivel_academico))}}</option>
                                                    @else 
                                                        <option value="{{$seccion->id_seccion}}">{{ucfirst(strtolower(substr($seccion->nom_grado,3)))}} "{{strtoupper($seccion->nom_seccion)}}" {{ucfirst(strtolower($seccion->c_nivel_academico))}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                        <!--<select name="seccion" id="seccion" class="form-control form-control-sm @error('seccion') is-invalid @enderror" required>
                                            @foreach($grados as $grado)
                                                <optgroup label="{{$grado->c_nombre}} - {{$grado->c_nivel_academico}}">
                                                    @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                                        @if($seccion->id_seccion==$alumno->id_seccion)
                                                            <option value="{{$seccion->id_seccion}}" selected>{{$seccion->c_nombre}}</option>
                                                        @else
                                                            <option value="{{$seccion->id_seccion}}">{{$seccion->c_nombre}}</option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>-->
                                        <span class="invalid-feedback" role="alert">
                                            La sección es necesario
                                            </span>
                                        @error('seccion')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>



                                <div class="form-group row">
                                    <div class="col" style="display:flex; justify-content: space-between;">
                                        <a href="{{route('super/alumnos')}}" class="btn btn-light float-right">Atrás</a>
                                        <button type="submit" class="btn btn-primary float-right">Actualizar datos del alumno</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="nav-dicta" role="tabpanel" aria-labelledby="nav-dicta-tab">

                            <form id="frmActualizacionRepresentanteAlumno" method="post" action="{{url('super/alumno/actualizarrepresentante')}}" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" id="id_alumno_repre" name="id_alumno_repre1" value="{{$alumno->id_alumno}}">
                            <h4>Primer representante</h4>
                            <div class="form-group row">
                                <label for="dni_repre1" class="col-sm-2 col-form-label">DNI</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="dni_repre1" name="dni_repre1" minlength="8" maxlength="8" value="{{$alumno->c_dni_representante1}}">
                                </div>

                                <label for="nombre_repre1" class="col-sm-2 col-form-label ">Nombre</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize form-control form-control-sm" id="nombre_repre1" name="nombre_repre1" value="{{$alumno->c_nombre_representante1}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nacionalidad_repre1" class="col-sm-2 col-form-label">Nacionalidad</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize form-control form-control-sm" id="nacionalidad_repre1" name="nacionalidad_repre1" value="{{$alumno->c_nacionalidad_representante1}}">
                                </div>

                                <label for="sexo_repre1" class="col-sm-2 col-form-label">Sexo</label>
                                <div class="col-sm-4">
                                    <select name="sexo_repre1" id="sexo_repre1" class="form-control form-control-sm">
                                        @if($alumno->c_sexo_representante1=='M')
                                            <option value=""></option>
                                            <option value="M" selected>Masculino</option>
                                            <option value="F">Femenino</option>
                                        @elseif($alumno->c_sexo_representante1=='F')
                                            <option value=""></option>
                                            <option value="M">Masculino</option>
                                            <option value="F" selected>Femenino</option>
                                        @else
                                            <option value=""></option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        @endif
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefono_repre1" class="col-sm-2 col-form-label">Teléfono</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="telefono_repre1" name="telefono_repre1" value="{{$alumno->c_telefono_representante1}}">
                                </div>

                                <label for="correo_repre1" class="col-sm-2 col-form-label">Correo</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="correo_repre1" name="correo_repre1" value="{{$alumno->c_correo_representante1}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="direccion_repre1" class="col-sm-2 col-form-label">Dirección</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize-first form-control form-control-sm" id="direccion_repre1" name="direccion_repre1" value="{{$alumno->c_direccion_representante1}}">
                                </div>

                                <label for="vinculo_repre1" class="col-sm-2 col-form-label">Vínculo</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize form-control form-control-sm" id="vinculo_repre1" name="vinculo_repre1" value="{{$alumno->c_vinculo_representante1}}">
                                </div>
                            </div>



                            <h4>Segundo representante</h4>
                            <div class="form-group row">
                                <label for="dni_repre2" class="col-sm-2 col-form-label">DNI</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="dni_repre2" name="dni_repre2" minlegth="8" maxlength="8" value="{{$alumno->c_dni_representante2}}">
                                </div>

                                <label for="nombre_repre2" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize form-control form-control-sm" id="nombre_repre2" name="nombre_repre2" value="{{$alumno->c_nombre_representante2}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nacionalidad_repre2" class="col-sm-2 col-form-label">Nacionalidad</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize form-control form-control-sm" id="nacionalidad_repre2" name="nacionalidad_repre2" value="{{$alumno->c_nacionalidad_representante2}}">
                                </div>

                                <label for="sexo_repre2" class="col-sm-2 col-form-label">Sexo</label>
                                <div class="col-sm-4">
                                    <select name="sexo_repre2" id="sexo_repre2" class="form-control form-control-sm">
                                        @if($alumno->c_sexo_representante2=='M')
                                            <option value=""></option>
                                            <option value="M" selected>Masculino</option>
                                            <option value="F">Femenino</option>
                                        @elseif($alumno->c_sexo_representante2=='F')
                                            <option value=""></option>
                                            <option value="M">Masculino</option>
                                            <option value="F" selected>Femenino</option>
                                        @else
                                            <option value=""></option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefono_repre2" class="col-sm-2 col-form-label">Teléfono</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="telefono_repre2" name="telefono_repre2" value="{{$alumno->c_telefono_representante2}}">
                                </div>

                                <label for="correo_repre2" class="col-sm-2 col-form-label">Correo</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" id="correo_repre2" name="correo_repre2" value="{{$alumno->c_correo_representante2}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="direccion_repre2" class="col-sm-2 col-form-label">Dirección</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize-first form-control form-control-sm" id="direccion_repre2" name="direccion_repre2" value="{{$alumno->c_direccion_representante2}}">
                                </div>

                                <label for="vinculo_repre2" class="col-sm-2 col-form-label">Vínculo</label>
                                <div class="col-sm-4">
                                <input type="text" class=" hs_capitalize form-control form-control-sm" id="vinculo_repre2" name="vinculo_repre2"value="{{$alumno->c_vinculo_representante2}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary float-right">Actualizar datos de representante(s)</button>
                                </div>
                            </div>


                            </form>

                        </div>
                        <div class="tab-pane fade" id="nav-foto" role="tabpanel" aria-labelledby="nav-foto-tab">
                            <div class="row mb-4">
                                <div class="col-md-12 mb-4">
                                    <div class="card text-left">

                                        <div class="card-body">
                                        <form id="frmSubidaFotoAlumno" method="post" action="{{url('super/alumno/cambiarfoto')}}" class="needs-validation"  enctype="multipart/form-data" novalidate>
                                                @csrf
                                            <input type="hidden" id="fotoid_alumno" name="fotoid_alumno" value="{{$alumno->id_alumno}}">
                                                <div class="form-group">
                                                    <label for="fotoalumno">Fotografía del alumno</label>
                                                    <input type='file' class="hs_upload form-control form-control-lg" id="fotoalumno" name="fotoalumno" required>
                                                    <span class="invalid-feedback" role="alert">
                                                        Elige una foto
                                                    </span>
                                                </div>                                                
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-primary float-right">Actualizar fotografía</button>
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
                                <input type="text" class="form-control" id="inpNombreUsuario" value="{{$usuario_del_alumno->email}}" readonly>
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
                            <form method="POST" class="needs-validation" action="{{ url('super/alumno/cambiarcontrasena') }}" id="frmActualizarContraAlumno" novalidate>
                                @csrf
                            <input type="hidden" id="infid_alumno" id="infid_alumno" value="{{$alumno->id_alumno}}">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>
                                <span>{{substr($alumno->seccion->grado->c_nombre,3)}}</span>
                                <span>"{{strtoupper($alumno->seccion->c_nombre)}}"</span>
                            </h4>
                            <h5><small>({{strtoupper($alumno->seccion->grado->c_nivel_academico)}})</small></h5>
                        </div>
                    </div>
    
                    <div class="text-center pt-4">
    
                        @if(is_null($alumno->c_foto)  || empty($alumno->c_foto))
                            @if(strtoupper($alumno->c_sexo)=='M')
                                <img class="w-30" src="{{asset('assets/images/usuario/studentman.png')}}" alt="Fotografía">
                            @else
                                <img class="w-30" src="{{asset('assets/images/usuario/studentwoman.png')}}" alt="Fotografía">
                            @endif
                            
                        @else
                            <img class="w-30" src="{{url('super/alumno/foto/'.$alumno->c_foto)}}" alt="Fotografía">
                        @endif
                    </div>

                    <div class="ul-contact-detail__info">
                        
                        <div class="row">
                            <div class="col-6 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <h5>DNI</h5>
                                    <span>{{$alumno->c_dni}}</span>
                                </div>
                                <div class="ul-contact-detail__info-1">
                                    <h5>Nombre</h5>
                                    <span class="hs_capitalize">{{$alumno->c_nombre}}</span>
                                </div>
                            </div>

                            <div class="col-6 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <h5>Nacionalidad</h5>
                                    <span class="hs_capitalize">{{$alumno->c_nacionalidad}}</span>
                                </div>
                                <div class="ul-contact-detail__info-1">
                                    <h5>Sexo</h5>
                                    <span>{{$alumno->c_sexo}}</span>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <h5>Fecha de nacimiento</h5>
                                    <span>{{$alumno->t_fecha_nacimiento}}</span>
                                </div>
                            </div>
                            
                            <div class="col-12 text-center">
                                <div class="ul-contact-detail__info-1">
                                        <h5>Dirección</h5>
                                        <span class="hs_capitalize-first">{{$alumno->c_direccion}}</span>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <h5>Información adicional</h5>
                                    <span class="hs_capitalize-first">{{$alumno->c_informacion_adicional}}</span>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

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

        $("#correo_alumno").on("keypress", function () {
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

        $("#adicional").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        // 

        $("#apellido_repre1").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#nombre_repre1").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#vinculo_repre1").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#nacionalidad_repre1").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#correo_repre1").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#direccion_repre1").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        // 

        $("#apellido_repre2").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#nombre_repre2").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#vinculo_repre2").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#nacionalidad_repre2").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#correo_repre2").on("keypress", function () {
            $input=$(this);
            setTimeout(function () {
                $input.val($input.val().toLocaleLowerCase());
            });
        });

        $("#direccion_repre2").on("keypress", function () {
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

        //

        jQuery('#dni_repre1').keypress(function(tecla) {
            if(tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        jQuery('#apellido_repre1').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#nombre_repre1').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#vinculo_repre1').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#nacionalidad_repre1').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });
        
        jQuery('#telefono_repre1').keypress(function(tecla) {
            if(tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        //

        jQuery('#dni_repre2').keypress(function(tecla) {
            if(tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

        jQuery('#apellido_repre2').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#nombre_repre2').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#vinculo_repre2').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });

        jQuery('#nacionalidad_repre2').keypress(function(tecla) {
            if(tecla.charCode > 47 && tecla.charCode < 58) return false;
        });
        
        jQuery('#telefono_repre2').keypress(function(tecla) {
            if(tecla.charCode < 48 || tecla.charCode > 57) return false;
        });

    });
</script>

<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/superadmin/infoalumno.js')}}"></script>
@endsection