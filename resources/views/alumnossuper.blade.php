@extends('reutilizable.principal')
@section('page-css')

    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_arrows.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <link href="{{asset('assets/styles/css/libreria/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('main-content')
<h2 class="hs_titulo">Alumnos</h2>

<div class="row hs_contenedor">
    <div class="card col-lg-11 col-sm-12">
        <div class="card-body">
            <div class="hs_encabezado">
                <h4 class="hs_encabezado-titulo">Alumnos de la institución</h4>
                <div class="hs_encabezado-linea"></div>
            </div>

            <div class="col" style="padding-right: 0;">
                <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary float-right mb-3" ><i class="i-Add-User text-white mr-2"></i>Nuevo alumno</button>
            </div>

            <div class="table-responsive">
                <table id="ul-contact-list" class="hs_tabla display table table-striped" style="width:100%; text-align: left;">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Apellidos y nombres</th>
                            <th>Usuario</th>
                            <th>Grado</th>
                            <th>Sección</th>
                            <th>Nivel</th>
                            <th>Dirección</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="press-mayusculas">
                        @foreach($grados as $grado)
                            @foreach($grado->secciones->where('estado','=',1) as $seccion)
                                @foreach($seccion->alumnos->where('estado','=',1) as $alumno)
                                <tr>
                                    <td>{{$alumno->c_dni}}</td>
                                    <td nowrap>
                                        <a href="{{url('super/alumno/'.$alumno->id_alumno)}}">
                                                <span>{{$alumno->c_nombre}}</span>
                                            </a>
                                    </td>
                                    <td>{{$alumno->usuario->email}}</td>
                                    @if (strtoupper($grado->c_nivel_academico) === 'INICIAL')
                                        <td>{{substr($grado->c_nombre,3)}}</td>
                                    @else
                                        <td>{{strtolower(substr($grado->c_nombre,3))}}</td>
                                    @endif

                                    <td>{{$seccion->c_nombre}}</td>
                                    <td >{{strtolower($grado->c_nivel_academico)}}</td>
                                    <td nowrap>{{$alumno->c_direccion}}</td>
                                    <td nowrap>
                                        <div style="display: flex">
                                            <a href="{{url('super/alumno/'.$alumno->id_alumno)}}" class="btn btn-sm btn-warning mr-2"  data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="nav-icon i-Pen-4" style="font-size: 15px"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-danger" id="btnEliminarAlumno{{$alumno->id_alumno}}" onclick="fxConfirmacionEliminarAlumno({{$alumno->id_alumno}});" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="far fa-trash-alt" style="font-size: 15px"></i>
                                            </a>
                                        </div>
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

