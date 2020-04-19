<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
class Calendario extends Controller
{
    public function index(){

        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if (!is_null($alumno) && !empty($alumno)) {
            //obteniendo las tareas pendientes
            $tareas_del_alumno = $alumno->tareas_asignados()->where('tarea_d.estado','=',1)->orderBy('tarea_d.created_at','DESC')->limit(6)->get();
            return view('calendarioalumno', compact('tareas_del_alumno'));
        } else {
            return redirect('home');
        }
    }
}
