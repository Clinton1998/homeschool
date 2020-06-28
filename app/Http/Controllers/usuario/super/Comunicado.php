<?php

namespace App\Http\Controllers\usuario\super;

use App\Http\Controllers\Controller;
use App\Events\NuevoComunicado;
use App\Events\AlertSimple;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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

    public function generar(Request $request){
        $usuarioSuper = App\User::findOrFail(Auth::user()->id);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => $usuarioSuper->id,
            'estado' => 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            $g_id_comunicado = $request->input('g_id_comunicado');
            if(!is_null($g_id_comunicado) && !empty($g_id_comunicado)){
                //obtenemos el comunicado, verificamos que pertenesca al colegio
                $comunicado = App\Comunicado_d::where([
                    'id_comunicado' => $g_id_comunicado,
                    'id_colegio' => $colegio->id_colegio,
                    'estado' => 0
                ])->first();
                if(!is_null($comunicado) && !empty($comunicado)){
                    $archivo = $request->file('qqfile');
                    if (!is_null($archivo) && !empty($archivo)) {
                        $nombre = $request->input('qqfilename');
                        $nombre = ("(".$comunicado->id_comunicado."-".date('s').")" . $nombre);
                        $archivo->storeAs('comunicados/' . $comunicado->id_comunicado . '/', $nombre);
                        $archivo_comunicado = new App\Archivo_comunicado_d;
                        $archivo_comunicado->id_comunicado = $comunicado->id_comunicado;
                        $archivo_comunicado->c_url_archivo = $nombre;
                        $archivo_comunicado->estado = 0;
                        $archivo_comunicado->creador = Auth::user()->id;
                        $archivo_comunicado->save();
                    }
                    $datos = array(
                        'success' => TRUE,
                        'id_comunicado' => $comunicado->id_comunicado,
                    );
                    return response()->json($datos);
                }
                $datos = array(
                    'success' => FALSE,
                    'id_comunicado' => '',
                );
                return response()->json($datos);
            }else{

                $comunicado = new App\Comunicado_d;
                $comunicado->id_colegio = $colegio->id_colegio;
                $comunicado->c_titulo = $request->input('titulo_comunicado');
                $comunicado->c_descripcion = $request->input('descripcion_comunicado');
                $comunicado->c_destino = $request->input('opt_destino_comunicado_con_archivo');
                $comunicado->estado = 0;
                $comunicado->creador = Auth::user()->id;
                $comunicado->save();

                $archivo = $request->file('qqfile');
                if (!is_null($archivo) && !empty($archivo)) {
                    $nombre = $request->input('qqfilename');
                    $nombre = ("(".$comunicado->id_comunicado."-".date('s').")" . $nombre);
                    $archivo->storeAs('comunicados/' . $comunicado->id_comunicado . '/', $nombre);
                    $comunicado->c_url_archivo = $nombre;
                    $comunicado->save();
                }
                $datos = array(
                    'success' => TRUE,
                    'id_comunicado' => $comunicado->id_comunicado
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'success' => FALSE
        );
        return response()->json($datos);
    }
    public function agregar(Request $request)
    {
        //validamos los datos
        $request->validate([
            'titulo_comunicado' => 'required',
            'opt_destino_comunicado_sin_archivo' => 'required',
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
            $comunicado->c_destino = $request->input('opt_destino_comunicado_sin_archivo');
            $comunicado->creador = $usuarioSuper->id;
            $comunicado->save();
            event(new NuevoComunicado($colegio,$comunicado));
            return redirect('/super/comunicados');
        }
        return redirect('/home');
    }

    public function confirmar(Request $request){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos el comunicado inactivo
            $comunicado = App\Comunicado_d::where([
                'id_comunicado' => $request->input('id_comunicado'),
                'id_colegio' => $colegio->id_colegio,
                'estado' => 0
            ])->first();
            if(!is_null($comunicado) && !empty($comunicado)){
                //actualizamos al comunicado como activo
                $comunicado->estado = 1;
                $comunicado->modificador = Auth::user()->id;
                $comunicado->save();
                //actualizamos el detalle archivo
                DB::table('archivo_comunicado_d')
                    ->where('id_comunicado','=',$comunicado->id_comunicado)
                    ->update(['estado' => 1,'modificador' => Auth::user()->id]);
                event(new NuevoComunicado($colegio,$comunicado));
                $datos = array(
                    'correcto' => TRUE
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
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
                //notificacion simple de que el comunicado fue abierto por un usuario
                if(!(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0)){
                    $title = 'Comunicado abierto';
                    $text = '';
                    $type = 'info';
                    $timeout = 10000;
                    $icon = '/assets/images/colegio/school.png';
                    $colegio = '';
                    if(!is_null(Auth::user()->id_docente)){
                        $docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
                        $colegio = $docente->colegio;
                        if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                            $icon = '/super/colegio/logo'.$colegio->c_logo;
                        }
                        $text = $docente->c_nombre. ' ha abierto el comunicado "'.$comunicado->c_titulo.'"';
                    }else if(!is_null(Auth::user()->id_alumno)){
                        $alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
                        $colegio = $alumno->seccion->grado->colegio;
                        if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                            $icon = '/super/colegio/logo/'.$colegio->c_logo;
                        }
                        $text = $alumno->c_nombre. ' ha abierto el comunicado "'.$comunicado->c_titulo.'"';
                    }
                    broadcast(new AlertSimple([$colegio->id_superadministrador],$title,$text,$type,$timeout,$icon));
                }

                return view('super.infocomunicado',compact('comunicado'));
            }
        }
        return redirect('/home');
    }

    public function descargar_archivo($id_comunicado,$filename)
    {
        $comunicado = App\Comunicado_d::findOrFail($id_comunicado);
        //notificamos al superadministrador del colegio, que alguien esta descagando
        if(!(is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root==0)){
            $title = 'Descarga de archivo';
            $text = '';
            $type = 'info';
            $timeout = 10000;
            $icon = '/assets/images/colegio/school.png';
            $colegio = '';
            if(!is_null(Auth::user()->id_docente)){
                $docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
                $colegio = $docente->colegio;
                if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                    $icon = '/super/colegio/logo/'.$colegio->c_logo;
                }
                $text = $docente->c_nombre. ' está descargando un archivo del comunicado "'.$comunicado->c_titulo.'"';
            }else if(!is_null(Auth::user()->id_alumno)){
                $alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
                $colegio = $alumno->seccion->grado->colegio;
                if(!is_null($colegio->c_logo) && !empty($colegio->c_logo)){
                    $icon = '/super/colegio/logo/'.$colegio->c_logo;
                }
                $text = $alumno->c_nombre. ' está descargando un archivo del comunicado "'.$comunicado->c_titulo.'"';
            }
            broadcast(new AlertSimple([$colegio->id_superadministrador],$title,$text,$type,$timeout,$icon));
        }
        return Storage::download('comunicados/' . $comunicado->id_comunicado . '/' . $filename);
    }
}
