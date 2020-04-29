<?php

namespace App\Listeners;

use App\Events\NuevaTareaAsignada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Nexmo\Laravel\Facade\Nexmo;

class EnviarSMS
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NuevaTareaAsignada  $event
     * @return void
     */
    public function handle(NuevaTareaAsignada $event)
    {
        $alumnos = $event->alumnos;
        $docente = $event->docente;

        foreach($alumnos as $alumno){
            $telefono_representante1 = $alumno->c_telefono_representante1;
            $telefono_representante2 = $alumno->c_telefono_representante2;

            if(!is_null($telefono_representante1) && !empty($telefono_representante1)){
                Nexmo::message()->send([
                    'to'   => '51920192637',
                    'from' => $telefono_representante1,
                    'text' => 'Al alumno '.$alumno->c_nombre.' le acaban de asignar una nueva tarea, Asignado por '.$docente
                ]);
            }
            if(!is_null($telefono_representante2) && !empty($telefono_representante2)){
                Nexmo::message()->send([
                    'to'   => '51920192637',
                    'from' => $telefono_representante2,
                    'text' => 'Al alumno '.$alumno->c_nombre.' le acaban de asignar una nueva tarea, Asignado por '.$docente
                ]);
            }
        }
    }
}
