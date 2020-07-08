<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\facturacion\ActualizarPreferencia;
use App\Http\Requests\facturacion\CrearPreferencia;
use Illuminate\Http\Request;
use App;
use Auth;

class Preferencia extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verificarsuperadministrador');
        $this->middleware('verificarpermisofacturacion');
    }
    public function index(){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos las preferencia del usuario administrador u otro del colegio
            //pero no un alumno o docente
            $preferencias = App\Preferencia_d::where([
                'id_usuario' => Auth::user()->id,
                'estado' => 1
            ])->get();

            //obtenemos los tipos de documento utilizados por el usuario en su preferencia
            $id_tipos_documento = array();
            foreach($preferencias as $preferencia){
                $id_tipos_documento[] = $preferencia->id_tipo_documento;
            }
            //obtenemos los tipos de documento para la preferencia
            if(count($id_tipos_documento)>0){
                $tipos_de_documento_para_preferencia = App\Tipo_documento_m::where('estado','=',1)
                    ->whereNotIn('id_tipo_documento',$id_tipos_documento)->get();
                return view('super.facturacion.preferencia',compact('preferencias','tipos_de_documento_para_preferencia'));
            }else{
                $tipos_de_documento_para_preferencia = App\Tipo_documento_m::where([
                    'estado' => 1,
                ])->orderBy('c_nombre','ASC')->get();
                return view('super.facturacion.preferencia',compact('preferencias','tipos_de_documento_para_preferencia'));
            }
        }
        return redirect('/home');
    }
    public function series_y_tipos_de_impresion(Request $request)
    {
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if (!is_null($colegio) && !empty($colegio)) {
            //obtenemos el tipo de documento
            $tipo_de_documento = App\Tipo_documento_m::where([
                'id_tipo_documento' => $request->input('id_tipo_documento'),
                'estado' => 1
            ])->first();

            if (!is_null($tipo_de_documento) && !empty($tipo_de_documento)) {
                //obtenemos las series de ese colegio con ese tipo de documento
                $series = App\Serie_d::where([
                    'id_colegio' => $colegio->id_colegio,
                    'id_tipo_documento' => $request->input('id_tipo_documento'),
                    'estado' => 1
                ])->orderBy('c_serie', 'ASC')->get();

                //obtenemos los tipos de impresion para ese tipo de documento
                $tipo = ($tipo_de_documento->b_tipo == 1) ? 'nota' : 'comprobante';
                $tipos_de_impresion = App\Tipo_impresion_m::where([
                    'c_tipo' => $tipo,
                    'estado' => 1
                ])->orderBy('c_nombre', 'ASC')->get();

                $datos = array(
                    'correcto' => TRUE,
                    'series' => $series,
                    'tipos_de_impresion' => $tipos_de_impresion
                );
                return response()->json($datos);
            }
        }

        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function agregar(CrearPreferencia $request){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if (!is_null($colegio) && !empty($colegio)) {
            //obtenemos una preferencia con ese tipo de documento
            $pref= App\Preferencia_d::where([
                'id_usuario' => Auth::user()->id,
                'id_tipo_documento' => $request->input('tipo_documento_preferencia'),
                'estado' => 1
            ])->first();

            if(is_null($pref) || empty($pref)){
                //registramos la nueva preferencia
                $preferencia = new App\Preferencia_d;
                $preferencia->id_tipo_documento = $request->input('tipo_documento_preferencia');
                $preferencia->id_tipo_impresion = $request->input('tipo_impresion_preferencia');
                $preferencia->id_serie = $request->input('serie_preferencia');
                $preferencia->id_usuario = Auth::user()->id;
                $preferencia->b_datos_adicionales_calculo = (int)$request->input('datos_adicionales_preferencia');
                $preferencia->c_modo_emision = strtoupper($request->input('modo_emision_preferencia'));
                $preferencia->creador = Auth::user()->id;
                $preferencia->save();
                return redirect()->back();
            }
        }
        return redirect('/home');
    }
    public function actualizar(ActualizarPreferencia $request){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if (!is_null($colegio) && !empty($colegio)) {
            //obtenemos la preferencia
            $preferencia = App\Preferencia_d::where([
                'id_preferencia' => $request->input('id_preferencia'),
                'id_usuario' => Auth::user()->id,
                'estado' => 1
            ])->first();
            if(!is_null($preferencia) && !empty($preferencia)){
                $preferencia->id_tipo_impresion = $request->input('tipo_impresion');
                $preferencia->id_serie = $request->input('serie');
                $preferencia->b_datos_adicionales_calculo = (int)$request->input('datos_adicionales');
                $preferencia->c_modo_emision = strtoupper($request->input('modo_emision'));
                $preferencia->modificador = Auth::user()->id;
                $preferencia->save();
                return redirect()->back();
            }
        }
        return redirect('/home');
    }
    public function aplicar(Request $request){
        $this->validate($request,[
            'id_preferencia' => 'required|numeric'
        ]);
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if (!is_null($colegio) && !empty($colegio)) {
            //obtenemos la preferencia
            $preferencia = App\Preferencia_d::where([
                'id_usuario' => Auth::user()->id,
                'id_preferencia' => $request->input('id_preferencia'),
                'estado' => 1
            ])->first();
            if(!is_null($preferencia)&& !empty($preferencia)){
                $preferencia->load('tipo_documento');
                //obtenemos las series de ese tipo de documento
                $series = App\Serie_d::where([
                    'id_colegio' => $colegio->id_colegio,
                    'id_tipo_documento' => $preferencia->tipo_documento->id_tipo_documento,
                    'estado' => 1
                ])->orderBy('c_serie','ASC')->get();
                //obtenemos los tipos de impresion
                $tipo = ($preferencia->tipo_documento->b_tipo == 1) ? 'nota' : 'comprobante';
                $tipos_de_impresion = App\Tipo_impresion_m::where([
                    'c_tipo' => $tipo,
                    'estado' => 1
                ])->orderBy('c_nombre', 'ASC')->get();
                $datos = array(
                    'correcto' => TRUE,
                    'preferencia' => $preferencia,
                    'series' => $series,
                    'tipos_de_impresion' => $tipos_de_impresion
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function eliminar(Request $request){
        $this->validate($request,[
            'id_preferencia' => 'required|numeric'
        ]);
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if (!is_null($colegio) && !empty($colegio)) {
            //obtenemos la preferencia
            $preferencia = App\Preferencia_d::where([
                'id_usuario' => Auth::user()->id,
                'id_preferencia' => $request->input('id_preferencia'),
                'estado' => 1
            ])->first();
            if(!is_null($preferencia) && !empty($preferencia)){
                $preferencia->estado = 0;
                $preferencia->save();
                $datos = array(
                    'eliminado' => TRUE,
                    'preferencia' => $preferencia
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'eliminado' => TRUE
        );
        return response()->json($datos);
    }
}
