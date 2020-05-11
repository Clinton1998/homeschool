<div class="content-header">
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h4 class="content-title">Anuncios</h4>
        <button type="button" id="btn-nuevo-anuncio" class="btn" data-toggle="modal" data-target="#MODAL-A" style="margin: -15px 0 5px 0; color: #FFF; background: {{$curso->col_curso}}">Nuevo anuncio</button>
    </div>
</div>

<div class="content-main">
    <div class="my-scroll">
        <div class="box-card card">
            <div class="card-header">
                <div class="box-title">
                    <strong><a href="#" class="hs_upper">Título de Anuncio</a></strong>
                </div>
            </div>
            <div class="card-body">
                <div class="box-content">
                    <div class="box-descripcion">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo sequi incidunt voluptates asperiores ut nulla placeat laboriosam ullam, quam pariatur reiciendis.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="box-fechas" style="justify-content: flex-end">
                    <div class="box-fecha-envio">
                        <p>Enviado: </p>
                        <p> 15-05-2020</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal anuncio -->
<div class="modal fade" id="MODAL-A" tabindex="-1" role="dialog" aria-labelledby="MODALLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
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
                {{-- <input type="hidden" id="id_mo" name="id_mo"> --}}
                {{-- <input type="hidden" id="id_sc" name="id_sc" value="{{$id_sc->id_seccion_categoria}}"> --}}
                <div class="form-group">
                    <label for="para_anuncio">Para</label>
                    <select name="para_anuncio" id="para_anuncio" class="form-control" autofocus required>
                        <option value="1">Este curso</option>
                        <option value="2">Toda la sección</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="titulo_anuncio">Título</label>
                    <input type="text" id="titulo_anuncio" name="titulo_anuncio" class="form-control" autofocus required>
                </div>
                <div class="form-group">
                    <label for="contenido_anuncio">Contenido</label>
                    <textarea name="contenido_anuncio" id="contenido_anuncio" cols="30" rows="6" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_crear_anuncio" class="btn btn-primary">Enviar</button>
            </div>
        </form>
        </div>
    </div>
</div>
