@extends('reutilizable.principal')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">

<link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_arrows.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
@endsection

@section('main-content')

<h2 class="hs_titulo">Docentes</h2>
<div class="row hs_contenedor">
    <div class="card col-lg-11 col-sm-12">
        <div class="card-body">
            <div class="hs_encabezado">
                <h4 class="hs_encabezado-titulo">Docentes de la Institución</h4>
                <div class="hs_encabezado-linea"></div>
            </div>
            
            <div class="col" style="padding-right: 0;">
                <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary float-right mb-3"><i class="i-Add-User text-white mr-2"></i>Nuevo docente</button>
            </div>

            <div class="table-responsive">
                <table id="tabla" class="hs_tabla display table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Apellidos y nombres</th>
                            <th>Usuario de acceso</th>
                            <th>Nacionalidad</th>
                            <th>Fecha Nacimiento</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docentes as $docente)
                            <tr>
                                <td>{{$docente->c_dni}}</td>
                                <td>
                                <a href="{{url('super/docente/'.$docente->id_docente)}}">
                                        <div class="ul-widget-app__profile-pic">
                                            <span class="hs_capitalize">{{$docente->c_nombre}}</span>
                                        </div>
                                    </a>
                                </td>
                                <td>{{$docente->usuario->email}}</td>
                                <td><span class="hs_capitalize-first">{{$docente->c_nacionalidad}}</span></td>
                                <td>{{$docente->t_fecha_nacimiento}}</td>
                                <td><a href="mailto:{{$docente->c_correo}}">{{$docente->c_correo}}</a></td>
                                <td><span class="text-info">{{$docente->c_telefono}}</span></td>
                                <td>
                                    <a href="{{url('super/docente/'.$docente->id_docente)}}" class="btn btn-sm btn-warning mr-2" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="nav-icon i-Pen-4"></i>
                                    </a>
                                    <a id="btnEliminarDocente{{$docente->id_docente}}" onclick="fxConfirmacionEliminarDocente({{$docente->id_docente}});" data-toggle="tooltip" data-placement="top" title="Eliminar" href="#" class="btn btn-sm btn-danger">X</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>

<!-- begin::modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo docente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <!-- SmartWizard html -->
                    <form action="{{route('super/docente/agregar')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                            <div id="smartwizard">
                                <ul>
                                    <li><a href="#step-1">Paso 1<br /><small>Datos personales</small></a></li>
                                    <li><a href="#step-2">Paso 2<br /><small>Secciones</small></a></li>
                                    <li><a href="#step-3">Paso 3<br /><small>Asignaturas</small></a></li>
                                    <li><a href="#step-4">Paso 3<br /><small>Foto del docente</small></a></li>
                                </ul>
                                <div>
                                    <div id="step-1">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="dni" >Número de DNI</label>
                                                    <input type="text" class="form-control form-control-sm" id="dni" name="dni" minlength="8" maxlength="8" required>
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>  
                                                
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="apellido" >Apellidos</label>
                                                    <input type="text" class="form-control form-control-sm" id="apellido" name="apellido" required>
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div> 

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="nombre" >Nombre(s)</label>
                                                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div> 
                                            </div>
                                        
                                            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="nacionalidad" >Nacionalidad</label>
                                                    <input type="text" class="hs_capitalize form-control form-control-sm" id="nacionalidad" name="nacionalidad" required placeholder="Peruano(a)">
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="sexo">Sexo</label>
                                                    <select name="sexo" id="sexo" class="form-control form-control-sm">
                                                        <option value="M">Masculino</option>
                                                        <option value="F" selected>Femenino</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                                    <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <strong><label for="especialidad">Especialidad</label></strong>
                                                <input type="text" class="form-control form-control-sm" id="especialidad" name="especialidad" placeholder="Ejemplo: Ciencia y Tecnología">
                                                <div class="help-block with-errors text-danger"></div>
                                            </div>

                                            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="correo">Correo electrónico</label>
                                                    <input type="email" class="form-control form-control-sm" id="correo" name="correo" required>
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                    <label for="telefono">Teléfono</label>
                                                    <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" required maxlength="15">
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" required placeholder="Ejemplo: Av. El Valle 9999, Miraflores">
                                                <div class="help-block with-errors text-danger"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="step-2">
                                        <div class="form-group">
                                        
                                            <label for="optsecciones"><strong>Asignar secciones</strong></label>
                                            <select id="optsecciones" name="optsecciones[]" multiple>
                                                @foreach($TMP as $seccion)
                                                    @if (strtoupper($seccion->c_nivel_academico) == 'INICIAL')
                                                        <option value="{{$seccion->id_seccion}}"><span class="hs_lower">{{ucfirst(strtolower($seccion->c_nivel_academico))}} </span> {{substr($seccion->nom_grado,3)}} "{{strtoupper($seccion->nom_seccion)}}" </option>
                                                    @else
                                                        <option value="{{$seccion->id_seccion}}"><span class="hs_lower">{{ucfirst(strtolower($seccion->c_nivel_academico))}} </span> {{ucfirst(strtolower(substr($seccion->nom_grado,3)))}} "{{strtoupper($seccion->nom_seccion)}}" </option>
                                                    @endif

                                                @endforeach
                                            </select> 
                                        </div>

                                    </div>

                                    <div id="step-3">
                                        <div id="divCursos">
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div id="step-4">
                                        <div class="form-group">
                                            <input type='file' class="hs_upload form-control form-control-lg" id="fotodocente" name="fotodocente" accept="image/x-png,image/gif,image/jpeg">
                                        </div>                                                
                                    </div>

                                </div>
                            </div>
                        </form>
                        


            </div>

            <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>-->
        </div>
    </div>
</div>
<!-- end::modal -->

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
@endsection