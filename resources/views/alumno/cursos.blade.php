@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
@endsection

@section('main-content')

<body>
    <div id="mis_cursos">
        <div id="cursos_tablero">
            <div class="cursos-header">
                @php
                    $tmp = 0;
                @endphp
                @foreach ($cursos as $c)
                    @if ($tmp == 0)
                        <strong><p class="hs_upper">{{substr($c->nom_grado,3)}}</p></strong> 
                        <strong>&nbsp;"{{$c->nom_seccion}}"&nbsp;</strong>
                        <strong>({{ucfirst(strtolower($c->nom_nivel))}})</strong>
                        @php
                            $tmp++;
                        @endphp
                    @endif
                @endforeach
            </div>
            <section class="cursos-tablero">
                @foreach ($cursos as $c)
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
                                <a class="btn btn-secondary" href="{{url('alumno/cursos/curso/'.$c->id_categoria)}}">Ingresar</a>
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
                        @if ($co->c_destino == 'TODO' || $co->c_destino == 'ALUM')
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
                    <strong><a href="#" data-toggle="modal" data-target="#MODAL-AALL">Anuncios de la Sección <i class="nav-icon i-Information icon_"></i></a></strong>
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
                                    <small class="hs_capitalize">Docente: '.$as->nom_docente.'</small>
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
                    <form id="frm_comu" method="POST" action="{{url('/notificacionesdelusuario/comunicado/marcarcomoleido')}}" novalidate>
                        @csrf
                        <input type="hidden" id="location" name="location" value="">
                        <input type="hidden" id="id_comunicado" name="id_comunicado" value="">
                        <input type="submit" class="btn btn-primary" value="Comunicado leído">
                    </form>
                    <form id="frm_anun" method="POST" action="{{url('/notificacionesdelusuario/anuncio/marcarcomoleido')}}" novalidate>
                        @csrf
                        <input type="hidden" id="ubicacion" name="ubicacion" value="TA">
                        <input type="hidden" id="id_anuncio" name="id_anuncio" value="">
                        <input type="submit" class="btn btn-primary" value="Anuncio leído">
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
                            @if ($call->c_destino == 'TODO' || $call->c_destino == 'ALUM')
                                <div class="his-com his-anc">
                                    <div class="modal-anuncios-header">
                                        <small class="his-com-d">{{$call->created_at}}</small>
                                    </div>
                                    <h6 class="hs_capitalize-first">
                                        <a href="#" class="his-com-t" id="pusher--{{$call->id_comunicado}}" onclick="MostrarContenido({{$call->id_comunicado}})">{{$call->c_titulo}}</a>
                                    </h6>
                                    <p class="contenido-acordion his-com-c hs_capitalize-first hs_justify" id="receptor--{{$call->id_comunicado}}">
                                        {{$call->c_descripcion}}
                                        <form method="POST" action="{{url('/notificacionesdelusuario/comunicado/marcarcomoleido')}}" novalidate>
                                            @csrf
                                            <input type="hidden" id="location" name="location" value="TA">
                                            <input type="hidden" id="id_comunicado" name="id_comunicado" value="{{$call->id_comunicado}}">
                                            <input type="submit" class="btn btn-secondary btn-sm" value="Comunicado leído">
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
                    <div class="">
                        @foreach ($anuncios_seccion_all as $aall)
                            <div class="his-anc">
                                <div class="modal-anuncios-header">
                                    <small class="his-anc-d hs_capitalize">Docente: {{$aall->nom_docente}}</small>
                                    <small class="his-anc-d">{{$aall->created_at}} </small>
                                </div>
                                <h6 class="hs_capitalize-first">
                                    <a href="#" class="his-anc-t" id="push--{{$aall->id_anuncio}}" onclick="MostrarAnuncio({{$aall->id_anuncio}})">{{$aall->c_titulo}}</a>
                                </h6>
                                <p class="contenido-acordion his-anc-c hs_capitalize-first hs_justify" id="recept--{{$aall->id_anuncio}}">
                                    {{$aall->c_url_archivo}}
                                    <form id="frm_anun" method="POST" action="{{url('/notificacionesdelusuario/anuncio/marcarcomoleido')}}" novalidate>
                                        @csrf
                                        <input type="hidden" id="ubicacion" name="ubicacion" value="TA">
                                        <input type="hidden" id="id_anuncio" name="id_anuncio" value="{{$aall->id_anuncio}}">
                                        <input type="submit" class="btn btn-secondary btn-sm" value="Anuncio leído">
                                    </form>
                                </p>
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
    function fxMarcarNotificacionTipoComunicado(comunicado){
        $.ajax({
            type: 'POST',
            url: '/notificacionesdelusuario/comunicado/marcarcomoleido',
            data: {
                id_comunicado: comunicado
            },
            error: function(error){
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function(data){
            console.log(data);
            if(data.marcadocomoleido){
                alert('Marcado como leido correctamente. La campanita se cambia solito.(EN DESARROLLO POR CLINTON TAPIA)');
            }else{
                alert('La notificacion de tipo comunicado ya esta marcado. O no existe el comunicado, o no existe la notificacion');
            }
        });
    }
    
    function OpenComunicado(id){
        t = $('#ct-'+id).text();
        c = $('#cc-'+id).text();
        d = $('#cd-'+id).text();
        
        $('#location').val('TA');
        $('#id_comunicado').val(id);
        $('#ntf-title').text(t);
        $('#ntf-content').text(c);
        $('#ntf-date').text('Fecha de publicación: ' + d);

        $('#frm_comu').show();
        $('#frm_anun').hide();

        $('#OPEN-NTF').modal('show');
    };

    function OpenAnuncio(id){
        t = $('#at-'+id).text();
        c = $('#ac-'+id).text();
        d = $('#ad-'+id).text();
        
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