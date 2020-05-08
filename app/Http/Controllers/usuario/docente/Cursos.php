<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
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

        $secciones = DB::table('seccion_d')
        ->join('docente_seccion_p','seccion_d.id_seccion','=','docente_seccion_p.id_seccion')
        ->join('docente_d','docente_seccion_p.id_docente','=','docente_d.id_docente')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->select('seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel')
        ->where(['seccion_d.estado' => 1, 'grado_m.estado' => 1, 'docente_d.estado' => 1, 'docente_seccion_p.id_docente' => $docente->id_docente])
        ->get();

        $cursos = DB::table('categoria_d')
        ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->select('categoria_d.id_categoria','categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso', 'seccion_d.id_seccion')
        ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1])
        ->get();

        return view('docente.cursos', compact('secciones','cursos'));
    }

    public function curso($id_curso){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where(['id_docente' => $usuarioDocente->id_docente,'estado' => 1])->first();

        $curso = DB::table('categoria_d')
        ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->select('categoria_d.id_categoria','categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso', 'seccion_d.id_seccion')
        ->where(['seccion_d.estado' => 1, 'categoria_d.estado' => 1, 'categoria_d.id_categoria' => $id_curso])
        ->first();

        return view('docente.curso', compact('curso'));
    }
}
