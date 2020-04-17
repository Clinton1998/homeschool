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
        /*$datos = array(
            'correcto' => $request->input('id_puente')
        );

        return response()->json($datos);*/

        $puente = DB::table('alumno_tarea_respuesta_p')->select('id_alumno_docente_tarea', 'id_respuesta', 'c_estado')->where([
            ['id_alumno_docente_tarea', '=', $request->input('id_puente')],
            ['estado', '=', 1],
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
                    'correctoxd1' => FALSE
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correctoxd2' => FALSE
        );
        return response()->json($datos);
    }

    public function calificar_respuesta(Request $request)
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        if (!is_null($docente) && !empty($docente)) {
            $puente = DB::table('alumno_tarea_respuesta_p')->where([
                'id_alumno_docente_tarea' => $request->input('id_puente'),
                'estado' => 1
            ])->first();

            if (!is_null($puente) && !empty($puente)) {
                //actualizamos la respuesta con la calificacion
                $respuesta = App\Respuesta_d::findOrFail($puente->id_respuesta);
                $respuesta->c_calificacion = $request->input('calificacion');
                $respuesta->c_comentario_calificacion = $request->input('comentario_calificacion');
                $respuesta->modificador = $usuarioDocente->id;
                $respuesta->save();
                //actualizamos la tabla puente
                DB::table('alumno_tarea_respuesta_p')
                    ->where('id_alumno_docente_tarea', $puente->id_alumno_docente_tarea)
                    ->update(['c_estado' => 'ACAL']);

                //obteniendo la tarea
                $tarea = App\Tarea_d::findOrFail($puente->id_tarea);
                //verificamos si se ha revisado a todos loa alumnos que enviaron la tarea
                $count_alumnos_que_enviaron =  0;
                $count_calificados = 0;
                foreach ($tarea->alumnos_asignados as $alumno) {
                    if (!is_null($alumno->pivot->id_respuesta)) {
                        $count_alumnos_que_enviaron++;
                        if ($alumno->pivot->c_estado == 'ACAL') {
                            $count_calificados++;
                        }
                    }
                }

                if ($count_calificados == $count_alumnos_que_enviaron) {
                    //actualizamos la tarea a calificado
                    $tarea->c_estado = 'DCAL';
                    $tarea->modificador = $usuarioDocente->id;
                    $tarea->save();
                }
                return redirect('docente/estadotareas');
            }
        }

        return redirect('docente/estadotareas');
    }
}
