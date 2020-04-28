<?php

namespace App\Http\Controllers\usuario\alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Companiero extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $usuarioAlumno  = App\User::findOrFail(Auth::user()->id);
        $alumno = App\Alumno_d::where([
            'id_alumno'=> $usuarioAlumno->id_alumno,
            'estado' => 1
        ])->first();
        $seccion_del_alumno = $alumno->seccion;
        //obteniendo los companieros
        $companieros = App\Alumno_d::where([
            ['id_seccion','=',$seccion_del_alumno->id_seccion],
            ['id_alumno','<>',$alumno->id_alumno],
            ['estado','=',1]
        ])->orderBy('created_at','DESC')->get();
        return view('miscompanierosalumno',compact('companieros'));
    }
}
