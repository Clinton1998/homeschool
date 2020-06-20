<?php

namespace App\Listeners;

use App\Events\NuevoComunicado;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\User;
use App\Grado_m;

class EnviarNotificacion
{
    /*Notificacion de comunicado*/
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NuevoComunicado  $event
     * @return void
     */
    public function handle(NuevoComunicado $event)
    {
        $colegio = $event->colegio;
        $comunicado = $event->comunicado;
        $comunicado->load('archivos');
        $destino = strtoupper($comunicado->c_destino);

        if ($destino == 'TODO') {
            //para docentes
            $docentes = $colegio->docentes()->where('estado', '=', 1)->get();
            $id_usuarios_doc = array();
            $i = 0;
            foreach ($docentes as $docente) {
                $id_usuarios_doc[$i] = $docente->usuario->id;
                $i++;
            }
            $usuarios_docente = User::whereIn('id', $id_usuarios_doc)->get();
            if ($usuarios_docente->count() > 0) {
                \Notification::send($usuarios_docente, new NuevaTareaParaAlumnoNotification(array(
                    'titulo' => 'Comunicado',
                    'mensaje' => $comunicado->c_titulo,
                    'url' => '/comunicado/ver/' . $comunicado->id_comunicado,
                    'tipo' => 'comunicado',
                    'comunicado' => $comunicado
                )));
            }

            //para alumnos

            $grados = Grado_m::where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 1
            ])->get();
            $id_usuarios_alu = array();
            $j = 0;
            foreach ($grados as $grado) {
                foreach ($grado->secciones()->where('estado', '=', 1)->get() as $seccion) {
                    foreach ($seccion->alumnos()->where('estado', '=', 1)->get() as $alumno) {
                        $id_usuarios_alu[$j] = $alumno->usuario->id;
                        $j++;
                    }
                }
            }
            $usuarios_alumno = User::whereIn('id', $id_usuarios_alu)->get();

            if ($usuarios_alumno->count() > 0) {
                \Notification::send($usuarios_alumno, new NuevaTareaParaAlumnoNotification(array(
                    'titulo' => 'Comunicado',
                    'mensaje' => $comunicado->c_titulo,
                    'url' => '/comunicado/ver/' . $comunicado->id_comunicado,
                    'tipo' => 'comunicado',
                    'comunicado' => $comunicado
                )));
            }
        } else if ($destino == 'DOCE') {
            $docentes = $colegio->docentes()->where('estado', '=', 1)->get();
            $id_usuarios_doc = array();
            $i = 0;
            foreach ($docentes as $docente) {
                $id_usuarios_doc[$i] = $docente->usuario->id;
                $i++;
            }
            $usuarios_docente = User::whereIn('id', $id_usuarios_doc)->get();
            if ($usuarios_docente->count() > 0) {
                \Notification::send($usuarios_docente, new NuevaTareaParaAlumnoNotification(array(
                    'titulo' => 'Comunicado',
                    'mensaje' => $comunicado->c_titulo,
                    'url' => '/comunicado/ver/' . $comunicado->id_comunicado,
                    'tipo' => 'comunicado',
                    'comunicado' => $comunicado
                )));
            }
        } else if ($destino == 'ALUM') {
            $grados = Grado_m::where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 1
            ])->get();
            $id_usuarios_alu = array();
            $j = 0;
            foreach ($grados as $grado) {
                foreach ($grado->secciones()->where('estado', '=', 1)->get() as $seccion) {
                    foreach ($seccion->alumnos()->where('estado', '=', 1)->get() as $alumno) {
                        $id_usuarios_alu[$j] = $alumno->usuario->id;
                        $j++;
                    }
                }
            }
            $usuarios_alumno = User::whereIn('id', $id_usuarios_alu)->get();

            if ($usuarios_alumno->count() > 0) {
                \Notification::send($usuarios_alumno, new NuevaTareaParaAlumnoNotification(array(
                    'titulo' => 'Comunicado',
                    'mensaje' => $comunicado->c_titulo,
                    'url' => '/comunicado/ver/' . $comunicado->id_comunicado,
                    'tipo' => 'comunicado',
                    'comunicado' => $comunicado
                )));
            }
        }
    }
}
