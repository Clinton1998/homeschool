<div class="content-header">
    <h4 class="content-title">Docente</h4>
</div>

<div class="content-main">
    <div class="my-scroll">
        <div class="box-card card docente-card">
            <div class="card-body text-center docente-card-body">
                @if(is_null($curso->c_foto)  || empty($curso->c_foto))
                    <img class="docente-photo" src="{{asset('assets/images/user.png')}}" alt="Docente">
                @else
                    <img class="docente-photo" src="{{url('super/docente/foto/'.$curso->c_foto)}}" alt="Docente">
                @endif
                <h4 class="docente-name hs_capitalize">{{mb_strtolower($curso->nom_docente)}}</h4>
                <strong>Especialidad</strong>
                <p class="docente-specialty hs_capitalize-first">{{mb_strtolower($curso->c_especialidad)}}</p>
                <br>
                <strong>Correo electrónico</strong>
                <p class="docente-email hs_lower">{{$curso->c_correo}}</p>
            </div>
        </div>
    </div>
</div>