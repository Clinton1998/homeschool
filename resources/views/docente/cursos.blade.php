@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
@endsection

@section('main-content')

<body>
    <div id="mis_cursos">
        <div id="cursos_tablero">
            <div class="cursos-header">
                <strong><p>Mis Cursos</p></strong>
            </div>
            <section class="cursos-tablero">
                @foreach ($cursos_del_docente as $c)
                    <article class="curso-card">
                        <div class="curso-card-header" style="background: {{$c->col_curso}}">
                            <h4 class="curso-card-titulo hs_capitalize-first">{{mb_strtolower($c->nom_curso)}}</h4>
                            <small class="curso-card-titulo hs_capitalize-first">{{$c->nom_nivel}}</small>
                            <h6 class="curso-card-titulo hs_capitalize-first">{{substr($c->nom_grado,3)}} "{{strtoupper($c->nom_seccion)}}"</h6>
                        </div>
                        <div class="curso-card-footer">
                            <div class="curso-card-notify">
                                <i class="curso-notify nav-icons i-Mailbox-Empty"></i>
                                <i class="curso-notify nav-icons i-Speach-Bubbles"></i>
                                <i class="curso-notify nav-icons i-Bell"></i>
                            </div>
                            <div>
                                <a class="btn btn-secondary" href="{{url('docente/cursos/curso/'.$c->id_seccion_categoria)}}">Ingresar</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>
        </div>
        <div id="cursos_notificaciones">
            <div class="cursos-header">
                <strong>Anuncios y comunicados</strong>
            </div>
            <div class="cn-box mb-1">
                <div class="cn-header">
                    <strong><a href="#" data-toggle="modal" data-target="#MODAL-CALL">Comunicados del Colegio <i class="nav-icon i-Information icon_"></i></a></strong>
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

                                    $html_card = '<div class="cn-card mb-2">'
                                                .'<strong><p id="ct-'.$co->id_comunicado.'" class="cn-card-title hs_capitalize-first">'.$co->c_titulo.'</p></strong>'
                                                .'<p id="cc-'.$co->id_comunicado.'" class="cn-card-content hs_capitalize-first">'.$co->c_descripcion.'</p>'
                                                .'<small id="cd-'.$co->id_comunicado.'">'.$co->created_at.'</small>';
                                    //verificamos si el comunicado tiene archivos
                                    if(!is_null($co->c_url_archivo) && !empty($co->c_url_archivo)){
                                        $html_card .= '<div id="divArchivosComunicado'.$co->id_comunicado.'" class="d-none">';
                                          $html_card .= '<span class="d-block"><a href="/comunicado/archivo/'.$co->id_comunicado.'/'.$co->c_url_archivo.'" class="text-primary" cdownload="'.$co->c_url_archivo.'">Descargar Archivo'.$co->c_url_archivo.'</a></span>';
                                          foreach($co->archivos()->where('estado','=',1)->get() as $archivo){
                                            $html_card .= '<span class="d-block"><a href="/comunicado/archivo/'.$co->id_comunicado.'/'.$archivo->c_url_archivo.'" class="text-primary" cdownload="'.$archivo->c_url_archivo.'">Descargar Archivo '.$archivo->c_url_archivo.'</a></span>';
                                          }
                                        $html_card .= '</div>';
                                    }
                                    $html_card .= '<a class="cn-card-link" href="#" onclick="OpenComunicado('.$co->id_comunicado.')">Ver</a></div>';
                                    echo $html_card;
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
                    <strong><a href="#" data-toggle="modal" data-target="#MODAL-AALL">Anuncios de la Sección <i class="nav-icon i-Information icon_"></i></a></strong>
                </div>
                <div class="cn-body">
                    @php
                        $counter_anc = 0;
                        $comodin = 0;
                    @endphp
                    @foreach ($anuncios_seccion as $as)
                        @php
                            $counter_anc++;
                            if ($counter_anc <= 2) {
                                echo '<div class="cn-card mb-2">
                                    <small>'.substr($as->nom_grado,3).' "'.$as->nom_seccion.'" - '.$as->nom_nivel.'</small>
                                    <strong><p id="at-'.$as->id_anuncio.'" class="cn-card-title hs_capitalize-first">'.$as->c_titulo.'</p></strong>
                                    <p id="ac-'.$as->id_anuncio.'" class="cn-card-content hs_capitalize-first">'.$as->c_url_archivo.'</p>
                                    <small id="ad-'.$as->id_anuncio.'">'.$as->created_at.'</small>
                                    <a class="cn-card-link" href="#" onclick="OpenAnuncio('.$as->id_anuncio.')">Ver</a>
                                </div>';
                            }
                            else {
                                if ($comodin == 0) {
                                    $comodin++;
                                    echo '<strong class="mb-2"><a class="cn-card-link" href="#" data-toggle="modal" data-target="#MODAL-AALL">Ver todo</a></strong>';
                                    break;
                                }
                            }
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="OPEN-NTF" tabindex="-1" role="dialog" aria-labelledby="OPEN-NTFLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                        <div id="ntf-content" class="hs_capitalize-first text-left"></div>
                        <br>
                        <div id="ntf-date" class="text-right"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form id="frm_comu" method="POST" action="{{url('/notificacionesdelusuario/comunicado/marcarcomoleido')}}" novalidate>
                        @csrf
                        <input type="hidden" id="location" name="location" value="">
                        <input type="hidden" id="id_comunicado" name="id_comunicado" value="">
                        <input type="submit" class="btn btn-primary" value="Comunicado leído">
                    </form>
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
                                <div class="his-com his-anc">
                                    <div>
                                        <small class="his-com-d">{{$call->created_at}}</small>
                                    </div>
                                    <h6 class="hs_capitalize-first">
                                        <a href="#" class="his-com-t" id="pusher--{{$call->id_comunicado}}" onclick="MostrarContenido({{$call->id_comunicado}})">{{$call->c_titulo}}</a>
                                    </h6>
                                    <p class="contenido-acordion his-com-c hs_capitalize-first hs_justify" id="receptor--{{$call->id_comunicado}}">
                                        {{$call->c_descripcion}}
                                        <form method="POST" action="{{url('/notificacionesdelusuario/comunicado/marcarcomoleido')}}" novalidate>
                                            @csrf
                                            <input type="hidden" id="location" name="location" value="TD">
                                            <input type="hidden" id="id_comunicado" name="id_comunicado" value="{{$call->id_comunicado}}">
                                            <input type="submit" class="btn btn-secondary btn-sm d-inline-block" value="Comunicado leído">
                                            <a href="/comunicado/ver/{{$call->id_comunicado}}" class="btn btn-primary btn-sm d-inline-block">Ver completo</a>
                                        </form>

                                    </p>
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
                                <div style="display:  flex; justify-content: space-between; flex-wrap: wrap">
                                    <small>{{substr($aall->nom_grado,3)}} "{{$aall->nom_seccion}}" - {{$aall->nom_nivel}}</small>
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
        //verificamos si hay archivos
        if($('#divArchivosComunicado'+id).length>0){
          c += $('#divArchivosComunicado'+id).html();
        }
        $('#location').val('TD');
        $('#id_comunicado').val(id);
        $('#ntf-title').text(t);
        $('#ntf-content').html(c);
        $('#ntf-date').text('Fecha de publicación: ' + d);
        $('#frm_comu').show();
        $('#frm_anun').hide();

        $('#OPEN-NTF').modal('show');
    };

    function OpenAnuncio(id){
        t = $('#at-'+id).text();
        c = $('#ac-'+id).text();
        d = $('#ad-'+id).text();

        $('#location').val('TD');
        $('#id_anuncio').val(id);
        $('#ntf-title').text(t);
        $('#ntf-content').text(c);
        $('#ntf-date').text('Fecha de publicación: ' + d);

        $('#frm_comu').hide();
        $('#frm_anun').show();

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

</script>
@endsection
