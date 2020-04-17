<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class Tarea extends Controller
{
    public function aplicar(Request $request)
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        $tarea = App\Tarea_d::where([
            ['id_tarea', '=', $request->input('id_tarea')],
            ['id_docente', '=', $docente->id_docente],
            ['c_estado', '<>', 'DCAL'],
            ['t_fecha_hora_entrega', '<=', date('Y-m-d H:i:s')],
            ['estado', '=', 1]
        ])->first();

        $tarea->categoria;
        $tarea->alumnos_asignados;
        if (!is_null($tarea) && !empty($tarea)) {

            $datos = array(
                'correcto' => TRUE,
                'tarea' => $tarea
            );

            return response()->json($datos);
        } else {
            $datos = array(
                'correcto' => FALSE
            );
            return response()->json($datos);
        }
    }

    public function respuesta(Request $request)
    {
        $puente = DB::table('alumno_tarea_respuesta_p')->select('id_alumno_docente_tarea', 'id_respuesta', 'c_estado')->where([
            ['id_alumno_docente_tarea', '=', $request->input('id_puente')],
            ['estado', '=', 1],
            ['c_estado', '<>', 'ACAL']
        ])->whereNotNull('id_respuesta')->first();

        if (!is_null($puente) && !empty($puente)) {
            $respuesta = App\Respuesta_d::where([
                'id_respuesta' => $puente->id_respuesta,
                'estado' => 1
            ])->first();

            if (!is_null($respuesta) && !empty($respuesta)) {
                $datos = array(
                    'correcto' => TRUE,
                    'puente' => $puente,
                    'respuesta' => $respuesta
                );
                return response()->json($datos);
            } else {
                $datos = array(
                    'correcto' => FALSE
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
}
