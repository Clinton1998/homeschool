<?php

namespace App\Http\Controllers\usuario\super\facturacion;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CrearProductoRequest;
use App\Http\Requests\AplicarProductoRequest;
use App\Http\Requests\ActualizarProductoRequest;
use App\Http\Requests\EliminarProductoRequest;
use App\Http\Requests\RestaurarProductoRequest;

use App;
use Auth;

class Producto extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verificarsuperadministrador');
    }

    public function index(){
		$colegio = App\Colegio_m::where([
		    'id_superadministrador' => Auth::user()->id,
            'estado' => 1
        ])->first();
		if(!is_null($colegio) && !empty($colegio)){
			//recuperamos los productos o servicios del colegio, solo los que no estan eliminados
			$productos_o_servicios = App\Producto_servicio_d::where([
				'id_colegio' => $colegio->id_colegio,
				'estado' => 1
			])->orderBy('created_at','DESC')->get();
			//obteniendo los tributos para la creacion de un producto
			$tributos = App\Tributo_m::where('estado','=',1)->orderBy('c_nombre','ASC')->get();

			//obteniendo las unidades diferentes para el filtro
            $unidades =  App\Producto_servicio_d::select('c_unidad')->where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 1
            ])->distinct()->get();
            //return response()->json($unidades);
			return view('super.facturacion.productos',compact('productos_o_servicios','tributos','unidades'));
		}
    	return redirect('/home');
    }
    public function agregar(CrearProductoRequest $request){
    	//obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=>1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            $producto = new App\Producto_servicio_d;
            $producto->id_colegio = $colegio->id_colegio;
            //verificamos si el codigo es manual o autogenerado
            $modo = $request->input('modo_codigo_producto');
            if(isset($modo)){
                //es autogenerado
                //el codigo debe tener el formato de 00001
                //obtener todos los productos de ese colegio con codigo generado(eliminados y no eliminados)
                $generado_maximo = (int)(App\Producto_servicio_d::where([
                    'id_colegio' => $colegio->id_colegio,
                    'c_tipo_codigo' => 'GENERADO'
                ])->max('c_codigo'));
                $generado_maximo++;
                $continua = true;
                //posble cuando hay coincidencia de codigo de producto,
                //cuando hay mixto(manual,generado)
                while($continua){
                    //verificamos si el codigo del producto,aun se encuntra
                    $codigo_consulta = str_pad($generado_maximo, 5, "0", STR_PAD_LEFT);
                    //consultamos un producto con ese codigo
                    $pro_disponible = App\Producto_servicio_d::where([
                        'id_colegio' => $colegio->id_colegio,
                        'c_codigo' => $codigo_consulta
                    ])->first();
                    if(is_null($pro_disponible) || empty($pro_disponible)){
                        $continua = false;
                    }else{
                        $generado_maximo++;
                    }
                }
                $generado_maximo = str_pad($generado_maximo, 5, "0", STR_PAD_LEFT);
                $producto->c_codigo = $generado_maximo;
                $producto->c_tipo_codigo = 'GENERADO';
            }else{
                //es manual
                $producto->c_codigo = trim($request->input('codigo_producto'));
                $producto->c_tipo_codigo = 'MANUAL';
            }
            $producto->c_nombre = trim($request->input('nombre_producto'));
            $producto->c_tipo = strtoupper($request->input('tipo_producto'));
            $producto->c_unidad = $request->input('unidad_producto');
            $producto->c_unidad_sunat = $request->input('unidad_sunat_producto');
            $producto->n_precio_sin_igv = $request->input('precio_producto_sin_igv');
            $producto->n_precio_con_igv = $request->input('precio_producto_con_igv');
            $producto->id_tributo = $request->input('tributo_producto');
            $producto->creador = Auth::user()->id;
            $producto->save();

            return redirect()->back();
        }
        return redirect('/home');
    }

    public function actualizar(ActualizarProductoRequest $request){

        //return response()->json($request->all());
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=>1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //verificamos que el producto pertenesca al colegio
            $producto = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_producto_servicio' => $request->input('id_producto'),
                'estado' => 1
            ])->first();

            if(!is_null($producto) && !empty($producto)){
                //proceso para actualizar el producto}

                $modo_anterior = strtoupper($producto->c_tipo_codigo);
                //verificamos si el codigo es manual o autogenerado
                $modo = $request->input('modo_codigo');
                if(isset($modo)){
                    //es autogenerado
                    $modo = strtoupper($modo);

                    //cuando se pasa de manual a generado
                    if($modo=='GENERADO' && $modo_anterior=='MANUAL'){
                        if($producto->c_codigo!=$request->input('codigo')){
                            return "Falta implementar";
                        }
                        $generado_maximo = (int)(App\Producto_servicio_d::where([
                            'id_colegio' => $colegio->id_colegio,
                            'c_tipo_codigo' => 'GENERADO'
                        ])->max('c_codigo'));
                        $generado_maximo++;
                        $continua = true;

                        while($continua){
                            //verificamos si el codigo del producto,aun se encuntra
                            $codigo_consulta = str_pad($generado_maximo, 5, "0", STR_PAD_LEFT);
                            //consultamos un producto con ese codigo
                            $pro_disponible = App\Producto_servicio_d::where([
                                'id_colegio' => $colegio->id_colegio,
                                'c_codigo' => $codigo_consulta
                            ])->first();
                            if(is_null($pro_disponible) || empty($pro_disponible)){
                                $continua = false;
                            }else{
                                $generado_maximo++;
                            }
                        }
                        $generado_maximo = str_pad($generado_maximo, 5, "0", STR_PAD_LEFT);
                        $producto->c_codigo = $generado_maximo;
                        $producto->c_tipo_codigo = 'GENERADO';
                    }
                }else{
                    //es manual
                    $producto->c_codigo = $request->input('codigo');
                    $producto->c_tipo_codigo = 'MANUAL';
                }

                //return "El valor de modo codigo es: ".$modo;
                $producto->c_nombre = trim($request->input('nombre'));
                $producto->c_tipo = strtoupper($request->input('tipo'));
                $producto->c_unidad = $request->input('unidad');
                $producto->c_unidad_sunat = $request->input('unidad_sunat');
                $producto->n_precio_sin_igv = $request->input('precio_sin_igv');
                $producto->n_precio_con_igv = $request->input('precio_con_igv');
                $producto->id_tributo = $request->input('tributo');
                $producto->modificador = Auth::user()->id;
                $producto->save();
                return redirect()->back();
            }
        }

        return redirect('/home');
    }

    public function aplicar(AplicarProductoRequest $request){
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos el producto del colegio
            $producto = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_producto_servicio' => $request->input('id_producto'),
                'estado' => 1
            ])->first();

            if(!is_null($producto) && !empty($producto)){
                $datos = array(
                    'correcto' => TRUE,
                    'producto' => $producto
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'correcto' => FALSE,
        ) ;
        return response()->json($datos);
    }

    public function eliminar(EliminarProductoRequest $request){
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)) {
            //obtenemos el producto del colegio
            $producto = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'id_producto_servicio' => $request->input('id_producto'),
                'estado' => 1
            ])->first();

            if(!is_null($producto) && !empty($producto)){
                //eliminamos el producto
                $producto->estado = 0;
                $producto->save();

                $datos = array(
                    'eliminado' => TRUE,
                    'producto' => $producto
                );

                return response()->json($datos);
            }
        }
        $datos = array(
            'eliminado' => FALSE
        );
        return response()->json($datos);
    }

    public function filtro_tipo(Request $request){
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            $tipo = strtoupper($request->input('tipo'));
            $productos = '';
            if($tipo=='TODOS'){
                $productos = App\Producto_servicio_d::where([
                    'id_colegio' => $colegio->id_colegio,
                    'estado' => 1
                ])->orderBy('created_at','DESC')->get();
                $productos->load('tributo');

            }else if($tipo=='PRODUCTO'){
                $productos = App\Producto_servicio_d::where([
                    'id_colegio' => $colegio->id_colegio,
                    'c_tipo' => 'PRODUCTO',
                    'estado' => 1
                ])->orderBy('created_at','DESC')->get();
                $productos->load('tributo');
            }else if($tipo=='SERVICIO'){
                $productos = App\Producto_servicio_d::where([
                    'id_colegio' => $colegio->id_colegio,
                    'c_tipo' => 'SERVICIO',
                    'estado' => 1
                ])->orderBy('created_at','DESC')->get();
                $productos->load('tributo');
            }

            $datos = array(
                'correcto' => TRUE,
                'productos' =>$productos
            );

            return response()->json($datos);
        }
        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function filtro_unidad(Request $request){

        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)) {
            //obtenemos los productos del colegio con esa unidad
            $productos = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'c_unidad' => $request->input('nombre_unidad'),
                'estado' => 1
            ])->orderBy('created_at','DESC')->get();
            $productos->load('tributo');
            $datos = array(
                'correcto' => TRUE,
                'productos' => $productos
            );
            return response()->json($datos);
        }

        $datos = array(
            'correcto' => FALSE
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
            //obtenemos los productos eliminados del colegio
            $productos = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 0
            ])->orderBy('created_at','DESC')->get();
            $datos = array(
                'correcto' => TRUE,
                'productos' => $productos
            );
            return response()->json($datos);
        }

        $datos = array(
            'correcto' => FALSE
        );
        return response()->json($datos);
    }
    public function restaurar(RestaurarProductoRequest $request){
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            //obtenemos el producto
            $producto = App\Producto_servicio_d::where([
                'id_colegio'=> $colegio->id_colegio,
                'id_producto_servicio' => $request->input('id_producto'),
                'estado'=> 0
            ])->first();

            if(!is_null($producto) && !empty($producto)){
                //restauramos el producto eliminados
                $producto->estado = 1;
                $producto->save();
                $datos = array(
                    'restaurado' => TRUE,
                    'producto' => $producto
                );
                return response()->json($datos);
            }
        }
        $datos = array(
            'restaurado' => FALSE
        );
        return response()->json($datos);
    }

    public function busqueda_nombre_codigo(Request $request){
        //obtenemos el colegio
        $colegio = App\Colegio_m::where([
            'id_superadministrador' => Auth::user()->id,
            'estado'=> 1
        ])->first();

        if(!is_null($colegio) && !empty($colegio)){
            $nombre_codigo = $request->input('nombre_codigo');
            //obteniendo los productos con coincidencia en el nombre y codigo del producto
            $productos = App\Producto_servicio_d::where([
                'id_colegio' => $colegio->id_colegio,
                'estado' => 1
            ])->where(function($query)use ($nombre_codigo){
                $query->where('c_nombre','like','%'.$nombre_codigo.'%')
                    ->orWhere('c_codigo','like','%'.$nombre_codigo.'%');
            })->orderBy('created_at','DESC')->get();
            $productos->load('tributo');
            $datos = array(
                'correcto' => TRUE,
                'productos' => $productos
            );
            return response()->json($datos);
        }

        $datos = array(
            'correcto' => TRUE
        );
        return response()->json($datos);
    }
}
