<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Comunicado extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarioSuper = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => $usuarioSuper->id,
            'estado' => 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //recuperamos los comunicados para todos
            $comunicados_todos = App\Comunicado_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_destino' => 'TODO',
                'estado'=> 1
            ])->orderBy('created_at','DESC')->get();

            //recuperamos los comunicados solo de docentes
            $comunicados_solo_docentes = App\Comunicado_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_destino' => 'DOCE',
                'estado'=> 1
            ])->orderBy('created_at','DESC')->get();

            //recuperamos los comunicados solo de alumnos
            $comunicados_solo_alumnos = App\Comunicado_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_destino' => 'ALUM',
                'estado'=> 1
            ])->orderBy('created_at','DESC')->get();

            return view('super.comunicados',compact('comunicados_todos','comunicados_solo_docentes','comunicados_solo_alumnos'));
        }
        return redirect('home');
    }
    public function agregar(Request $request){
        return response()->json($request->all());
    }
}
