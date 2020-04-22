<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class Categoria extends Controller
{
    public function index(){
        //mostrar las categorias del colegio
        $usuario = App\User::findOrFail(Auth::user()->id);

        //consultamos el colegio
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        //consultamos las categorias del colegio
        $categorias = App\Categoria_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        ])->orderBy('c_nivel_academico','ASC')->orderBy('c_nombre','ASC')->get();

        //consultamos las secciones del colegio
        //obtenemos el grado de esos colegios
        $grados = App\Grado_m::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        ])->orderBy('c_nivel_academico','ASC')->orderBy('c_nombre','ASC')->get();

        //prueba
        //Obteniendo todas las secciones
        //$secciones = App\Seccion_d::where('estado','=',1)->orderBy('c_nombre','ASC')->get();


        $secciones = DB::table('seccion_d')
            ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
            ->select('seccion_d.*')
            ->where([
                'grado_m.id_colegio' => $colegio->id_colegio,
                'seccion_d.estado' => 1
            ])->get();

        $TMP = DB::table('seccion_categoria_p')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->join('colegio_m','grado_m.id_colegio','=','colegio_m.id_colegio')
        ->select('categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado','grado_m.*','colegio_m.*')
        ->where([
            'categoria_d.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'categoria_d.estado' => 1])
            ->orderBy('nom_grado','ASC')->orderBy('nom_seccion','ASC')->get();

        $tmp_secciones = DB::table('seccion_d')
        ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
        ->select('seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
        ->where([
            'grado_m.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1
        ])->get();
        

        return view('categoriassuper',compact('categorias','secciones','grados', 'TMP', 'tmp_secciones'));
    }

    public function agregar(Request $request){
        if ($request->input('frm')=='1') {
            $request->validate([
                'nombre' => 'required',
                'nivel_academico' => 'required'
            ]);
    
            //ti todo esta bien
            $usuario = App\User::findOrFail(Auth::user()->id);
            //consultamos el colegio
            $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();
    
            //registramos la categoria
            $categoria = new App\Categoria_d;
            $categoria->id_colegio = $colegio->id_colegio;
            $categoria->c_nombre = $request->input('nombre');
            $categoria->c_nivel_academico = $request->input('nivel_academico');
            $categoria->creador = Auth::user()->id;
            $categoria->save();
    
            $secciones = $request->input('optgroups');
    
            if(!is_null($secciones) && !empty($secciones)){
                for($i=0; $i<count($secciones); $i++){
                    DB::table('seccion_categoria_p')->insert([
                        ['id_seccion' => $secciones[$i], 'id_categoria' => $categoria->id_categoria,'creador' => Auth::user()->id]
                    ]);
                }
            }

        }elseif ($request->input('frm')=='2') {
            $request->validate([
                'nombre2' => 'required',
                'nivel_academico2' => 'required'
            ]);
    
            //ti todo esta bien
            $usuario = App\User::findOrFail(Auth::user()->id);
            //consultamos el colegio
            $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();
    
            //registramos la categoria
            $categoria = new App\Categoria_d;
            $categoria->id_colegio = $colegio->id_colegio;
            $categoria->c_nombre = $request->input('nombre2');
            $categoria->c_nivel_academico = $request->input('nivel_academico2');
            $categoria->creador = Auth::user()->id;
            $categoria->save();
    
            $secciones = $request->input('optgroups2');
    
            if(!is_null($secciones) && !empty($secciones)){
                for($i=0; $i<count($secciones); $i++){
                    DB::table('seccion_categoria_p')->insert([
                        ['id_seccion' => $secciones[$i], 'id_categoria' => $categoria->id_categoria,'creador' => Auth::user()->id]
                    ]);
                }
            }
        }else {
            $request->validate([
                'nombre3' => 'required',
                'nivel_academico3' => 'required'
            ]);
    
            //ti todo esta bien
            $usuario = App\User::findOrFail(Auth::user()->id);
            //consultamos el colegio
            $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();
    
            //registramos la categoria
            $categoria = new App\Categoria_d;
            $categoria->id_colegio = $colegio->id_colegio;
            $categoria->c_nombre = $request->input('nombre3');
            $categoria->c_nivel_academico = $request->input('nivel_academico3');
            $categoria->creador = Auth::user()->id;
            $categoria->save();
    
            $secciones = $request->input('optgroups3');
    
            if(!is_null($secciones) && !empty($secciones)){
                for($i=0; $i<count($secciones); $i++){
                    DB::table('seccion_categoria_p')->insert([
                        ['id_seccion' => $secciones[$i], 'id_categoria' => $categoria->id_categoria,'creador' => Auth::user()->id]
                    ]);
                }
            }
        }

        return redirect('super/categorias');
    }

    public function actualizar(Request $request){
        $request->validate([
            'actnombre' => 'required'
            //'actnivel_academico' => 'required'
        ]);

        //si todo esta bien
        $categoria = App\Categoria_d::findOrFail($request->input('id_categoria'));
        $categoria->c_nombre = $request->input('actnombre');
        //$categoria->c_nivel_academico = $request->input('actnivel_academico');
        $categoria->modificador = Auth::user()->id;
        $categoria->save();

        return redirect('super/categorias');
    }

    public function aplicar(Request $request){
        $categoria  = App\Categoria_d::findOrFail($request->input('id_categoria'));
        return response()->json($categoria);
    }

    public function eliminar(Request $request){
        $categoria = App\Categoria_d::findOrFail($request->input('id_categoria'));
        $categoria->estado = 0;
        $categoria->save();

        $datos = array(
            'correcto' => TRUE
        );
        return response()->json($datos);
    }

    public function quitar_categoria(Request $request){
        DB::table('seccion_categoria_p')->where([
            'id_seccion' => $request->input('id_seccion'),
            'id_categoria' => $request->input('id_categoria')
        ])->delete();

        $datos = array(
            'correcto' => TRUE
        );

        return response()->json($datos);
    }
}
