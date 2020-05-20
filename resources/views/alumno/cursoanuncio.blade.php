<div class="content-header">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap">
        <h4 class="content-title">Anuncios</h4>
        <strong><a href="#" class="cn-card-link" data-toggle="modal" data-target="#HISTORIAL">Historial de anuncios</a></strong>
    </div>
</div>

<div class="content-main">
    <div class="my-scroll">
        @php
            $counter_anc_cur = 0;
        @endphp
        @foreach ($anuncios_curso as $anc)
            @php
                $counter_anc_cur++;
                if ($counter_anc_cur <= 3) {
                    echo '<div class="box-card card">
                        <div class="card-header">
                            <div class="box-title">
                                <strong class="hs_capitalize-first"><a href="#" id="at-'.$anc->id_anuncio.'">'.$anc->c_titulo.'</a></strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="box-content">
                                <div class="box-descripcion ">
                                    <p id="ac-'.$anc->id_anuncio.'" class="box-descripcion-wrap">
                                        '.$anc->c_url_archivo.'
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="box-fechas" style="justify-content: space-between">
                                <div class="box-fecha-envio">
                                    <small class="box-fecha-envio">
                                        <p>Enviado: </p>
                                        <p id="ad-'.$anc->id_anuncio.'"> '.$anc->created_at.'</p>
                                    </small>
                                </div>
                                <a href="#" class="cn-card-link" onclick="OpenAnuncio('.$anc->id_anuncio.')">Leer anuncio</a>
                            </div>
                        </div>
                    </div>';
                }
                else {
                    echo '<strong class="mb-2"><a class="cn-card-link text-center" href="#" data-toggle="modal" data-target="#HISTORIAL">Ver todo</a></strong>';
                    break;
                }
            @endphp
        @endforeach
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
                    <div class="text-center hs_capitalize-first"><strong id="atf-title"></strong></div>
                    <br>
                    <div id="atf-content" class="hs_capitalize-first hs_justify"></div>
                    <br>
                    <div id="atf-date" class="text-right"></div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="key_anuncio" name="key_anuncio" value="">
                <button type="button" id="btn-confirm-anuncio" class="btn btn-primary" data-dismiss="modal" onclick="ConfirmarAnuncio()">Anuncio leído</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal anuncios ALL-->
<div class="modal fade" id="HISTORIAL" tabindex="-1" role="dialog" aria-labelledby="HISTORIALLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anuncios del curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pl-2 pr-2">
                    @foreach ($anuncios_curso as $ac)
                        <div class="his-anc">
                            <div>
                                <small class="his-anc-d">{{$ac->created_at}}</small>
                            </div>
                            <h6 class="hs_capitalize-first">
                                <a href="#" class="his-anc-t" id="push--{{$ac->id_anuncio}}" onclick="MostrarAnuncio({{$ac->id_anuncio}})">{{$ac->c_titulo}}</a>
                            </h6>
                            <p class="contenido-acordion his-anc-c hs_capitalize-first hs_justify" id="recept--{{$ac->id_anuncio}}">
                                {{$ac->c_url_archivo}}
                                <br>
                                <input type="submit" class="btn btn-secondary btn-sm" onclick="ConfirmarAnuncio2({{$ac->id_anuncio}})" data-dismiss="modal" value="Anuncio leído">
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

<script>
    function OpenAnuncio(id){
        t = $('#at-'+id).text();
        c = $('#ac-'+id).text();
        d = $('#ad-'+id).text();
        
        $('#key_anuncio').val(id);
        $('#atf-title').text(t);
        $('#atf-content').text(c);
        $('#atf-date').text('Fecha de publicación: ' + d);

        $('#OPEN-NTF').modal('show');
    };

    function MostrarAnuncio(id){
        $('#push--' + id).toggleClass('seleccionado');
        $('#recept--' + id).toggle();
    };

    function ConfirmarAnuncio(){
        k = $('#key_anuncio').val();

        $.ajax({
            type: 'POST',
            url: '/notificacionesdelusuario/anuncio/marcarcomoleido',
            data: {
                id_anuncio: k
            },
            error: function(error){
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function(data){
            /* console.log(data);
            if(data.marcadocomoleido){
                alert('Leído');
            }else{
                alert('La notificacion de tipo comunicado ya esta marcado. O no existe el comunicado, o no existe la notificacion');
            } */
        });
    };

    function ConfirmarAnuncio2(id){
        $.ajax({
            type: 'POST',
            url: '/notificacionesdelusuario/anuncio/marcarcomoleido',
            data: {
                id_anuncio: id
            },
            error: function(error){
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function(data){
            /* console.log(data);
            if(data.marcadocomoleido){
                alert('Leído');
            }else{
                alert('La notificacion de tipo comunicado ya esta marcado. O no existe el comunicado, o no existe la notificacion');
            } */
        });
    };
</script>