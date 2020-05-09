@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-alumno.css')}}">
@endsection

@section('main-content')

<body>
    @foreach ($secciones as $s)
        <h5 class="hs_titulo">{{substr($s->nom_grado,3)}} {{$s->c_nombre}} {{$s->nom_nivel}}</h5>
        <section class="cursos-tablero">
            @foreach ($cursos as $c)
                @if ($c->id_seccion == $s->id_seccion)
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
    @endforeach
</body>

@endsection