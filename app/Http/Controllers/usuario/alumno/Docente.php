<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        //obteniendo los docentes del alumno
        $docentes = $seccion_del_alumno->docentes()->where('docente_d.estado','=',1)->orderBy('docente_d.created_at','DESC')->get();
        return view('misdocentesalumno',compact('docentes'));
    }
}
