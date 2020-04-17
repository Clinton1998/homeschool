<?php

namespace App\Http\Controllers\usuario\docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Docente extends Controller
{
    public function index(){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);

        //obtenemos el docente logueado
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();
        //obtenemos el colegio
        $colegio = App\Colegio_m::findOrFail($docente->id_colegio);
        //obtenemos los docentes del colegio
        $docentes = App\Docente_d::where([
            ['id_colegio','=',$colegio->id_colegio],
            ['id_docente','<>',$docente->id_docente],
            ['estado','=',1]
        ])->orderBy('created_at','DESC')->get();

        return view('docente.docentes',compact('docentes'));
    }
    public function aplicar(Request $request){

        $usuarioDocente = App\User::findOrFail(Auth::user()->id);
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();
        $colegio = App\Colegio_m::findOrFail($docente->id_colegio);

        $docente_solicitante = App\Docente_d::where([
            'id_docente'=> $request->input('id_docente'),
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->first();

        if(!is_null($docente_solicitante) && !empty($docente_solicitante)){
            $datos = array(
                'correcto' => TRUE,
                'docente' => $docente_solicitante
            );
            return response()->json($datos);
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }

    public function buscar(Request $request){
        $usuarioDocente = App\User::findOrFail(Auth::user()->id);

        //obtenemos el docente logueado
        $docente = App\Docente_d::where([
            'id_docente' => $usuarioDocente->id_docente,
            'estado' => 1
        ])->first();
        //obtenemos el colegio
        $colegio = App\Colegio_m::findOrFail($docente->id_colegio);
        $docentes = App\Docente_d::where([
            ['id_colegio','=',$colegio->id_colegio],
            ['id_docente','<>',$docente->id_docente],
            ['estado','=',1],
            ['c_nombre','like','%'.$request->input('nombre').'%']
        ])->get();

        $datos = array(
            'docentes' => $docentes
        );
        return response()->json($datos);
    }
}
