<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'prefijo' => 'required|string|min:1|max:2',
                'serie' => 'required|numeric|digits:2'
            ]);
            //verificamos que el documento de afectacion sea F O B
            $documento_afectacion = strtoupper($request->input('documento_afectacion'));
            if(!($documento_afectacion=='F' || $documento_afectacion=='B')){
                return redirect('/home');
            }
        }else{
            $this->validate($request,[
                'tipo_documento' => 'required|numeric',
                'prefijo' => 'required|string|min:1|max:2',
                'serie' => 'required|numeric|digits:3'
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
            $serie->c_serie = $request->input('prefijo').$request->input('serie');
            //verificamos si ya existe una serie no eliminado con el tipo de documento seleccionado
            if($tipo_documento->b_tipo==1){
                if(App\Serie_d::where([
                        'id_colegio' => $colegio->id_colegio,
                        'id_tipo_documento' => $tipo_documento->id_tipo_documento,
                        'c_documento_afectacion' => strtoupper($request->input('documento_afectacion')),
                        'estado' => 1
                    ])->count()==0 ){
                    $serie->b_principal = 1;
                }else{
                    $serie->b_principal = 0;
                }
            }else{
                if(App\Serie_d::where([
                        'id_colegio' => $colegio->id_colegio,
                        'id_tipo_documento' => $tipo_documento->id_tipo_documento,
                        'estado' => 1
                    ])->count()==0 ){
                    $serie->b_principal = 1;
                }else{
                    $serie->b_principal = 0;
                }
            }
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
                'prefijo_edit' => 'required|string|min:1|max:2',
                'numero_serie' => 'required|numeric|digits:2'
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
                'prefijo_edit' => 'required|string|min:1|max:2',
                'numero_serie' => 'required|numeric|digits:3'
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
            $serie_tipo_documento = $serie->id_tipo_documento;
            $afectacion = $serie->c_documento_afectacion;
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
                $serie->c_serie = $request->input('prefijo_edit').$request->input('numero_serie');
                $serie->modificador = Auth::user()->id;
                $serie->save();

                //verificamos si ha cambiado de tipo de documento
                if($serie_tipo_documento!=$tipo_documento->id_tipo_documento){
                    //verificamos si la serie actual era principal

                    /************REVIEW MEJORAR LOGICA*************/
                    if($serie->b_principal==1){
                        if(is_null($afectacion) || empty($afectacion)){
                            $affected = DB::table('serie_d')
                                ->where([
                                    'id_colegio' => $colegio->id_colegio,
                                    'id_tipo_documento' => $serie_tipo_documento
                                ])->update(['b_principal' => 0]);
                        }else{
                            $affected = DB::table('serie_d')
                                ->where([
                                    'id_colegio' => $colegio->id_colegio,
                                    'id_tipo_documento' => $serie_tipo_documento,
                                    'c_documento_afectacion' => strtoupper($afectacion)
                                ])->update(['b_principal' => 0]);
                        }
                    }
                    /******************END REVIEW****************/
                }

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
                //verificamos si es una serie principal
                if($serie->b_principal==1){
                    if(is_null($serie->c_documento_afectacion) || empty($serie->c_documento_afectacion)){
                        $affected = DB::table('serie_d')
                            ->where([
                                'id_colegio' => $colegio->id_colegio,
                                'id_tipo_documento' => $serie->id_tipo_documento
                            ])->update(['b_principal' => 0]);
                    }else{
                        $affected = DB::table('serie_d')
                            ->where([
                                'id_colegio' => $colegio->id_colegio,
                                'id_tipo_documento' => $serie->id_tipo_documento,
                                'c_documento_afectacion' => strtoupper($serie->c_documento_afectacion)
                            ])->update(['b_principal' => 0]);
                    }
                }
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
                    'restaurado' => FALSE
                );
                return response()->json($datos);
            }
        }

        $datos = array(
            'restaurado' => FALSE
        );
        return response()->json($datos);
    }
    public function establecer_a_principal(Request $request){
        $this->validate($request,[
            'id_serie' => 'required|numeric'
        ]);
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //verificamos que la serie exista  y no sea principal y que pertenesca al colegio
            $serie = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('id_serie'),
                'estado' => 1,
                'b_principal' => 0
            ])->first();

            if(!is_null($serie) && !empty($serie)){
                //obtenemos series de ese tipo de documento de la serie y los actualizamos como no principal
                if(is_null($serie->c_documento_afectacion)){
                    $affected = DB::table('serie_d')
                        ->where([
                            'id_colegio' => $colegio->id_colegio,
                            'id_tipo_documento' => $serie->id_tipo_documento
                        ])->update(['b_principal' => 0]);
                }else{
                    $affected = DB::table('serie_d')
                        ->where([
                            'id_colegio' => $colegio->id_colegio,
                            'id_tipo_documento' => $serie->id_tipo_documento,
                            'c_documento_afectacion'=> strtoupper($serie->c_documento_afectacion)
                        ])->update(['b_principal' => 0]);
                }
                //actualizamos la serie como principal de ese tipo,
                // o cuando es nota segundo el documento afectado
                $serie->b_principal = 1;
                $serie->save();
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

    public function prefijo(Request $request){
        $this->validate($request,[
            'id_tipo_documento' => 'required|numeric',
            'documento_afectacion' => 'required|string|size:1'
        ]);

        //obtenemos el tipo de documento
        $tipo_documento = App\Tipo_documento_m::where([
            'id_tipo_documento' => $request->input('id_tipo_documento'),
            'estado'=> 1
        ])->first();

        if(!is_null($tipo_documento) && !empty($tipo_documento) && $tipo_documento->b_tipo==1){
            $documento_afectacion = strtoupper($request->input('documento_afectacion'));
            //es nota de credito o debito
            if($tipo_documento->c_codigo_sunat=='07'){
                //nota de credito
                if($documento_afectacion=='F') {
                    $datos = array(
                        'correcto' => TRUE,
                        'prefijo' => 'FC'
                    );
                    return response()->json($datos);
                }else if($documento_afectacion=='B'){
                    $datos = array(
                        'correcto' => TRUE,
                        'prefijo' => 'BC'
                    );
                    return response()->json($datos);
                }
            }else if($tipo_documento->c_codigo_sunat=='08'){
                //nota de debito
                if($documento_afectacion=='F') {
                    $datos = array(
                        'correcto' => TRUE,
                        'prefijo' => 'FD'
                    );
                    return response()->json($datos);
                }else if($documento_afectacion=='B'){
                    $datos = array(
                        'correcto' => TRUE,
                        'prefijo' => 'BD'
                    );
                    return response()->json($datos);
                }
            }
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
}
