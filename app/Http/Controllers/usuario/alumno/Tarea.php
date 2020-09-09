<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use App\Events\AlertSimple;
use App\Events\NewCommentTask;
use Illuminate\Http\Request;
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

    public function info_pendiente($id_tarea)
    {
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();
        if (!is_null($alumno) && !empty($alumno)) {
            $tarea = App\Tarea_d::where([
                ['id_tarea', '=', $id_tarea],
                ['estado', '=', 1],
                ['t_fecha_hora_entrega', '>', date('Y-m-d H:i:s')]
            ])->first();

            if(!is_null($tarea) && !empty($tarea)){
              //comprobamos si la tarea pertenece al alumno
              $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                  'alumno_d.estado' => 1,
                  'alumno_tarea_respuesta_p.c_estado' => 'APEN',
                  'alumno_d.id_alumno' => $alumno->id_alumno
              ])->first();
              if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                  //marcar la notificacion generado como leido
                  $notificaciones = $usuarioAlumno->unreadNotifications()->get();
                  $my_url = parse_url('/alumno/tareapendiente/' . $id_tarea)['path'];
                  $notificacion_a_marcar = null;
                  foreach ($notificaciones as $notificacion) {
                      $url = $notificacion->data['notificacion']['url'];
                      $url = parse_url($url)['path'];
                      if ($url === $my_url) {
                          $notificacion_a_marcar = $notificacion;
                      }
                  }
                  if (!is_null($notificacion_a_marcar)) {
                      //marcar la notificacion como leido
                      $notificacion_a_marcar->read_at  = date('Y-m-d H:i:s');
                      $notificacion_a_marcar->save();
                  }

                  $tarea->comentarios = $tarea->comentarios()->where('comentario_d.estado','=',1)->orderBy('created_at','DESC')->get();
                  $tarea->comentarios = $tarea->comentarios->map(function ($comentario){
                    if(!is_null($comentario->comenta->id_docente)){
                      $comentario->load('comenta.docente');
                    }else{
                      $comentario->load('comenta.alumno');
                    }
                    return $comentario;
                  });

                  //enviamos una alerta simple al docente, de que un alumno abrio la tarea.
                  $colegio = $alumno_de_tarea->seccion->grado->colegio;
                  $title = 'Tarea abierta';
                  $text = '';
                  $type = 'info';
                  $timeout = 5000;
                  $icon = '/assets/images/colegio/school.png';
                  if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                    $icon = '/super/colegio/logo/'.$colegio->c_logo;
                  }
                  $text = $alumno_de_tarea->c_nombre. ' ha abierto la tarea "'.$tarea->c_titulo.'"';
                  broadcast(new AlertSimple([$tarea->docente->usuario->id],$title,$text,$type,$timeout,$icon));
                  return view('alumno.infotareapendiente', compact('tarea'));
              }
            }
        }
        return redirect('alumno/tareas');;
    }

    public function info_enviado($id_tarea)
    {
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if (!is_null($alumno) && !empty($alumno)) {
            $tarea = App\Tarea_d::where([
                'id_tarea' => $id_tarea,
                'estado' => 1
            ])->first();
            //comprobamos si la tarea pertenece al alumno
            $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                'alumno_d.estado' => 1,
                'alumno_tarea_respuesta_p.c_estado' => 'AENV',
                'alumno_d.id_alumno' => $alumno->id_alumno
            ])->first();

            if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                $tarea->comentarios = $tarea->comentarios()->where('comentario_d.estado','=',1)->orderBy('created_at','DESC')->get();
                $tarea->comentarios = $tarea->comentarios->map(function ($comentario){
                  if(!is_null($comentario->comenta->id_docente)){
                    $comentario->load('comenta.docente');
                  }else{
                    $comentario->load('comenta.alumno');
                  }
                  return $comentario;
                });
                return view('alumno.infotareaenviado', compact('tarea'));
            } else {
                return redirect('alumno/tareas');;
            }
        } else {
            return redirect('alumno/tareas');;
        }
    }

    public function info_vencido($id_tarea)
    {
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();
        if (!is_null($alumno) && !empty($alumno)) {
            $tarea = App\Tarea_d::where([
                ['id_tarea', '=', $id_tarea],
                ['estado', '=', 1],
                ['t_fecha_hora_entrega', '<=', date('Y-m-d H:i:s')]
            ])->first();
            if (!is_null($tarea) && !empty($tarea)) {
                //comprobamos si la tarea pertenece al alumno
                $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                    'alumno_d.estado' => 1,
                    'alumno_tarea_respuesta_p.c_estado' => 'APEN',
                    'alumno_d.id_alumno' => $alumno->id_alumno
                ])->first();

                if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                  $tarea->comentarios = $tarea->comentarios()->where('comentario_d.estado','=',1)->orderBy('created_at','DESC')->get();
                  $tarea->comentarios = $tarea->comentarios->map(function ($comentario){
                    if(!is_null($comentario->comenta->id_docente)){
                      $comentario->load('comenta.docente');
                    }else{
                      $comentario->load('comenta.alumno');
                    }
                    return $comentario;
                  });
                  //enviamos una alerta simple al docente, de que un alumno abrio una tarea que ya se venció.
                  $colegio = $alumno_de_tarea->seccion->grado->colegio;
                  $title = 'Tarea abierta fuera de plazo';
                  $text = '';
                  $type = 'info';
                  $timeout = 5000;
                  $icon = '/assets/images/colegio/school.png';
                  if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                    $icon = '/super/colegio/logo/'.$colegio->c_logo;
                  }
                  $text = $alumno_de_tarea->c_nombre. ' ha abierto la tarea "'.$tarea->c_titulo.'"';
                  broadcast(new AlertSimple([$tarea->docente->usuario->id],$title,$text,$type,$timeout,$icon));
                  return view('alumno.infotareavencido', compact('tarea'));
                } else {
                    return redirect('alumno/tareas');;
                }
            } else {
                return redirect('alumno/tareas');
            }
        } else {
            return redirect('alumno/tareas');
        }
    }

    public function responder(Request $request)
    {
        $request->validate([
            'preid_tarea' => 'required|numeric',
            'preobservacion'=> 'required',
        ]);

        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if(!is_null($alumno) && !empty($alumno)){
              $tarea = App\Tarea_d::where([
                  'id_tarea' => $request->input('preid_tarea'),
                  'estado' => 1
              ])->first();

              if(!is_null($tarea) && !empty($tarea)){
                //comprobamos si la tarea pertenece al alumno
                $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                    'alumno_d.estado' => 1,
                    'alumno_tarea_respuesta_p.c_estado' => 'APEN',
                    'alumno_d.id_alumno' => $alumno->id_alumno
                ])->first();

                if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                    //creamos la respuesta
                    $respuesta = new App\Respuesta_d;
                    $respuesta->c_observacion = $request->input('preobservacion');
                    $respuesta->creador = $usuarioAlumno->id;
                    $respuesta->save();
                    DB::table('alumno_tarea_respuesta_p')
                        ->where([
                            'id_tarea' => $tarea->id_tarea,
                            'id_alumno' => $alumno->id_alumno,
                        ])
                        ->update([
                            'id_respuesta' => $respuesta->id_respuesta,
                            'c_estado' => 'AENV',
                            'updated_at' => date('Y-m-d H:i:s'),
                            'modificador' => $usuarioAlumno->id
                        ]);
                    //enviamos una notificacion al docente
                    $usuarioDocente = $tarea->docente->usuario;
                    \Notification::send($usuarioDocente, new NuevaTareaParaAlumnoNotification(array(
                        'titulo' => 'Respuesta de '.$alumno->c_nombre.' a la tarea '.$tarea->c_titulo,
                        'mensaje' =>$respuesta->c_observacion,
                        'url' => '/docente/tarea/' . $tarea->id_tarea,
                        'tipo' => 'respuestaatarea',
                        'respuesta' => $respuesta
                    )));
                    //obtenemos los alumnos asignados de la tarea
                    $alumnos_asignados = $tarea->alumnos_asignados()->where([
                      ['alumno_d.id_alumno','<>',$alumno->id_alumno],
                      ['alumno_d.estado','=',1]
                    ])->get();
                    $id_usuarios = array();
                    foreach($alumnos_asignados as $item_alumno){
                      $id_usuarios[] = $item_alumno->usuario->id;
                    }
                    //Enviamos una alerta simple a los companieros del alumno que esta respondiendo
                    $colegio = $alumno->seccion->grado->colegio;
                    $title = 'Respuesta enviada de compañero(a)';
                    $text = '';
                    $type = 'info';
                    $timeout = 10000;
                    $icon = '/assets/images/colegio/school.png';
                    if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                      $icon = '/super/colegio/logo/'.$colegio->c_logo;
                    }
                    $text = $alumno->c_nombre. ' envió su respuesta de la tarea "'.$tarea->c_titulo.'"';
                    if(count($id_usuarios)>0){
                        broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));    
                    }
                    return redirect('/alumno/tareas');
                }
              }
        }
        return redirect('/home');
    }
    public function generar_respuesta(Request $request){
      $request->validate([
          'preid_tarea' => 'required|numeric',
          'preobservacion'=> 'required',
      ]);

      $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
      $alumno = App\Alumno_d::where([
          'id_alumno' => $usuarioAlumno->id_alumno,
          'estado' => 1
      ])->first();

      if(!is_null($alumno) && !empty($alumno)){
        $tarea = App\Tarea_d::where([
            'id_tarea' => $request->input('preid_tarea'),
            'estado' => 1
        ])->first();
        if(!is_null($tarea) && !empty($tarea)){
          //comprobamos si la tarea pertenece al alumno
          $alumno_de_tarea = $tarea->alumnos_asignados()->where([
              'alumno_d.estado' => 1,
              'alumno_tarea_respuesta_p.c_estado' => 'APEN',
              'alumno_d.id_alumno' => $alumno->id_alumno
          ])->first();
          if(!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)){
            $g_id_respuesta = $request->input('g_id_respuesta');
            if(!is_null($g_id_respuesta) && !empty($g_id_respuesta)){
              $respuesta = App\Respuesta_d::where([
                  'id_respuesta' => $g_id_respuesta,
                  'estado' => 0
              ])->first();
              if(!is_null($respuesta) && !empty($respuesta)){
                $archivo = $request->file('qqfile');
                if(!is_null($archivo) && !empty($archivo)){
                  $archivo_respuesta = new App\Archivo_respuesta_d;
                  $archivo_respuesta->id_respuesta = $respuesta->id_respuesta;
                  $archivo_respuesta->c_url_archivo = '-';
                  $archivo_respuesta->estado = 0;
                  $archivo_respuesta->creador = Auth::user()->id;
                  $archivo_respuesta->save();
                  $nombre = $request->input('qqfilename');
                  $nombre = ("(".$respuesta->id_respuesta."-".$archivo_respuesta->id_archivo.date('s').")" . $nombre);
                  $archivo->storeAs('tarearespuesta/' . $tarea->id_tarea . '/'.$respuesta->id_respuesta.'/',$nombre);
                  $archivo_respuesta->c_url_archivo = $nombre;
                  $archivo_respuesta->save();
                }
                $datos = array(
                    'success' => TRUE,
                    'id_respuesta' => $respuesta->id_respuesta,
                );
                return response()->json($datos);
              }
              return response()->json(['success' => FALSE,'id_respuesta' => '']);
            }else{
              //creamos una respuesta como inactiva
              $respuesta = new App\Respuesta_d;
              $respuesta->c_observacion = $request->input('preobservacion');
              $respuesta->estado = 0;
              $respuesta->creador = $usuarioAlumno->id;
              $respuesta->save();
              //verificamos si hay algun archivo
              $archivo = $request->file('qqfile');
              if(!is_null($archivo) && !empty($archivo)){
                $nombre = $request->input('qqfilename');
                $nombre = ("(".$respuesta->id_respuesta."-".date('s').")" . $nombre);
                $archivo->storeAs('tarearespuesta/' . $tarea->id_tarea . '/'.$respuesta->id_respuesta.'/',$nombre);
                $respuesta->c_url_archivo = $nombre;
                $respuesta->save();
              }
              return response()->json(['success' => TRUE,'id_respuesta' => $respuesta->id_respuesta]);
            }
          }
        }
      }
      return response()->json(['success' => FALSE]);
    }
    public function confirmar_respuesta(Request $request){
      $this->validate($request,[
        'id_tarea' => 'required|numeric',
        'id_respuesta' => 'required|numeric'
      ]);

      $alumno = App\Alumno_d::where([
        'id_alumno' => Auth::user()->id_alumno,
        'estado' => 1
      ])->first();
      if(!is_null($alumno) && !empty($alumno)){
        $tarea = App\Tarea_d::where([
            'id_tarea' => $request->input('id_tarea'),
            'estado' => 1
        ])->first();
        if(!is_null($tarea) && !empty($tarea)){
          //comprobamos si la tarea pertenece al alumno
          $alumno_de_tarea = $tarea->alumnos_asignados()->where([
              'alumno_d.estado' => 1,
              'alumno_tarea_respuesta_p.c_estado' => 'APEN',
              'alumno_d.id_alumno' => $alumno->id_alumno
          ])->first();
          if(!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)){
            //obtenemos la respuesta
            $respuesta = App\Respuesta_d::where([
              'id_respuesta' => $request->input('id_respuesta'),
              'estado' => 0
            ])->first();
            if(!is_null($respuesta) && !empty($respuesta)){

              //actualizamos los Archivos
              DB::table('archivo_respuesta_d')
              ->where([
                'id_respuesta' => $respuesta->id_respuesta,
                'estado' => 0
              ])->update(['estado' => 1]);

              //actualizamos la respuesta
              $respuesta->estado = 1;
              $respuesta->save();

              //relacionamos la respuesta a la tarea
              DB::table('alumno_tarea_respuesta_p')
                  ->where([
                      'id_tarea' => $tarea->id_tarea,
                      'id_alumno' => $alumno->id_alumno,
                  ])
                  ->update([
                      'id_respuesta' => $respuesta->id_respuesta,
                      'c_estado' => 'AENV',
                      'updated_at' => date('Y-m-d H:i:s'),
                      'modificador' => Auth::user()->id
                  ]);

                  //enviamos una notificacion al docente
                  $usuarioDocente = $tarea->docente->usuario;
                  \Notification::send($usuarioDocente, new NuevaTareaParaAlumnoNotification(array(
                      'titulo' => 'Respuesta de '.$alumno->c_nombre.' a la tarea '.$tarea->c_titulo,
                      'mensaje' =>$respuesta->c_observacion,
                      'url' => '/docente/tarea/' . $tarea->id_tarea,
                      'tipo' => 'respuestaatarea',
                      'respuesta' => $respuesta
                  )));

                  //obtenemos los alumnos asignados de la tarea
                  $alumnos_asignados = $tarea->alumnos_asignados()->where([
                    ['alumno_d.id_alumno','<>',$alumno->id_alumno],
                    ['alumno_d.estado','=',1]
                  ])->get();
                  $id_usuarios = array();
                  foreach($alumnos_asignados as $item_alumno){
                    $id_usuarios[] = $item_alumno->usuario->id;
                  }
                  //enviamos una alerta simple a los companieros de que el alumno ya envio su respuesta
                  $colegio = $alumno->seccion->grado->colegio;
                  $title = 'Respuesta enviada de compañero(a)';
                  $text = '';
                  $type = 'info';
                  $timeout = 10000;
                  $icon = '/assets/images/colegio/school.png';
                  if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                    $icon = '/super/colegio/logo/'.$colegio->c_logo;
                  }
                  $text = $alumno->c_nombre. ' envió su respuesta de la tarea "'.$tarea->c_titulo.'"';
                  broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));

                  return response()->json(['correcto' => TRUE]);
              }
          }
        }
      }
      return response()->json(['correcto' => FALSE]);
    }
    public function editar_respuesta(Request $request)
    {
        $request->validate([
            'preid_tarea' => 'required|numeric',
            'preid_respuesta' => 'required|numeric',
            'preobservacion'=> 'required',
        ]);
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();
        if(!is_null($alumno) && !empty($alumno)){
          //aplicando la tarea
          $tarea = App\Tarea_d::where([
              'id_tarea' => $request->input('preid_tarea'),
              'estado' => 1
          ])->first();
          if(!is_null($tarea) && !empty($tarea)){
            //comprobamos si la tarea pertenece al alumno
            $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                'alumno_d.estado' => 1,
                'alumno_tarea_respuesta_p.c_estado' => 'AENV',
                'alumno_d.id_alumno' => $alumno->id_alumno
            ])->first();

            if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                $respuesta = App\Respuesta_d::findOrFail($request->input('preid_respuesta'));
                $respuesta->c_observacion = $request->input('preobservacion');
                $respuesta->modificador = $usuarioAlumno->id;
                $respuesta->c_url_archivo = null;
                $respuesta->save();
                DB::table('archivo_respuesta_d')->where('id_respuesta', '=', $respuesta->id_respuesta)->delete();
                return redirect('/alumno/tareaenviada/' . $request->input('preid_tarea'));
            }
          }
        }
        return redirect('/home');
    }
    public function editar_respuesta_generado(Request $request){
      $request->validate([
          'preid_tarea' => 'required|numeric',
          'preid_respuesta' => 'required|numeric',
          'preobservacion'=> 'required',
      ]);
      $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
      $alumno = App\Alumno_d::where([
          'id_alumno' => $usuarioAlumno->id_alumno,
          'estado' => 1
      ])->first();
      if(!is_null($alumno) && !empty($alumno)){
        //aplicando la tarea
        $tarea = App\Tarea_d::where([
            'id_tarea' => $request->input('preid_tarea'),
            'estado' => 1
        ])->first();
        if(!is_null($tarea) && !empty($tarea)){
          //comprobamos si la tarea pertenece al alumno
          $alumno_de_tarea = $tarea->alumnos_asignados()->where([
              'alumno_d.estado' => 1,
              'alumno_tarea_respuesta_p.c_estado' => 'AENV',
              'alumno_d.id_alumno' => $alumno->id_alumno
          ])->first();
          if(!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)){
            $g_id_respuesta = $request->input('g_id_respuesta');
            if(!is_null($g_id_respuesta) && !empty($g_id_respuesta)){
              $respuesta = App\Respuesta_d::where([
                  'id_respuesta' => $g_id_respuesta,
                  'estado' => 0
              ])->first();
              if(!is_null($respuesta) && !empty($respuesta)){
                $archivo = $request->file('qqfile');
                if(!is_null($archivo) && !empty($archivo)){
                  $archivo_respuesta = new App\Archivo_respuesta_d;
                  $archivo_respuesta->id_respuesta = $respuesta->id_respuesta;
                  $archivo_respuesta->c_url_archivo = '-';
                  $archivo_respuesta->estado = 0;
                  $archivo_respuesta->creador = Auth::user()->id;
                  $archivo_respuesta->save();
                  $nombre = $request->input('qqfilename');
                  $nombre = ("(".$respuesta->id_respuesta."-".$archivo_respuesta->id_archivo.date('s').")" . $nombre);
                  $archivo->storeAs('tarearespuesta/' . $tarea->id_tarea . '/'.$respuesta->id_respuesta.'/',$nombre);
                  $archivo_respuesta->c_url_archivo = $nombre;
                  $archivo_respuesta->save();
                }
                $datos = array(
                    'success' => TRUE,
                    'id_respuesta' => $respuesta->id_respuesta,
                );
                return response()->json($datos);
              }
              return response()->json(['success' => FALSE,'id_respuesta' => '']);
            }else{
              //editamos la respuesta
              $respuesta = App\Respuesta_d::findOrFail($request->input('preid_respuesta'));
              $respuesta->c_observacion = $request->input('preobservacion');
              $respuesta->estado = 0;
              $respuesta->modificador = $usuarioAlumno->id;
              $respuesta->save();
              //verificamos si hay algun archivo
              $archivo = $request->file('qqfile');
              if(!is_null($archivo) && !empty($archivo)){
                $nombre = $request->input('qqfilename');
                $nombre = ("(".$respuesta->id_respuesta."-".date('s').")" . $nombre);
                $archivo->storeAs('tarearespuesta/' . $tarea->id_tarea . '/'.$respuesta->id_respuesta.'/',$nombre);
                $respuesta->c_url_archivo = $nombre;
                $respuesta->save();
                DB::table('archivo_respuesta_d')->where('id_respuesta', '=', $respuesta->id_respuesta)->delete();
              }
              return response()->json(['success' => TRUE,'id_respuesta' => $respuesta->id_respuesta]);
            }
          }
        }
      }
      return response()->json(['success' => FALSE]);
    }
    public function confirmar_respuesta_editado(Request $request){
      $this->validate($request,[
        'id_tarea' => 'required|numeric',
        'id_respuesta' => 'required|numeric'
      ]);
      $alumno = App\Alumno_d::where([
        'id_alumno' => Auth::user()->id_alumno,
        'estado' => 1
      ])->first();
      if(!is_null($alumno) && !empty($alumno)){
        $tarea = App\Tarea_d::where([
            'id_tarea' => $request->input('id_tarea'),
            'estado' => 1
        ])->first();
        if(!is_null($tarea) && !empty($tarea)){
          //comprobamos si la tarea pertenece al alumno
          $alumno_de_tarea = $tarea->alumnos_asignados()->where([
              'alumno_d.estado' => 1,
              'alumno_tarea_respuesta_p.c_estado' => 'AENV',
              'alumno_d.id_alumno' => $alumno->id_alumno
          ])->first();
          if(!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)){
            //obtenemos la respuesta
            $respuesta = App\Respuesta_d::where([
              'id_respuesta' => $request->input('id_respuesta'),
              'estado' => 0
            ])->first();
            if(!is_null($respuesta) && !empty($respuesta)){

              //actualizamos los Archivos
              DB::table('archivo_respuesta_d')
              ->where([
                'id_respuesta' => $respuesta->id_respuesta,
                'estado' => 0
              ])->update(['estado' => 1]);
                //actualizamos la respuesta
                $respuesta->estado = 1;
                $respuesta->save();
                  //enviamos una notificacion al docente
                  $usuarioDocente = $tarea->docente->usuario;
                  \Notification::send($usuarioDocente, new NuevaTareaParaAlumnoNotification(array(
                      'titulo' => $alumno->c_nombre.' editó su respuesta de la tarea '.$tarea->c_titulo,
                      'mensaje' =>$respuesta->c_observacion,
                      'url' => '/docente/tarea/' . $tarea->id_tarea,
                      'tipo' => 'respuestaatarea',
                      'respuesta' => $respuesta
                  )));

                  return response()->json(['correcto' => TRUE]);
              }
          }
        }
      }
      return response()->json(['correcto' => FALSE]);
    }
    public function comentar_pendiente(Request $request)
    {
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();
        if (!is_null($alumno) && !empty($alumno)) {
            //aplicando la tarea
            $tarea = App\Tarea_d::where([
                'id_tarea' => $request->input('id_tarea'),
                'estado' => 1
            ])->first();

            //comprobamos si la tarea pertenece al alumno
            $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                'alumno_d.estado' => 1,
                'alumno_tarea_respuesta_p.c_estado' => 'APEN',
                'alumno_d.id_alumno' => $alumno->id_alumno
            ])->first();

            if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                //agregamos el comentario
                $comentario = new App\Comentario_d;
                $comentario->id_tarea = $tarea->id_tarea;
                $comentario->id_usuario = $usuarioAlumno->id;
                $comentario->c_descripcion = $request->input('comentario');
                $id_referencia =  $request->input('id_comentario_referncia');
                if (!is_null($id_referencia) && !empty($id_referencia)) {
                    $ref_com = App\Comentario_d::findOrFail($id_referencia);
                    $comentario->id_comentario_referencia = $ref_com->id_comentario;
                }
                $comentario->creador = $usuarioAlumno->id;
                $comentario->save();
                //alerta simple de un comentario nuevo
                $title = 'Nuevo comentario en la tarea "'.$tarea->c_titulo.'"';
                $text = '';
                $type = 'info';
                $timeout = 10000;
                $icon = '';
                if(!is_null($alumno_de_tarea->c_foto) && !empty($alumno_de_tarea->c_foto)){
                  $icon = '/super/alumno/foto/'.$alumno_de_tarea->c_foto;
                }else{
                  if(strtoupper($alumno_de_tarea->c_sexo)=='M'){
                      $icon = '/assets/images/usuario/studentman.png';
                  }else{
                      $icon = '/assets/images/usuario/studentwoman.png';
                  }
                }
                $text = $comentario->c_descripcion;
                $alumnos_asignados = $tarea->alumnos_asignados()->where([
                  ['alumno_d.id_alumno','<>',$alumno_de_tarea->id_alumno],
                  ['alumno_d.estado','=',1]
                ])->get();
                $id_usuarios = array($tarea->docente->usuario->id);
                foreach($alumnos_asignados as $item_alumno){
                  $id_usuarios[] = $item_alumno->usuario->id;
                }
                $comentario->load('comenta.alumno');
                broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));
                broadcast(new NewCommentTask($comentario));
                return response()->json([
                  'correcto' => TRUE,
                  'comentario' => $comentario
                ]);
            }
        }
        return response()->json(['correcto' => FALSE]);
    }

    public function comentar_vencido(Request $request)
    {

        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if (!is_null($alumno) && !empty($alumno)) {
            //aplicando la tarea
            $tarea = App\Tarea_d::where([
                ['id_tarea', '=', $request->input('id_tarea')],
                ['estado', '=', 1],
                ['t_fecha_hora_entrega', '<=', date('Y-m-d H:i:s')]
            ])->first();

            if (!is_null($tarea) && !empty($tarea)) {

                //comprobamos si la tarea pertenece al alumno
                $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                    'alumno_d.estado' => 1,
                    'alumno_tarea_respuesta_p.c_estado' => 'APEN',
                    'alumno_d.id_alumno' => $alumno->id_alumno
                ])->first();

                if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                    //agregamos el comentario
                    $comentario = new App\Comentario_d;
                    $comentario->id_tarea = $tarea->id_tarea;
                    $comentario->id_usuario = $usuarioAlumno->id;
                    $comentario->c_descripcion = $request->input('comentario');
                    $id_referencia =  $request->input('id_comentario_referncia');
                    if (!is_null($id_referencia) && !empty($id_referencia)) {
                        $ref_com = App\Comentario_d::findOrFail($id_referencia);
                        $comentario->id_comentario_referencia = $ref_com->id_comentario;
                    }
                    $comentario->creador = $usuarioAlumno->id;
                    $comentario->save();

                    //alerta simple de un comentario nuevo
                    $title = 'Nuevo comentario en la tarea "'.$tarea->c_titulo.'"';
                    $text = '';
                    $type = 'info';
                    $timeout = 10000;
                    $icon = '';
                    if(!is_null($alumno_de_tarea->c_foto) && !empty($alumno_de_tarea->c_foto)){
                      $icon = '/super/alumno/foto/'.$alumno_de_tarea->c_foto;
                    }else{
                      if(strtoupper($alumno_de_tarea->c_sexo)=='M'){
                          $icon = '/assets/images/usuario/studentman.png';
                      }else{
                          $icon = '/assets/images/usuario/studentwoman.png';
                      }
                    }
                    $text = $comentario->c_descripcion;
                    $alumnos_asignados = $tarea->alumnos_asignados()->where([
                      ['alumno_d.id_alumno','<>',$alumno_de_tarea->id_alumno],
                      ['alumno_d.estado','=',1]
                    ])->get();
                    $id_usuarios = array($tarea->docente->usuario->id);
                    foreach($alumnos_asignados as $item_alumno){
                      $id_usuarios[] = $item_alumno->usuario->id;
                    }
                    $comentario->load('comenta.alumno');
                    broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));
                    broadcast(new NewCommentTask($comentario));
                    return response()->json([
                      'correcto' => TRUE,
                      'comentario' => $comentario
                    ]);
                }
            }
        }
        return response()->json(['correcto'=> FALSE]);
    }

    public function comentar_enviado(Request $request)
    {
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();

        if (!is_null($alumno) && !empty($alumno)) {
            //aplicando la tarea
            $tarea = App\Tarea_d::where([
                'id_tarea' => $request->input('id_tarea'),
                'estado' => 1
            ])->first();
            if(!is_null($tarea) && !empty($tarea)){
              //comprobamos si la tarea pertenece al alumno
              $alumno_de_tarea = $tarea->alumnos_asignados()->where([
                  'alumno_d.estado' => 1,
                  'alumno_tarea_respuesta_p.c_estado' => 'AENV',
                  'alumno_d.id_alumno' => $alumno->id_alumno
              ])->first();

              if (!is_null($alumno_de_tarea) && !empty($alumno_de_tarea)) {
                  //agregamos el comentario
                  $comentario = new App\Comentario_d;
                  $comentario->id_tarea = $tarea->id_tarea;
                  $comentario->id_usuario = $usuarioAlumno->id;
                  $comentario->c_descripcion = $request->input('comentario');
                  $id_referencia =  $request->input('id_comentario_referncia');
                  if (!is_null($id_referencia) && !empty($id_referencia)) {
                      $ref_com = App\Comentario_d::findOrFail($id_referencia);
                      $comentario->id_comentario_referencia = $ref_com->id_comentario;
                  }
                  $comentario->creador = $usuarioAlumno->id;
                  $comentario->save();

                  //alerta simple de un comentario nuevo
                  $title = 'Nuevo comentario en la tarea "'.$tarea->c_titulo.'"';
                  $text = '';
                  $type = 'info';
                  $timeout = 10000;
                  $icon = '';
                  if(!is_null($alumno_de_tarea->c_foto) && !empty($alumno_de_tarea->c_foto)){
                    $icon = '/super/alumno/foto/'.$alumno_de_tarea->c_foto;
                  }else{
                    if(strtoupper($alumno_de_tarea->c_sexo)=='M'){
                        $icon = '/assets/images/usuario/studentman.png';
                    }else{
                        $icon = '/assets/images/usuario/studentwoman.png';
                    }
                  }
                  $text = $comentario->c_descripcion;
                  $alumnos_asignados = $tarea->alumnos_asignados()->where([
                    ['alumno_d.id_alumno','<>',$alumno_de_tarea->id_alumno],
                    ['alumno_d.estado','=',1]
                  ])->get();
                  $id_usuarios = array($tarea->docente->usuario->id);
                  foreach($alumnos_asignados as $item_alumno){
                    $id_usuarios[] = $item_alumno->usuario->id;
                  }
                  $comentario->load('comenta.alumno');
                  broadcast(new AlertSimple($id_usuarios,$title,$text,$type,$timeout,$icon));
                  broadcast(new NewCommentTask($comentario));
                  return response()->json([
                    'correcto' => TRUE,
                    'comentario' => $comentario
                  ]);
              }
            }
        }
        return response()->json(['correcto' => TRUE]);
    }
    public function respuesta(Request $request)
    {
        $respuesta = App\Respuesta_d::findOrFail($request->input('id_respuesta'));

        return "Todo muy bien hasta ahora";
        return response()->json($respuesta);
    }
    public function descargar_archivo($id_tarea, $id_respuesta,$filename)
    {
        $tarea = App\Tarea_d::findOrFail($id_tarea);
        $respuesta = App\Respuesta_d::findOrFail($id_respuesta);
        return Storage::download('tarearespuesta/' . $tarea->id_tarea . '/' . $respuesta->id_respuesta . '/' . $filename);
    }
}
