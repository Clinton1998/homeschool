<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Tarea extends Controller
{
    public function index()
    {
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if (!is_null($alumno) && !empty($alumno)) {
            //obteniendo las tareas pendientes
            $tareas_del_alumno = $alumno->tareas_asignados()->where('tarea_d.estado', '=', 1)->orderBy('tarea_d.created_at', 'DESC')->get();
            return view('tareasalumno', compact('tareas_del_alumno'));
        } else {
            return redirect('home');
        }
    }

    public function listar(Request $request)
    {

        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if (!is_null($alumno) && !empty($alumno)) {
            //obteniendo las tareas pendientes
            $tareas_del_alumno = $alumno->tareas_asignados()->where('tarea_d.estado', '=', 1)->get();
            $events = array();
            $i = 0;
            foreach ($tareas_del_alumno as $tarea) {
                $color = '';
                if ($tarea->pivot->c_estado == 'APEN' && $tarea->t_fecha_hora_entrega > date('Y-m-d H:i:s')) {
                    $color = '#FFC107';
                } else if ($tarea->pivot->c_estado == 'APEN' && $tarea->t_fecha_hora_entrega <= date('Y-m-d H:i:s')) {
                    $color = 'red';
                } else if ($tarea->pivot->c_estado == 'AENV') {
                    $color = '#003473';
                } else if ($tarea->pivot->c_estado == 'ACAL') {
                    $color = '#4CAF50';
                }
                $events[$i] = array(
                    'title' => $tarea->c_titulo,
                    'start' => $tarea->created_at,
                    'end' => $tarea->t_fecha_hora_entrega,
                    'color' => $color
                );
                $i++;
            }
            return response()->json($events);
        }
    }
}
