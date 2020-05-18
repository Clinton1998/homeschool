@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
    <style>
        .continua {
        overflow:hidden;
        white-space:nowrap;
        text-overflow: ellipsis;
    }
    </style>
@endsection

@section('main-content')

<section class="ul-contact-detail">
    <h2 class="hs_titulo">Comunicados</h2>
    <div class="row">
        
        <div class="col-lg-12 col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#mdlNuevoComunicado">Nuevo comunicado</button>
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active show" id="nav-paratodo-tab" data-toggle="tab" href="#nav-paratodo" role="tab" aria-controls="nav-paratodo" aria-selected="true">Todos</a>
                            <a class="nav-item nav-link " id="nav-paradocentes-tab" data-toggle="tab" href="#nav-paradocentes" role="tab" aria-controls="nav-paradocentes" aria-selected="false">Solo docentes</a>
                            <a class="nav-item nav-link " id="nav-paraalumnos-tab" data-toggle="tab" href="#nav-paraalumnos" role="tab" aria-controls="nav-paraalumnos" aria-selected="false">Solo alumnos</a>
                        </div>
                    </nav>
                    <div class="tab-content ul-tab__content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-paratodo" role="tabpanel" aria-labelledby="nav-paratodo-tab">
                            <div class="row">
                                @if($comunicados_todos->count()<=0)
                                    <div class="col-12"><h5>No hay comunicados</h5></div>
                                @else
                                    @foreach($comunicados_todos as $comunicado)
                                        <div class="col-xl-12">
                                            <div class="card mt-3 mb-3">
                                                <div class="card-body">
                                                    <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                                        <div class="continua">
                                                            <h5 class="hs_upper "><a href="{{url('/comunicado/ver/'.$comunicado->id_comunicado)}}" class="text-primary">{{$comunicado->c_titulo}}</a></h5>
                                                            <p class="ul-task-manager__paragraph mb-3 text-justify hs_capitalize-first">{{$comunicado->c_descripcion}}</p>
                                                        </div>
            
                                                        <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right;">
                                                            <li><span class="ul-task-manager__font-date text-muted">{{$comunicado->created_at}}</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                                    <a href="{{url('/comunicado/ver/'.$comunicado->id_comunicado)}}" class="text-primary">Ver</a>
                                                </div>

                                            </div>
                                        </div> 
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-paradocentes" role="tabpanel" aria-labelledby="nav-paradocentes-tab">
                            <div class="row">
                                @if($comunicados_solo_docentes->count()<=0)
                                    <div class="col-12"><h5>No hay comunicados</h5></div>
                                @else
                                    @foreach($comunicados_solo_docentes as $comunicado)
                                    <div class="col-xl-12">
                                        <div class="card mt-3 mb-3">
                                            <div class="card-body">
                                                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                                    <div class="continua">
                                                        <h5 class="hs_upper "><a href="{{url('/comunicado/ver/'.$comunicado->id_comunicado)}}" class="text-primary">{{$comunicado->c_titulo}}</a></h5>
                                                        <p class="ul-task-manager__paragraph mb-3 text-justify hs_capitalize-first">{{$comunicado->c_descripcion}}</p>
                                                    </div>
        
                                                    <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right;">
                                                        <li><span class="ul-task-manager__font-date text-muted">{{$comunicado->created_at}}</span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                                <a href="{{url('/comunicado/ver/'.$comunicado->id_comunicado)}}" class="text-primary">Ver</a>
                                            </div>

                                        </div>
                                    </div> 
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-paraalumnos" role="tabpanel" aria-labelledby="nav-paraalumnos-tab">
                            <div class="row">
                                @if($comunicados_solo_alumnos->count()<=0)
                                    <div class="col-12"><h5>No hay comunicados</h5></div>
                                @else
                                    @foreach($comunicados_solo_alumnos as $comunicado)
                                    <div class="col-xl-12">
                                        <div class="card mt-3 mb-3">
                                            <div class="card-body">
                                                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                                    <div class="continua">
                                                        <h5 class="hs_upper "><a href="{{url('/comunicado/ver/'.$comunicado->id_comunicado)}}" class="text-primary">{{$comunicado->c_titulo}}</a></h5>
                                                        <p class="ul-task-manager__paragraph mb-3 text-justify hs_capitalize-first">{{$comunicado->c_descripcion}}</p>
                                                    </div>
        
                                                    <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto" style="text-align: right;">
                                                        <li><span class="ul-task-manager__font-date text-muted">{{$comunicado->created_at}}</span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                                <a href="{{url('/comunicado/ver/'.$comunicado->id_comunicado)}}" class="text-primary">Ver</a>
                                            </div>

                                        </div>
                                    </div> 
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

  <!-- Modal Nuevo Comunicado -->
  <div class="modal" id="mdlNuevoComunicado" tabindex="-1" role="dialog" aria-labelledby="mdlNuevoComunicadoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdlNuevoComunicadoTitle">Nuevo comunicado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="progress mb-3" id="divProgressArchivoComunicado" style="height: 40px;display: none;">
                <div class="progress-bar w-100 progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="font-size: 2em;font-weight: bold;">Subiendo archivo</div>
            </div>

        <form id="frmNuevoComunicado" class="needs-validation" method="POST" action="{{url('/super/comunicados/agregar')}}" enctype="multipart/form-data" novalidate>
            @csrf
            @error('titulo_comunicado')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{$message}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @enderror
            @error('archivo_comunicado')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{$message}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @enderror
            @error('opt_destino_comunicado')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{$message}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @enderror

            <div class="form-group">
                <label for="titulo_comunicado">Título</label>
                <input type="text" class="form-control" id="titulo_comunicado" name="titulo_comunicado" required>
                <div class="invalid-feedback">
                    El título es necesario
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion_comunicado">Descripción</label>
                <textarea name="descripcion_comunicado" class="form-control" id="descripcion_comunicado" cols="30" rows="7"></textarea>
            </div>

            <div class="form-group">
                <label for="archivo_comunicado">Archivo</label>
                <input type="file" class="form-control" id="archivo_comunicado" name="archivo_comunicado">
            </div>
            <br>
            <h3>Para</h3>
            <div class="radio-alumnos form-group" id="divRadioAlumno">
                <div class="radio-btn form-check form-check-inline">
                    <label class="radio radio-success">
                        <input type="radio" name="opt_destino_comunicado" [value]="1" formcontrolname="radio" class="form-check-input" value="TODO" required checked >
                        <span>Todos</span>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="radio-btn form-check form-check-inline">
                    <label class="radio radio-success">
                        <input type="radio" name="opt_destino_comunicado" [value]="1" formcontrolname="radio" class="form-check-input" value="DOCE" required >
                        <span>Docentes</span>
                        <span class="checkmark"></span>
                    </label>
                </div>

                <div class="radio-btn form-check form-check-inline">
                    <label class="radio radio-success">
                        <input type="radio" name="opt_destino_comunicado" [value]="1" formcontrolname="radio" class="form-check-input" value="ALUM" required >
                        <span>Alumnos</span>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary btn-lg" form="frmNuevoComunicado" id="btnEnviarComunicado">Enviar a <span>todos</span></button>
        </div>
      </div>
    </div>
  </div>

  <!-- endModal Nuevo Comunicado-->

@endsection

@section('page-js')
    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/superadmin/comunicados.js')}}"></script>
    @if($errors->has('titulo_comunicado') || $errors->has('archivo_comunicado') || $errors->has('opt_destino_comunicado'))
        <script>
            $('#mdlNuevoComunicado').modal('show');
        </script>
    @endif
@endsection