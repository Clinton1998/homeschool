<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Alumno extends Controller
{
    public function index(){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();
        //obteniendo las secciones del docente
        $secciones = $docente->secciones()->where('seccion_d.estado','=',1)->orderBy('seccion_d.c_nombre')->get();
        return view('docente.alumnos',compact('secciones'));
    }

    public function aplicar(Request $request){
        $alumno = App\Alumno_d::where([
            'id_alumno' => $request->input('id_alumno'),
            'estado' => 1
        ])->first();
        $seccion_solicitante = $alumno->seccion;

        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $seccion_docente = (App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first())->secciones()->where([
            'seccion_d.id_seccion' => $seccion_solicitante->id_seccion,
            'seccion_d.estado' => 1
        ])->first();

        if(!is_null($seccion_docente) && !empty($seccion_docente)){
            $datos = array(
                'correcto' => TRUE,
                'alumno' => $alumno
            );
            return response()->json($datos);
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
}
