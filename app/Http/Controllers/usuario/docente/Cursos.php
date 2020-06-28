<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;
use Auth;

class Cursos extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        $cursos_del_docente = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->join('seccion_categoria_docente_p','seccion_categoria_p.id_seccion_categoria','=','seccion_categoria_docente_p.id_seccion_categoria')
            ->select('seccion_categoria_p.id_seccion_categoria',
                    'categoria_d.id_categoria', 'categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso',
                    'seccion_d.id_seccion', 'seccion_d.c_nombre as nom_seccion',
                    'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['seccion_categoria_docente_p.id_docente' => $docente->id_docente,
                'categoria_d.estado' => 1,
                'seccion_d.estado' => 1,
                'grado_m.estado' => 1,
                'seccion_categoria_p.estado' => 1,
                'seccion_categoria_docente_p.estado' => 1])
            ->orderBy('nom_nivel')
            ->orderBy('nom_grado')
            ->orderBy('nom_curso')
        ->get();

        /*$comunicados = DB::table('comunicado_d')
            ->select ('comunicado_d.*')
            ->where(['comunicado_d.estado' => 1, 'comunicado_d.id_colegio' => $docente->id_colegio])
            ->orderBy('comunicado_d.created_at', 'DESC')
        ->get();*/
        $comunicados = App\Comunicado_d::where([
          'estado' => 1,
          'id_colegio' => $docente->id_colegio
        ])->orderBy('created_at','DESC')->get();

        $comunicados_all = DB::table('comunicado_d')
            ->select ('comunicado_d.*')
            ->where(['comunicado_d.id_colegio' => $docente->id_colegio])
            ->orderBy('comunicado_d.created_at', 'DESC')
        ->get();

        $anuncios_seccion = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->select ('anuncio_d.*', 'seccion_d.c_nombre  as nom_seccion', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.estado' => 1,'grado_m.estado' => 1,'anuncio_d.creador' => Auth::user()->id])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        $anuncios_seccion_all = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->select ('anuncio_d.*', 'seccion_d.c_nombre  as nom_seccion', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.estado' => 1,'grado_m.estado' => 1,'anuncio_d.creador' => Auth::user()->id])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return view('docente.cursos', compact('cursos_del_docente', 'comunicados', 'comunicados_all', 'anuncios_seccion', 'anuncios_seccion_all'));
    }

    public function curso($id_curso){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        $curso = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->join('seccion_categoria_docente_p','seccion_categoria_p.id_seccion_categoria','=','seccion_categoria_docente_p.id_seccion_categoria')
            ->join('docente_d','seccion_categoria_docente_p.id_docente','=','docente_d.id_docente')
            ->select('seccion_categoria_p.id_seccion_categoria',
                    'categoria_d.id_categoria', 'categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso',
                    'seccion_d.id_seccion', 'seccion_d.c_nombre as nom_seccion',
                    'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
            ->where(['seccion_categoria_p.id_seccion_categoria' => $id_curso, 'seccion_categoria_docente_p.id_docente' => $docente->id_docente,
            'categoria_d.estado' => 1,
            'seccion_d.estado' => 1,
            'grado_m.estado' => 1,
            'seccion_categoria_p.estado' => 1,
            'seccion_categoria_docente_p.estado' => 1])
        ->first();

        //Módulos del curso (seccion - categoria)
        $modulos = DB::table('modulo_d')
            ->select('modulo_d.*')
            ->where(['modulo_d.id_seccion_categoria' => $curso->id_seccion_categoria, 'modulo_d.estado' => 1])
            ->orderBy('modulo_d.id_modulo', 'ASC')
        ->get();

        //Anuncios para sección
        $anuncios_seccion = DB::table('anuncio_d')
            ->join('seccion_d','anuncio_d.id_seccion','=','seccion_d.id_seccion')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_d.id_seccion' => $curso->id_seccion])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        //Anuncios para curso
        $anuncios_curso = DB::table('anuncio_d')
            ->join('seccion_categoria_p','anuncio_d.id_seccion_categoria','=','seccion_categoria_p.id_seccion_categoria')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1, 'seccion_categoria_p.id_seccion_categoria' => $curso->id_seccion_categoria])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        //Archivos
        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.estado' => 1])
            ->orderBy('archivo_d.id_archivo','ASC')
        ->get();

        //Alumnos de curso - sección (seccion-categoria)
        $alumnosseccion = DB::table('alumno_d')
            ->select('alumno_d.*')
            ->where(['alumno_d.id_seccion' => $curso->id_seccion, 'alumno_d.estado' => 1])
            ->orderBy('alumno_d.c_nombre', 'ASC')
        ->get();

        //Tareas en general
        $tareas = App\Tarea_d::where([
            'id_docente' => $docente->id_docente,
            'id_categoria' => $curso->id_categoria,
            'estado' => 1])
            ->orderBy('created_at', 'DESC')
        ->get();

        //Tareas calificadas
        $tareas_calificadas = $docente->tareas()->where([
            'tarea_d.c_estado' => 'DCAL',
            'tarea_d.estado' => 1
            ])->orderBy('tarea_d.created_at', 'DESC')
        ->get();

        //Tareas pendientes
        $tareas_pendientes = $docente->tareas()->where([
            ['tarea_d.c_estado','<>','DCAL'],
            ['tarea_d.id_categoria','=',$curso->id_categoria],
            ['tarea_d.t_fecha_hora_entrega', '<=',date('Y-m-d H:i:s')]
            ])->orderBy('tarea_d.created_at','DESC')
        ->get();

         return view('docente.curso', compact('docente','curso', 'modulos', 'anuncios_seccion', 'anuncios_curso', 'archivos', 'alumnosseccion', 'tareas', 'tareas_calificadas', 'tareas_pendientes'));
    }

    public function crear_modulo(Request $Request){
        $modulo = new App\Modulo_d;
        $modulo->id_seccion_categoria = $Request->id_seccion_categoria;
        $modulo->c_nombre = $Request->c_nombre;
        $modulo->creador = Auth::user()->id;
        $modulo->save();

        $modulos = DB::table('modulo_d')
        ->select('modulo_d.*')
        ->where(['modulo_d.id_seccion_categoria' => $Request->id_seccion_categoria, 'modulo_d.estado' => 1])
        ->get();

        return  response()->json($modulos);
    }

    public function actualizar_modulo(Request $Request){
        $modulo = App\Modulo_d::findOrFail($Request->id_modulo);
        $modulo->c_nombre = $Request->c_nombre;
        $modulo->modificador = Auth::user()->id;
        $modulo->save();

        $modulos = DB::table('modulo_d')
        ->select('modulo_d.*')
        ->where(['modulo_d.id_seccion_categoria' => $Request->id_seccion_categoria, 'modulo_d.estado' => 1])
        ->get();

        return  response()->json($modulos);
    }

    public function eliminar_modulo(Request $Request){
        $modulo = App\Modulo_d::findOrFail($Request->id_modulo);
        $modulo->estado = 0;
        $modulo->modificador = Auth::user()->id;
        $modulo->save();

        Storage::deleteDirectory('archivos/'. $Request->id_modulo);

        $modulos = DB::table('modulo_d')
            ->select('modulo_d.*')
            ->where(['modulo_d.id_seccion_categoria' => $Request->id_seccion_categoria, 'modulo_d.estado' => 1])
        ->get();

        return  response()->json($modulos);
    }

    public function agregar_archivo(Request $Request){
        $archivo = new App\Archivo_d;
        $archivo->id_modulo = $Request->input('id_m_key');
        $archivo->c_nombre = $Request->input('nombre_archivo');

        $TMP = $Request->file('el_archivo');

        if (!is_null($TMP) && !empty($TMP)) {
            $nombre = $TMP->getClientOriginalName();
            $TMP->storeAs('archivos/'.$Request->input('id_m_key').'/', $nombre);
            $archivo->c_url = $nombre;
        }

        $archivo->c_link = $Request->input('url_archivo');
        $archivo->creador = Auth::user()->id;
        $archivo->save();

        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.id_modulo' => $Request->id_modulo, 'archivo_d.estado' => 1])
        ->get();

        return  response()->json($archivos);
    }

    public function eliminar_archivo(Request $Request){

        $archivo = App\Archivo_d::where(['id_archivo' => $Request->id_archivo])->first();
        Storage::delete('archivos/'. $Request->id_modulo .'/'. $archivo->c_url);
        DB::table('archivo_d')->where(['id_archivo' => $Request->id_archivo])->delete();

        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.id_modulo' => $Request->id_modulo, 'archivo_d.estado' => 1])
        ->get();

        return  response()->json($archivos);
    }

    public function descargar_archivo($id_archivo){
        $archivo = App\Archivo_d::findOrFail($id_archivo);
        return Storage::download('archivos/' . $archivo->id_modulo . '/' . $archivo->c_url);
    }

    public function crear_anuncio(Request $Request){

        $anuncio = new App\Anuncio_d;

        $COD = $Request->c_para;

        if ($COD == '1') {
            $anuncio->id_seccion = -1;
            $anuncio->id_seccion_categoria = $Request->isc;
        } else {
            $anuncio->id_seccion = $Request->is;
            $anuncio->id_seccion_categoria = -1;
        }

        $anuncio->c_titulo = $Request->c_titulo;
        $anuncio->c_url_archivo = $Request->c_url_archivo;
        $anuncio->creador = Auth::user()->id;
        $anuncio->save();

        $alumnos_asignados = App\Alumno_d::where(['alumno_d.estado' => 1, 'alumno_d.id_seccion' => $Request->is])->get();

        $id_usuarios = array();
        $i = 0;
        foreach ($alumnos_asignados as $alumno) {
            $id_usuarios[$i] = $alumno->usuario->id;
            $i++;
        }

        $usuarios_a_notificar = App\User::whereIn('id', $id_usuarios)->get();
        \Notification::send($usuarios_a_notificar, new NuevaTareaParaAlumnoNotification(array(
            'titulo' => $anuncio->c_titulo,
            'mensaje' => $anuncio->c_url_archivo,
            'url' => '/alumno/cursos/',
            'tipo' => 'anuncio',
            'anuncio'=> $anuncio
        )));

        $anuncios = DB::table('anuncio_d')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return response()->json($anuncios);
    }

    public function eliminar_anuncio(Request $Request){
        $anuncio = App\Anuncio_d::findOrFail($Request->id_anuncio);
        $anuncio->estado = 0;
        $anuncio->modificador = Auth::user()->id;
        $anuncio->save();

        $anuncios = DB::table('anuncio_d')
            ->select ('anuncio_d.*')
            ->where(['anuncio_d.estado' => 1])
            ->orderBy('anuncio_d.created_at', 'DESC')
        ->get();

        return response()->json($anuncios);
    }

    public function crear_tarea(Request $request){

        if($request->input('radioAlumnos')=='option1'){
                $request->validate([
                    'tarea_titulo'=> 'required',
                    'tarea_fecha_entrega' => 'required',
                ]);
        }else if($request->input('radioAlumnos')=='option2'){
                $request->validate([
                    'tarea_titulo'=> 'required',
                    'tarea_fecha_entrega' => 'required',
                    'alumnos' => 'required|array'
                ]);
        }else{
            return redirect('docente/cursos');
        }

        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();
        if(!is_null($docente) && !empty($docente)){
              $tarea_nueva = new App\Tarea_d;
              $tarea_nueva->id_docente = $docente->id_docente;
              $tarea_nueva->id_categoria = $request->input('id_categoria');
              $tarea_nueva->c_titulo = $request->input('tarea_titulo');
              $tarea_nueva->c_observacion = $request->input('tarea_desc');
              $fecha_hora_entrega = date('Y-m-d', strtotime($request->input('tarea_fecha_entrega'))) . ' ' . $request->input('tarea_hora_entrega');
              $tarea_nueva->t_fecha_hora_entrega = $fecha_hora_entrega;
              $tarea_nueva->c_estado = 'DENV';
              $tarea_nueva->creador = $usuarioDocente->id;
              $tarea_nueva->save();

              $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));
              $opcion_radio = $request->input('radioAlumnos');
              if ($opcion_radio == 'option1') {
                  foreach ($seccion->alumnos->where('estado', '=', 1) as $alumno) {
                      DB::table('alumno_tarea_respuesta_p')->insert(
                          ['id_tarea' => $tarea_nueva->id_tarea, 'id_alumno' => $alumno->id_alumno, 'c_estado' => 'APEN', 'creador' => $usuarioDocente->id]
                      );
                  }
              } else {
                  $alumnos = $request->input('alumnos');
                  for ($i = 0; $i < count($alumnos); $i++) {
                      DB::table('alumno_tarea_respuesta_p')->insert(
                          ['id_tarea' => $tarea_nueva->id_tarea, 'id_alumno' => $alumnos[$i], 'c_estado' => 'APEN', 'creador' => $usuarioDocente->id]
                      );
                  }
              }
              $search_tarea = App\Tarea_d::findOrFail($tarea_nueva->id_tarea);
              $alumnos_asignados = $search_tarea->alumnos_asignados()->select('alumno_d.id_alumno','alumno_d.c_nombre','alumno_d.c_telefono_representante1','alumno_d.c_telefono_representante2')->where('alumno_d.estado', '=', 1)->get();
              $id_usuarios = array();
              foreach ($alumnos_asignados as $alumno) {
                  $id_usuarios[] = $alumno->usuario->id;
              }
              $usuarios_a_notificar = App\User::whereIn('id', $id_usuarios)->get();
              \Notification::send($usuarios_a_notificar, new NuevaTareaParaAlumnoNotification(array(
                  'titulo' => 'Nueva tarea',
                  'mensaje' => $search_tarea->c_titulo,
                  'url' => '/alumno/tareapendiente/' . $search_tarea->id_tarea,
                  'tipo' => 'nuevatarea'
              )));
              //sms para los representantes
              //event(new NuevaTareaAsignada($alumnos_asignados,$docente->c_nombre));
              return response()->json($tarea_nueva);
        }
        return response()->json(['correcto' => FALSE,'message' => 'Errores al agregar tarea. Intenta de nuevo']);
    }
    public function generar_tarea(Request $request){
      $docente = App\Docente_d::findOrFail($request->input('id_docente'));
      if(!is_null($docente) && !empty($docente)){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        if($docente->id_docente==$usuarioDocente->id_docente){
          $g_id_tarea = $request->input('g_id_tarea');
          if(!is_null($g_id_tarea) && !empty($g_id_tarea)){
            $tarea = App\Tarea_d::where([
                'id_tarea' => $g_id_tarea,
                'id_docente' => $docente->id_docente,
                'estado' => 0
            ])->first();
            if(!is_null($tarea) && !empty($tarea)){
              $archivo = $request->file('qqfile');
              if (!is_null($archivo) && !empty($archivo)) {
                  $archivo_tarea = new App\Archivo_tarea_d;
                  $archivo_tarea->id_tarea = $tarea->id_tarea;
                  $archivo_tarea->c_url_archivo = '-';
                  $archivo_tarea->estado = 0;
                  $archivo_tarea->creador = Auth::user()->id;
                  $archivo_tarea->save();
                  $nombre = $request->input('qqfilename');
                  $nombre = ("(".$tarea->id_tarea."-".$archivo_tarea->id_archivo.date('s').")" . $nombre);
                  $archivo->storeAs('tareaasignacion/' . $tarea->id_tarea . '/', $nombre);
                  $archivo_tarea->c_url_archivo = $nombre;
                  $archivo_tarea->save();
              }
              $datos = array(
                  'success' => TRUE,
                  'id_tarea' => $tarea->id_tarea,
              );
              return response()->json($datos);
            }
            return response()->json(['success' => FALSE,'id_tarea' => '']);
          }else{
            $newtarea = new App\Tarea_d;
            $newtarea->id_categoria = $request->input('id_categoria');
            $newtarea->id_docente = $docente->id_docente;
            $newtarea->c_titulo = $request->input('tarea_titulo');
            $newtarea->c_observacion = $request->input('tarea_desc');
            $fecha_hora_entrega = date('Y-m-d', strtotime($request->input('tarea_fecha_entrega'))) . ' ' . $request->input('tarea_hora_entrega');
            $newtarea->t_fecha_hora_entrega = $fecha_hora_entrega;
            $newtarea->c_estado = 'DENV';
            $newtarea->estado = 0;
            $newtarea->creador = $usuarioDocente->id;
            $newtarea->save();
            //subida de archivos
            $archivo = $request->file('qqfile');
            if (!is_null($archivo) && !empty($archivo)) {
              $nombre = $request->input('qqfilename');
              $nombre = ("(".$newtarea->id_tarea."-".date('s').")" . $nombre);
              $archivo->storeAs('tareaasignacion/' . $newtarea->id_tarea . '/', $nombre);
              $newtarea->c_url_archivo = $nombre;
              $newtarea->save();
            }
            //obtenemos la seccion
            $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));
            //obtenemos el radio elegido
            $opcion_radio = $request->input('radioAlumnos');
            if ($opcion_radio == 'option1') {
                //asignamos la tareas a todos los alumnos de la seccion
                foreach ($seccion->alumnos->where('estado', '=', 1) as $alumno) {
                    DB::table('alumno_tarea_respuesta_p')->insert(
                        ['id_tarea' => $newtarea->id_tarea, 'id_alumno' => $alumno->id_alumno, 'c_estado' => 'APEN','estado' => 0 ,'creador' => $usuarioDocente->id]
                    );
                }
            } else {
                //asignamos tareas solo a algunos alumnos
                $alumnos = $request->input('alumnos');
                for ($i = 0; $i < count($alumnos); $i++) {
                    DB::table('alumno_tarea_respuesta_p')->insert(
                        ['id_tarea' => $newtarea->id_tarea, 'id_alumno' => $alumnos[$i], 'c_estado' => 'APEN', 'estado' => 0,'creador' => $usuarioDocente->id]
                    );
                }
            }
            return response()->json(['success' => TRUE,'id_tarea' => $newtarea->id_tarea ]);
          }
        }
      }
      return response()->json(['success' => FALSE]);
    }
    public function confirmar_tarea(Request $request){
      $docente = App\Docente_d::where([
        'id_docente' => Auth::user()->id_docente,
        'estado' => 1
      ])->first();
      if(!is_null($docente) && !empty($docente)){
        //obtenemos la tarea de ese docente
        $tarea = App\Tarea_d::where([
            'id_tarea' => $request->input('id_tarea'),
            'id_docente' => $docente->id_docente,
            'estado' => 0
        ])->first();
        if(!is_null($tarea) && !empty($tarea)){
          $tarea->estado = 1;
          $tarea->modificador = Auth::user()->id;
          $tarea->save();
          //actualizamos el detalle archivo
          DB::table('archivo_tarea_d')
              ->where('id_tarea','=',$tarea->id_tarea)
              ->update(['estado' => 1,'modificador' => Auth::user()->id]);

          DB::table('alumno_tarea_respuesta_p')
            ->where('id_tarea','=',$tarea->id_tarea)
            ->update(['estado' => 1,'modificador' => Auth::user()->id]);

            $search_tarea = App\Tarea_d::findOrFail($tarea->id_tarea);
            $alumnos_asignados = $search_tarea->alumnos_asignados()->select('alumno_d.id_alumno','alumno_d.c_nombre','alumno_d.c_telefono_representante1','alumno_d.c_telefono_representante2')->where('alumno_d.estado', '=', 1)->get();
            $id_usuarios = array();
            foreach ($alumnos_asignados as $alumno) {
                $id_usuarios[] = $alumno->usuario->id;
            }
            $usuarios_a_notificar = App\User::whereIn('id', $id_usuarios)->get();
            \Notification::send($usuarios_a_notificar, new NuevaTareaParaAlumnoNotification(array(
                'titulo' => 'Nueva tarea',
                'mensaje' => $search_tarea->c_titulo,
                'url' => '/alumno/tareapendiente/' . $search_tarea->id_tarea,
                'tipo' => 'nuevatarea'
            )));

          return response()->json(['correcto' => TRUE]);
        }
      }
      return response()->json(['correcto' => TRUE]);
    }
    public function comentarios(Request $request){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);

        $comentarios = DB::table('comentario_d')
            ->select('comentario_d.*')
            ->where(['comentario_d.estado' => 1, 'comentario_d.id_tarea' => $request->id_tarea])
            ->orderBy('comentario_d.created_at', 'DESC')
        ->get();

        $comentarios_docente = DB::table('comentario_d')
            ->join('users','comentario_d.id_usuario','=','users.id')
            ->join('docente_d','users.id_docente','=','docente_d.id_docente')
            ->select('comentario_d.*', 'docente_d.c_nombre as nom_docente', 'docente_d.*', 'users.id as id_usuario')
            ->where(['comentario_d.estado' => 1, 'comentario_d.id_tarea' => $request->id_tarea])
            ->orderBy('comentario_d.created_at', 'DESC')
        ->get();

        $comentarios_alumno = DB::table('comentario_d')
            ->join('users','comentario_d.id_usuario','=','users.id')
            ->join('alumno_d','users.id_alumno','=','alumno_d.id_alumno')
            ->select('comentario_d.*', 'alumno_d.c_nombre as nom_alumno', 'alumno_d.*', 'users.id as id_usuario')
            ->where(['comentario_d.estado' => 1, 'comentario_d.id_tarea' => $request->id_tarea])
            ->orderBy('comentario_d.created_at', 'DESC')
        ->get();

        return response()->json([
            'success' => true,
            'comentarios' => $comentarios,
            'comentarios_docente' => $comentarios_docente,
            'comentarios_alumno' => $comentarios_alumno,
        ], 200);
    }

    public function crear_comentario(Request $request){

        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        $tarea = App\Tarea_d::where([
            'id_tarea' => $request->id_tarea,
            'id_docente' => $docente->id_docente,
            'estado' => 1
        ])->first();

        if (!is_null($tarea) && !empty($tarea)) {
            $comentario = new App\Comentario_d;
            $comentario->id_tarea = $tarea->id_tarea;
            $comentario->id_usuario = $usuarioDocente->id;
            $comentario->c_descripcion = $request->c_descripcion;
            /* $id_referencia =  $request->input('id_comentario_referncia'); */

            /* if (!is_null($id_referencia) && !empty($id_referencia)) {
                $ref_com = App\Comentario_d::findOrFail($id_referencia);
                $comentario->id_comentario_referencia = $ref_com->id_comentario;
            } */

            $comentario->creador = $usuarioDocente->id;
            $comentario->save();
        }

        return response()->json($comentario);
    }




    public function cursos_de_secciones(Request $request){
        $secciones = $request->input('secciones');

        $respuesta = array();

        for($i=0; $i<count($secciones); $i++){
            $seccion = App\Seccion_d::findOrFail($secciones[$i]['value']);
            $seccion->grado;
            $seccion->categorias = $seccion->categorias()->where('categoria_d.estado','=',1)->get();
            array_push($respuesta,$seccion);
        }
        return response()->json($respuesta);
    }
}
