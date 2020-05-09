<div class="content-header">
    <h4 class="content-title">Docente</h4>
</div>

<div class="content-main">
    <div class="my-scroll">
        <div class="box-card card docente-card">
            <div class="card-body text-center docente-card-body">
                @if (is_null($docente) || empty($docente))
                    <img class="docente-photo" src="{{asset('assets/images/user.png')}}" alt="Docente">
                    <h5 class="docente-name hs_upper">Docente no asignado</h5>
                    <strong>Especialidad</strong>
                    <p class="docente-specialty hs_capitalize-first">-</p>
                    <br>
                    <strong>Correo electrónico</strong>
                    <p class="docente-email">-</p>
                @else
                    @if(is_null($docente->c_foto)  || empty($docente->c_foto))
                        <img class="docente-photo" src="{{asset('assets/images/user.png')}}" alt="Docente">
                    @else
                        <img class="docente-photo" src="{{url('super/docente/foto/'.$docente->c_foto)}}" alt="Docente">
                    @endif
                    <h5 class="docente-name hs_upper">{{$docente->c_nombre}}</h5>
                    <strong>Especialidad</strong>
                    <p class="docente-specialty hs_capitalize-first">{{$docente->c_especialidad}}</p>
                    <br>
                    <strong>Correo electrónico</strong>
                    <p class="docente-email">{{$docente->c_correo}}</p>
                @endif
            </div>
        </div>
    </div>
</div>