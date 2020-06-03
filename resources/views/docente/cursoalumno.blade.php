<div class="content-header">
    <h4 class="content-title">Mis alumnos</h4>
</div>

<div class="content-main">
    <div class="my-scroll">
        @php
            $num_orden = 1;   
        @endphp

        @foreach ($alumnosseccion as $as)
            <div class="box-group">
                <h5 class="alumno-number">
                    @php
                        echo $num_orden++
                    @endphp
                </h5>

                @if(is_null($as->c_foto)  || empty($as->c_foto))
                    <img class="alumno-photo" src="{{asset('assets/images/user.png')}}" alt="Alumno">
                @else
                    <img class="alumno-photo" src="{{url('super/alumno/foto/'.$as->c_foto)}}" alt="Alumno">
                @endif
                
                <div class="alumno-group">
                    <p class="alumno-name hs_capitalize">{{mb_strtolower($as->c_nombre)}} </p>
                    <p class="alumno-email"> {{mb_strtolower($as->c_correo)}}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>