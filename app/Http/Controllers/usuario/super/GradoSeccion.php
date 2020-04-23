<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class GradoSeccion extends Controller
{
    public function index(){
        //proceso para consultar los grados del colegio
        $usuario = App\User::findOrFail(Auth::user()->id);

        //investigamos de que colegio es este usuario
        $colegio = App\Colegio_m::where('id_superadministrador', '=', $usuario->id)->first();

        //obtenemos el grado de esos colegios
        $grados = App\Grado_m::where([
            'id_colegio' => $colegio->id_colegio,
            'estado' => 1
        ])->orderBy('c_nivel_academico', 'ASC')->orderBy('c_nombre','ASC')
        ->get();

        $TMP = DB::table('seccion_d')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->join('colegio_m','grado_m.id_colegio','=','colegio_m.id_colegio')
        ->select('seccion_d.c_nombre as nom_seccion', 'seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
        ->where([
            'grado_m.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1])
            ->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->orderBy('seccion_d.c_nombre','ASC')->get();
            
        //return view('seccionessuper', compact('grados', 'TMP'));
        return view('super.gradoseccion', compact('grados', 'TMP'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);
        //tenemos que verificar que el grado pertenesca al colegio que maneja el superadministrador
        $grado = App\Grado_m::findOrFail($request->input('id_grado'));

        //consultamos el colegio
        $colegio = App\Colegio_m::where([
            'id_colegio' => $grado->id_colegio,
            'id_superadministrador' => Auth::user()->id
        ])->first();

        if (!is_null($colegio)) {
            //agregamos la seccion al grado
            $seccion = new App\Seccion_d;
            $seccion->id_grado = $grado->id_grado;
            $seccion->c_nombre = $request->input('nombre');
            $seccion->creador = Auth::user()->id;
            $seccion->save();
        }
        return redirect('super/gradoseccion');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'actnombre' => 'required'
        ]);

        $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));
        $seccion->c_nombre = $request->input('actnombre');
        $seccion->modificador = Auth::user()->id;
        $seccion->save();

        $datos = array(
            'correcto' => TRUE,
            'actnombre' => $seccion->c_nombre
        );
        return redirect('super/gradoseccion');
    }

    public function aplicar(Request $request){
        $seccion  = App\Seccion_d::findOrFail($request->input('id_seccion'));
        return response()->json($seccion);
    }
    
    public function eliminar(Request $request)
    {
        $seccion = App\Seccion_d::findOrfail($request->input('id_seccion'));
        $seccion->estado = 0;
        $seccion->save();

        $datos = array(
            'correcto' => TRUE
        );
        return response()->json($datos);
    }
}
