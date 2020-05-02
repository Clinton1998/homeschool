@extends('reutilizable.principal')
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/css/style-super.css')}}">
@endsection

@section('main-content')
<section class="ul-contact-detail">
    <h2 class="hs_titulo">Comunicado</h2>

    <div class="row">
        <div class="col-xs-12 col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">{{$comunicado->c_titulo}}</h3>
                </div>
                <div class="card-body">
                    <p class="text-right">Fecha de publicación: {{$comunicado->created_at}}</p>
                    <p>{{$comunicado->c_descripcion}}</p>
                    @if(!is_null($comunicado->c_url_archivo))
                        <div>
                            <a href="/comunicado/archivo/{{$comunicado->id_comunicado}}" class="text-primary" cdownload="{{$comunicado->c_url_archivo}}">Descargar Archivo</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-js')
@endsection