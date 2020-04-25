<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class AsignarTareas extends Controller
{
    public function index()
    {
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();

        //obteniendo las tareas del docente
        $tareas = App\Tarea_d::where([
            'id_docente' => $docente->id_docente,
            'estado' => 1
        ])->orderBy('created_at', 'DESC')->get();

        return view('docente.asignartareas', compact('docente', 'tareas'));
    }

    public function alumnos_categorias(Request $request)
    {

        $seccion = App\Seccion_d::where([
            'id_seccion' => $request->input('id_seccion'),
            'estado' => 1
        ])->first();

        $docente = App\Docente_d::where([
            'id_docente' => $request->input('id_docente'),
            'estado' => 1
        ])->first();

        //verificamos si la seccion es manipulable por el docente
        $seccion_del = $docente->secciones->where('id_seccion', '=', $seccion->id_seccion)->first();

        if (!is_null($seccion_del) && !empty($seccion_del)) {
            //obtenemos los alumnos y categorias para esa seccion
            $alumnos = $seccion_del->alumnos()->where('alumno_d.estado', '=', 1)->get();
            $categorias = $seccion_del->categorias()->where('categoria_d.estado', '=', 1)->get();

            $datos = array(
                'correcto' => TRUE,
                'alumnos' => $alumnos,
                'categorias' => $categorias
            );

            return response()->json($datos);
        } else {
            $datos = array(
                'correcto' => FALSE
            );
            return response()->json($datos);
        }
    }

    public function asignar(Request $request)
    {
        //return response()->json($request->all());
        $docente = App\Docente_d::findOrFail($request->input('id_docente'));
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        //creamos una tarea
        $newtarea = new App\Tarea_d;
        $newtarea->id_categoria = $request->input('categoria');
        $newtarea->id_docente = $docente->id_docente;
        $newtarea->c_titulo = $request->input('titulo');
        $newtarea->c_observacion = $request->input('descripcion');
        $hora = '';
        $minuto = '';
        if ($request->input('hora_entrega') == '' && $request->input('minuto_entrega') == '') {
            $hora = 23;
            $minuto = 59;
        } else if ($request->input('hora_entrega') != '' && $request->input('minuto_entrega') == '') {
            $hora = $request->input('hora_entrega');
            $minuto = '00';
        } else if ($request->input('hora_entrega') == '' && $request->input('minuto_entrega') != '') {
            $hora = '00';
            $minuto = $request->input('minuto_entrega');
        } else {
            $hora = $request->input('hora_entrega');
            $minuto = $request->input('minuto_entrega');
        }
        $fecha_hora_entrega = date('Y-m-d', strtotime($request->input('fecha_hora_entrega'))) . ' ' . $hora . ':' . $minuto . ':00';
        $newtarea->t_fecha_hora_entrega = $fecha_hora_entrega;
        $newtarea->c_estado = 'DENV';
        $newtarea->creador = $usuarioDocente->id;
        $newtarea->save();
        //subida de archivo,si es que existe
        $archivo = $request->file('archivo');

        if (!is_null($archivo) && !empty($archivo)) {
            $nombre = $archivo->getClientOriginalName();
            $archivo->storeAs('tareaasignacion/' . $newtarea->id_tarea . '/', $nombre);
            $newtarea->c_url_archivo = $nombre;
            $newtarea->save();
        }

        //obtenemos la seccion
        $seccion = App\Seccion_d::findOrFail($request->input('seccion'));
        //obtenemos el radio elegido
        $opcion_radio = $request->input('radioAlumnos');

        if ($opcion_radio == 'option1') {
            //asignamos la tareas a todos los alumnos de la seccion
            foreach ($seccion->alumnos->where('estado', '=', 1) as $alumno) {
                DB::table('alumno_tarea_respuesta_p')->insert(
                    ['id_tarea' => $newtarea->id_tarea, 'id_alumno' => $alumno->id_alumno, 'c_estado' => 'APEN', 'creador' => $usuarioDocente->id]
                );
            }
        } else {
            //asignamos tareas solo a algunos alumnos
            $alumnos = $request->input('alumnos');
            for ($i = 0; $i < count($alumnos); $i++) {
                DB::table('alumno_tarea_respuesta_p')->insert(
                    ['id_tarea' => $newtarea->id_tarea, 'id_alumno' => $alumnos[$i], 'c_estado' => 'APEN', 'creador' => $usuarioDocente->id]
                );
            }
        }
        //consultando la tarea
        $search_tarea = App\Tarea_d::findOrFail($newtarea->id_tarea);
        $alumnos_asignados = $search_tarea->alumnos_asignados()->select('alumno_d.id_alumno')->where('alumno_d.estado', '=', 1)->get();
        $id_usuarios = array();
        $i = 0;
        foreach ($alumnos_asignados as $alumno) {
            $id_usuarios[$i] = $alumno->usuario->id;
            $i++;
        }
        $usuarios_a_notificar = App\User::whereIn('id', $id_usuarios)->get();
        \Notification::send($usuarios_a_notificar, new NuevaTareaParaAlumnoNotification(array(
            'titulo' => 'Nueva tarea',
            'mensaje' => $search_tarea->c_titulo,
            'url' => '/alumno/tareapendiente/' . $search_tarea->id_tarea
        )));
        return redirect('docente/asignartareas');
    }
}
