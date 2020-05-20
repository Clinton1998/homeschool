<div class="content-header">
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h4 class="content-title">Anuncios</h4>
        <button type="button" id="btn-nuevo-anuncio" class="btn" data-toggle="modal" data-target="#MODAL-A" style="margin: -15px 0 5px 0; color: #FFF; background: {{$curso->col_curso}}">Nuevo anuncio</button>
    </div>
</div>

<div class="content-main">
    <div id="anuncios-reload" class="my-scroll tbl-container">
        @if ($anuncios_curso->count() > 0)
            <table id="tbl-anuncios" class="table-hover">
                <thead>
                    <tr>
                        <th>Título del anuncio</th>
                        <th>Fecha de envío</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anuncios_curso as $anc)
                        <tr>
                            <td style="text-align: left" class="hs_capitalize-first">{{$anc->c_titulo}}</td>
                            <td><small>{{$anc->created_at}}</small></td>
                            <td>
                                <a href="#" class="badge badge-success" onclick="VerAnuncio({{$anc->id_anuncio}})">Ver</a>{{-- &nbsp; --}}
                                {{-- <a href="#" class="badge badge-light" onclick="EliminarAnuncio({{$anc->id_anuncio}})">Eliminar</a> --}}
                            </td>
                        </tr>
                        <span class="anc-title" id="ANT-{{$anc->id_anuncio}}">{{$anc->c_titulo}}</span>
                        <span class="anc-content" id="ANC-{{$anc->id_anuncio}}">{{$anc->c_url_archivo}}</span>
                        <span class="anc-content" id="AND-{{$anc->id_anuncio}}">{{$anc->created_at}}</span>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Modal anuncio -->
<div class="modal fade" id="MODAL-A" tabindex="-1" role="dialog" aria-labelledby="MODALLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo anuncio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_anuncio" method="POST" action="{{url('/docente/cursos/crear_anuncio')}}" novalidate>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="tmp_id_seccion" name="tmp_id_seccion" value="{{$curso->id_seccion}}">
                    <input type="hidden" id="tmp_id_seccion_categoria" name="tmp_id_seccion_categoria" value="{{$curso->id_seccion_categoria}}">
                    <div class="row">
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <label for="para_anuncio">Para</label>
                            <select name="para_anuncio" id="para_anuncio" class="form-control" autofocus required>
                                <option value="1">Este curso</option>
                                <option value="2">Toda la sección</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-8 col-md-8 col-sm-12">
                            <label for="titulo_anuncio">Título</label>
                            <input type="text" id="titulo_anuncio" name="titulo_anuncio" class="form-control" autofocus required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contenido_anuncio">Contenido</label>
                        <textarea name="contenido_anuncio" id="contenido_anuncio" cols="30" rows="6" class="form-control" required></textarea>
                    </div>
                    <div class="text-right">
                        <i class="nav-icon i-Information text-danger"></i>&nbsp;<strong><em>Asegúrese de revisar la información del anuncio, ya que después de publicarlo no podrá ser modificado o eliminado.</em></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_crear_anuncio" class="btn btn-primary">Publicar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal mostrar anuncio -->
<div class="modal fade" id="MODAL-SHOW" tabindex="-1" role="dialog" aria-labelledby="MODAL-SHOWLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <h5 class="modal-title hs_capitalize-first" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pl-2 pr-2">
                    <div class="text-center hs_capitalize-first"><strong id="mb-title"></strong></div>
                    <br>
                    <div id="mb-content" class="hs_capitalize-first hs_justify"></div>
                    <br>
                    <div id="mb-date" class="text-right"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" ></script>

<script>
    //Crear nuevo anuncio
    $('#btn_crear_anuncio').click(function(){

        ruta = '/docente/cursos/crear_anuncio';
        metodo = 'POST';
        tipoDato = 'json';

        is = $('#tmp_id_seccion').val();
        isc = $('#tmp_id_seccion_categoria').val();
        para = $('#para_anuncio').val();
        title = $('#titulo_anuncio').val();
        content = $('#contenido_anuncio').val();
        
        modal = $('#MODAL-A');

        if (title == '') {
            RPT('R-NAME');
        } else {
            if (content == '') {
                RPT('R-CONTENT');
            } else {
                $.ajax({
                    url: ruta,
                    type: metodo,
                    dataType: tipoDato,
                    data: {
                        is: is,
                        isc: isc,
                        c_para: para, 
                        c_titulo: title,
                        c_url_archivo: content
                    },
                    success:function(data){
                        $("#anuncios-reload").load(" #anuncios-reload");
                        modal.modal('hide');
                        $('#titulo_anuncio').val('');
                        $('#contenido_anuncio').val('');
                        RPT('AEN');
                    },
                    error: function(){
                        RPT('AER');
                    }
                });
            }
        }
    });
    
    ///Eliminar anuncio
    function EliminarAnuncio(id){
        ruta = '/docente/cursos/eliminar_anuncio';
        metodo = 'POST';
        tipoDato = 'json';
        
        id_anuncio = id;
        
        Swal.fire({
            text: "¿Seguro(a) que quiere eliminar este anuncio?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Si, eliminar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: ruta,
                    type: metodo,
                    dataType: tipoDato,
                    data: {
                        id_anuncio: id_anuncio
                    },
                    success:function(data){
                        $("#anuncios-reload").load(" #anuncios-reload");
                        RPT('AEL');
                    },
                    error: function(){
                        RPT('AELER');
                    }
                })
            }
        })
    };

    //ALERTS
    function RPT(cod){
        switch (cod) {
            case 'AEN':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'El anuncio fue enviado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'AER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'El anuncio no pudo ser enviado, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'R-NAME':
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'El anuncio necesita un títiulo',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
                break;
            case 'R-CONTENT':
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    text: 'El anuncio que intenta enviar, no tiene contenido',
                    showConfirmButton: true,
                    confirmButtonColor: '#3498db'
                });
                break;
            case 'AEL':
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'El anuncio fue eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            case 'AELER':
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    text: 'El anuncio no pudo ser eliminado, vuelva a intentarlo',
                    showConfirmButton: false,
                    timer: 1500
                });
                break;
            default:
                break;
        }
    };

    $(document).ready(function(){
        $('.anc-content').hide();
    });

    function VerAnuncio(id){
        $('#mb-title').text($('#ANT-'+id).text());
        $('#mb-content').text($('#ANC-'+id).text());
        $('#mb-date').text('Fecha de publicación: ' + $('#AND-'+id).text());
        $('#MODAL-SHOW').modal('show');
    };
</script>

