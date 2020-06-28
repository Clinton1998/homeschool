@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/libreria/slim/slimselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">

    <link  rel="stylesheet" href="{{asset('fine-uploader/fine-uploader-new.css')}}">
    <script src="{{asset('fine-uploader/fine-uploader.js')}}"></script>
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Seleccionar archivos</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>Procesando archivos caídos...</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Quitar</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Reintentar</button>
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Eliminar</button>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Sí</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancelar</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
@endsection
@section('main-content')

<head>
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}">
</head>

<body>
    <h2 class="titulo">Asignación de tareas</h2>
    @foreach($errors->all() as $error)
      <h1>{{ $error }}</h1>
    @endforeach
    <div class="mis-alumnos-contenedor card col col-lg-6">
        <div class="card-body">

            <a href="" class="btn btn-primary float-right" id="btn-nueva-tarea" data-toggle="modal" data-target="#modal-tarea-nueva">+ Crear nueva tarea</a>
            <br>
            <br>

            <div id="tareas">
                <!-- Tarea -->
                @php
                    $contador_tareas = 0;
                @endphp

                @foreach($tareas as $tarea)
                    @php
                        $contador_tareas++;
                        if ($contador_tareas <= 3) {

                        }
                        else {
                            echo '<div class="text-right" style="width: 100%"><strong class="mb-2"><a class="my-link" href="#" data-toggle="modal" data-target="#TAREAS">Ver todo</a></strong></div>';
                            break;
                        }
                    @endphp

                    <div style="border-color: {{$tarea->categoria->c_nivel_academico}}; border-left: solid 4px {{$tarea->categoria->c_nivel_academico}};" class="tarea" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">
                        <div class="row">
                            <div class="col">
                                <h5 class="tarea-titulo hs_upper">{{$tarea->c_titulo}}</h5>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-light p-2 hs_capitalize" style="font-size: 11px; color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                            </div>
                        </div>

                        <p class="tarea-descripcion hs_capitalize-first">{{$tarea->c_observacion}}</p>
                        <div class="tarea-fechas">
                            <div class="tarea-fecha-publicacion">
                                <small>Fecha de publicación: </small>
                                <small>{{$tarea->created_at}}</small>
                            </div>
                            <div class="tarea-fecha-entrega">
                                <strong>Fecha de entrega: </strong>
                                <strong>{{$tarea->t_fecha_hora_entrega}}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Tarea nueva -->
    <div class="modal fade" id="modal-tarea-nueva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar nueva tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="switch switch-success mr-3">
                            <span>Adjuntar archivo</span>
                            <input type="checkbox" id="chkConArchivoNuevaTarea">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div id="divFrmTareaSinArchivo">
                      <form id="frmAsignarTarea" method="post" action="{{route('docente/tarea/registrar')}}" class="needs-validation"  enctype="multipart/form-data" novalidate>
                          @csrf
                          @foreach($errors->all() as $error)
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>{{$error}}</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                          @endforeach
                          <input type="hidden" id="id_docente_sin_archivo" name="id_docente" value="{{$docente->id_docente}}">
                          <div class="form-group">
                              <label class="label-text" for="txtTituloSinArchivo">Título de tarea</label>
                              <input class="form-control" id="txtTituloSinArchivo" name="titulo" type="text" placeholder="Ejemplo: Los planetas" required>
                              <span class="invalid-feedback" role="alert">
                                  El título es requerido
                              </span>
                          </div>
                          <div class="form-group">
                              <label for="txtDescripcionSinArchivo">Descripción</label>
                              <textarea class="form-control" id="txtDescripcionSinArchivo" name="descripcion" rows="3" placeholder="Opcional"></textarea>
                          </div>

                          <div class="form-group">
                              <label class="label-text" for="cbGradoSeccionSinArchivo">Para</label>
                              <select id="cbGradoSeccionSinArchivo" name="seccion" class="hs_capitalize" required>
                                      <option class="hs_capitalize" value=""></option>
                                    @foreach($docente->secciones()->where('seccion_d.estado','=',1)->get() as $seccion)
                                        <option class="hs_capitalize" value="{{$seccion->id_seccion}}">{{mb_strtolower(substr($seccion->grado->c_nombre,3))}} "{{$seccion->c_nombre}}" - {{mb_strtolower($seccion->grado->c_nivel_academico)}}</option>
                                    @endforeach
                              </select>
                              <span class="invalid-feedback" role="alert">
                                  Elige una sección
                              </span>
                          </div>

                          <div class="radio-alumnos form-group" id="divRadioAlumnoSinArchivo">
                              <div class="radio-btn form-check form-check-inline">
                                  <label class="radio radio-light">
                                      <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option1" checked >
                                      <span>Todos los alumnos</span>
                                      <span class="checkmark"></span>
                                  </label>
                              </div>
                              <div class="radio-btn form-check form-check-inline" data-toggle="modal" data-target="#modal-seleccion-alumnos">
                                  <label class="radio radio-light">
                                      <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option2" >
                                      <span>Seleccionar alumnos</span>
                                      <span class="checkmark"></span>
                                  </label>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="alert alert-card alert-danger" role="alert" id="alertNoHayCategoriasSinArchivo" style="display: none;">
                                  <strong class="text-capitalize">Aviso!</strong>
                                  Aun no tienes cursos o asignaturas. Pídele a tu superadministrador que te asigne.
                              </div>

                              <label for="selCategoriaSinArchivo">Asignatura o curso</label>
                              <select name="categoria" id="selCategoriaSinArchivo" class="form-control" disabled required>
                              </select>
                              <span class="invalid-feedback" role="alert">
                                  Elige una asignatura o curso
                              </span>
                          </div>

                          <h5>Fecha y hora de entrega</h5>
                          <div class="row">
                              <div class="col-6" style="min-width: 190px!important">
                                  <div class="form-group">
                                      <label class="label-text" for="txtFechaEntregaSinArchivo">Fecha</label>
                                      <input class="form-control" id="txtFechaEntregaSinArchivo"  name="fecha_hora_entrega" type="date" min="{{date('Y-m-d')}}" disabled required>
                                      <span class="invalid-feedback" role="alert">
                                          Selecciona una fecha correcta
                                      </span>
                                  </div>
                              </div>
                              <div class="col-3" style="min-width: 50px!important">
                                  <div class="form-group">
                                      <label class="label-text" for="txtHoraEntregaSinArchivo">Hora</label>
                                      <input class="form-control" id="txtHoraEntregaSinArchivo"  name="hora_entrega" type="number" min="0" max="23" disabled>
                                      <span class="invalid-feedback" role="alert">
                                          Ingresa hora
                                      </span>
                                  </div>
                              </div>
                              <div class="col-3" style="min-width: 50px!important">
                                  <div class="form-group">
                                      <label class="label-text" for="txtMinutoEntregaSinArchivo">Minuto</label>
                                      <input class="form-control" id="txtMinutoEntregaSinArchivo"  name="minuto_entrega" type="number" min="0" max="59" disabled>
                                      <span class="invalid-feedback" role="alert">
                                          Ingresa minuto
                                      </span>
                                  </div>
                              </div>
                          </div>

                          </form>
                    </div>

                    <div id="divFrmTareaConArchivo" style="display: none;">
                      <form id="qq-form" method="POST" action="{{url('/docente/tarea/generar')}}" class="needs-validation"  enctype="multipart/form-data" novalidate>
                          @csrf
                          <input type="hidden" id="gIdTarea" name="g_id_tarea" value="">
                          @foreach($errors->all() as $error)
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>{{$error}}</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                          @endforeach
                          <input type="hidden" id="id_docente_con_archivo" name="id_docente" value="{{$docente->id_docente}}">
                          <div class="form-group">
                              <label class="label-text" for="txtTituloConArchivo">Título de tarea</label>
                              <input class="form-control input-modo-con-archivo" id="txtTituloConArchivo" name="titulo" type="text" placeholder="Ejemplo: Los planetas" required>
                              <span class="invalid-feedback" role="alert">
                                  El título es requerido
                              </span>
                          </div>
                          <div class="form-group">
                              <label for="txtDescripcionConArchivo">Descripción</label>
                              <textarea class="form-control input-modo-con-archivo" id="txtDescripcionConArchivo" name="descripcion" rows="3" placeholder="Opcional"></textarea>
                          </div>

                          <div id="uploader-tarea"></div>

                          <div class="form-group">
                              <label class="label-text" for="cbGradoSeccionConArchivo">Para</label>
                              <select id="cbGradoSeccionConArchivo" name="seccion" class="hs_capitalize" required>
                                      <option class="hs_capitalize" value=""></option>
                                  @foreach($docente->secciones()->where('seccion_d.estado','=',1)->get() as $seccion)
                                      <option class="hs_capitalize" value="{{$seccion->id_seccion}}">{{mb_strtolower(substr($seccion->grado->c_nombre,3))}} "{{$seccion->c_nombre}}" - {{mb_strtolower($seccion->grado->c_nivel_academico)}}</option>
                                  @endforeach
                              </select>
                              <span class="invalid-feedback" role="alert">
                                  Elige una sección
                              </span>
                          </div>

                          <div class="radio-alumnos form-group" id="divRadioAlumnoConArchivo">
                              <div class="radio-btn form-check form-check-inline">
                                  <label class="radio radio-light">
                                      <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option1" checked >
                                      <span>Todos los alumnos</span>
                                      <span class="checkmark"></span>
                                  </label>
                              </div>
                              <div class="radio-btn form-check form-check-inline" data-toggle="modal" data-target="#modal-seleccion-alumnos">
                                  <label class="radio radio-light">
                                      <input type="radio" name="radioAlumnos" [value]="1" formcontrolname="radio" class="form-check-input" value="option2" >
                                      <span>Seleccionar alumnos</span>
                                      <span class="checkmark"></span>
                                  </label>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="alert alert-card alert-danger" role="alert" id="alertNoHayCategoriasConArchivo" style="display: none;">
                                  <strong class="text-capitalize">Aviso!</strong>
                                  Aun no tienes cursos o asignaturas. Pídele a tu superadministrador que te asigne.
                              </div>

                              <label for="selCategoriaConArchivo">Asignatura o curso</label>
                              <select name="categoria" id="selCategoriaConArchivo" class="form-control input-modo-con-archivo" disabled required>
                              </select>
                              <span class="invalid-feedback" role="alert">
                                  Elige una asignatura o curso
                              </span>
                          </div>

                          <h5>Fecha y hora de entrega</h5>
                          <div class="row">
                              <div class="col-6" style="min-width: 190px!important">
                                  <div class="form-group">
                                      <label class="label-text" for="txtFechaEntregaConArchivo">Fecha</label>
                                  <input class="form-control input-modo-con-archivo" id="txtFechaEntregaConArchivo"  name="fecha_hora_entrega" type="date" min="{{date('Y-m-d')}}" disabled required>
                                      <span class="invalid-feedback" role="alert">
                                          Selecciona una fecha correcta
                                      </span>
                                  </div>
                              </div>
                              <div class="col-3" style="min-width: 50px!important">
                                  <div class="form-group">
                                      <label class="label-text" for="txtHoraEntregaConArchivo">Hora</label>
                                      <input class="form-control input-modo-con-archivo" id="txtHoraEntregaConArchivo"  name="hora_entrega" type="number" min="0" max="23" disabled>
                                      <span class="invalid-feedback" role="alert">
                                          Ingresa hora
                                      </span>
                                  </div>
                              </div>

                              <div class="col-3" style="min-width: 50px!important">
                                  <div class="form-group">
                                      <label class="label-text" for="txtMinutoEntregaConArchivo">Minuto</label>
                                      <input class="form-control input-modo-con-archivo" id="txtMinutoEntregaConArchivo"  name="minuto_entrega" type="number" min="0" max="59" disabled>
                                      <span class="invalid-feedback" role="alert">
                                          Ingresa minuto
                                      </span>
                                  </div>
                              </div>

                          </div>

                          </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitAsignarTareaSinArchivo" form="frmAsignarTarea">Asignar tarea</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitAsignarTareaConArchivo" form="qq-form" style="display: none;">Asignar tarea</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Selección de alumnos -->
    <div class="modal fade" id="modal-seleccion-alumnos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Seleccionar alumnos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alumnos-scroll" id="divAlumnosDeSeccionSinArchivo">
                </div>
                <div class="alumnos-scroll" id="divAlumnosDeSeccionConArchivo" style="display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Listo</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal para Todas las tareas asignadas-->
    <div class="modal fade" id="TAREAS" tabindex="-1" role="dialog" aria-labelledby="TAREASLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tareas asignadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pl-2 pr-2">

                        @php
                            $cont1 = 0;
                            $cont2 = 0;
                            $cont3 = 0;
                            $cont4 = 0;
                            $cont5 = 0;
                            $cont6 = 0;
                            $cont7 = 0;
                            $cont8 = 0;
                            $cont9 = 0;
                            $cont10 = 0;
                            $cont11 = 0;
                            $cont12 = 0;
                        @endphp

                        @foreach($tareas as $tarea)
                            @switch(substr($tarea->created_at, 5, 2))
                                @case('01')
                                    @php
                                        if ($cont1 == 0) {
                                            echo '<h5 class="tarea_por_mes">Enero</h5>';
                                            $cont1++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('02')
                                    @php
                                        if ($cont2 == 0) {
                                            echo '<h5 class="tarea_por_mes">Febrero</h5>';
                                            $cont2++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('03')
                                        @php
                                        if ($cont3 == 0) {
                                            echo '<h5 class="tarea_por_mes">Marzo</h5>';
                                            $cont3++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('04')
                                        @php
                                        if ($cont4 == 0) {
                                            echo '<h5 class="tarea_por_mes">Abril</h5>';
                                            $cont4++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('05')
                                    @php
                                        if ($cont5 == 0) {
                                            echo '<h5 class="tarea_por_mes" id="mes-5" onclick="MostrarTareas(5)">Mayo</h5>';
                                            $cont5++;
                                        }
                                    @endphp
                                    <div class="list_tarea" >
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('06')
                                    @php
                                        if ($cont6 == 0) {
                                            echo '<h5 class="tarea_por_mes">Junio</h5>';
                                            $cont6++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('07')
                                    @php
                                        if ($cont7 == 0) {
                                            echo '<h5 class="tarea_por_mes">Julio</h5>';
                                            $cont7++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('08')
                                    @php
                                        if ($cont8 == 0) {
                                            echo '<h5 class="tarea_por_mes">Agosto</h5>';
                                            $cont8++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('09')
                                    @php
                                        if ($cont9 == 0) {
                                            echo '<h5 class="tarea_por_mes">Setiembre</h5>';
                                            $cont9++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('10')
                                    @php
                                        if ($cont10 == 0) {
                                            echo '<h5 class="tarea_por_mes">Octubre</h5>';
                                            $cont10++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('11')
                                    @php
                                        if ($cont11 == 0) {
                                            echo '<h5 class="tarea_por_mes">Noviembre</h5>';
                                            $cont11++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case('12')
                                    @php
                                        if ($cont12 == 0) {
                                            echo '<h5 class="tarea_por_mes">Diciembre</h5>';
                                            $cont12++;
                                        }
                                    @endphp
                                    <div class="list_tarea">
                                        <div class="list_tarea_box">
                                            <div class="list_tarea_left">
                                                <h6 class="list_tarea_left_title hs_capitalize-first">{{$tarea->c_titulo}}</h6>
                                                <small>Enviado:&nbsp;{{$tarea->created_at}}&nbsp;</small>
                                                <small>Entregar:&nbsp;{{$tarea->t_fecha_hora_entrega}}</small>
                                            </div>

                                            <div class="list_tarea_right">
                                                <span class="badge hs_capitalize" style="color: #FFF; background-color: {{$tarea->categoria->c_nivel_academico}};">{{$tarea->categoria->c_nombre}}</span>
                                                <a class="my-link" href="#" onclick="window.open('/docente/tarea/{{$tarea->id_tarea}}', '_self');">ver tarea</a>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @default
                            @endswitch
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection

@section('page-js')
    @if($errors->count()>0)
        <script>
            $('#modal-tarea-nueva').modal('show');
        </script>
    @endif
    <script>
        function MostrarTareas(id){
            $('#tareas-' + id).toggle();
            /* $('#mes-' + id).toggleClass('mostrar_tareas'); */
        };
    </script>
    <script src="{{asset('assets/js/tooltip.script.js') }}"></script>
    <script src="{{asset('assets/js/libreria/slim/slimselect.min.js')}}"></script>
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/docente/asignartareas.js')}}"></script>
    <script>
        var uploader = new qq.FineUploader({
            element: document.getElementById('uploader-tarea'),
            thumbnails: {
                placeholders: {
                    waitingPath: '/fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
                }
            },
          validation: {
                //256MB
              sizeLimit: 268435456
          },
            messages: {
                sizeError: '¡{file} es demasiado grande! Sus archivos deben estar restringidos a {sizeLimit} o más pequeños.',
                noFilesError: 'No hay ningun archivo para subir, seleccione un archivo es obligatorio'
            },
            text: {
                failUpload: 'Falló al subir',
                waitingForResponse: 'Subiendo. Espere por favor'
            },
            callbacks: {
                onComplete: function(id,name,responseJSON){
                    if(responseJSON.success){
                        $('.input-modo-con-archivo').attr('readonly','true');
                        $('#btnSubmitAsignarTareaConArchivo').attr('disabled','true');
                        $('#gIdTarea').val(responseJSON.id_tarea);
                    }else{
                        $('.input-modo-con-archivo').removeAttr('readonly');
                        $('#btnSubmitAsignarTareaConArchivo').removeAttr('disabled');
                    }
                },
                onAllComplete: function(succeeded,failed) {
                    $('#btnSubmitAsignarTareaConArchivo').attr('disabled','true');
                    if(failed.length==0){
                        $.ajax({
                            type: 'POST',
                            url: '/docente/tarea/confirmar',
                            data: {
                                id_tarea: $('#gIdTarea').val()
                            },
                            error: function(error){
                                alert('Ocurrío un error');
                                console.error(error);
                                location.reload();
                            }
                        }).done(function(data){
                            if(data.correcto){
                                location.reload();
                            }
                        });
                    }else{
                        alert('Algo salió mal. Recarga la pagina e intenta de nuevo');
                        location.reload();
                    }
                }
            },
            maxConnections: 1,
            autoUpload: false,
            debug: false
        });
    </script>
@endsection
