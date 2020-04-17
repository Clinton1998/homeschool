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
                                    <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-md m-1"><i class="i-Add-User text-white mr-2"></i> Agregar docente</button>
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
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($docentes as $docente)
                                            <tr>
                                                <td>{{$docente->c_dni}}</td>
                                                <td>
                                                <a href="{{url('super/docente/'.$docente->id_docente)}}">
                                                        <div class="ul-widget-app__profile-pic">
                                                            @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                                                                @if(strtoupper($docente->c_sexo)=='M')
                                                                    <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                                                                @else
                                                                    <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                                                                @endif

                                                            @else
                                                                <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Foto del docente">
                                                            @endif
                                                            {{$docente->c_nombre}}
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>{{$docente->c_nacionalidad}}</td>
                                                <td>{{$docente->t_fecha_nacimiento}}</td>
                                                <td><a href="mailto:{{$docente->c_correo}}">{{$docente->c_correo}}</a></td>
                                                <td><span class="text-info">{{$docente->c_telefono}}</span></td>
                                                <td>
                                                    <a href="{{url('super/docente/'.$docente->id_docente)}}" class="ul-link-action text-success"  data-toggle="tooltip" data-placement="top" title="Editar">
                                                            <i class="i-Edit"></i>
                                                        </a>
                                                    <button class="btn btn-sm btn-danger" id="btnEliminarDocente{{$docente->id_docente}}" onclick="fxConfirmacionEliminarDocente({{$docente->id_docente}});" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                        <i class="i-Eraser-2"></i>
                                                    </button>  
                                                </td>
                                            </tr>
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
            <div class="modal-dialog  modal-dialog-centered">
              <div class="modal-content">
                
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- SmartWizard html -->
                            <form action="{{route('super/docente/agregar')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                    <div id="smartwizard">
                                        <ul>
                                            <li><a href="#step-1">Paso 1<br /><small>Datos del docente</small></a></li>
                                            <li><a href="#step-2">Paso 2<br /><small>Dará clases en</small></a></li>
                                            <li><a href="#step-3">Paso 3<br /><small>Foto del docente</small></a></li>
                                            <li><a href="#step-4">Paso 4<br /><small>Datos de acceso</small></a></li>
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
                                                                <input type="text" class="form-control form-control-sm" id="nacionalidad" name="nacionalidad" value="Peruano" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="sexo">Sexo</label>
                                                                <select name="sexo" id="sexo" class="form-control form-control-sm">
                                                                    <option value="M">Masculino</option>
                                                                    <option value="F" selected>Femenino</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="especialidad">Especialidad</label>
                                                                <input type="text" class="form-control form-control-sm" id="especialidad" name="especialidad" placeholder="Ejm: Ciencia y Tecnología">
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                     
                                                       
                                                            <div class="form-group">
                                                                <label for="fecha_nacimiento">F.Nacimiento</label>
                                                                <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                   
                                                       
                                                            <div class="form-group">
                                                                <label for="correo">Correo</label>
                                                                <input type="email" class="form-control form-control-sm" id="correo" name="correo" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                     

                                                        
                                                            <div class="form-group">
                                                                <label for="telefono">Teléfono</label>
                                                                <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>
                                                    
                                                        
                                                            <div class="form-group">
                                                                <label for="direccion">Dirección</label>
                                                                <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" required>
                                                                <div class="help-block with-errors text-danger"></div>
                                                            </div>

                                                    
                                                </div>
                            
                                            </div>
                                            <div id="step-2">
                                                <div class="form-group">
                                                    <select id="optsecciones" name="optsecciones[]" multiple>
                                                        @foreach($grados as $grado)
                                                            <optgroup label="{{$grado->c_nombre}} - {{$grado->c_nivel_academico}}">
                                                                @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                                                    <option value="{{$seccion->id_seccion}}">{{$seccion->c_nombre}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>                
                                                </div>
                                            </div>
                                            <div id="step-3">
                                                <div class="form-group">
                                                    <input type='file' class="form-control form-control-lg" id="fotodocente" name="fotodocente">
                                                </div>                                                

                                            </div>
                                            <div id="step-4" class="">                                                
                                                    <div class="form-group">
                                                        <label for="usuariodocente">Usuario</label>
                                                        <input type="text" class="form-control" id="usuariodocente" name="usuariodocente" required>
                                                    </div>                            
    
                                                    <div class="form-group">
                                                        <label for="contrasenadocente">Contraseña</label>
                                                        <input type="text" class="form-control" id="contrasenadocente" name="contrasenadocente" value="12345678" readonly>
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
<script src="{{asset('assets/js/superadmin/docentes.js')}}"></script>

<script>
$('#ul-contact-list').DataTable();
new SlimSelect({
            select: '#optsecciones',
            placeholder: 'Elige secciones'
          });
</script>
@endsection