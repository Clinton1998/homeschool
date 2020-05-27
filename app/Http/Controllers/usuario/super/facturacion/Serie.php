<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Serie extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verificarsuperadministrador');
    }

    public function index(){

        //obtenemos los tipos de documento
        $tipos_de_documento = App\Tipo_documento_m::where([
            'estado' => 1
        ])->orderBy('created_at','ASC')->get();
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos las series del colegio
            $series = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 1
            ])->orderBy('created_at','DESC')->get();
            return view('super.facturacion.series',compact('tipos_de_documento','series'));
        }
        return redirect('/home');
    }
    public function aplicar(Request $request){
        $this->validate($request,[
            'id_serie' => 'required|numeric'
        ]);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos la serie
            $serie = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('id_serie'),
                'estado' => 1
            ])->first();
            if(!is_null($serie) && !empty($serie)){
                $serie->load('tipo_documento');
                $datos = array(
                    'correcto' => TRUE,
                    'serie' => $serie
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }

    public function agregar(Request $request){
        $documento_afectacion = $request->input('documento_afectacion');
        if(isset($documento_afectacion)){
            //existe documento de afectacion
            $this->validate($request,[
                'tipo_documento' => 'required|numeric',
                'documento_afectacion' => 'required|string|size:1',
                'serie' => 'required|max:191'
            ]);
            //verificamos que el documento de afectacion sea F O B
            $documento_afectacion = strtoupper($request->input('documento_afectacion'));
            if(!($documento_afectacion=='F' || $documento_afectacion=='B')){
                return redirect('/home');
            }
        }else{
            $this->validate($request,[
                'tipo_documento' => 'required|numeric',
                'serie' => 'required|max:191'
            ]);
        }
        //verificamos que el tipo documento exista
        $tipo_documento = App\Tipo_documento_m::where([
            'id_tipo_documento' => $request->input('tipo_documento'),
            'estado' => 1
        ])->first();
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio) && !is_null($tipo_documento) && !empty($tipo_documento)){
            //agregamos la serie al colegio con b_principal = 0
            $serie = new App\Serie_d;
            $serie->id_colegio = $colegio->id_colegio;
            $serie->id_tipo_documento = $tipo_documento->id_tipo_documento;
            //definimos el documento de afectacion
            if($tipo_documento->b_tipo ==1){
                //guardamos el documento de afectacion
                $serie->c_documento_afectacion = strtoupper($request->input('documento_afectacion'));
            }
            $serie->c_serie = $request->input('serie');
            $serie->b_principal = 0;
            $serie->creador = Auth::user()->id;
            $serie->save();
            return redirect()->back();
        }
        return redirect('/home');
    }

    public function tipo_documento(Request $request){
        $this->validate($request,[
            'id_tipo_documento' => 'required|numeric'
        ]);

        //obtenemos el tipo de documento
        $tipo_documento = App\Tipo_documento_m::where([
            'id_tipo_documento' => $request->input('id_tipo_documento'),
            'estado' => 1
        ])->first();

        return response()->json($tipo_documento);

    }

    public function actualizar(Request $request){
        $documento_afectacion = $request->input('documento_afectacion_serie');
        if(isset($documento_afectacion)){
            //existe documento de afectacion
            $this->validate($request,[
                'id_serie' => 'required|numeric',
                'tipo_documento_serie' => 'required|numeric',
                'documento_afectacion_serie' => 'required|string|size:1',
                'numero_serie' => 'required|max:191'
            ]);
            //verificamos que el documento de afectacion sea F O B
            $documento_afectacion = strtoupper($request->input('documento_afectacion_serie'));
            if(!($documento_afectacion=='F' || $documento_afectacion=='B')){
                return redirect('/home');
            }
        }else{
            $this->validate($request,[
                'id_serie' => 'required|numeric',
                'tipo_documento_serie' => 'required|numeric',
                'numero_serie' => 'required|max:191'
            ]);
        }

        //verificamos que el tipo documento exista
        $tipo_documento = App\Tipo_documento_m::where([
            'id_tipo_documento' => $request->input('tipo_documento_serie'),
            'estado' => 1
        ])->first();
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio) && !is_null($tipo_documento) && !empty($tipo_documento)){
            //obtenemos la serie
            $serie = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('id_serie'),
                'estado' => 1
            ])->first();

            if(!is_null($serie) && !empty($serie)){
                //actualizamos la serie
                $serie->id_tipo_documento = $tipo_documento->id_tipo_documento;
                //definimos el documento de afectacion
                if($tipo_documento->b_tipo ==1){
                    //guardamos el documento de afectacion
                    $serie->c_documento_afectacion = strtoupper($request->input('documento_afectacion_serie'));
                }else{
                    $serie->c_documento_afectacion = null;
                }
                $serie->c_serie = $request->input('numero_serie');
                $serie->modificador = Auth::user()->id;
                $serie->save();

                return redirect()->back();
            }

        }

        return redirect('/home');
    }
    public function eliminar(Request $request){
        $this->validate($request,[
            'id_serie' => 'required|numeric'
        ]);

        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos la serie del colegio
            $serie = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('id_serie'),
                'estado' => 1
            ])->first();

            if(!is_null($serie) && !empty($serie)){
                $serie->estado = 0;
                $serie->save();
                $datos = array(
                    'eliminado' => TRUE,
                    'serie' => $serie
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'eliminado' => FALSE
        );
        return response()->json($datos);
    }
    public function eliminados(){
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obteniendo las series del colegio
            $series = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 0
            ])->orderBy('created_at','DESC')->get();
            $series->load('tipo_documento');
            $datos = array(
                'correcto' => TRUE,
                'series' => $series
            );
            return response()->json($datos);
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function restaurar(Request $request){
        $this->validate($request,[
            'id_serie' => 'required|numeric'
        ]);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos la serie
            $serie = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('id_serie'),
                'estado' => 0
            ])->first();

            if(!is_null($serie) && !empty($serie)){
                //restauramos la serie
                $serie->estado = 1;
                $serie->save();

                $datos = array(
                    'restaurado' => TRUE,
                    'serie' => $serie
                );
                return response()->json($datos);
            }else{
                $datos = array(
                    'message' => 'segundo else'
                );
                return response()->json($datos);
            }
        }

        $datos = array(
            'restaurado' => FALSE
        );
        return response()->json($datos);
    }
}