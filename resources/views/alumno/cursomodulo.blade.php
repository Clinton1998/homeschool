<div class="content-header">
    <h4 class="content-title">Módulos</h4>
</div>

@php
    $num = 0;
@endphp

<div class="content-main">
    <div id="container-reload" class="my-scroll">
        @if ($modulos->count() > 0)
            @foreach ($modulos as $m)
                <div class="box-card card">
                    <div class="card-header">
                        <div class="box-title">
                            <strong style="display: flex; align-items: center">
                                <span>
                                    @php
                                        $num++;
                                        echo '<span class="badge  badge-dark p-1 mr-1">'.$num.'</span>'; 
                                    @endphp
                                </span>
                                <span href="#" class="hs_upper" style="margin-bottom: -2px"> {{$m->c_nombre}}</span>
                            </strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="box-content">
                            <div class="box-descripcion">
                                <div class="box-files" id="box_files{{$m->id_modulo}}">
                                    @php
                                        $sub_item = 0;
                                    @endphp
                                    @if ($archivos->count() > 0)
                                        @foreach ($archivos as $a)
                                            @if ($a->id_modulo == $m->id_modulo)
                                                <div class="box-file">
                                                    <div class="box-file-header">
                                                        <div class="box-file-header-title">
                                                            @php
                                                                $sub_item++;
                                                                echo '<span class="mr-1">'.$num.'.'.$sub_item.'.'.'</span><p class="hs_capitalize-first">'.$a->c_nombre.'</p>';
                                                            @endphp
                                                        </div>
                                                    </div>
                                                    <div class="boc-file-footer">
                                                        <a href="{{url('/docente/cursos/descargar_archivo/'.$a->id_archivo)}}" class="box-file-link" download="{{$a->c_url}}">Descargar</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="box-card card">
                <div class="card-header">
                    <div class="box-title">
                        <strong><a href="#" class="hs_upper">Este curso aún no tiene módulos creados</a></strong>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>