<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class Comprobante extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verificarsuperadministrador');
    }

    public function index(Request $request){
        $this->validate($request,[
            'serie_comprobante' => 'required|numeric',
            'moneda_comprobante' => 'required|numeric',
            'tipo_impresion_comprobante' => 'required'
        ]);
        //obteniendo datos basicos
        //obteniendo el alumno
        $id_alumno = trim($request->input('id_alumno_comprobante'));
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos la serie
            $serie_para_comprobante = App\Serie_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('serie_comprobante'),
                'estado' => 1
            ])->first();

            //obtenemos la moneda
            $moneda_para_comprobante = App\Moneda_m::where([
                'id_moneda' => $request->input('moneda_comprobante'),
                'estado' => 1
            ])->first();

            if((!is_null($serie_para_comprobante) && !empty($serie_para_comprobante)) && (!is_null($moneda_para_comprobante) && !empty($moneda_para_comprobante))){
                $serie_para_comprobante->load('tipo_documento');
                //falta validar el tipo impresion
                $tipo_impresion_comprobante = $request->input('tipo_impresion_comprobante');

                //si hay un alumno elegido
                if($id_alumno!='' && !empty($id_alumno)){
                    $alumno_para_comprobante = App\Alumno_d::where([
                        'id_alumno' => $id_alumno,
                        'estado' => 1
                    ])->first();
                    $colegio_del_alumno = $alumno_para_comprobante->seccion->grado->colegio;
                    if($colegio_del_alumno->id_colegio==$colegio->id_colegio){
                        //ese alumno pertenece al colegio
                        //obteniendo al cliente para el alumno
                        $tipo_dato_cliente_para_alumno = strtolower(trim($request->input('tipo_dato_cliente_comprobante')));
                        return view('super.facturacion.comprobante',compact('alumno_para_comprobante','tipo_dato_cliente_para_alumno','serie_para_comprobante','moneda_para_comprobante','tipo_impresion_comprobante'));
                    }else{
                        return redirect('/home');
                    }
                }else{
                    return view('super.facturacion.comprobante',compact('serie_para_comprobante','moneda_para_comprobante','tipo_impresion_comprobante'));
                }
            }
        }
        return redirect('/home');
    }
    public function posibles_clientes(){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            $arr_posibles_clientes = array();
            //obtenemos alumnos y representantes del alumno
            $grados = $colegio->grados()->where('grado_m.estado','=',1)->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->get();
            foreach ($grados as $grado){
                foreach($grado->secciones()->where('seccion_d.estado','=',1)->orderBy('seccion_d.c_nombre','ASC')->get() as $seccion){
                    foreach($seccion->alumnos()->where('alumno_d.estado','=',1)->orderBy('alumno_d.c_nombre','ASC')->get() as $alumno){
                        //{ label: "anders", category: "Alumno|Representante" }
                        $item_alumno = array(
                            'label' => $alumno->c_nombre,
                            'category' => 'Alumno'
                        );
                        //verificamos si ese alumno tiene el primer representante
                        if(!is_null($alumno->c_dni_representante1) && !empty($alumno->c_dni_representante1) && !is_null($alumno->c_nombre_representante1) && !empty($alumno->c_nombre_representante1)){
                            $item_repre1 = array(
                                'label' => $alumno->c_nombre_representante1,
                                'category' => 'Representante'
                            );
                            array_push($arr_posibles_clientes,$item_repre1);
                        }

                        //verificamos si ese alumno tiene el segundo representante
                        if(!is_null($alumno->c_dni_representante2) && !empty($alumno->c_dni_representante2) && !is_null($alumno->c_nombre_representante2) && !empty($alumno->c_nombre_representante2)){
                            $item_repre2 = array(
                                'label' => $alumno->c_nombre_representante2,
                                'category' => 'Representante'
                            );
                            array_push($arr_posibles_clientes,$item_repre2);
                        }

                        array_push($arr_posibles_clientes,$item_alumno);
                    }
                }
            }
            $datos = array(
                'correcto'=> TRUE,
                'posibles_clientes' => $arr_posibles_clientes
            );
            return response()->json($datos);
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function basico_necesario(Request $request){
        $this->validate($request,[
            'tipo' => 'required|string|size:1'
        ]);
        $tipo = strtoupper($request->input('tipo'));
        $codigo_sunat = '';
        if($tipo=='F'){
            $codigo_sunat = '01';
        }else if($tipo=='B'){
            $codigo_sunat = '03';
        }else{
            $datos = array(
                'correcto' => FALSE
            );
            return response()->json($datos);
        }
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos el tipo de documento
            $tipo_documento = App\Tipo_documento_m::where([
                'c_codigo_sunat' => $codigo_sunat,
                'b_tipo' => 0,
                'estado' => 1
            ])->first();
            if(!is_null($tipo_documento) && !empty($tipo_documento)){
                //obtenemos las series del colegio con ese tipo de documento
                $series = App\Serie_d::where([
                    'id_colegio'=> $colegio->id_colegio,
                    'id_tipo_documento' => $tipo_documento->id_tipo_documento,
                    'estado'=> 1
                ])->orderBy('created_at','DESC')->get();
                //obteniendo los tipos de impresion
                $tipos_de_impresion = array('A4','TICKET');
                //obteniendo las monedas
                $monedas = App\Moneda_m::where([
                    'estado' => 1
                ])->get();
                $datos = array(
                    'correcto' => TRUE,
                    'series'=> $series,
                    'tipos_de_impresion' => $tipos_de_impresion,
                    'monedas'=> $monedas
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }

    public function alumnos(){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos los grados del colegio
            $grados = $colegio->grados()->where('grado_m.estado','=',1)
                ->orderBy('grado_m.c_nivel_academico','ASC')->orderBy('grado_m.c_nombre','ASC')->get();

            $grados = $grados->map(function ($grado)  {
                $grado->secciones = $grado->secciones()->where('seccion_d.estado','=',1)->get();
                $grado->secciones->load(['alumnos' => function ($query) {
                    $query->where('alumno_d.estado','=',1)->orderBy('c_nombre','ASC');
                }]);
                return $grado;
            });

            $datos = array(
                'correcto'=> TRUE,
                'grados' => $grados
            );
            return response()->json($datos);
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function alumno(Request $request){
        $this->validate($request,[
            'id_alumno'=>'required|numeric'
        ]);
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos el alumno
            $alumno = App\Alumno_d::where([
                'id_alumno' => $request->input('id_alumno'),
                'estado' => 1
            ])->first();
            if(!is_null($alumno) && !empty($alumno)){
                //verificamos que el alumno pertenezca al colegio
                $colegio_de_alumno = $alumno->seccion->grado->colegio;
                if($colegio_de_alumno->id_colegio==$colegio->id_colegio){
                    $datos = array(
                        'correcto' => TRUE,
                        'alumno' => $alumno
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
