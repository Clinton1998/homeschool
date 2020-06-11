<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\facturacion\GenerarPrevisualizacion;
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
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obteniendo el alumno
            $id_alumno = trim($request->input('id_alumno_comprobante'));
            //obteniendo valor de datos adicionales calculo
            $datos_adicionales_calculo = 0;
            $adicional_para_calculo = $request->input('datos_adicionales_calculo');
            if(isset($adicional_para_calculo)){
                $datos_adicionales_calculo = 1;
            }
            $datos_adicionales_calculo = $request->input('datos_adicionales_calculo');
            //obtenemos los tributos generales
            $tributos_para_producto = App\Tributo_m::where([
                'estado'=> 1
            ])->orderBy('c_nombre','ASC')->get();
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
                //obtenemos el colegio
                $colegio_para_comprobante = $colegio;
                //tipo impresion para comprobante
                $tipo_impresion_para_comprobante = App\Tipo_impresion_m::where([
                    'id_tipo_impresion' => $request->input('tipo_impresion_comprobante'),
                    'estado' => 1
                ])->first();

                //verificamos si el tipo documento elegigo es un registro preferencia o no, del usuario actual
                $preferencia_para_comprobante = App\Preferencia_d::where([
                    'id_tipo_documento' => $serie_para_comprobante->id_tipo_documento,
                    'id_usuario' => Auth::user()->id,
                    'estado' =>1
                ])->first();
                if(is_null($preferencia_para_comprobante) || empty($preferencia_para_comprobante)){
                    //guardamos la preferencia de ese tipo de documento del usuario logueado
                    $preferencia = new App\Preferencia_d;
                    $preferencia->id_tipo_documento = $serie_para_comprobante->id_tipo_documento;
                    $preferencia->id_tipo_impresion = $tipo_impresion_para_comprobante->id_tipo_impresion;
                    $preferencia->id_serie = $serie_para_comprobante->id_serie;
                    $preferencia->id_usuario = Auth::user()->id;
                    $preferencia->b_datos_adicionales_calculo = (int)$datos_adicionales_calculo;
                    $preferencia->c_modo_emision = 'DET';
                    $preferencia->creador = Auth::user()->id;
                    $preferencia->save();
                }
                //obteniendo los tributos
                $tributos = App\Tributo_m::where('estado','=',1)->orderBy('c_nombre','ASC')->get();
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
                        return view('super.facturacion.comprobante',compact('colegio_para_comprobante','alumno_para_comprobante','tipo_dato_cliente_para_alumno','tributos_para_producto','serie_para_comprobante','moneda_para_comprobante','tipo_impresion_para_comprobante','datos_adicionales_calculo','tributos'));
                    }else{
                        /*REVIEW*/
                        return redirect('/home');
                    }
                }else{
                    return view('super.facturacion.comprobante',compact('colegio_para_comprobante','tributos_para_producto','serie_para_comprobante','moneda_para_comprobante','tipo_impresion_para_comprobante','datos_adicionales_calculo','tributos'));
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
                        //verificamos si ese alumno tiene el primer representante
                        if(!is_null($alumno->c_dni_representante1) && !empty($alumno->c_dni_representante1) && !is_null($alumno->c_nombre_representante1) && !empty($alumno->c_nombre_representante1)){
                            $item_repre1 = array(
                                'dni' => $alumno->c_dni_representante1,
                                'direccion' => $alumno->c_direccion_representante1,
                                'label' => $alumno->c_nombre_representante1,
                                'category' => 'Representante'
                            );
                            array_push($arr_posibles_clientes,$item_repre1);
                        }

                        //verificamos si ese alumno tiene el segundo representante
                        if(!is_null($alumno->c_dni_representante2) && !empty($alumno->c_dni_representante2) && !is_null($alumno->c_nombre_representante2) && !empty($alumno->c_nombre_representante2)){
                            $item_repre2 = array(
                                'dni' => $alumno->c_dni_representante2,
                                'direccion' => $alumno->c_direccion_representante2,
                                'label' => $alumno->c_nombre_representante2,
                                'category' => 'Representante'
                            );
                            array_push($arr_posibles_clientes,$item_repre2);
                        }

                        //verificamos si alumno(a) es mayor de edad
                        $fecha_nacimiento = new \DateTime($alumno->t_fecha_nacimiento);
                        $hoy = new \DateTime();
                        $edad = $hoy->diff($fecha_nacimiento);
                        if($edad->y>=18){
                            $item_alumno = array(
                                'dni' => $alumno->c_dni,
                                'direccion' => $alumno->c_direccion,
                                'label' => $alumno->c_nombre,
                                'category' => 'Alumno'
                            );
                            array_push($arr_posibles_clientes,$item_alumno);
                        }
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
    public function productos($q,$tipo)
    {
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos todos los productos del colegio
            if($tipo=='nombre'){
                $productos = App\Producto_servicio_d::where([
                    ['id_colegio','=',$colegio->id_colegio],
                    ['estado','=',1],
                    ['c_nombre','like','%'.$q.'%']
                ])->select('producto_servicio_d.id_producto_servicio as id', 'producto_servicio_d.c_nombre as text')->get();
                $datos = array(
                    'correcto' => TRUE,
                    'productos' => $productos
                );
                return response()->json($datos);
            }elseif($tipo=='codigo'){
                $productos = App\Producto_servicio_d::where([
                    ['id_colegio','=',$colegio->id_colegio],
                    ['estado','=',1],
                    ['c_codigo','like','%'.$q.'%']
                ])->select('producto_servicio_d.id_producto_servicio as id', 'producto_servicio_d.c_codigo as text')->get();
                $datos = array(
                    'correcto' => TRUE,
                    'productos' => $productos
                );
                return response()->json($datos);
            }else{
                $datos = array(
                    'correctoelse' => FALSE
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correctofuera' => FALSE
        );
        return response()->json($datos);
    }
    public function producto(Request $request){

        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos el producto o servicio
            $producto = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_producto_servicio' => $request->input('id_producto_servicio'),
                'estado' => 1
            ])->first();

            if(!is_null($producto) && !empty($producto)){
                $producto->load('tributo');
                $datos = array(
                    'correcto' => TRUE,
                    'producto' => $producto
                );
                return response()->json($datos);
            }
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
                //verificamos si el usuario actual, tiene preferencias con este tipo de documento
                $preferencia = App\Preferencia_d::where([
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_documento' => $tipo_documento->id_tipo_documento,
                    'estado' => 1
                ])->first();
                //obtenemos las series del colegio con ese tipo de documento
                $series = App\Serie_d::where([
                    'id_colegio'=> $colegio->id_colegio,
                    'id_tipo_documento' => $tipo_documento->id_tipo_documento,
                    'estado'=> 1
                ])->orderBy('created_at','DESC')->get();
                //obteniendo los tipos de impresion
                $tipos_de_impresion = App\Tipo_impresion_m::where([
                    'c_tipo' => 'comprobante',
                    'estado' => 1
                ])->orderBy('c_nombre','ASC')->get();
                //obteniendo las monedas
                $monedas = App\Moneda_m::where([
                    'estado' => 1
                ])->get();
                $datos = array(
                    'correcto' => TRUE,
                    'series'=> $series,
                    'tipos_de_impresion' => $tipos_de_impresion,
                    'monedas'=> $monedas,
                    'preferencia' => $preferencia
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
    public function alumno_por_dni(Request $request){
        $this->validate($request,[
            'dni' => 'required|string|size:8'
        ]);
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //buscamos un alumno con ese dni
            $alumno = App\Alumno_d::where([
                'c_dni' => trim($request->input('dni')),
                'estado' => 1
            ])->first();
            if(!is_null($alumno) && !empty($alumno)){
                //verificamos que ese alumno pertenesca al colegio
                $colegio_del_alumno = $alumno->seccion->grado->colegio;
                if($colegio->id_colegio == $colegio_del_alumno->id_colegio){
                    $datos = array(
                        'encontrado' => TRUE,
                        'alumno' => $alumno
                    );
                    return response()->json($datos);
                }
            }
        }
        $datos = array(
            'encontrado' => FALSE
        );
        return response()->json($datos);

    }

    public function alumnos_para_comprobante(Request $request){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            $array_alumnos = array();
            //criterio de busqueda
            $term = $request->input('term');
            $grados = $colegio->grados()->where('grado_m.estado','=',1)->orderBy('grado_m.c_nombre','ASC')->orderBy('grado_m.c_nivel_academico','ASC')->get();

            foreach($grados as $grado){
                foreach($grado->secciones()->where('seccion_d.estado','=',1)->get() as $seccion){
                    foreach($seccion->alumnos()->where([
                        ['c_nombre','like','%'.$term.'%'],
                        ['estado','=',1]
                    ])->get() as $alumno){
                        $item_alumno = array(
                            'label' => $alumno->c_nombre,
                            'value' => $alumno->c_nombre,
                            'dni_alumno' => $alumno->c_dni,
                            'dni_repre1' => $alumno->c_dni_representante1,
                            'nombre_repre1' => $alumno->c_nombre_representante1,
                            'direccion_repre1' => $alumno->c_direccion_representante1
                        );
                        array_push($array_alumnos,$item_alumno);
                    }
                }
            }

            return response()->json($array_alumnos);
        }
        $datos = array();
        return response()->json($datos);
    }

    /*public function generar_previsualizacion(GenerarPrevisualizacion $request){
        $datos = array(
            'correcto' => TRUE,
            'datos' => $request->all()
        );

        return response()->json($datos);
    }*/
}
