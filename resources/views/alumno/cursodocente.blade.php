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
                <h5 class="docente-name hs_upper">{{$curso->nom_docente}}</h5>
                <strong>Especialidad</strong>
                <p class="docente-specialty hs_capitalize-first">{{$curso->c_especialidad}}</p>
                <br>
                <strong>Correo electrónico</strong>
                <p class="docente-email">{{$curso->c_correo}}</p>
            </div>
        </div>
    </div>
</div>