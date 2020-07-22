<div class="content-header">
    <h4 class="content-title">Docente</h4>
</div>

<div class="content-main">
    <div class="my-scroll">
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            @foreach ($docentes as $doc)
                <div class="box-card card docente-card">
                    <div class="card-body text-center docente-card-body">
                        @if(is_null($doc->c_foto)  || empty($doc->c_foto))
                            <img class="docente-photo" src="{{asset('assets/images/user.png')}}" alt="Docente">
                        @else
                            <img class="docente-photo" src="{{url('super/docente/foto/'.$doc->c_foto)}}" alt="Docente">
                        @endif
                        <h4 class="docente-name hs_capitalize">{{mb_strtolower($doc->nom_docente)}}</h4>
                        <strong>Especialidad</strong>
                        <p class="docente-specialty hs_capitalize-first">{{mb_strtolower($doc->c_especialidad)}}</p>
                        <br>
                        <strong>Correo electrónico</strong>
                        <p class="docente-email hs_lower">{{$doc->c_correo}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>