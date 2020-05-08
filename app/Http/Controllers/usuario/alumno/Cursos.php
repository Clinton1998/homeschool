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

        $cursos = DB::table('categoria_d')
        ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->select('categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso')
        ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'seccion_d.id_seccion' => $alumno->id_seccion, 'categoria_d.id_categoria' => $id_curso])
        ->first();

        $tareas = $alumno->tareas_asignados()->where(['tarea_d.estado' => 1, 'tarea_d.id_categoria' => $id_curso])->get();

        $docente = DB::table('docente_d')
        ->join('docente_seccion_p','docente_d.id_docente','=','docente_seccion_p.id_docente')
        ->join('seccion_d','docente_seccion_p.id_seccion','=','seccion_d.id_seccion')
        ->join('seccion_categoria_p','seccion_d.id_seccion','=','seccion_categoria_p.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->select('docente_d.*')
        ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'seccion_d.id_seccion' => $alumno->id_seccion, 'categoria_d.id_categoria' => $id_curso])
        ->first();

        $alumnosseccion = DB::table('alumno_d')
        ->select('alumno_d.*')
        ->where(['alumno_d.id_seccion' => $alumno->id_seccion])
        ->orderBy('alumno_d.c_nombre', 'ASC')
        ->get();

        /* $alumnoscurso = DB::table('alumno_d')
        ->join('seccion_d','alumno_d.id_seccion','=','seccion_d.id_seccion')
        ->join('seccion_categoria_p','seccion_d.id_seccion','=','seccion_categoria_p.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->select('alumno_d.*')
        ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'seccion_d.id_seccion' => $alumno->id_seccion, 'categoria_d.id_categoria' => $id_curso])
        ->orderBy('alumno_d.c_nombre', 'ASC')
        ->get(); */

        return view('alumno.curso', compact('cursos', 'tareas', 'docente','alumnosseccion'));
    }
}
