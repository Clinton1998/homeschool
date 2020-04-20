<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class Seccion extends Controller
{
    public function index()
    {
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
            
        return view('seccionessuper', compact('grados'));
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
        return redirect('super/secciones');
    }
    public function actualizar(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));
        $seccion->c_nombre = $request->input('nombre');
        $seccion->modificador = Auth::user()->id;
        $seccion->save();

        $datos = array(
            'correcto' => TRUE,
            'nombre' => $seccion->c_nombre
        );
        return response()->json($datos);
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
    public function aplicar(Request $request)
    {
        $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));
        //consultamos las categorias que no esta utilizando esta seccion

        $categorias_utilizadas = $seccion->categorias;

        $id_utilizados = array();

        $i = 0;
        foreach ($categorias_utilizadas as $categoria) {
            $id_utilizados[$i] = $categoria->id_categoria;
            $i++;
        }

        $categorias_no_utilizadas = DB::table('categoria_d')->select('id_categoria','c_nombre','c_nivel_academico')
            ->where('categoria_d.estado','=',1)
            ->whereNotIn('id_categoria', $id_utilizados)
            ->get();

        $datos = array(
            'seccion' => $seccion,
            'categoria_no_utilizados' => $categorias_no_utilizadas
        );

        return response()->json($datos);
    }

    public function agregar_categoria(Request $request)
    {
        $seccion = App\Seccion_d::findOrFail($request->input('id_seccion'));

        DB::table('seccion_categoria_p')->insert([
            ['id_seccion' => $seccion->id_seccion, 'id_categoria' => $request->input('nombrecategoria'),'creador' => Auth::user()->id]
        ]);
        return redirect('super/categorias');
    }
}