<!-- begin::modal -->
<div class="ul-card-list__modal">
    <div class="modal fade bd-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- SmartWizard html -->
                            <form action="{{route('super/alumno/agregar')}}" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <div id="smartwizard">
                                    <ul>
                                        <li><a href="#step-1">Paso 1</a></li>
                                        <li><a href="#step-2">Paso 2</a></li>
                                        <li><a href="#step-3">Paso 3</a></li>
                                    </ul>
                                    <div>
                                        <div id="step-1">
                                            <div id="form-step-0" role="form" data-toggle="validator">
                                                <h5 style="color: rgb(7, 160, 221);"> <i class="nav-icon i-Right-2" style="font-size: 14px;"></i> Datos del alumno</h5>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="dni" >Número de DNI</label>
                                                        <input type="text" class="only-numeros form-control form-control-sm" id="dni" name="dni" minlength="8" maxlength="8" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="apellido" >Apellidos</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="apellido" name="apellido" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="nombre" >Nombre(s)</label>
                                                        <input type="text" class="press-mayusculas only-letras  form-control form-control-sm" id="nombre_alumno" name="nombre" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="nacionalidad" >Nacionalidad</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="nacionalidad" name="nacionalidad" required placeholder="Peruano(a)">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="sexo">Sexo</label>
                                                        <select name="sexo" id="sexo" class="form-control form-control-sm">
                                                            <option value="M">MASCULINO</option>
                                                            <option value="F">FEMENINO</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="fecha_nacimiento">F.Nacimiento</label>
                                                        <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="correo_alumno">Correo del alumno</label>
                                                    <input type="email" class="press-mayusculas form-control form-control-sm" id="correo_alumno" name="correo_alumno">
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="direccion">Dirección</label>
                                                    <input type="text" class="press-mayusculas form-control form-control-sm" id="direccion" name="direccion" required placeholder="Ejemplo: Av. El Valle 155, Miraflores">
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selDepartamento">Departamento</label>
                                                        <select id="selDepartamento" name="departamento" style="width: 100%;" required>
                                                            <option></option>
                                                            @foreach($departamentos as $departamento)
                                                              <option value="{{$departamento->c_departamento}}">{{$departamento->c_nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selProvincia">Provincia</label>
                                                        <select id="selProvincia"style="width: 100%;" name="provincia" required>
                                                            <option></option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>


                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selDistrito">Distrito</label>
                                                        <select id="selDistrito" style="width: 100%;" name="distrito" required>
                                                            <option></option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="adicional">Información adicional</label>
                                                    <input type="text" class="press-mayusculas form-control form-control-sm" id="adicional" name="adicional" placeholder="(Opcional)">
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>


                                                <h5 style="color: rgb(7, 160, 221);"> <i class="nav-icon i-Right-2" style="font-size: 14px;"></i> Grado y Sección</h5>

                                                <div class="form-group">
                                                    <label for="optseccion">Registrar en la sección</label>

                                                    <select name="optseccion" id="optseccion" class="form-control form-control-sm" required>
                                                        <option value=""></option>
                                                        @foreach($TMP as $seccion)
                                                            @if (strtoupper($seccion->c_nivel_academico) === 'INICIAL')
                                                                <option value="{{$seccion->id_seccion}}">{{substr($seccion->nom_grado,3)}} "{{strtoupper($seccion->nom_seccion)}}" {{ucfirst(strtolower($seccion->c_nivel_academico))}}</option>
                                                            @else
                                                                <option value="{{$seccion->id_seccion}}">{{ucfirst(strtolower(substr($seccion->nom_grado,3)))}} "{{strtoupper($seccion->nom_seccion)}}" {{ucfirst(strtolower($seccion->c_nivel_academico))}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>

                                                <h5 style="color: rgb(7, 160, 221);"> <i class="nav-icon i-Right-2" style="font-size: 14px;"></i> Fotografía del alumno</h5>
                                                <br>
                                                <div class="form-group">
                                                    <input type="file" class="hs_upload form-control form-control-lg" id="fotoalumno" name="fotoalumno" accept="image/x-png,image/gif,image/jpeg">
                                                </div>

                                            </div>
                                        </div>

                                        <div id="step-2">
                                            <div id="form-step-1" role="form" data-toggle="validator">
                                                <h5 style="color: rgb(7, 160, 221);"> <i class="nav-icon i-Right-2" style="font-size: 14px;"></i> Primer representante</h5>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="dni_repre1">Número de DNI</label>
                                                        <input type="text" class="only-numeros form-control form-control-sm" id="dni_repre1" name="dni_repre1" minlength="8" maxlength="8" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="apellido_repre1">Apellidos</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="apellido_repre1" name="apellido_repre1" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="nombre_repre1">Nombre(s)</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="nombre_repre1" name="nombre_repre1" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="vinculo_repre1">Vínculo</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="vinculo_repre1" name="vinculo_repre1" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="nacionalidad_repre1">Nacionalidad</label>
                                                        <input  type="text" class="press-mayusculas only-letras form-control form-control-sm" id="nacionalidad_repre1" name="nacionalidad_repre1" placeholder="Peruano(a)" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="sexo_repre1">Sexo</label>
                                                        <select name="sexo_repre1" id="sexo_repre1" class="form-control form-control-sm" required>
                                                            <option value="M">MASCULINO</option>
                                                            <option value="F">FEMENINO</option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="telefono_repre1">Teléfono</label>
                                                        <input type="text" class="only-numeros form-control form-control-sm" id="telefono_repre1" name="telefono_repre1" maxlength="15" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="correo_repre1">Correo electrónico</label>
                                                        <input type="email" class="press-mayusculas form-control form-control-sm" id="correo_repre1" name="correo_repre1" required>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="direccion_repre1">Dirección</label>
                                                    <input type="text" class="press-mayusculas form-control form-control-sm" id="direccion_repre1" name="direccion_repre1" placeholder="Ejemplo: Av. El Valle 155, Miraflores" required>
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selDepartamentoRepre1">Departamento</label>
                                                        <select id="selDepartamentoRepre1" name="departamento_repre1" style="width: 100%;" required>
                                                            <option></option>
                                                            @foreach($departamentos as $departamento)
                                                              <option value="{{$departamento->c_departamento}}">{{$departamento->c_nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selProvinciaRepre1">Provincia</label>
                                                        <select id="selProvinciaRepre1" style="width: 100%;" name="provincia_repre1" required>
                                                            <option></option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>


                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selDistritoRepre1">Distrito</label>
                                                        <select id="selDistritoRepre1" style="width: 100%;" name="distrito_repre1" required>
                                                            <option></option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="step-3">
                                            <div id="form-step-2" role="form" data-toggle="validator">
                                                <h5 style="color: rgb(7, 160, 221);"> <i class="nav-icon i-Right-2" style="font-size: 14px;"></i> Segundo representante</h5>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="dni_repre2">Número de DNI</label>
                                                        <input type="text" class="only-numeros form-control form-control-sm" id="dni_repre2" name="dni_repre2" maxlength="8">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="apellido_repre2">Apellidos</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="apellido_repre2" name="apellido_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="nombre_repre2">Nombre(s)</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="nombre_repre2" name="nombre_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="vinculo_repre2">Vínculo</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="vinculo_repre2" name="vinculo_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="nacionalidad_repre2">Nacionalidad</label>
                                                        <input type="text" class="press-mayusculas only-letras form-control form-control-sm" id="nacionalidad_repre2" name="nacionalidad_repre2" placeholder="Peruano(a)">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="sexo_repre2">Sexo</label>
                                                        <select name="sexo_repre2" id="sexo_repre2" class="form-control form-control-sm">
                                                            <option value="M">MASCULINO</option>
                                                            <option value="F">FEMENINO</option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="telefono_repre2">Teléfono</label>
                                                        <input type="text" class="only-numeros form-control form-control-sm" id="telefono_repre2" name="telefono_repre2" maxlength="15">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>

                                                    <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding: 0;">
                                                        <label for="correo_repre2">Correo electrónico</label>
                                                        <input type="email" class="press-mayusculas form-control form-control-sm" id="correo_repre2" name="correo_repre2">
                                                        <div class="help-block with-errors text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="direccion_repre2">Dirección</label>
                                                    <input type="text" class="press-mayusculas form-control form-control-sm" id="direccion_repre2" name="direccion_repre2" placeholder="Ejemplo: Av. El Valle 155, Miraflores">
                                                    <div class="help-block with-errors text-danger"></div>
                                                </div>


                                                <div class="row">
                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selDepartamentoRepre2">Departamento</label>
                                                        <select id="selDepartamentoRepre2" name="departamento_repre2" style="width: 100%;">
                                                            <option></option>
                                                            @foreach($departamentos as $departamento)
                                                              <option value="{{$departamento->c_departamento}}">{{$departamento->c_nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>

                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selProvinciaRepre2">Provincia</label>
                                                        <select id="selProvinciaRepre2" style="width: 100%;" name="provincia_repre2">
                                                            <option></option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>


                                                  <div class="col-md-4 col-xs-12">
                                                      <div class="form-group">
                                                        <label for="selDistritoRepre2">Distrito</label>
                                                        <select id="selDistritoRepre2" style="width: 100%;" name="distrito_repre2">
                                                            <option></option>
                                                        </select>
                                                        <div class="help-block with-errors text-danger"></div>
                                                      </div>
                                                  </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::modal -->
@endsection
@section('page-js')
  <script>
      $('#optseccion').on('change', function(){
          tmp = $('#optseccion').val();

          if(tmp == ''){
              alert('Debe seleccionar una sección');
          }
      })
  </script>
  <!-- page script -->
  <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
  <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
  <script src="{{asset('assets/js/libreria/validator/validator.min.js')}}"></script>
  <script src="{{asset('assets/js/libreria/select2/select2.min.js')}}"></script>
  <script src="{{asset('assets/js/vendor/jquery.smartWizard.min.js')}}"></script>
  <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
  <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
  <script src="{{asset('assets/js/superadmin/alumnos.js')}}"></script>
  <script src="{{asset('assets/js/all/validacionKey.js')}}"></script>
  <script>
    $('#ul-contact-list').DataTable();
  </script>
@endsection
