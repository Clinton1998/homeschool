<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use App\Notifications\NuevaTareaParaAlumnoNotification;
use App\Events\NuevaTareaAsignada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class AsignarTareas extends Controller
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

            //obteniendo cursos del docente
        $pivot_seccion_categoria_docente = DB::table('seccion_categoria_docente_p')
                ->join('seccion_categoria_p','seccion_categoria_docente_p.id_seccion_categoria','=','seccion_categoria_p.id_seccion_categoria')
                ->select('seccion_categoria_p.*','seccion_categoria_docente_p.id_seccion_categoria_docente as pivot_3')
                ->where([
                    'seccion_categoria_docente_p.id_docente' => $docente->id_docente,
                ])->get();
        $array_cursos = array();

        foreach($pivot_seccion_categoria_docente as $pivot){
            //elegimos los cursos solo de la seccion que eligio
            $pivot_seccion_categoria = DB::table('seccion_categoria_p')->where('id_seccion_categoria','=',$pivot->id_seccion_categoria)->first();
            if($seccion->id_seccion == $pivot_seccion_categoria->id_seccion){
                $item = array();
                $temp_curso = App\Categoria_d::where([
                    'id_categoria' => $pivot->id_categoria,
                    'estado' => 1
                ])->first();
                if((!is_null($temp_curso) && !empty($temp_curso))){
                    $item['curso'] = $temp_curso;
                    array_push($array_cursos,$item);
                }
            }
        }
        $cursos = collect($array_cursos);
        $datos = array(
                'correcto' => TRUE,
                'alumnos' => $alumnos,
                'categorias' => $cursos
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
        //tamaño maximo de archivo 256 MB
        //validamos los datos
        if($request->input('radioAlumnos')=='option1'){
                $request->validate([
                    'titulo'=> 'required',
                    'archivo' => 'file|max:256000',
                    'fecha_hora_entrega' => 'required',
                ]);
        }else if($request->input('radioAlumnos')=='option2'){
                $request->validate([
                    'titulo'=> 'required',
                    'archivo' => 'file|max:256000',
                    'fecha_hora_entrega' => 'required',
                    'alumnos' => 'required|array'
                ]);
        }else{
            return redirect('home');
        }

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
        $alumnos_asignados = $search_tarea->alumnos_asignados()->select('alumno_d.id_alumno','alumno_d.c_nombre','alumno_d.c_telefono_representante1','alumno_d.c_telefono_representante2')->where('alumno_d.estado', '=', 1)->get();
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
            'url' => '/alumno/tareapendiente/' . $search_tarea->id_tarea,
            'tipo' => 'nuevatarea'
        )));
        //sms para los representantes
        //event(new NuevaTareaAsignada($alumnos_asignados,$docente->c_nombre));
        return redirect('docente/asignartareas');
    }
}
