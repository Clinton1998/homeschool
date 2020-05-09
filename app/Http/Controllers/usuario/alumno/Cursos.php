<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;
use Auth;

class cursos extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where(['id_alumno' => $usuarioAlumno->id_alumno,'estado' => 1])->first();

        $cursos = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->select('categoria_d.id_categoria','categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso')
            ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'seccion_d.id_seccion' => $alumno->id_seccion])
        ->get();

        return view('alumno.cursos', compact('cursos'));
    }

    public function curso($id_curso){
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where(['id_alumno' => $usuarioAlumno->id_alumno,'estado' => 1])->first();

        //Datos del curso
        $cursos = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->select('categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso')
            ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'seccion_d.id_seccion' => $alumno->id_seccion, 'categoria_d.id_categoria' => $id_curso])
        ->first();

        //Tareas asignadas
        $tareas = $alumno->tareas_asignados()->where(['tarea_d.estado' => 1, 'tarea_d.id_categoria' => $id_curso])->get();

        //Docente del curso
        $docente = DB::table('docente_d')
            ->join('docente_seccion_p','docente_d.id_docente','=','docente_seccion_p.id_docente')
            ->join('seccion_d','docente_seccion_p.id_seccion','=','seccion_d.id_seccion')
            ->join('seccion_categoria_p','seccion_d.id_seccion','=','seccion_categoria_p.id_seccion')
            ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
            ->select('docente_d.*')
            ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'seccion_d.id_seccion' => $alumno->id_seccion, 'categoria_d.id_categoria' => $id_curso])
        ->first();

        //Compañeros de sección
        $alumnosseccion = DB::table('alumno_d')
            ->select('alumno_d.*')
            ->where(['alumno_d.id_seccion' => $alumno->id_seccion])
            ->orderBy('alumno_d.c_nombre', 'ASC')
        ->get();

        //Módulos de curso
        $modulos = DB::table('modulo_d')
            ->join('seccion_categoria_p','modulo_d.id_seccion_categoria','=','seccion_categoria_p.id_seccion_categoria')
            ->select('modulo_d.*')
            ->where(['seccion_categoria_p.id_seccion' => $alumno->id_seccion, 'seccion_categoria_p.id_categoria' => $id_curso, 'modulo_d.estado' => 1])
            ->orderBy('modulo_d.id_modulo', 'ASC')
        ->get();

        //Archivos
        $archivos = DB::table('archivo_d')
            ->select('archivo_d.*')
            ->where(['archivo_d.estado' => 1])
            ->orderBy('archivo_d.id_archivo','ASC')
        ->get();

        return view('alumno.curso', compact('cursos', 'tareas', 'docente','alumnosseccion', 'modulos', 'archivos'));
    }

    public function descargar_archivo($id_archivo){
        $archivo = App\Archivo_d::findOrFail($id_archivo);
        return Storage::download('archivos/' . $archivo->id_modulo . '/' . $archivo->c_url);
    }
}
