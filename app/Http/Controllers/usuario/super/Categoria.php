<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class Categoria extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read_asignatura(){
        //mostrar las categorias del colegio
        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();
        $asignaturas = App\Categoria_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        //])->orderBy('c_nombre','ASC')->get();
        ])->orderBy('created_at','DESC')->get();

        return response()->json($asignaturas);
    }

    public function create_asignatura(Request $request){
        
        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $asignatura = new App\Categoria_d;
        $asignatura->id_colegio = $colegio->id_colegio;
        $asignatura->c_nombre = $request->c_nombre;
        $asignatura->c_nivel_academico = $request->c_nivel_academico;
        $asignatura->creador = Auth::user()->id;
        $asignatura->save();

        $asignaturas = App\Categoria_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        //])->orderBy('c_nombre','ASC')->get();
        ])->orderBy('created_at','DESC')->get();

        return response()->json($asignaturas);
    }

    public function update_asignatura(Request $request){

        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $asignatura = App\Categoria_d::findOrFail($request->id_categoria);
        $asignatura->c_nombre = $request->c_nombre;
        $asignatura->c_nivel_academico = $request->c_nivel_academico;
        $asignatura->modificador = Auth::user()->id;
        $asignatura->save();
       
        $asignaturas = App\Categoria_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        ])->orderBy('c_nombre','ASC')->get();

        return response()->json($asignaturas);
    }

    public function delete_asignatura(Request $request){

        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $asignatura = App\Categoria_d::findOrFail($request->id_categoria);
        $asignatura->estado = 0;
        $asignatura->save();

        $asignaturas = App\Categoria_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        ])->orderBy('c_nombre','ASC')->get();

        return response()->json($asignaturas);
    }

    public function read_seccion_categoria(Request $request){
        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $NIVEL = null;

        if ($request->c_nivel_academico == '1')
            $NIVEL = 'INICIAL';
        elseif ($request->c_nivel_academico == '2')
            $NIVEL = 'PRIMARIA';
        else 
            $NIVEL = 'SECUNDARIA';

        $asignaturas = DB::table('seccion_categoria_p')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->join('colegio_m','grado_m.id_colegio','=','colegio_m.id_colegio')
        //->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', DB::raw('substr(grado_m.c_nombre, 4) as nom_grado'),'grado_m.*','colegio_m.*')
        ->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado','grado_m.*','colegio_m.*')
        ->where([
            'categoria_d.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'categoria_d.estado' => 1,
            'grado_m.c_nivel_academico' => $NIVEL])
            ->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->orderBy('seccion_d.c_nombre','ASC')->get();

        return response()->json($asignaturas);
    }

    public function create_seccion_categoria(Request $request){
        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $NIVEL = '';

        if ($request->c_nivel_academico == '1')
            $NIVEL = 'INICIAL';
        elseif ($request->c_nivel_academico == '2')
            $NIVEL = 'PRIMARIA';
        else 
            $NIVEL = 'SECUNDARIA';

        $sec = $request->id_seccion;
        $cat = $request->id_categoria;
        $existen_cursos = array();

        if(!is_null($sec) && !empty($sec) && !is_null($cat) && !empty($cat)){
            for($i=0; $i<count($sec); $i++){
                for ($j=0; $j<count($cat); $j++) { 
                    //verificamos si existe la relacion
                    $pivot_seccion_categoria = DB::table('seccion_categoria_p')->where([
                        'id_seccion' => $sec[$i],
                        'id_categoria' => $cat[$j]
                    ])->first();

                    //si no existe creamos la nueva relacion
                    if(is_null($pivot_seccion_categoria) || empty($pivot_seccion_categoria)){
                        DB::table('seccion_categoria_p')->insert([
                            ['id_seccion' => $sec[$i], 'id_categoria' => $cat[$j],'creador' => Auth::user()->id]
                        ]);
                    }else{
                        $curso = App\Categoria_d::where([
                            'id_categoria'=> $cat[$j],
                            'estado' => 1
                        ])->first();
                        if(!is_null($curso) && !empty($curso)){
                            array_push($existen_cursos,$curso);    
                        }
                    }
                }
            }
        }

        $asignaturas = DB::table('seccion_categoria_p')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->join('colegio_m','grado_m.id_colegio','=','colegio_m.id_colegio')
        //->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', DB::raw('substr(grado_m.c_nombre, 4) as nom_grado'),'grado_m.*','colegio_m.*')
        ->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado','grado_m.*','colegio_m.*')
        ->where([
            'categoria_d.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'categoria_d.estado' => 1,
            'grado_m.c_nivel_academico' => $NIVEL])
            ->orderBy('nom_grado','ASC')->orderBy('nom_seccion','ASC')->get();
            $datos = array(
                'asignaciontodocursos' => TRUE,
                'asignaturas' => $asignaturas
            );
            if(count($existen_cursos)>0){
                $datos['asignaciontodocursos'] = FALSE;
                $datos['cursosnoasignados']= $existen_cursos;
            }
        return response()->json($datos);
    }

    public function update_seccion_categoria(Request $request){

        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $NIVEL = '';

        if ($request->c_nivel_academico == '1')
            $NIVEL = 'INICIAL';
        elseif ($request->c_nivel_academico == '2')
            $NIVEL = 'PRIMARIA';
        else 
            $NIVEL = 'SECUNDARIA';

        $idc = $request->id_seccion_categoria;
        $sec = $request->id_seccion;
        $cat = $request->id_categoria;

        //verificamos si ya existe esa relacion
        $pivot_seccion_categoria = DB::table('seccion_categoria_p')->where([
            'id_seccion'=> $sec,
            'id_categoria' => $cat
        ])->first();

        $curso_existente = '';

        if(is_null($pivot_seccion_categoria) || empty($pivot_seccion_categoria)){
            DB::table('seccion_categoria_p')->where(['id_seccion_categoria' => $idc])->update([
            'id_seccion' => $sec, 'id_categoria'=>$cat, 'creador' => Auth::user()->id
            ]);
        }else{
            $curso = App\Categoria_d::where([
                'id_categoria' => $cat,
                'estado' => 1
            ])->first();
            if(!is_null($curso) && !empty($curso)){
                $curso_existente = $curso;
            }
        }
    
        $asignaturas = DB::table('seccion_categoria_p')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->join('colegio_m','grado_m.id_colegio','=','colegio_m.id_colegio')
        //->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', DB::raw('substr(grado_m.c_nombre, 4) as nom_grado'),'grado_m.*','colegio_m.*')
        ->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado','grado_m.*','colegio_m.*')
        ->where([
            'categoria_d.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'categoria_d.estado' => 1,
            'grado_m.c_nivel_academico' => $NIVEL])
            ->orderBy('nom_grado','ASC')->orderBy('nom_seccion','ASC')->get();

            $datos = array();
            if($curso_existente==''){
                $datos['correcto'] = TRUE;
                $datos['asignaturas'] = $asignaturas;
            }else{
                $datos['correcto'] = FALSE;
                $datos['cursoexistente'] = $curso_existente;
                $datos['asignaturas'] = $asignaturas;
            }

        return response()->json($datos);
    }

    public function delete_seccion_categoria(Request $request){

        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        $NIVEL = '';

        if ($request->c_nivel_academico == '1')
            $NIVEL = 'INICIAL';
        elseif ($request->c_nivel_academico == '2')
            $NIVEL = 'PRIMARIA';
        else 
            $NIVEL = 'SECUNDARIA';

        $idc = $request->id_seccion_categoria;

        DB::table('seccion_categoria_p')->where(['id_seccion_categoria' => $idc])->delete();

        $asignaturas = DB::table('seccion_categoria_p')
        ->join('seccion_d','seccion_categoria_p.id_seccion','=','seccion_d.id_seccion')
        ->join('categoria_d','seccion_categoria_p.id_categoria','=','categoria_d.id_categoria')
        ->join('grado_m','seccion_d.id_grado','=','grado_m.id_grado')
        ->join('colegio_m','grado_m.id_colegio','=','colegio_m.id_colegio')
        //->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', DB::raw('substr(grado_m.c_nombre, 4) as nom_grado'),'grado_m.*','colegio_m.*')
        ->select('seccion_categoria_p.id_seccion_categoria','categoria_d.c_nombre as nom_categoria', 'categoria_d.*','seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado','grado_m.*','colegio_m.*')
        ->where([
            'categoria_d.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'categoria_d.estado' => 1,
            'grado_m.c_nivel_academico' => $NIVEL])
            ->orderBy('nom_grado','ASC')->orderBy('nom_seccion','ASC')->get();

        return response()->json($asignaturas);
    }

    //

    public function index(){
        $usuario = App\User::findOrFail(Auth::user()->id);
        $colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();

        //

        $inicial = DB::table('seccion_d')
        ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
        ->select('seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
        ->where([
            'grado_m.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'grado_m.c_nivel_academico' => 'INICIAL'
        ])->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->orderBy('seccion_d.c_nombre','ASC')->get();
        
        $primaria = DB::table('seccion_d')
        ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
        ->select('seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
        ->where([
            'grado_m.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'grado_m.c_nivel_academico' => 'PRIMARIA'
        ])->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->orderBy('seccion_d.c_nombre','ASC')->get();

        $secundaria = DB::table('seccion_d')
        ->join('grado_m', 'seccion_d.id_grado', '=', 'grado_m.id_grado')
        ->select('seccion_d.c_nombre as nom_seccion','seccion_d.*', 'grado_m.c_nombre as nom_grado', 'grado_m.*')
        ->where([
            'grado_m.id_colegio' => $colegio->id_colegio,
            'grado_m.estado' => 1,
            'seccion_d.estado' => 1,
            'grado_m.c_nivel_academico' => 'SECUNDARIA'
        ])->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->orderBy('seccion_d.c_nombre','ASC')->get();

        $asignaturas = App\Categoria_d::where([
            'id_colegio' => $colegio->id_colegio,
            'estado'=> 1
        //])->orderBy('c_nombre','ASC')->get();
        ])->orderBy('created_at','DESC')->get();

        return view('categoriassuper',compact('inicial', 'primaria', 'secundaria', 'asignaturas'));
    }

    /*
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
    */
}
