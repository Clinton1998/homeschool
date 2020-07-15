<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use App\Events\AlertSimple;
use App\Events\NewCommentTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;
use Auth;

class Tarea extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function aplicar(Request $request)
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();
        if(!is_null($docente) && !empty($docente)){
              $tarea = App\Tarea_d::where([
                  ['id_tarea', '=', $request->input('id_tarea')],
                  ['id_docente', '=', $docente->id_docente],
                  ['t_fecha_hora_entrega', '<=', date('Y-m-d H:i:s')],
                  ['estado', '=', 1]
              ])->first();
              if(!is_null($tarea) && !empty($tarea)){
                  $tarea->categoria;
                  $tarea->alumnos_asignados;
                  $tarea->archivos = $tarea->archivos()->where('estado','=',1)->get();
                  $p_alumno = $tarea->alumnos_asignados()->first();
                  $seccion_asignada = App\Seccion_d::findOrFail($p_alumno->id_seccion);
                  $seccion_asignada->grado;
                  $datos = array(
                      'correcto' => TRUE,
                      'tarea' => $tarea,
                      'seccion_asignada' =>  $seccion_asignada
                  );
                  return response()->json($datos);
              }
        }
        return response()->json(['correcto' => FALSE]);
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

                //alerta simple de un nuevo comentario a todos los alumnos
                $title = 'Nuevo comentario en la tarea "'.$tarea->c_titulo.'"';
                $text = '';
                $type = 'info';
                $timeout = 10000;
                $icon = '';
                if(!is_null($docente->c_foto) && !empty($docente->c_foto)){
                  $icon = '/super/docente/foto/'.$docente->c_foto;
                }else{
                  if(strtoupper($docente->c_sexo)=='M'){
                      $icon = '/assets/images/usuario/teacherman.png';
                  }else{
                      $icon = '/assets/images/usuario/teacherwoman.png';
                  }
                }
                $text = $comentario->c_descripcion;
                $alumnos_asignados = $tarea->alumnos_asignados()->where('alumno_d.estado','=',1)->get();
                $id_usuarios = array();
                foreach($alumnos_asignados as $item_alumno){
                  $id_usuarios[] = $item_alumno->usuario->id;
                }
                $comentario->load('comenta.docente');
                broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));
                broadcast(new NewCommentTask($comentario));
                return response()->json(['correcto' => TRUE,'comentario' => $comentario]);
            }
        }
        return response()->json(['correcto' => FALSE]);
    }

    public function respuesta(Request $request)
    {
        $puente = DB::table('alumno_tarea_respuesta_p')->select('id_alumno_docente_tarea','id_alumno', 'id_tarea','id_respuesta', 'c_estado')->where([
            ['id_alumno_docente_tarea', '=', $request->input('id_puente')],
            ['estado', '=', 1],
        ])->whereNotNull('id_respuesta')->first();

        if (!is_null($puente) && !empty($puente)) {
            $respuesta = App\Respuesta_d::where([
                'id_respuesta' => $puente->id_respuesta,
                'estado' => 1
            ])->first();
            if (!is_null($respuesta) && !empty($respuesta)) {
                $respuesta->archivos = $respuesta->archivos()->where('estado','=',1)->get();
              //obtenemos la tarea
                $tarea = App\Tarea_d::where([
                  'id_tarea' => $puente->id_tarea,
                  'estado' => 1
                ])->first();
                if(!is_null($tarea) && !empty($tarea)){
                  $docente = $tarea->docente;
                  $alumno = App\Alumno_d::where([
                      'id_alumno' => $puente->id_alumno,
                      'estado' => 1
                  ])->first();
                  if(!is_null($alumno) && !empty($alumno)){
                    //alerta simple al alumno de que se visualizo su respuesta
                    $title = 'Respuesta visto';
                    $text =   $docente->c_nombre.' acaba de ver tu respuesta de la tarea "'.$tarea->c_titulo.'""';
                    $type = 'info';
                    $timeout = 10000;
                    $icon = '/assets/images/colegio/school.png';
                    broadcast(new AlertSimple([$alumno->usuario->id],$title,$text,$type,$timeout,$icon));
                    $datos = array(
                        'correcto' => TRUE,
                        'puente' => $puente,
                        'respuesta' => $respuesta
                    );
                    return response()->json($datos);
                  }
                }
            } else {
                $datos = array(
                    'correcto' => FALSE
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE,
            'puente' => $puente
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
                    ->where('id_alumno_docente_tarea','=', $puente->id_alumno_docente_tarea)
                    ->update(['c_estado' => 'ACAL']);
                //obteniendo la tarea
                $tarea = App\Tarea_d::findOrFail($puente->id_tarea);
                $alumno = App\Alumno_d::where([
                  'id_alumno' => $puente->id_alumno,
                  'estado' => 1
                ])->first();
                if(!is_null($alumno) && !empty($alumno)){
                  \Notification::send($alumno->usuario, new NuevaTareaParaAlumnoNotification(array(
                      'titulo' => 'Respuesta calificada',
                      'mensaje' => 'La respuesta de la tarea "'.$tarea->c_titulo.'" ha sido calificada"',
                      'url' => '/alumno/tareas/',
                      'tipo' => 'tareacalificada'
                  )));

                  $alumnos_asignados = $tarea->alumnos_asignados()->where([
                    ['alumno_d.estado','=',1],
                    ['alumno_d.id_alumno','<>',$alumno->id_alumno]
                    ])->get();
                  $id_usuarios = array();
                  foreach ($alumnos_asignados as $item_alumno) {
                      $id_usuarios[] = $item_alumno->usuario->id;
                  }
                  if(count($id_usuarios)>0){
                    //alert simple para otros alumnos de la tarea
                    $title = 'Respuesta calificada de tu compañero(a)';
                    $text = 'A '.$alumno->c_nombre.' le acaban de calificar su respuesta de la tarea "'.$tarea->c_titulo.'"';
                    $type = 'info';
                    $timeout = 10000;
                    $icon = '/assets/images/colegio/school.png';
                    broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));
                  }
                }

                //verificamos si se ha revisado a todos los alumnos que enviaron la tarea
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
                    if(strtoupper($tarea->c_estado)!='DCAL'){
                      $alumnos_asignados = $tarea->alumnos_asignados()->where('alumno_d.estado','=',1)->get();
                      $id_usuarios = array();
                      foreach ($alumnos_asignados as $alumno) {
                          $id_usuarios[] = $alumno->usuario->id;
                      }
                      /*Mostramos una alerta a los alumnos de que la revision y calificacion de la tarea finzalizo*/
                      $title = 'Calificacíon y revisión de las respuestas terminó';
                      $text = 'Las respuestas de la tarea "'.$tarea->c_titulo.'" ya han sido revisadas y calificadas."';
                      $type = 'success';
                      $timeout = 10000;
                      $icon = '/assets/images/colegio/school.png';
                      broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));
                    }
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
                $p_alumno = $tarea->alumnos_asignados()->first();
                $seccion_asignada = App\Seccion_d::findOrFail($p_alumno->id_seccion);
                $seccion_asignada->grado;

                $tarea->alumnos_asignados = $tarea->alumnos_asignados()->where('alumno_d.estado','=',1)->orderBy('alumno_d.c_nombre','ASC')->get();
                $tarea->comentarios = $tarea->comentarios()->where('comentario_d.estado','=',1)->orderBy('created_at','DESC')->get();

                $tarea->comentarios = $tarea->comentarios->map(function ($comentario){
                  if(!is_null($comentario->comenta->id_docente)){
                    $comentario->load('comenta.docente');
                  }else{
                    $comentario->load('comenta.alumno');
                  }
                  return $comentario;
                });
                return view('docente.infotarea', compact('tarea','seccion_asignada'));
            } else {
                return redirect('docente/asignartareas');;
            }
        } else {
            return redirect('docente/asignartareas');;
        }
    }

    public function descargar_archivo($id_tarea,$filename)
    {
        $tarea = App\Tarea_d::findOrFail($id_tarea);
        return Storage::download('tareaasignacion/' . $tarea->id_tarea . '/' . $filename);
    }
}
