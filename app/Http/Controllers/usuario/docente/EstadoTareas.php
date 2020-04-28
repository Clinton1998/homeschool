<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class EstadoTareas extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        if (!is_null($docente) && !empty($docente)) {
            //obtenemos las tareas enviadas
            $tareas_enviadas = $docente->tareas()->where([
                'tarea_d.estado' => 1
            ])->orderBy('tarea_d.created_at', 'DESC')->get();
            //obtenemos las tareas que se han completado de calificar
            //que todos los alumnos de esa tarea ya han sido calificados y revisados
            $tareas_calificadas = $docente->tareas()->where([
                'tarea_d.c_estado' => 'DCAL',
                'tarea_d.estado' => 1
            ])->orderBy('tarea_d.created_at', 'DESC')->get();
            
            //tareas pendientes por calificar,  tareas  que la fecha de entrega ya vencio
            //esto cuando no ha completado de revisar a todos los alumnos
            //hay algunos alumnos sin revisar
            $tareas_pendientes_por_calificar = $docente->tareas()->where([
               ['tarea_d.c_estado','<>','DCAL'],
               ['tarea_d.t_fecha_hora_entrega', '<=',date('Y-m-d H:i:s')]
            ])->orderBy('tarea_d.created_at','DESC')->get();

            return view('docente.estadotareas',compact('tareas_enviadas','tareas_calificadas','tareas_pendientes_por_calificar'));
        } else {
            return redirect('home');
        }
        
    }
}
