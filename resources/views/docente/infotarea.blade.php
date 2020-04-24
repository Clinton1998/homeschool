@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">   
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-docente.css')}}"> 
@endsection

@section('main-content')
<section class="contact-list">
    <div class="row">
        <div class="col-xs-12 col-md-6 offset-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                        <div>
                        <h4 class="">{{$tarea->c_titulo}}</h4>
                        <p class="ul-task-manager__paragraph mb-3 text-justify">{{$tarea->c_observacion}}</p>
                        @if(!is_null($tarea->c_url_archivo) && !empty($tarea->c_url_archivo))
                            <h5>Archivo</h5>
                            <p>
                            <a href="{{url('/docente/tarea/archivo/'.$tarea->id_tarea)}}" class="text-primary" cdownload="{{$tarea->c_url_archivo}}">
                                    Descargar Archivo {{$tarea->c_url_archivo}}
                                    </a>
                            </p>
                        @endif

                        @if(is_null($tarea->docente->c_foto)  || empty($tarea->docente->c_foto))
                            @if(strtoupper($tarea->docente->c_sexo)=='M')
                                <img  class="rounded-circle" width="50" height="50" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                            @else
                                <img class="rounded-circle" width="50" height="50" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                            @endif
                        @else
                                <img class="rounded-circle" width="50" height="50" src="{{url('super/docente/foto/'.$tarea->docente->c_foto)}}" alt="Foto del docente">
                        @endif
                                {{$tarea->docente->c_nombre}}
                        </div>

                        <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto">
                            <li><span class="ul-task-manager__font-date text-muted">{{$tarea->created_at}}</span></li>
                            <li class="dropdown">
                                Categoria: &nbsp;
                                <span class="badge badge-pill badge-danger p-1 m-1">{{$tarea->categoria->c_nombre}}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                    <span>Fecha de entrega: <span class="font-weight-semibold text-primary">{{$tarea->t_fecha_hora_entrega}}</span></span>
                    @if($tarea->t_fecha_hora_entrega<=date('Y-m-d H:i:s'))
                        <a href="/docente/estadotareas">Ver respuestas</a>
                    @endif
                </div>
                
                
                <div class="card-body">
                    <strong>Escribe un comentario</strong>

                    <form id="frmAsignarTarea" method="post" action="{{url('/docente/tarea/comentar')}}" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="id_tarea" value="{{$tarea->id_tarea}}">
                        <input class="form-control form-control-lg mb-6" id="txtComentario" name="comentario" rows="2" placeholder="Escribe aquí..." required autofocus>
                        <div class="mb-4">
                            <br>
                        <button type="submit" class="btn btn-primary float-right">Publicar comentario</button>
                        </div>
                    </form>
                    
                    <br>
                    <h4 class="">Comentarios recientes</h4>
                    
                    <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                        <div class="caja-comentarios">
                            @if($tarea->comentarios()->count()<=0)
                                <h4 class="text-secondary">Sin comentarios</h4>
                            @else
                                @foreach($tarea->comentarios()->orderBy('created_at','DESC')->get() as $comentario)
                                    <div class="comentario mb-4">
                                    <strong class="comentario-persona">
                                        @if(!is_null($comentario->comenta->id_docente))
                                            @if(is_null($comentario->comenta->docente->c_foto)  || empty($comentario->comenta->docente->c_foto))
                                                @if(strtoupper($comentario->comenta->docente->c_sexo)=='M')
                                                <img  class="rounded-circle" width="36" height="36" src="{{asset('assets/images/usuario/teacherman.png')}}" alt="Foto del docente">
                                                @else
                                                <img class="rounded-circle" width="36" height="36" src="{{asset('assets/images/usuario/teacherwoman.png')}}" alt="Foto del docente">
                                                @endif
                                            @else
                                                <img class="rounded-circle" width="36" height="36" src="{{url('super/docente/foto/'.$comentario->comenta->docente->c_foto)}}" alt="Foto del docente">
                                            @endif
                                            {{$comentario->comenta->docente->c_nombre}}
                                        @else
                                            @if(is_null($comentario->comenta->alumno->c_foto)  || empty($comentario->comenta->alumno->c_foto))
                                                @if(strtoupper($comentario->comenta->alumno->c_sexo)=='M')
                                                    <img class="rounded-circle" width="36" height="36"  src="{{asset('assets/images/usuario/studentman.png')}}" alt="Foto del alumno">
                                                @else
                                                    <img class="rounded-circle" width="36" height="36"  src="{{asset('assets/images/usuario/studentwoman.png')}}" alt="Foto de la alumna">
                                                @endif
                                            @else
                                                <img class="rounded-circle" width="36" height="36"  src="{{url('super/alumno/foto/'.$comentario->comenta->alumno->c_foto)}}" alt="Foto del alumno">
                                            @endif

                                            {{$comentario->comenta->alumno->c_nombre}}
                                        @endif
                                        ({{$comentario->created_at}})
                                    <p class="comentario-contenido">{{$comentario->c_descripcion}}</p>
                                    </div>
                                @endforeach
                            @endif
                            
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</section>
  

@endsection

@section('page-js')
<!-- page script -->

<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/form.validation.script.js')}}"></script>
<script src="{{asset('assets/js/docente/infotarea.js')}}"></script>
@endsection