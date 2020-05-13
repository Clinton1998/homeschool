@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
@endsection

@section('main-content')

<body>
    <div id="mis_cursos">
        <div id="cursos_tablero">
           {{--  @foreach ($secciones as $s) --}}
                <div class="cursos-header">
                    <strong><p class="hs_lower">{{substr($secciones->nom_grado,3)}}</p></strong> 
                    <strong>&nbsp;"{{$secciones->c_nombre}}"&nbsp;</strong>
                    <strong>- {{ucfirst(strtolower($secciones->nom_nivel))}}</strong>
                </div>
                <section class="cursos-tablero">
                    @foreach ($cursos as $c)
                        @if ($c->id_seccion == $secciones->id_seccion)
                            <article class="curso-card">
                                <div class="curso-card-header" style="background: {{$c->col_curso}}">
                                    <h4 class="curso-card-titulo hs_capitalize-first">{{$c->nom_curso}}</h4>
                                </div>
                                <div class="curso-card-footer">
                                    <div class="curso-card-notify">
                                        <i class="curso-notify nav-icons i-Mailbox-Empty"></i>
                                        <i class="curso-notify nav-icons i-Speach-Bubbles"></i>
                                        <i class="curso-notify nav-icons i-Bell"></i>
                                    </div>
                                    <div>
                                        <a class="btn btn-secondary" href="{{url('docente/cursos/curso/'.$c->id_categoria)}}">Ingresar</a>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </section>
            {{-- @endforeach --}}
        </div>
        <div id="cursos_notificaciones">
            <div class="cursos-header">
                <strong>Anuncios y comunicados</strong>
            </div>
            <div class="cn-box mb-1">
                <div class="cn-header">
                    <strong><a href="#" data-toggle="modal" data-target="#MODAL-CALL">Comunicados del Colegio <i class="nav-icon i-Information"></i></a></strong>
                </div>
                <div class="cn-body">
                    @php
                        $counter_com = 0;
                    @endphp
                    @foreach ($comunicados as $co)
                        @if ($co->c_destino == 'TODO' || $co->c_destino == 'DOCE')
                            @php
                                $counter_com++;
                                if ($counter_com <= 2) {
                                    echo '<div class="cn-card mb-2">
                                        <strong><p id="ct-'.$co->id_comunicado.'" class="cn-card-title hs_capitalize-first">'.$co->c_titulo.'</p></strong>
                                        <p id="cc-'.$co->id_comunicado.'" class="cn-card-content hs_capitalize-first">'.$co->c_descripcion.'</p>
                                        <small id="cd-'.$co->id_comunicado.'">'.$co->created_at.'</small>
                                        <a class="cn-card-link" href="#" onclick="OpenComunicado('.$co->id_comunicado.')">Ver</a>
                                    </div>';
                                }
                                else {
                                    echo '<strong class="mb-2"><a class="cn-card-link" href="#" data-toggle="modal" data-target="#MODAL-CALL">Ver todo</a></strong>';
                                    break;
                                }
                            @endphp
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="cn-box">
                <div class="cn-header">
                    <strong><a href="#" data-toggle="modal" data-target="#MODAL-AALL">Anuncios de la Sección <i class="nav-icon i-Information"></i></a></strong>
                </div>
                <div class="cn-body">
                    @php
                        $counter_anc = 0;
                    @endphp
                    @foreach ($anuncios_seccion as $as)
                        @php
                            $counter_anc++;
                            if ($counter_anc <= 2) {
                                echo '<div class="cn-card mb-2">
                                    <strong><p id="at-'.$as->id_anuncio.'" class="cn-card-title hs_capitalize-first">'.$as->c_titulo.'</p></strong>
                                    <p id="ac-'.$as->id_anuncio.'" class="cn-card-content hs_capitalize-first">'.$as->c_url_archivo.'</p>
                                    <small id="ad-'.$as->id_anuncio.'">'.$as->created_at.'</small>
                                    <a class="cn-card-link" href="#" onclick="OpenAnuncio('.$as->id_anuncio.')">Ver</a>
                                </div>';
                            }
                            else {
                                echo '<strong class="mb-2"><a class="cn-card-link" href="#" data-toggle="modal" data-target="#MODAL-AALL">Ver todo</a></strong>';
                                break;
                            }
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="OPEN-NTF" tabindex="-1" role="dialog" aria-labelledby="OPEN-NTFLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pl-2 pr-2">
                        <div class="text-center hs_capitalize-first"><strong id="ntf-title"></strong></div>
                        <br>
                        <div id="ntf-content" class="hs_capitalize-first"></div>
                        <br>
                        <div id="ntf-date" class="text-right"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-confirm-comunicado" class="btn btn-primary" data-dismiss="modal" {{-- onclick="ConfirmarComunicado()" --}}>Comunicado leído</button>
                    <button type="button" id="btn-confirm-anuncio" class="btn btn-primary" data-dismiss="modal" {{-- onclick="ConfirmarAnuncio()" --}}>Anuncio leído</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal comunicados ALL-->
    <div class="modal fade" id="MODAL-CALL" tabindex="-1" role="dialog" aria-labelledby="MODAL-CALLLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comunicados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pl-2 pr-2">
                        @foreach ($comunicados_all as $call)
                            @if ($call->c_destino == 'TODO' || $call->c_destino == 'DOCE')
                                <div class="his-com">
                                    <div>
                                        <small class="his-com-d">{{$call->created_at}}</small>
                                    </div>
                                    <h6 class="hs_capitalize-first">
                                        <a href="#" class="his-com-t" id="pusher--{{$call->id_comunicado}}" onclick="MostrarContenido({{$call->id_comunicado}})">{{$call->c_titulo}}</a>
                                    </h6>
                                    <p class="contenido-acordion his-com-c hs_capitalize-first hs_justify" id="receptor--{{$call->id_comunicado}}">{{$call->c_descripcion}}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal anuncios ALL-->
    <div class="modal fade" id="MODAL-AALL" tabindex="-1" role="dialog" aria-labelledby="MODAL-AALLLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anuncios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pl-2 pr-2">
                        @foreach ($anuncios_seccion_all as $aall)
                            <div class="his-anc">
                                <div>
                                    <small class="his-anc-d">{{$aall->created_at}}</small>
                                </div>
                                <h6 class="hs_capitalize-first">
                                    <a href="#" class="his-anc-t" id="push--{{$aall->id_anuncio}}" onclick="MostrarAnuncio({{$aall->id_anuncio}})">{{$aall->c_titulo}}</a>
                                </h6>
                                <p class="contenido-acordion his-anc-c hs_capitalize-first hs_justify" id="recept--{{$aall->id_anuncio}}">{{$aall->c_url_archivo}}</p>
                            </div>
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
<script>
    function OpenComunicado(id){
        t = $('#ct-'+id).text();
        c = $('#cc-'+id).text();
        d = $('#cd-'+id).text();
        
        $('#ntf-title').text(t);
        $('#ntf-content').text(c);
        $('#ntf-date').text('Fecha de publicación: ' + d);

        $('#btn-confirm-comunicado').show();
        $('#btn-confirm-anuncio').hide();

        $('#OPEN-NTF').modal('show');
    };

    function OpenAnuncio(id){
        t = $('#at-'+id).text();
        c = $('#ac-'+id).text();
        d = $('#ad-'+id).text();
        
        $('#ntf-title').text(t);
        $('#ntf-content').text(c);
        $('#ntf-date').text('Fecha de publicación: ' + d);

        $('#btn-confirm-comunicado').hide();
        $('#btn-confirm-anuncio').show();

        $('#OPEN-NTF').modal('show');
    };

    function MostrarContenido(id){
        $('#pusher--' + id).toggleClass('seleccionado');
        $('#receptor--' + id).toggle();
    };

    function MostrarAnuncio(id){
        $('#push--' + id).toggleClass('seleccionado');
        $('#recept--' + id).toggle();
    };

    /* function ConfirmarComunicado(){

    };

    function ConfirmarAnuncio(){

    }; */
</script>
@endsection