<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Grado extends Controller
{
    public function index(){

        //proceso para consultar los grados del colegio
        $usuario = App\User::findOrFail(Auth::user()->id);

        //investigamos de que colegio es este usuario
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        //obtenemos el grado de esos colegios
        $grados = App\Grado_m::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        ])->orderBy('c_nivel_academico','ASC')->orderBy('c_nombre','ASC')->get();
        return  view('gradossuper',compact('grados'));
    }

    public function agregar(Request $request){
        $request->validate([
            'nombre' => 'required',
            'nivel_academico' => 'required'
        ]);

        // si todo esta bien registramos
        $usuario = App\User::findOrFail(Auth::user()->id);

        //en que colegio
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        //agregamos el grado
        $grado = new App\Grado_m;
        $grado->id_colegio = $colegio->id_colegio;
        $grado->c_nombre = $request->input('nombre');
        $grado->c_nivel_academico = $request->input('nivel_academico');
        $grado->creador = Auth::user()->id;
        $grado->save();
        return redirect('super/grados');
    }
    public function actualizar(Request $request){
        $request->validate([
            'actnombre' => 'required',
            'actnivel_academico' => 'required'
        ]);

        $grado = App\Grado_m::findOrfail($request->input('actidgrado'));
        $grado->c_nombre = $request->input('actnombre');
        $grado->c_nivel_academico = $request->input('actnivel_academico');
        $grado->modificador = Auth::user()->id;
        $grado->save();
        return redirect('super/grados');
    }
    public function aplicar(Request $request){
        //consultando el grado
        $grado = App\Grado_m::findOrFail($request->input('id_grado'));
        return response()->json($grado);
    }
    public function eliminar(Request $request){
        $grado = App\Grado_m::findOrfail($request->input('id_grado'));
        $grado->estado = 0;
        $grado->save();
        
        $datos = array(
            'correcto'=> TRUE
        );
        return response()->json($datos);
    }
}
