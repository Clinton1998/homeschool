<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use App\Events\NuevoComunicado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App;
use Auth;

class Comunicado extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuarioSuper = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => $usuarioSuper->id,
            'estado' => 1
        ])->first();

        if (!is_null($colegio) && !empty($colegio)) {
            //recuperamos los comunicados para todos
            $comunicados_todos = App\Comunicado_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_destino' => 'TODO',
                'estado' => 1
            ])->orderBy('created_at', 'DESC')->get();

            //recuperamos los comunicados solo de docentes
            $comunicados_solo_docentes = App\Comunicado_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_destino' => 'DOCE',
                'estado' => 1
            ])->orderBy('created_at', 'DESC')->get();

            //recuperamos los comunicados solo de alumnos
            $comunicados_solo_alumnos = App\Comunicado_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_destino' => 'ALUM',
                'estado' => 1
            ])->orderBy('created_at', 'DESC')->get();

            return view('super.comunicados', compact('comunicados_todos', 'comunicados_solo_docentes', 'comunicados_solo_alumnos'));
        }
        return redirect('home');
    }

    public function prueba(){
        return view('super.delete');
    }

    public function prueba_subir_archivo(Request $request){
        $datos = array(
            'success' => TRUE,
            'message' => 'El titulo del comunicado es: '.$request->input('titulo_comunicado'),
            'data' => $request->all()
        );
        return response()->json($datos);
    }
    public function agregar(Request $request)
    {
        //tamaño maximo de archivo 256 MB
        //validamos los datos
        $request->validate([
            'titulo_comunicado' => 'required',
            'opt_destino_comunicado' => 'required',
            'archivo_comunicado' => 'file|max:256000'
        ]);

        $usuarioSuper = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => $usuarioSuper->id,
            'estado' => 1
        ])->first();

        if (!is_null($colegio) && !empty($colegio)) {
            $comunicado = new App\Comunicado_d;
            $comunicado->id_colegio = $colegio->id_colegio;
            $comunicado->c_titulo = $request->input('titulo_comunicado');
            $comunicado->c_descripcion = $request->input('descripcion_comunicado');
            $comunicado->c_destino = $request->input('opt_destino_comunicado');
            $comunicado->creador = $usuarioSuper->id;
            $comunicado->save();
            //subida de archivo,si es que existe
            $archivo = $request->file('archivo_comunicado');

            if (!is_null($archivo) && !empty($archivo)) {
                $nombre = $archivo->getClientOriginalName();
                $nombre = $comunicado->id_comunicado . $nombre;
                $archivo->storeAs('comunicados/' . $comunicado->id_comunicado . '/', $nombre);
                $comunicado->c_url_archivo = $nombre;
                $comunicado->save();
            }

            event(new NuevoComunicado($colegio,$comunicado));

            return redirect('super/comunicados');
        }
        return redirect('home');
    }

    public function info($id_comunicado){
        $usuario = App\User::findOrFail(Auth::user()->id);
        $comunicado = App\Comunicado_d::findOrFail($id_comunicado);
        $colegio = $comunicado->colegio;
        $re_colegio = '';
        //tenemos que verificar que el usuario pertenece al colegio
        if(is_null($usuario->id_docente) && is_null($usuario->id_alumno) && $usuario->b_root==0){
            //se trata de un superadministrador del colegio
            $re_colegio = App\Colegio_m::where('id_superadministrador','=',$usuario->id)->first();
        }else if(!is_null($usuario->id_docente)){
            $re_docente = App\Docente_d::findOrFail($usuario->id_docente);
            $re_colegio = $re_docente->colegio;
        }else if(!is_null($usuario->id_alumno)){
            $re_alumno = App\Alumno_d::findOrFail($usuario->id_alumno);
            $re_colegio = $re_alumno->seccion->grado->colegio;
        }
        if($colegio->id_colegio==$re_colegio->id_colegio){
            //verificamos que el comunicado pertenesca al usuario
            $destino = strtoupper($comunicado->c_destino);
            $permitido = FALSE;

            if(is_null($usuario->id_docente) && is_null($usuario->id_alumno) && $usuario->b_root==0){
                $permitido = TRUE;
            }else{
                if($destino=='TODO'){
                    $permitido= TRUE;
                }else if($destino=='DOCE' && !is_null($usuario->id_docente)){
                    $permitido = TRUE;
                }else if($destino=='ALUM' && !is_null($usuario->id_alumno)){
                    $permitido = TRUE;
                }
            }
            if($permitido){
                return view('super.infocomunicado',compact('comunicado'));
            }
        }
        return redirect('home');
    }

    public function descargar_archivo($id_comunicado)
    {
        $comunicado = App\Comunicado_d::findOrFail($id_comunicado);
        return Storage::download('comunicados/' . $comunicado->id_comunicado . '/' . $comunicado->c_url_archivo);
    }
}
