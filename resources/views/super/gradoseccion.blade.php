@extends('reutilizable.principal')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
@endsection
@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
</head>

<body>
    <h2 class="hs_titulo">Grados y secciones</h2>

    <div class="row hs_contenedor">
        <div class="card  col col-lg-7 col-sm-12">
            <div class="card-body">
                <div class="hs_encabezado">
                    <h4 class="hs_encabezado-titulo">Mis grados y secciones</h4>
                    <div class="hs_encabezado-linea"></div>
                </div>
                
                <div class="botonera-superior-derecha">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#hs_MODAL" onclick="GradoSeccion()">Agregar</button>
                </div>

                <div class="table-responsive">
                    <table id="zero_configuration_table" class=" hs_tabla display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nivel</th>
                                <th>Grado</th>
                                <th>Sección</th>
                                <th><small></small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($TMP as $item)
                                <tr>
                                    <td>
                                        {{ucfirst(strtolower($item->c_nivel_academico))}}
                                    </td>
                                    <td>
                                        @if ($item->c_nombre === '1-.3 AÑOS' || $item->c_nombre === '2-.4 AÑOS' || $item->c_nombre === '3-.5 AÑOS')
                                            {{substr($item->nom_grado,3)}}
                                        @endif
                                        {{ucfirst(substr(strtolower($item->c_nombre),3))}}
                                    </td>
                                    <td class="hs_upper">
                                        {{$item->nom_seccion}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" id="btnActualizarSeccion{{$item->id_seccion}}" onclick="fxActualizarSeccion({{$item->id_seccion}});" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="i-Pen-4"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" id="btnConfirmacionEliminarSeccion{{$item->id_seccion}}" onclick="fxConfirmacionEliminarSeccion({{$item->id_seccion}});" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="i-Eraser-2"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Guardar -->
    <div class="modal fade" id="hs_MODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nueva sección</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmAgregarSeccion" class="needs-validation" method="POST" action="{{route('super/gradoseccion/agregar')}}" novalidate>
                        <div class="form-group">
                            <label for="picker2">Nivel - Grado</label>
                            <select class="form-control" id="id_grado" name="id_grado">
                                <option>-- Eliga el nivel-grado --</option>
                                @foreach ($grados as $item)
                                    @if ($item->c_nombre === '1-.3 AÑOS' || $item->c_nombre === '2-.4 AÑOS' || $item->c_nombre === '3-.5 AÑOS')
                                        <option value="{{$item->id_grado}}">{{ucfirst(strtolower($item->c_nivel_academico))}} - {{substr($item->c_nombre,3)}} </option>
                                    @else
                                        <option value="{{$item->id_grado}}">{{ucfirst(strtolower($item->c_nivel_academico))}} - {{ucfirst(substr(strtolower($item->c_nombre),3))}} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label for="nombre">Sección</label>
                            <input type="text" class="form-control" id="nombre"name="nombre"  placeholder="Ejemplo: A" required>
                            <div class="invalid-feedback">
                                La sección es necesaria
                            </div>
                        </div>

                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmAgregarSeccion">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Actualizar -->
    <div class="modal fade" id="hs_MODAL-2" tabindex="-1" role="dialog" aria-labelledby="hs_MODAL-2Label" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nueva sección</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmActualizar" class="needs-validation" method="POST" action="{{route('super/gradoseccion/actualizar')}}" novalidate>
                        
                        @csrf
                        <input type="hidden" id="id_seccion" name="id_seccion">
    
                        <div class="form-group">
                            <label for="actnombre">Sección</label>
                            <input type="text" class=" hs_upper form-control" id="actnombre" name="actnombre"  placeholder="Ejemplo: A" required>
                            <div class="invalid-feedback">
                                La sección es necesaria
                            </div>
                        </div>

                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="frmActualizar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection

@section('page-js')

<script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/ladda.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/superadmin/secciones.js')}}"></script>

@endsection