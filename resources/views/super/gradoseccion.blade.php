@extends('reutilizable.principal')

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
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#hs_MODAL">Agregar</button>
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
                            <tr>
                                <td>
                                    Inicial
                                </td>
                                <td>
                                    4 años
                                </td>
                                <td>
                                    A
                                </td>
                                <td>
                                    <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                          <a href="#" class="badge badge-danger m-2">X</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Inicial
                                </td>
                                <td>
                                    5 años
                                </td>
                                <td>
                                    A
                                </td>
                                <td>
                                    <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                    <a href="#" class="badge badge-danger m-2">X</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Primaria
                                </td>
                                <td>
                                    Segundo
                                </td>
                                <td>
                                    A
                                </td>
                                <td>
                                    <a href="#" class="badge badge-warning m-2" data-toggle="modal" data-target="#hs_MODAL"><i class="nav-icon i-Pen-4"></i></a>
                                    <a href="#" class="badge badge-danger m-2">X</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal -->
    <div class="modal fade" id="hs_MODAL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{Crear nueva sección} ó {Editar sección}</h5> <!-- Según sea el botón que llame al MODAL -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="picker2">Nivel - Grado</label>
                        <select class="form-control">
                            <option>-- Eliga el nivel-grado --</option>
                            <option>Incial 3 años</option>  
                            <option>Incial 4 años</option>  
                            <option>Incial 5 años</option>
                            <option>Primero de primaria</option>
                            <option>Segundo de primaria</option>
                            <option>Tercero de primaria</option>
                            <option>Cuarto de primaria</option>
                            <option>Quinto de primaria</option>
                            <option>Sexto de primaria</option>
                            <option>Primero de secundaria</option>
                            <option>Segundo de secundaria</option>
                            <option>Tercero de secundaria</option>
                            <option>Cuarto de secundaria</option>
                            <option>Quinto de secundaria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtSeccion">Sección</label>
                        <input type="text" class="form-control" id="txtSeccion" placeholder="Ejemplo: A">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection