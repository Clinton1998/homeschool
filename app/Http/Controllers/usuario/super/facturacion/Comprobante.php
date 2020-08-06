<?php

namespace App\Http\Controllers\usuario\super\facturacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\facturacion\GenerarPrevisualizacion;
use App\Http\Requests\facturacion\AgregarComprobante;
use App\Events\NumberVoucherCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use Auth;

class Comprobante extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verificarsuperadministrador');
        $this->middleware('verificarpermisofacturacion');
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

                //obtenemos el numero correspondiente a esa serie de un determinados colegio
                $numero_maximo = App\Comprobante_d::where([
                    'id_colegio' => $colegio_para_comprobante->id_colegio,
                    'id_serie' => $serie_para_comprobante->id_serie,
                ])->max('n_numero');
                if(is_null($numero_maximo) || empty($numero_maximo)){
                    $numero_maximo = 0;
                }
                $numero_maximo++;
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
                        return view('super.facturacion.comprobante',compact('colegio_para_comprobante','alumno_para_comprobante','tipo_dato_cliente_para_alumno','tributos_para_producto','serie_para_comprobante','moneda_para_comprobante','tipo_impresion_para_comprobante','datos_adicionales_calculo','tributos','numero_maximo'));
                    }else{
                        /*REVIEW*/
                        return redirect('/home');
                    }
                }else{
                    return view('super.facturacion.comprobante',compact('colegio_para_comprobante','tributos_para_producto','serie_para_comprobante','moneda_para_comprobante','tipo_impresion_para_comprobante','datos_adicionales_calculo','tributos','numero_maximo'));
                }
            }
        }
        return redirect('/home');
    }
    public function agregar(AgregarComprobante $request){
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
        if(!is_null($colegio) && !empty($colegio)){
            //hallamos el proximo numero del comprobante
            $numero_maximo = App\Comprobante_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_serie' => $request->input('id_serie'),
            ])->max('n_numero');
            if(is_null($numero_maximo) || empty($numero_maximo)){
                $numero_maximo = 0;
            }
            $numero_maximo++;

            $comprobante = new App\Comprobante_d;
            $comprobante->id_colegio = $colegio->id_colegio;
            $comprobante->id_serie = $request->input('id_serie');
            $comprobante->id_alumno = $request->input('id_alumno');
            $comprobante->id_tipo_documento = $request->input('id_tipo_documento');
            $comprobante->id_moneda = $request->input('id_moneda');
            $comprobante->n_numero = $numero_maximo;
            $comprobante->c_nombre_receptor = $request->input('nombre_receptor');
            $doc = trim($request->input('numero_documento_identidad'));
            $codigo_sunat = null;
            if(strlen($doc)==8){
                $codigo_sunat = 1;
            }else if(strlen($doc)==11){
                $codigo_sunat = 6;
            }
            if(!is_null($codigo_sunat)){
                $documento_identidad = App\Documento_identidad_m::where([
                'c_codigo_sunat'=> $codigo_sunat,
                'estado' => 1
                ])->first();
                if(!is_null($documento_identidad) && !empty($documento_identidad)){
                    $comprobante->id_documento_identidad = $documento_identidad->id_documento_identidad;
                }
            }
            $comprobante->c_numero_documento_identidad = $doc;
            $comprobante->c_direccion_receptor = $request->input('direccion_receptor');
            $comprobante->c_ubigeo_receptor = $request->input('ubigeo_receptor');
            $comprobante->c_email_receptor = $request->input('email_receptor');
            $comprobante->c_telefono_receptor = $request->input('telefono_receptor');
            $comprobante->t_fecha_emision = $request->input('fecha');
            $comprobante->t_fecha_vencimiento = $request->input('fecha');
            $comprobante->c_observaciones = $request->input('observaciones');
            $comprobante->id_tipo_impresion = $request->input('id_tipo_impresion');
            $comprobante->b_envio_automatico_email = 0;
            $comprobante->n_total_operacion_gravada = $request->input('total_operacion_gravada');
            $comprobante->n_total_operacion_inafecta = $request->input('total_operacion_inafecta');
            $comprobante->n_total_operacion_exonerada = $request->input('total_operacion_exonerada');
            $comprobante->n_total_operacion_gratuita = 0;
            $comprobante->n_total_descuento = $request->input('total_descuento');
            $comprobante->n_total_igv = $request->input('total_igv');
            $comprobante->n_total_icbper = 0;
            $comprobante->n_total = $request->input('total');
            $comprobante->b_estado_comprobado = 0;
            $comprobante->creador = Auth::user()->id;
            $response = $comprobante->save();

            if($response){
                $porcentaje = (App\Tributo_m::where([
                    'c_codigo_sunat' => 'IGV',
                    'estado' => 1
                ])->first())->n_porcentaje;
                $items = $request->input('items');
                for($i = 0; $i<count($items); $i++){
                    //obtemos el producto
                    $producto = App\Producto_servicio_d::where([
                        'id_colegio' => $colegio->id_colegio,
                        'id_producto_servicio' => $items[$i]['id_producto'],
                        'estado' => 1
                    ])->first();
                    if(!is_null($producto) && !empty($producto)){
                        //agregamos los items del comprobante
                        $detalle = new App\Detalle_comprobante_d;
                        $detalle->id_comprobante = $comprobante->id_comprobante;
                        $detalle->id_producto = $producto->id_producto_servicio;
                        $detalle->c_codigo_producto = $producto->c_codigo;
                        $detalle->c_nombre_producto = $producto->c_nombre;
                        $detalle->c_unidad_producto = $producto->c_unidad;
                        $detalle->c_tributo_producto = $items[$i]['tributo'];
                        $detalle->c_informacion_adicional = $items[$i]['inf_adi'];
                        $detalle->b_tipo_detalle = 0;
                        $detalle->n_cantidad = $items[$i]['cantidad'];
                        $detalle->n_valor_unitario = $items[$i]['valor_unitario'];
                        $detalle->n_precio_unitario = $items[$i]['precio_unitario'];
                        $detalle->n_porcentaje_igv = $porcentaje;
                        $detalle->n_total_base = $items[$i]['total_base'];
                        $detalle->n_total_igv = $items[$i]['total_igv'];
                        $detalle->n_total_icbper = 0;
                        $detalle->n_total_impuesto = $items[$i]['total_igv'];
                        $detalle->n_total_detalle = $items[$i]['total_detalle'];
                        $detalle->estado  = 0;
                        $detalle->creador = Auth::user()->id;
                        $detalle->save();
                    }
                }

                //actualizamos el detalle y la cabacera
                DB::table('detalle_comprobante_d')
                ->where('id_comprobante','=',$comprobante->id_comprobante)
                ->update(['estado' => 1]);
                $comprobante->estado = 2;
                $comprobante->save();

                broadcast(new NumberVoucherCreated($comprobante));

                return response()->json([
                    'correcto' => TRUE
                ]);
            }
        }
        return response()->json([
            'correcto' => FALSE
        ]);
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
                            $ubigeo = '040101';
                            $c_departamento = null;
                            $c_provincia = null;
                            $c_distrito = null;
                            $id_ubigeo = $alumno->c_ubigeo_representante1;
                            if(!is_null($id_ubigeo) && !empty($id_ubigeo)){
                                $ubigeo_repre1 = DB::table('ubigeo_m')->where([
                                    'id_ubigeo' => $id_ubigeo
                                ])->select('id_ubigeo','c_departamento','c_provincia','c_distrito','c_nombre')->first();
                                $c_distrito = $ubigeo_repre1->c_nombre;

                                $c_provincia = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_repre1->c_departamento,
                                    'c_provincia' => $ubigeo_repre1->c_provincia,
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $c_departamento = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_repre1->c_departamento,
                                    'c_provincia' => '00',
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $ubigeo = $id_ubigeo;
                            }
                            $direccion_completa = $alumno->c_direccion_representante1;
                            if(!is_null($c_departamento)){
                                $direccion_completa .= ' '.$c_departamento.'-'.$c_provincia.'-'.$c_distrito;
                            }
                            $item_repre1 = array(
                                'dni' => $alumno->c_dni_representante1,
                                'direccion' => $direccion_completa,
                                'ubigeo' => $ubigeo,
                                'telefono' => $alumno->c_telefono_representante1,
                                'email' => $alumno->c_correo_representante1,
                                'label' => $alumno->c_nombre_representante1,
                                'category' => 'Representante'
                            );
                            array_push($arr_posibles_clientes,$item_repre1);
                        }

                        //verificamos si ese alumno tiene el segundo representante
                        if(!is_null($alumno->c_dni_representante2) && !empty($alumno->c_dni_representante2) && !is_null($alumno->c_nombre_representante2) && !empty($alumno->c_nombre_representante2)){
                            $ubigeo = '040101';
                            $c_departamento = null;
                            $c_provincia = null;
                            $c_distrito = null;
                            $id_ubigeo = $alumno->c_ubigeo_representante2;
                            if(!is_null($id_ubigeo) && !empty($id_ubigeo)){
                                $ubigeo_repre2 = DB::table('ubigeo_m')->where([
                                    'id_ubigeo' => $id_ubigeo
                                ])->select('id_ubigeo','c_departamento','c_provincia','c_distrito','c_nombre')->first();
                                $c_distrito = $ubigeo_repre2->c_nombre;

                                $c_provincia = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_repre2->c_departamento,
                                    'c_provincia' => $ubigeo_repre2->c_provincia,
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $c_departamento = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_repre2->c_departamento,
                                    'c_provincia' => '00',
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $ubigeo = $id_ubigeo;
                            }
                            $direccion_completa = $alumno->c_direccion_representante2;
                            if(!is_null($c_departamento)){
                                $direccion_completa .= ' '.$c_departamento.'-'.$c_provincia.'-'.$c_distrito;
                            }
                            $item_repre2 = array(
                                'dni' => $alumno->c_dni_representante2,
                                'direccion' => $direccion_completa ,
                                'ubigeo' => $ubigeo,
                                'telefono' => $alumno->c_telefono_representante2,
                                'email' => $alumno->c_correo_representante2,
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
                            $ubigeo = '040101';
                            $c_departamento = null;
                            $c_provincia = null;
                            $c_distrito = null;
                            $id_ubigeo = $alumno->c_ubigeo;
                            if(!is_null($id_ubigeo) && !empty($id_ubigeo)){
                                $ubigeo_alumn = DB::table('ubigeo_m')->where([
                                    'id_ubigeo' => $id_ubigeo
                                ])->select('id_ubigeo','c_departamento','c_provincia','c_distrito','c_nombre')->first();
                                $c_distrito = $ubigeo_alumn->c_nombre;
                                $c_provincia = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_alumn->c_departamento,
                                    'c_provincia' => $ubigeo_alumn->c_provincia,
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $c_departamento = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_alumn->c_departamento,
                                    'c_provincia' => '00',
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $ubigeo = $id_ubigeo;
                            }
                            $direccion_completa = $alumno->c_direccion;
                            if(!is_null($c_departamento)){
                                $direccion_completa .= ' '.$c_departamento.'-'.$c_provincia.'-'.$c_distrito;
                            }
                            $item_alumno = array(
                                'dni' => $alumno->c_dni,
                                'direccion' => $direccion_completa,
                                'ubigeo' => $ubigeo,
                                'telefono' => $alumno->c_telefono_representante1,
                                'email' => $alumno->c_correo,
                                'label' => $alumno->c_nombre,
                                'category' => 'Alumno(a)'
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
                    $ubigeo = '040101';
                    $direccion_completa = 'SIN INFORMACIÓN';
                    $c_departamento = null;
                    $c_provincia = null;
                    $c_distrito = null;

                    if(!is_null($alumno->c_direccion_representante1) && !empty($alumno->c_direccion_representante1)){
                        $direccion_completa = $alumno->c_direccion_representante1;
                        $id_ubigeo = $alumno->c_ubigeo_representante1;

                        if(!is_null($id_ubigeo) && !empty($id_ubigeo)){
                            $ubigeo_repre1 = DB::table('ubigeo_m')->where([
                                'id_ubigeo' => $id_ubigeo
                            ])->select('id_ubigeo','c_departamento','c_provincia','c_distrito','c_nombre')->first();

                            $c_distrito = $ubigeo_repre1->c_nombre;
                            
                            $c_provincia = (DB::table('ubigeo_m')->where([
                                'c_departamento' => $ubigeo_repre1->c_departamento,
                                'c_provincia' => $ubigeo_repre1->c_provincia,
                                'c_distrito' => '00'
                            ])->select('c_nombre')->first())->c_nombre;

                            $c_departamento = (DB::table('ubigeo_m')->where([
                                'c_departamento' => $ubigeo_repre1->c_departamento,
                                'c_provincia'=>'00',
                                'c_distrito' => '00'
                            ])->select('c_nombre')->first())->c_nombre;


                            $ubigeo = $id_ubigeo;
                        }

                        $direccion_completa = $alumno->c_direccion_representante1;
                        if(!is_null($c_departamento)){
                            $direccion_completa .= ' '.$c_departamento.'-'.$c_provincia.'-'.$c_distrito;
                        }
                    }

                    $alumno->c_direccion_representante1 = $direccion_completa;
                    $alumno->c_ubigeo_representante1 = $ubigeo;
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
                        $id_ubigeo = $alumno->c_ubigeo_representante1;
                            if(!is_null($id_ubigeo) && !empty($id_ubigeo)){
                                $ubigeo_repre1 = DB::table('ubigeo_m')->where([
                                    'id_ubigeo' => $id_ubigeo
                                ])->select('id_ubigeo','c_departamento','c_provincia','c_distrito','c_nombre')->first();
                                $c_distrito = $ubigeo_repre1->c_nombre;

                                $c_provincia = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_repre1->c_departamento,
                                    'c_provincia' => $ubigeo_repre1->c_provincia,
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $c_departamento = (DB::table('ubigeo_m')->where([
                                    'c_departamento' => $ubigeo_repre1->c_departamento,
                                    'c_provincia' => '00',
                                    'c_distrito' => '00'
                                ])->select('c_nombre')->first())->c_nombre;

                                $ubigeo = $id_ubigeo;
                            }
                            $direccion_completa = $alumno->c_direccion_representante1;
                            if(!is_null($c_departamento)){
                                $direccion_completa .= ' '.$c_departamento.'-'.$c_provincia.'-'.$c_distrito;
                            }
                        $item_alumno = array(
                            'label' => $alumno->c_nombre,
                            'value' => $alumno->c_nombre,
                            'dni_alumno' => $alumno->c_dni,
                            'dni_repre1' => $alumno->c_dni_representante1,
                            'nombre_repre1' => $alumno->c_nombre_representante1,
                            'direccion_repre1' => $direccion_completa,
                            'ubigeo_repre1' => $alumno->c_ubigeo_representante1,
                            'email_repre1' => $alumno->c_correo_representante1,
                            'telefono_repre1' => $alumno->c_telefono_representante1
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
}
