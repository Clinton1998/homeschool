@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_arrows.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection

@section('main-content')


<section class="contact-list">
    <div class="row">
            <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header bg-transparent">
                            <div class="row">
                                <div class="col-sm-1">Filtro</div>
                                <div class="col-sm-3">
                                    <select name="" id="" class="form-control">
                                        <option value="">PRIMERO</option>
                                        <option value="">SEGUNDO</option>
                                        <option value="">TERCERO</option>
                                        <option value="">CUARTO</option>
                                        <option value="">QUINTO</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="" id="" class="form-control">
                                        <option value="">A</option>
                                        <option value="">B</option>
                                        <option value="">C</option>
                                        <option value="">D</option>
                                        <option value="">E</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1"><i class="i-Add-User text-white mr-2"></i> Agregar alumno</button>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            
                                <div class="table-responsive">
                                    <table id="ul-contact-list" class="display table table-sm table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>DNI</th>
                                                <th>Nombre</th>
                                                <th>Nacionalidad</th>
                                                <th>Fecha Nacimiento</th>
                                                <th>Dirección</th>
                                                <th>Sección</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($grados as $grado)
                                                @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                                    @foreach($seccion->alumnos->where('estado','=',1) as $alumno)
                                                    <tr>
                                                        <td>{{$alumno->c_dni}}</td>
                                                        <td>
                                                            <a href="{{url('super/alumno/'.$alumno->id_alumno)}}">
                                                                    <div class="ul-widget-app__profile-pic">
                                                                        @if(is_null($alumno->c_foto)  || empty($alumno->c_foto))
                                                                            @if(strtoupper($alumno->c_sexo)=='M')
                                                                                <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{asset('assets/images/usuario/studentman.png')}}" alt="Foto del alumno">
                                                                            @else
                                                                                <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{asset('assets/images/usuario/studentwoman.png')}}" alt="Foto de alumna">
                                                                            @endif
            
                                                                        @else
                                                                            <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{url('super/alumno/foto/'.$alumno->c_foto)}}" alt="Foto del alumno">
                                                                        @endif
                                                                        {{$alumno->c_nombre}}
                                                                    </div>
                                                                </a>
                                                        </td>
                                                        <td>{{$alumno->c_nacionalidad}}</td>
                                                        <td>{{$alumno->t_fecha_nacimiento}}</td>
                                                        <td>{{$alumno->c_direccion}}</td>
                                                        <td><span class="text-primary">{{$seccion->c_nombre}}</span> - <span class="text-success">{{$grado->c_nombre}} - {{$grado->c_nivel_academico}}</span></td>
                                                        <td>
                                                            <a href="{{url('super/alumno/'.$alumno->id_alumno)}}" class="ul-link-action text-success"  data-toggle="tooltip" data-placement="top" title="Editar">
                                                                    <i class="i-Edit"></i>
                                                                </a>
                                                            <button class="btn btn-sm btn-danger" id="btnEliminarAlumno{{$alumno->id_alumno}}" onclick="fxConfirmacionEliminarAlumno({{$alumno->id_alumno}});" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                <i class="i-Eraser-2"></i>
                                                            </button>  
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    
                                    </table>
                                </div>
                                
                            
                        
                        </div>
                    </div>
                </div>
    </div>
</section>

