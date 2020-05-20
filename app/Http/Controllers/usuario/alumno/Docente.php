<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class Docente extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $usuarioAlumno = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno' => $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();
        
        $seccion_del_alumno = $alumno->seccion;

        $docentes = $seccion_del_alumno->docentes()->where('docente_d.estado','=',1)->orderBy('docente_d.c_nombre','ASC')->get();

        $cursos_docente = DB::table('categoria_d')
            ->join('seccion_categoria_p','categoria_d.id_categoria','=','seccion_categoria_p.id_categoria')
            ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
            ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
            ->join('seccion_categoria_docente_p','seccion_categoria_p.id_seccion_categoria','=','seccion_categoria_docente_p.id_seccion_categoria')
            ->join('docente_d','seccion_categoria_docente_p.id_docente','=','docente_d.id_docente')
            ->select('seccion_categoria_p.id_seccion_categoria',
                    'categoria_d.id_categoria', 'categoria_d.c_nombre as nom_curso', 'categoria_d.c_nivel_academico as col_curso',
                    'seccion_d.id_seccion', 'seccion_d.c_nombre as nom_seccion',
                    'grado_m.c_nombre as nom_grado', 'grado_m.c_nivel_academico as nom_nivel',
                    'docente_d.id_docente', 'docente_d.c_nombre as nom_docente', 'docente_d.*')
            ->where(['seccion_d.id_seccion' => $alumno->id_seccion])
            ->orderBy('docente_d.c_nombre','ASC')
        ->get();

        return view('misdocentesalumno',compact('docentes', 'cursos_docente'));
    }
}
