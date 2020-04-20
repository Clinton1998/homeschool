<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

            $p_alumno = $tarea->alumnos_asignados()->first();
            $seccion_asignada = App\Seccion_d::findOrFail($p_alumno->id_seccion);
            $seccion_asignada->grado;
            $datos = array(
                'correcto' => TRUE,
                'tarea' => $tarea,
                'seccion_asignada' =>  $seccion_asignada
            );

            return response()->json($datos);
        } else {
            $datos = array(
                'correcto' => FALSE
            );
            return response()->json($datos);
        }
    }

    public function aplicar_info(Request $request)
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        $tarea = App\Tarea_d::where([
            ['id_tarea', '=', $request->input('id_tarea')],
            ['id_docente', '=', $docente->id_docente],
            ['estado', '=', 1]
        ])->first();

        $tarea->categoria;
        $tarea->alumnos_asignados;
        if (!is_null($tarea) && !empty($tarea)) {

            $p_alumno = $tarea->alumnos_asignados()->first();
            $seccion_asignada = App\Seccion_d::findOrFail($p_alumno->id_seccion);
            $seccion_asignada->grado;
            $datos = array(
                'correcto' => TRUE,
                'tarea' => $tarea,
                'seccion_asignada' =>  $seccion_asignada
            );

            return response()->json($datos);
        } else {
            $datos = array(
                'correcto' => FALSE
            );
            return response()->json($datos);
        }
    }

    public function comentar(Request $request)
    {

        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        if (!is_null($docente) && !empty($docente)) {
            //aplicando la tarea
            $tarea = App\Tarea_d::where([
                'id_tarea' => $request->input('id_tarea'),
                'id_docente' => $docente->id_docente,
                'estado' => 1
            ])->first();

            //verificamos si la tarea le pertenece al docente
            if (!is_null($tarea) && !empty($tarea)) {
                //agregamos el comentario
                $comentario = new App\Comentario_d;
                $comentario->id_tarea = $tarea->id_tarea;
                $comentario->id_usuario = $usuarioDocente->id;
                $comentario->c_descripcion = $request->input('comentario');
                $id_referencia =  $request->input('id_comentario_referncia');
                if (!is_null($id_referencia) && !empty($id_referencia)) {
                    $ref_com = App\Comentario_d::findOrFail($id_referencia);
                    $comentario->id_comentario_referencia = $ref_com->id_comentario;
                }
                $comentario->creador = $usuarioDocente->id;
                $comentario->save();
            }
        }
        return redirect('docente/tarea/' . $request->input('id_tarea'));
    }

    public function respuesta(Request $request)
    {
        $puente = DB::table('alumno_tarea_respuesta_p')->select('id_alumno_docente_tarea', 'id_tarea','id_respuesta', 'c_estado')->where([
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

    public function info($id_tarea)
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        if (!is_null($docente) && !empty($docente)) {
            //aplicando la tarea
            $tarea = App\Tarea_d::where([
                'id_tarea' => $id_tarea,
                'id_docente' => $docente->id_docente,
                'estado' => 1
            ])->first();

            //verificamos si la tarea le pertenece al docente
            if (!is_null($tarea) && !empty($tarea)) {
                return view('docente.infotarea', compact('tarea'));
            } else {
                return redirect('docente/asignartareas');;
            }
        } else {
            return redirect('docente/asignartareas');;
        }
    }

    public function descargar_archivo($id_tarea)
    {
        $tarea = App\Tarea_d::findOrFail($id_tarea);
        return Storage::download('tareaasignacion/' . $tarea->id_tarea . '/' . $tarea->c_url_archivo);
    }
}