<!-- begin::modal -->
<div class="ul-card-list__modal">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- SmartWizard html -->
                            <form action="{{route('super/alumno/agregar')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                    <div id="smartwizard">
                                        <ul>
                                            <li><a href="#step-1">Paso 1<br /><small>Datos del alumno</small></a></li>
                                            <li><a href="#step-2">Paso 2<br /><small>Primer representante</small></a></li>
                                            <li><a href="#step-3">Paso 3<br /><small>Segundo representante</small></a></li>
                                            <li><a href="#step-4">Paso 4<br /><small>Pertenece a</small></a></li>
                                            <li><a href="#step-5">Paso 5<br /><small>Foto del alumno</small></a></li>
                                            <li><a href="#step-6">Paso 6<br /><small>Datos de acceso</small></a></li>
                                        </ul>
                                        <div>
                                            <div id="step-1">
                                                <div id="form-step-0" role="form" data-toggle="validator">

                                                            <div class="form-group">
                                                                <label for="dni" >DNI</label>
                                                                <input type="text" class="form-control form-control-sm" id="dni" name="dni" minlength="8" maxlength="8" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>  
                                                     
                                                        
                                                            <div class="form-group">
                                                                <label for="nombre" >Nombre</label>
                                                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>     
                                                      


                                                        
                                                            <div class="form-group">
                                                                <label for="nacionalidad" >Nacionalidad</label>
                                                                <input type="text" class="form-control form-control-sm" id="nacionalidad" name="nacionalidad" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                      

                                                        
                                                            <div class="form-group">
                                                                <label for="sexo">Sexo</label>
                                                                <select name="sexo" id="sexo" class="form-control form-control-sm">
                                                                    <option value="M">Masculino</option>
                                                                    <option value="F">Femenino</option>
                                                                </select>
                                                            </div>
                                                     
                                                       
                                                            <div class="form-group">
                                                                <label for="fecha_nacimiento">F.Nacimiento</label>
                                                                <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="correo_alumno">Correo del alumno</label>
                                                                <input type="email" class="form-control form-control-sm" id="correo_alumno" name="correo_alumno">
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                    
                                                        
                                                            <div class="form-group">
                                                                <label for="direccion">Dirección</label>
                                                                <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="adicional">Información adicional</label>
                                                                <input type="text" class="form-control form-control-sm" id="adicional" name="adicional">
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                    
                                                </div>
                            
                                            </div>
                                            <div id="step-2">
                                                <div id="form-step-1" role="form" data-toggle="validator">
                                                    <div class="form-group">
                                                        <label for="dni_repre1">DNI</label>
                                                        <input type="text" class="form-control form-control-sm" id="dni_repre1" name="dni_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nombre_repre1">Nombre</label>
                                                        <input type="text" class="form-control form-control-sm" id="nombre_repre1" name="nombre_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nacionalidad_repre1">Nacionalidad</label>
                                                        <input type="text" class="form-control form-control-sm" id="nacionalidad_repre1" name="nacionalidad_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="sexo_repre1">Sexo</label>
                                                        <select name="sexo_repre1" id="sexo_repre1" class="form-control form-control-sm">
                                                            <option value=""></option>
                                                            <option value="M">Masculino</option>
                                                            <option value="F">Femenino</option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="telefono_repre1">Teléfono</label>
                                                        <input type="text" class="form-control form-control-sm" id="telefono_repre1" name="telefono_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="correo_repre1">Correo</label>
                                                        <input type="email" class="form-control form-control-sm" id="correo_repre1" name="correo_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="direccion_repre1">Dirección</label>
                                                        <input type="text" class="form-control form-control-sm" id="direccion_repre1" name="direccion_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="vinculo_repre1">Vínculo</label>
                                                        <input type="text" class="form-control form-control-sm" id="vinculo_repre1" name="vinculo_repre1">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="step-3">
                                                <div id="form-step-2" role="form" data-toggle="validator">
                                                    <div class="form-group">
                                                        <label for="dni_repre2">DNI</label>
                                                        <input type="text" class="form-control form-control-sm" id="dni_repre2" name="dni_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nombre_repre2">Nombre</label>
                                                        <input type="text" class="form-control form-control-sm" id="nombre_repre2" name="nombre_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nacionalidad_repre2">Nacionalidad</label>
                                                        <input type="text" class="form-control form-control-sm" id="nacionalidad_repre2" name="nacionalidad_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="sexo_repre2">Sexo</label>
                                                        <select name="sexo_repre2" id="sexo_repre2" class="form-control form-control-sm">
                                                            <option value=""></option>
                                                            <option value="M">Masculino</option>
                                                            <option value="F">Femenino</option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="telefono_repre2">Teléfono</label>
                                                        <input type="text" class="form-control form-control-sm" id="telefono_repre2" name="telefono_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="correo_repre2">Correo</label>
                                                        <input type="email" class="form-control form-control-sm" id="correo_repre2" name="correo_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="direccion_repre2">Dirección</label>
                                                        <input type="text" class="form-control form-control-sm" id="direccion_repre2" name="direccion_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="vinculo_repre2">Vínculo</label>
                                                        <input type="text" class="form-control form-control-sm" id="vinculo_repre2" name="vinculo_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="step-4" class="">
                                                <div id="form-step-3" role="form" data-toggle="validator">
                                                    <div class="form-group">
                                                        <select name="optseccion" id="optseccion" class="form-control form-control-sm" required>
                                                            @foreach($grados as $grado)
                                                                <option data-placeholder="true"></option>
                                                                <optgroup label="{{$grado->c_nombre}} - {{$grado->c_nivel_academico}}">
                                                                    @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                                                        <option value="{{$seccion->id_seccion}}">{{$seccion->c_nombre}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div id="step-5">
                                                <div class="form-group">
                                                    <input type="file" class="form-control form-control-lg" id="fotoalumno" name="fotoalumno">
                                                </div>
                                            </div>

                                            <div id="step-6">
                                                <div class="form-group">
                                                    <label for="usuarioalumno">Usuario</label>
                                                    <input type="text" class="form-control" id="usuarioalumno" name="usuarioalumno" required>
                                                </div>                            

                                                <div class="form-group">
                                                    <label for="contrasenaalumno">Contraseña</label>
                                                    <input type="text" class="form-control" id="contrasenaalumno" name="contrasenaalumno" value="12345678" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
              </div>
            </div>
          </div>
</div>
<!-- end::modal -->



@endsection

@section('page-js')


    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <!-- page script -->
    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
    <script src="{{asset('assets/js/libreria/validator/validator.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/jquery.smartWizard.min.js')}}"></script>

    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/alumnos.js')}}"></script>

    <script>
    $('#ul-contact-list').DataTable();
    /*new SlimSelect({
            select: '#optseccion',
            placeholder: 'Elige seccion'
          });*/
    </script>
@endsection